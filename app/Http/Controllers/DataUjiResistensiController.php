<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\DataUjiResistensi;
use App\Models\KategoriUji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DeleteRequest;

class DataUjiResistensiController extends Controller
{
    public function index(Request $request)
    {
        $provinsis = Provinsi::orderBy('name', 'asc')->get();

        $daftarBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Ambil daftar tahun dinamis dari database + rentang tahun sistem
        $tahunDb = DataUjiResistensi::select('year')
            ->distinct()
            ->whereNotNull('year')
            ->pluck('year')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->toArray();
        $daftarTahun = array_values(array_unique(array_merge([date('Y') + 1, (int)date('Y'), (int)date('Y') - 1, (int)date('Y') - 2], $tahunDb)));
        rsort($daftarTahun);

        $search = trim($request->get('search', ''));

        // Filter Bulan (Default: Semua Bulan)
        $bulanSekarang = $daftarBulan[(int)date('n') - 1];
        if ($request->has('bulan') && $request->get('bulan') !== '') {
            $bulan = $request->get('bulan');
            if ($bulan === 'Semua bulan') $bulan = 'Semua';
        } else {
            $bulan = 'Semua';
        }

        // Filter Tahun
        if ($request->has('tahun')) {
            $tahunReq = $request->get('tahun');
            $tahun = ($tahunReq === 'Semua' || $tahunReq === 'semua' || empty($tahunReq)) ? 'Semua' : (int)$tahunReq;
        } else {
            // Jika ada pencarian tanpa filter tahun eksplisit, jangan kunci tahun
            $tahun = $search !== '' ? 'Semua' : (int)date('Y');
        }

        $query = DataUjiResistensi::with([
            'provinsi',
            'kabupaten'
        ]);

        if ($bulan !== 'Semua' && !empty($bulan)) {
            $query->where('month', $bulan);
        }

        if ($tahun !== 'Semua' && !empty($tahun)) {
            $query->where('year', (int)$tahun);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('address', 'LIKE', "%{$search}%")
                  ->orWhere('mosquito_type', 'LIKE', "%{$search}%")
                  ->orWhere('insecticide', 'LIKE', "%{$search}%")
                  ->orWhere('method', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%")
                  ->orWhere('month', 'LIKE', "%{$search}%")
                  ->orWhere('year', 'LIKE', "%{$search}%")
                  ->orWhereHas('provinsi', function ($p) use ($search) {
                      $p->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('kabupaten', function ($k) use ($search) {
                      $k->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Hitung total item & sampel yang difilter sebelum pagination
        $totalFilteredItem = (clone $query)->count();
        $totalFilteredSampel = (clone $query)->sum('sample_count');

        $perPageRaw = $request->input('per_page', 10);
        if ($perPageRaw === 'all' || (int)$perPageRaw >= 999999) {
            $perPage = 999999;
        } elseif (in_array((int)$perPageRaw, [5, 10, 25, 50, 100])) {
            $perPage = (int)$perPageRaw;
        } else {
            $perPage = 10;
        }

        $data = $query->latest('id')->paginate($perPage)->withQueryString();

        // Data untuk statistik tahun berjalan / semua tahun
        if ($tahun !== 'Semua' && !empty($tahun)) {
            $dataTahunBerjalan = DataUjiResistensi::where('year', (int)$tahun)->get();
        } else {
            $dataTahunBerjalan = DataUjiResistensi::all();
        }
        $bulanAktif = ($bulan === 'Semua') ? $bulanSekarang : $bulan;
        $totalSemuaData = DataUjiResistensi::count();

        // Ambil daftar parameter dari Master Data Kategori
        $daftarNyamuk = KategoriUji::nyamuk()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();
        $daftarInsektisida = KategoriUji::insektisida()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();
        $daftarMetode = KategoriUji::metode()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();

        return view('input', compact(
            'provinsis',
            'data',
            'bulan',
            'tahun',
            'daftarBulan',
            'daftarTahun',
            'dataTahunBerjalan',
            'bulanAktif',
            'totalSemuaData',
            'totalFilteredItem',
            'totalFilteredSampel',
            'search',
            'daftarNyamuk',
            'daftarInsektisida',
            'daftarMetode',
            'perPageRaw'
        ));
    }


    public function store(Request $request)
    {
        // Jika input dikirim sebagai satu data langsung (dari Modal / Form Tambah Data)
        if ($request->filled('provinsi_id') || !$request->has('rows')) {
            $validated = $request->validate([
                'bulan' => 'required|string',
                'tahun' => 'required|integer',
                'provinsi_id' => 'required|exists:provinsis,id',
                'kabupaten_id' => 'required|exists:kabupatens,id',
                'alamat' => 'nullable|string|max:500',
                'jenis_nyamuk' => 'required|string',
                'insektisida' => 'required|string',
                'metode' => 'required|string',
                'sampel_diperiksa' => 'required|integer|min:1',
                'status' => 'nullable|string|max:50',
                'mutasi' => 'nullable|string|max:100',
                'publikasi' => 'nullable|string|max:255',
            ], [
                'provinsi_id.required' => 'Pilih provinsi.',
                'kabupaten_id.required' => 'Pilih kota/kabupaten.',
                'jenis_nyamuk.required' => 'Pilih jenis nyamuk.',
                'insektisida.required' => 'Pilih jenis insektisida.',
                'metode.required' => 'Pilih metode pemeriksaan.',
                'sampel_diperiksa.required' => 'Isi jumlah sampel diperiksa (minimal 1).',
            ]);

            Kabupaten::where('id', $validated['kabupaten_id'])
                ->where('provinsi_id', $validated['provinsi_id'])
                ->firstOrFail();

            $bulan = $validated['bulan'];
            $tahun = (int)$validated['tahun'];

            $lastCount = DataUjiResistensi::where('month', $bulan)
                ->where('year', $tahun)
                ->count();

            DataUjiResistensi::create([
                'no' => (string)($lastCount + 1),
                'month' => $bulan,
                'year' => $tahun,
                'provinsi_id' => $validated['provinsi_id'],
                'kabupaten_id' => $validated['kabupaten_id'],
                'address' => $validated['alamat'] ?? null,
                'mosquito_type' => $validated['jenis_nyamuk'],
                'insecticide' => $validated['insektisida'],
                'method' => $validated['metode'],
                'sample_count' => $validated['sampel_diperiksa'],
                'status' => $validated['status'] ?? null,
                'mutation' => $validated['mutasi'] ?? null,
                'publication' => $validated['publikasi'] ?? null,
            ]);

            return redirect()
                ->route('input', ['bulan' => $bulan, 'tahun' => $tahun])
                ->with('success', 'Data uji resistensi berhasil ditambahkan.');
        }

        // Fallback jika form mengirim rows
        $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'rows' => 'required|array|min:1',
            'rows.*.provinsi_id' => 'required|exists:provinsis,id',
            'rows.*.kabupaten_id' => 'required|exists:kabupatens,id',
            'rows.*.jenis_nyamuk' => 'required|string',
            'rows.*.insektisida' => 'required|string',
            'rows.*.metode' => 'required|string',
            'rows.*.sampel_diperiksa' => 'required|integer|min:1',
            'rows.*.status' => 'nullable|string|max:50',
            'rows.*.mutasi' => 'nullable|string|max:100',
            'rows.*.publikasi' => 'nullable|string|max:255',
        ]);

        $bulan = $request->input('bulan');
        $tahun = (int)$request->input('tahun');

        DB::transaction(function () use ($request, $bulan, $tahun) {
            $lastNo = DataUjiResistensi::where('month', $bulan)
                ->where('year', $tahun)
                ->count();

            $i = 0;
            foreach ($request->rows as $row) {
                $i++;
                Kabupaten::where('id', $row['kabupaten_id'])
                    ->where('provinsi_id', $row['provinsi_id'])
                    ->firstOrFail();

                DataUjiResistensi::create([
                    'no' => (string)($lastNo + $i),
                    'month' => $bulan,
                    'year' => $tahun,
                    'provinsi_id' => $row['provinsi_id'],
                    'kabupaten_id' => $row['kabupaten_id'],
                    'address' => $row['alamat'] ?? null,
                    'mosquito_type' => $row['jenis_nyamuk'],
                    'insecticide' => $row['insektisida'],
                    'method' => $row['metode'],
                    'sample_count' => $row['sampel_diperiksa'],
                    'status' => $row['status'] ?? null,
                    'mutation' => $row['mutasi'] ?? null,
                    'publication' => $row['publikasi'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('input', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', 'Data uji resistensi berhasil disimpan ke database.');
    }

    public function update(Request $request, $id)
    {
        $data = DataUjiResistensi::findOrFail($id);

        $validated = $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'alamat' => 'nullable|string|max:500',
            'jenis_nyamuk' => 'required|string',
            'insektisida' => 'required|string',
            'metode' => 'required|string',
            'sampel_diperiksa' => 'required|integer|min:1',
            'status' => 'nullable|string|max:50',
            'mutasi' => 'nullable|string|max:100',
            'publikasi' => 'nullable|string|max:255',
        ], [
            'provinsi_id.required' => 'Pilih provinsi.',
            'kabupaten_id.required' => 'Pilih kota/kabupaten.',
            'jenis_nyamuk.required' => 'Pilih jenis nyamuk.',
            'insektisida.required' => 'Pilih jenis insektisida.',
            'metode.required' => 'Pilih metode pemeriksaan.',
            'sampel_diperiksa.required' => 'Isi jumlah sampel diperiksa (minimal 1).',
        ]);

        Kabupaten::where('id', $validated['kabupaten_id'])
            ->where('provinsi_id', $validated['provinsi_id'])
            ->firstOrFail();

        $data->update([
            'month' => $validated['bulan'],
            'year' => (int)$validated['tahun'],
            'provinsi_id' => $validated['provinsi_id'],
            'kabupaten_id' => $validated['kabupaten_id'],
            'address' => $validated['alamat'] ?? null,
            'mosquito_type' => $validated['jenis_nyamuk'],
            'insecticide' => $validated['insektisida'],
            'method' => $validated['metode'],
            'sample_count' => $validated['sampel_diperiksa'],
            'status' => $validated['status'] ?? null,
            'mutation' => $validated['mutasi'] ?? null,
            'publication' => $validated['publikasi'] ?? null,
        ]);

        return redirect()
            ->route('input', ['bulan' => $validated['bulan'], 'tahun' => $validated['tahun']])
            ->with('success', 'Data uji resistensi berhasil diperbarui.');
    }


    public function getKabupaten($provinsi_id)
    {
        $kabupatens = Kabupaten::where('provinsi_id', $provinsi_id)
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($kabupatens);
    }

    public function dashboard()
    {
        // 1. Agregasi ringkasan langsung di tingkat MySQL (Cepat, hemat memori RAM PHP)
        $totalPemeriksaan = DataUjiResistensi::count();
        $totalSampel = (int) DataUjiResistensi::sum('sample_count');
        $totalProvinsi = DataUjiResistensi::whereNotNull('provinsi_id')->distinct()->count('provinsi_id');
        $totalKabupaten = DataUjiResistensi::whereNotNull('kabupaten_id')->distinct()->count('kabupaten_id');

        // 2. Ambil data dengan memilih hanya kolom yang diperlukan untuk rendering peta & tabel
        $data = DataUjiResistensi::select([
            'id', 'no', 'month', 'year', 'provinsi_id', 'kabupaten_id',
            'address', 'mosquito_type', 'insecticide', 'method',
            'sample_count', 'status', 'mutation', 'publication', 'created_at'
        ])
        ->with([
            'provinsi:id,name',
            'kabupaten:id,provinsi_id,name,latitude,longitude'
        ])
        ->latest('id')
        ->get();

        $dataTerbaru = $data->take(10);

        $provinsis = Provinsi::select('id', 'name')
            ->orderBy('name', 'asc')
            ->get();

        $daftarNyamuk = KategoriUji::nyamuk()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();
        if (empty($daftarNyamuk)) {
            $daftarNyamuk = [
                'Ae. aegypti', 'Culex sp', 'Anhopheles', 'Aedes sp', 'An. Farauti', 'An. Vagus',
                'An. tessellatus', 'An. sundaicus s.I', 'An. punctulatus s.I.', 'An. peditaeniatus',
                'An. parensis', 'An. letifer', 'An. koliensis', 'An. kochi', 'An. indefinitus',
                'An. hyrcanus s.I.', 'An. farauti s.s', 'An. barbirostris', 'An. aconitus', 'An. Albopictus'
            ];
        }

        $daftarInsektisida = KategoriUji::insektisida()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();
        if (empty($daftarInsektisida)) {
            $daftarInsektisida = [
                'Cypermethrin', 'Lamdacyhalothrin', 'Deltamethrin', 'Alphacypermethrin',
                'Cyfluthrin', 'Permethrin', 'Malathion', 'Deltamethrin 0,025%',
                'Lambda-cyhalothrin 0,0025%', 'Temefos (Abate)', 'Bendiocarb', 'Sipermethrin'
            ];
        }

        $daftarMetode = KategoriUji::metode()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();
        if (empty($daftarMetode)) {
            $daftarMetode = [
                'Sequencing', 'WHO Tube Bioassay', 'WHO larval bioassay',
                'WHO susceptibilitity test', 'WHO test kit_adults', 'CDC bottle_adults',
                'CDC bottle bioassay', 'WHO standards bioassay'
            ];
        }

        $daftarTahun = DataUjiResistensi::select('year')->distinct()->pluck('year')->toArray();
        if (empty($daftarTahun)) {
            $daftarTahun = [(int)date('Y')];
        }
        foreach ([2024, 2025, 2026] as $thn) {
            if (!in_array($thn, $daftarTahun)) {
                $daftarTahun[] = $thn;
            }
        }
        rsort($daftarTahun);


        return view('dashboard', compact(
            'data',
            'provinsis',
            'daftarTahun',
            'daftarNyamuk',
            'daftarInsektisida',
            'daftarMetode',
            'totalPemeriksaan',
            'totalSampel',
            'totalProvinsi',
            'totalKabupaten',
            'dataTerbaru'
        ));
    }

    public function destroy($id)
    {
        $data = DataUjiResistensi::findOrFail($id);
        $bulan = $data->bulan;
        $tahun = $data->tahun;
        $data->delete();

        return redirect()
            ->route('input', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', 'Data uji resistensi berhasil dihapus.');
    }

    // public function requestDelete(Request $request)
    // {
    //     $request->validate([
    //         'data_id' => 'required|exists:data_uji_resistensis,id',
    //         'alasan' =>'required|string|max:1000',
    //     ]);

    //     DeleteRequest::create([
    //         'data_uji_resistensi_id' => $request->data_id,
    //         'alasan' => $request->alasan,
    //         'status' => 'pending',
    //     ]);

    //     return redirect()
    //         ->route('input')
    //         ->with(
    //             'success',
    //             'Request penghapusan berhasil dikirim kepada Admin.'
    //         );
    // }
}