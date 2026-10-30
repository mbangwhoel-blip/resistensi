<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\DataUjiResistensi;
use App\Models\KategoriUji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

        // Pastikan kolom user_id tersedia di database hosting untuk mencegah error 500 / 1054 Unknown column
        $hasUserIdCol = DataUjiResistensi::checkAndEnsureUserIdColumn();

        // Ambil daftar tahun dinamis dari database + rentang tahun sistem (2015 s.d sekarang)
        $tahunDbQuery = DataUjiResistensi::select('year')
            ->distinct()
            ->whereNotNull('year');
        if ($hasUserIdCol && Auth::check() && !Auth::user()->canSeeAllData()) {
            $tahunDbQuery->where('user_id', Auth::id());
        }
        $tahunDb = $tahunDbQuery->pluck('year')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y >= 2015 && $y <= (int)date('Y'))
            ->toArray();
        $tahunRange = range((int)date('Y'), 2015);
        $daftarTahun = array_values(array_unique(array_merge($tahunRange, $tahunDb)));
        rsort($daftarTahun);

        $daftarTahunAsc = array_values($daftarTahun);
        sort($daftarTahunAsc);

        $search = trim($request->get('search', ''));

        // Filter Bulan (Default: Semua Bulan)
        $bulanSekarang = $daftarBulan[(int)date('n') - 1];
        if ($request->has('bulan') && $request->get('bulan') !== '') {
            $bulan = $request->get('bulan');
            if ($bulan === 'Semua bulan') $bulan = 'Semua';
        } else {
            $bulan = 'Semua';
        }

        // Filter Rentang Tahun (tahun_mulai & tahun_selesai) atau Tahun Tunggal
        $tahunMulaiReq = $request->get('tahun_mulai');
        $tahunSelesaiReq = $request->get('tahun_selesai');

        $tahunMulai = ($tahunMulaiReq !== null && $tahunMulaiReq !== '' && $tahunMulaiReq !== 'Semua') ? (int)$tahunMulaiReq : null;
        $tahunSelesai = ($tahunSelesaiReq !== null && $tahunSelesaiReq !== '' && $tahunSelesaiReq !== 'Semua') ? (int)$tahunSelesaiReq : null;

        // Fallback jika parameter tunggal 'tahun' yang dikirim
        if ($tahunMulai === null && $tahunSelesai === null && $request->has('tahun')) {
            $thnVal = $request->get('tahun');
            if ($thnVal !== 'Semua' && $thnVal !== 'semua' && !empty($thnVal)) {
                $tahunMulai = (int)$thnVal;
                $tahunSelesai = (int)$thnVal;
            }
        }

        // Normalisasi urutan jika tahun_mulai > tahun_selesai
        if ($tahunMulai && $tahunSelesai && $tahunMulai > $tahunSelesai) {
            $temp = $tahunMulai;
            $tahunMulai = $tahunSelesai;
            $tahunSelesai = $temp;
        }

        // Label teks tahun untuk badge ringkasan
        if ($tahunMulai && $tahunSelesai) {
            $tahun = ($tahunMulai === $tahunSelesai) ? (string)$tahunMulai : "{$tahunMulai} - {$tahunSelesai}";
        } elseif ($tahunMulai) {
            $tahun = "≥ {$tahunMulai}";
        } elseif ($tahunSelesai) {
            $tahun = "≤ {$tahunSelesai}";
        } else {
            $tahun = 'Semua';
        }

        $relations = ['provinsi', 'kabupaten'];
        if ($hasUserIdCol) {
            $relations[] = 'user';
        }
        $query = DataUjiResistensi::with($relations);

        // Scoping akses: Non-admin hanya dapat melihat datanya sendiri jika kolom user_id tersedia
        if ($hasUserIdCol && Auth::check() && !Auth::user()->canSeeAllData()) {
            $query->where('user_id', Auth::id());
        }

        if ($bulan !== 'Semua' && !empty($bulan)) {
            $query->where('month', $bulan);
        }

        if ($tahunMulai && $tahunSelesai) {
            $query->whereBetween('year', [$tahunMulai, $tahunSelesai]);
        } elseif ($tahunMulai) {
            $query->where('year', '>=', $tahunMulai);
        } elseif ($tahunSelesai) {
            $query->where('year', '<=', $tahunSelesai);
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

        // Data untuk statistik tahun berjalan / rentang tahun / semua tahun (disesuaikan hak akses)
        $baseStatQuery = DataUjiResistensi::query();
        if ($hasUserIdCol && Auth::check() && !Auth::user()->canSeeAllData()) {
            $baseStatQuery->where('user_id', Auth::id());
        }

        if ($tahunMulai && $tahunSelesai) {
            $dataTahunBerjalan = (clone $baseStatQuery)->whereBetween('year', [$tahunMulai, $tahunSelesai])->get();
        } elseif ($tahunMulai) {
            $dataTahunBerjalan = (clone $baseStatQuery)->where('year', '>=', $tahunMulai)->get();
        } elseif ($tahunSelesai) {
            $dataTahunBerjalan = (clone $baseStatQuery)->where('year', '<=', $tahunSelesai)->get();
        } else {
            $dataTahunBerjalan = (clone $baseStatQuery)->get();
        }
        $bulanAktif = ($bulan === 'Semua') ? $bulanSekarang : $bulan;
        $totalSemuaData = (clone $baseStatQuery)->count();

        // Ambil daftar parameter dari Master Data Kategori
        $daftarNyamuk = KategoriUji::nyamuk()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();
        $daftarInsektisida = KategoriUji::insektisida()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();
        $daftarMetode = KategoriUji::metode()->where('is_active', true)->orderBy('name')->pluck('name')->toArray();

        return view('input', compact(
            'provinsis',
            'data',
            'bulan',
            'tahun',
            'tahunMulai',
            'tahunSelesai',
            'daftarBulan',
            'daftarTahun',
            'daftarTahunAsc',
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
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->back()->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only) tanpa hak akses menambah data.');
        }

        // Jika input dikirim sebagai satu data langsung (dari Modal / Form Tambah Data)
        if ($request->filled('provinsi_id') || !$request->has('rows')) {
            $currentYear = (int)date('Y');
            $validated = $request->validate([
                'bulan' => 'required|string',
                'tahun' => 'required|integer|min:2015|max:' . $currentYear,
                'provinsi_id' => 'required|exists:provinsis,id',
                'kabupaten_id' => 'required|exists:kabupatens,id',
                'alamat' => 'nullable|string|max:500',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
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
                'tahun.required' => 'Tahun pengujian wajib diisi.',
                'tahun.integer' => 'Tahun pengujian harus berupa angka bulat.',
                'tahun.min' => 'Tahun pengujian minimal adalah tahun 2015.',
                'tahun.max' => 'Tahun pengujian maksimal adalah tahun ' . $currentYear . ' (sekarang).',
                'latitude.numeric' => 'Format Latitude harus berupa angka desimal (contoh: -7.324512).',
                'latitude.between' => 'Nilai Latitude harus berada di antara -90 dan 90 derajat.',
                'longitude.numeric' => 'Format Longitude harus berupa angka desimal (contoh: 110.501234).',
                'longitude.between' => 'Nilai Longitude harus berada di antara -180 dan 180 derajat.',
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

            $storeData = [
                'no' => (string)($lastCount + 1),
                'month' => $bulan,
                'year' => $tahun,
                'provinsi_id' => $validated['provinsi_id'],
                'kabupaten_id' => $validated['kabupaten_id'],
                'address' => $validated['alamat'] ?? null,
                'latitude' => isset($validated['latitude']) && $validated['latitude'] !== '' ? $validated['latitude'] : null,
                'longitude' => isset($validated['longitude']) && $validated['longitude'] !== '' ? $validated['longitude'] : null,
                'mosquito_type' => $validated['jenis_nyamuk'],
                'insecticide' => $validated['insektisida'],
                'method' => $validated['metode'],
                'sample_count' => $validated['sampel_diperiksa'],
                'status' => $validated['status'] ?? null,
                'mutation' => $validated['mutasi'] ?? null,
                'publication' => $validated['publikasi'] ?? null,
            ];

            if ($hasUserIdCol) {
                $storeData['user_id'] = Auth::id();
            }

            DataUjiResistensi::create($storeData);

            // Auto-register parameter ke Master Data Kategori jika belum terdaftar
            KategoriUji::firstOrCreateCategory('nyamuk', $validated['jenis_nyamuk']);
            KategoriUji::firstOrCreateCategory('insektisida', $validated['insektisida']);
            KategoriUji::firstOrCreateCategory('metode', $validated['metode']);

            return redirect()
                ->route('input', ['bulan' => $bulan, 'tahun' => $tahun])
                ->with('success', 'Data uji resistensi berhasil ditambahkan.');
        }

        // Fallback jika form mengirim rows
        $currentYear = (int)date('Y');
        $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer|min:2015|max:' . $currentYear,
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

                $rowPayload = [
                    'no' => (string)($lastNo + $i),
                    'month' => $bulan,
                    'year' => $tahun,
                    'provinsi_id' => $row['provinsi_id'],
                    'kabupaten_id' => $row['kabupaten_id'],
                    'address' => $row['alamat'] ?? null,
                    'latitude' => isset($row['latitude']) && $row['latitude'] !== '' ? $row['latitude'] : null,
                    'longitude' => isset($row['longitude']) && $row['longitude'] !== '' ? $row['longitude'] : null,
                    'mosquito_type' => $row['jenis_nyamuk'],
                    'insecticide' => $row['insektisida'],
                    'method' => $row['metode'],
                    'sample_count' => $row['sampel_diperiksa'],
                    'status' => $row['status'] ?? null,
                    'mutation' => $row['mutasi'] ?? null,
                    'publication' => $row['publikasi'] ?? null,
                ];

                if (DataUjiResistensi::checkAndEnsureUserIdColumn()) {
                    $rowPayload['user_id'] = Auth::id();
                }

                DataUjiResistensi::create($rowPayload);

                // Auto-register parameter ke Master Data Kategori jika belum terdaftar
                KategoriUji::firstOrCreateCategory('nyamuk', $row['jenis_nyamuk']);
                KategoriUji::firstOrCreateCategory('insektisida', $row['insektisida']);
                KategoriUji::firstOrCreateCategory('metode', $row['metode']);
            }
        });

        return redirect()
            ->route('input', ['bulan' => $bulan, 'tahun' => $tahun])
            ->with('success', 'Data uji resistensi berhasil disimpan ke database.');
    }

    public function update(Request $request, $id)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->back()->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only) tanpa hak akses mengedit data.');
        }

        $data = DataUjiResistensi::findOrFail($id);

        // Validasi kepemilikan data: Non-admin hanya boleh memperbarui datanya sendiri
        if (DataUjiResistensi::checkAndEnsureUserIdColumn() && Auth::check() && !Auth::user()->canSeeAllData() && !empty($data->user_id) && $data->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Akses Ditolak: Anda hanya memiliki izin mengedit data yang Anda inputkan sendiri.');
        }

        $currentYear = (int)date('Y');
        $validated = $request->validate([
            'bulan' => 'required|string',
            'tahun' => 'required|integer|min:2015|max:' . $currentYear,
            'provinsi_id' => 'required|exists:provinsis,id',
            'kabupaten_id' => 'required|exists:kabupatens,id',
            'alamat' => 'nullable|string|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
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
            'tahun.required' => 'Tahun pengujian wajib diisi.',
            'tahun.integer' => 'Tahun pengujian harus berupa angka bulat.',
            'tahun.min' => 'Tahun pengujian minimal adalah tahun 2015.',
            'tahun.max' => 'Tahun pengujian maksimal adalah tahun ' . $currentYear . ' (sekarang).',
            'latitude.numeric' => 'Format Latitude harus berupa angka desimal (contoh: -7.324512).',
            'latitude.between' => 'Nilai Latitude harus berada di antara -90 dan 90 derajat.',
            'longitude.numeric' => 'Format Longitude harus berupa angka desimal (contoh: 110.501234).',
            'longitude.between' => 'Nilai Longitude harus berada di antara -180 dan 180 derajat.',
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
            'latitude' => isset($validated['latitude']) && $validated['latitude'] !== '' ? $validated['latitude'] : null,
            'longitude' => isset($validated['longitude']) && $validated['longitude'] !== '' ? $validated['longitude'] : null,
            'mosquito_type' => $validated['jenis_nyamuk'],
            'insecticide' => $validated['insektisida'],
            'method' => $validated['metode'],
            'sample_count' => $validated['sampel_diperiksa'],
            'status' => $validated['status'] ?? null,
            'mutation' => $validated['mutasi'] ?? null,
            'publication' => $validated['publikasi'] ?? null,
        ]);

        // Auto-register parameter ke Master Data Kategori jika belum terdaftar
        KategoriUji::firstOrCreateCategory('nyamuk', $validated['jenis_nyamuk']);
        KategoriUji::firstOrCreateCategory('insektisida', $validated['insektisida']);
        KategoriUji::firstOrCreateCategory('metode', $validated['metode']);

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
        $hasUserIdCol = DataUjiResistensi::checkAndEnsureUserIdColumn();
        $baseQuery = DataUjiResistensi::query();
        if ($hasUserIdCol && Auth::check() && !Auth::user()->canSeeAllData()) {
            $baseQuery->where('user_id', Auth::id());
        }

        // 1. Agregasi ringkasan langsung di tingkat MySQL (Cepat, hemat memori RAM PHP)
        $totalPemeriksaan = (clone $baseQuery)->count();
        $totalSampel = (int) (clone $baseQuery)->sum('sample_count');
        $totalProvinsi = (clone $baseQuery)->whereNotNull('provinsi_id')->distinct()->count('provinsi_id');
        $totalKabupaten = (clone $baseQuery)->whereNotNull('kabupaten_id')->distinct()->count('kabupaten_id');
        $totalResisten = (clone $baseQuery)->where('status', 'Resisten')->count();
        $totalToleran = (clone $baseQuery)->whereIn('status', ['Toleran', 'Toleran/Terduga Resisten', 'Terduga Resisten'])->count();
        $totalRentan = (clone $baseQuery)->where('status', 'Rentan')->count();

        // 2. Ambil data dengan memilih hanya kolom yang diperlukan untuk rendering peta & tabel
        $data = (clone $baseQuery)->select([
            'id', 'no', 'month', 'year', 'provinsi_id', 'kabupaten_id',
            'address', 'latitude', 'longitude', 'mosquito_type', 'insecticide', 'method',
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

        $tahunDb = (clone $baseQuery)->select('year')
            ->distinct()
            ->whereNotNull('year')
            ->pluck('year')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y >= 2015 && $y <= (int)date('Y'))
            ->toArray();
        $tahunRange = range((int)date('Y'), 2015);
        $daftarTahun = array_values(array_unique(array_merge($tahunRange, $tahunDb)));
        rsort($daftarTahun);
        $daftarTahunAsc = array_values($daftarTahun);
        sort($daftarTahunAsc);

        return view('dashboard', compact(
            'data',
            'provinsis',
            'daftarTahun',
            'daftarTahunAsc',
            'daftarNyamuk',
            'daftarInsektisida',
            'daftarMetode',
            'totalPemeriksaan',
            'totalSampel',
            'totalProvinsi',
            'totalKabupaten',
            'totalResisten',
            'totalToleran',
            'totalRentan',
            'dataTerbaru'
        ));
    }

    public function destroy($id)
    {
        if (Auth::check() && Auth::user()->isViewer()) {
            return redirect()->back()->with('error', 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only) tanpa hak akses menghapus data.');
        }

        $data = DataUjiResistensi::findOrFail($id);

        // Validasi kepemilikan data: Non-admin hanya boleh menghapus datanya sendiri
        if (DataUjiResistensi::checkAndEnsureUserIdColumn() && Auth::check() && !Auth::user()->canSeeAllData() && !empty($data->user_id) && $data->user_id != Auth::id()) {
            return redirect()->back()->with('error', 'Akses Ditolak: Anda hanya memiliki izin menghapus data yang Anda inputkan sendiri.');
        }
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