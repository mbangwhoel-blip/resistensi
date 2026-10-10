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
        $provinsis = Provinsi::orderBy('nama_provinsi', 'asc')->get();

        $daftarBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Ambil daftar tahun dinamis dari database + rentang tahun sistem
        $tahunDb = DataUjiResistensi::select('tahun')
            ->distinct()
            ->whereNotNull('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->toArray();
        $daftarTahun = array_values(array_unique(array_merge([date('Y') + 1, (int)date('Y'), (int)date('Y') - 1, (int)date('Y') - 2], $tahunDb)));
        rsort($daftarTahun);

        $search = trim($request->get('search', ''));

        // Filter Bulan
        $bulanSekarang = $daftarBulan[(int)date('n') - 1];
        if ($request->has('bulan')) {
            $bulan = $request->get('bulan');
            if ($bulan === 'Semua bulan') $bulan = 'Semua';
        } else {
            // Jika ada pencarian tanpa filter bulan eksplisit, jangan kunci bulan
            $bulan = $search !== '' ? 'Semua' : $bulanSekarang;
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
            $query->where('bulan', $bulan);
        }

        if ($tahun !== 'Semua' && !empty($tahun)) {
            $query->where('tahun', (int)$tahun);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('alamat', 'LIKE', "%{$search}%")
                  ->orWhere('jenis_nyamuk', 'LIKE', "%{$search}%")
                  ->orWhere('insektisida', 'LIKE', "%{$search}%")
                  ->orWhere('metode', 'LIKE', "%{$search}%")
                  ->orWhere('status', 'LIKE', "%{$search}%")
                  ->orWhere('bulan', 'LIKE', "%{$search}%")
                  ->orWhere('tahun', 'LIKE', "%{$search}%")
                  ->orWhereHas('provinsi', function ($p) use ($search) {
                      $p->where('nama_provinsi', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('kabupaten', function ($k) use ($search) {
                      $k->where('nama_kabupaten', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Hitung total item & sampel yang difilter sebelum pagination
        $totalFilteredItem = (clone $query)->count();
        $totalFilteredSampel = (clone $query)->sum('sampel_diperiksa');

        $data = $query->latest('id')->paginate(10)->withQueryString();

        // Data untuk statistik tahun berjalan / semua tahun
        if ($tahun !== 'Semua' && !empty($tahun)) {
            $dataTahunBerjalan = DataUjiResistensi::where('tahun', (int)$tahun)->get();
        } else {
            $dataTahunBerjalan = DataUjiResistensi::all();
        }
        $bulanAktif = ($bulan === 'Semua') ? $bulanSekarang : $bulan;
        $totalSemuaData = DataUjiResistensi::count();

        // Ambil daftar parameter dari Master Data Kategori
        $daftarNyamuk = KategoriUji::nyamuk()->where('is_active', true)->orderBy('nama')->pluck('nama')->toArray();
        $daftarInsektisida = KategoriUji::insektisida()->where('is_active', true)->orderBy('nama')->pluck('nama')->toArray();
        $daftarMetode = KategoriUji::metode()->where('is_active', true)->orderBy('nama')->pluck('nama')->toArray();

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
            'daftarMetode'
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

            $lastCount = DataUjiResistensi::where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->count();

            DataUjiResistensi::create([
                'no' => (string)($lastCount + 1),
                'bulan' => $bulan,
                'tahun' => $tahun,
                'provinsi_id' => $validated['provinsi_id'],
                'kabupaten_id' => $validated['kabupaten_id'],
                'alamat' => $validated['alamat'] ?? null,
                'jenis_nyamuk' => $validated['jenis_nyamuk'],
                'insektisida' => $validated['insektisida'],
                'metode' => $validated['metode'],
                'sampel_diperiksa' => $validated['sampel_diperiksa'],
                'status' => $validated['status'] ?? null,
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
        ]);

        $bulan = $request->input('bulan');
        $tahun = (int)$request->input('tahun');

        DB::transaction(function () use ($request, $bulan, $tahun) {
            $lastNo = DataUjiResistensi::where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->count();

            $i = 0;
            foreach ($request->rows as $row) {
                $i++;
                Kabupaten::where('id', $row['kabupaten_id'])
                    ->where('provinsi_id', $row['provinsi_id'])
                    ->firstOrFail();

                DataUjiResistensi::create([
                    'no' => (string)($lastNo + $i),
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'provinsi_id' => $row['provinsi_id'],
                    'kabupaten_id' => $row['kabupaten_id'],
                    'alamat' => $row['alamat'] ?? null,
                    'jenis_nyamuk' => $row['jenis_nyamuk'],
                    'insektisida' => $row['insektisida'],
                    'metode' => $row['metode'],
                    'sampel_diperiksa' => $row['sampel_diperiksa'],
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
            'bulan' => $validated['bulan'],
            'tahun' => (int)$validated['tahun'],
            'provinsi_id' => $validated['provinsi_id'],
            'kabupaten_id' => $validated['kabupaten_id'],
            'alamat' => $validated['alamat'] ?? null,
            'jenis_nyamuk' => $validated['jenis_nyamuk'],
            'insektisida' => $validated['insektisida'],
            'metode' => $validated['metode'],
            'sampel_diperiksa' => $validated['sampel_diperiksa'],
            'status' => $validated['status'] ?? null,
        ]);

        return redirect()
            ->route('input', ['bulan' => $validated['bulan'], 'tahun' => $validated['tahun']])
            ->with('success', 'Data uji resistensi berhasil diperbarui.');
    }


    public function getKabupaten($provinsi_id)
    {
        $kabupatens = Kabupaten::where('provinsi_id', $provinsi_id)
            ->orderBy('nama_kabupaten', 'asc')
            ->get();

        return response()->json($kabupatens);
    }

    public function dashboard()
    {
        $data = DataUjiResistensi::with([
            'provinsi',
            'kabupaten'
        ])
        ->latest()
        ->get();

        $provinsis = Provinsi::orderBy('nama_provinsi', 'asc')->get();

        $daftarNyamuk = KategoriUji::nyamuk()->where('is_active', true)->orderBy('nama')->pluck('nama')->toArray();
        if (empty($daftarNyamuk)) {
            $daftarNyamuk = [
                'Ae. aegypti', 'Culex sp', 'Anhopheles', 'Aedes sp', 'An. Farauti', 'An. Vagus',
                'An. tessellatus', 'An. sundaicus s.I', 'An. punctulatus s.I.', 'An. peditaeniatus',
                'An. parensis', 'An. letifer', 'An. koliensis', 'An. kochi', 'An. indefinitus',
                'An. hyrcanus s.I.', 'An. farauti s.s', 'An. barbirostris', 'An. aconitus', 'An. Albopictus'
            ];
        }

        $daftarInsektisida = KategoriUji::insektisida()->where('is_active', true)->orderBy('nama')->pluck('nama')->toArray();
        if (empty($daftarInsektisida)) {
            $daftarInsektisida = [
                'Cypermethrin', 'Lamdacyhalothrin', 'Deltamethrin', 'Alphacypermethrin',
                'Cyfluthrin', 'Permethrin', 'Malathion', 'Deltamethrin 0,025%',
                'Lambda-cyhalothrin 0,0025%', 'Temefos (Abate)', 'Bendiocarb', 'Sipermethrin'
            ];
        }

        $daftarMetode = KategoriUji::metode()->where('is_active', true)->orderBy('nama')->pluck('nama')->toArray();
        if (empty($daftarMetode)) {
            $daftarMetode = [
                'Sequencing', 'WHO Tube Bioassay', 'WHO larval bioassay',
                'WHO susceptibilitity test', 'WHO test kit_adults', 'CDC bottle_adults',
                'CDC bottle bioassay', 'WHO standards bioassay'
            ];
        }

        $daftarTahun = DataUjiResistensi::select('tahun')->distinct()->pluck('tahun')->toArray();
        if (empty($daftarTahun)) {
            $daftarTahun = [(int)date('Y')];
        }
        foreach ([2024, 2025, 2026] as $thn) {
            if (!in_array($thn, $daftarTahun)) {
                $daftarTahun[] = $thn;
            }
        }
        rsort($daftarTahun);

        $totalPemeriksaan = $data->count();
        $totalSampel = $data->sum('sampel_diperiksa');
        $totalProvinsi = $data->pluck('provinsi_id')->filter()->unique()->count();
        $totalKabupaten = $data->pluck('kabupaten_id')->filter()->unique()->count();
        $dataTerbaru = $data->take(10);

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