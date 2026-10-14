<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\DataUjiResistensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RekomendasiKebijakanController extends Controller
{
    /**
     * Peta Golongan Kimia Insektisida Standar WHO / Kemenkes RI
     */
    protected array $golonganKimia = [
        'pyrethroid' => [
            'nama' => 'Pyrethroid (Sintetik)',
            'warna' => 'rose',
            'deskripsi' => 'Bekerja pada kanal natrium sel saraf serangga. Paling umum digunakan untuk fogging dan kelambu (LLINs).',
            'keywords' => ['cypermethrin', 'deltamethrin', 'permethrin', 'lambda-cyhalothrin', 'alpha-cypermethrin', 'etofenprox', 'bifenthrin', 'transfluthrin']
        ],
        'organofosfat' => [
            'nama' => 'Organofosfat',
            'warna' => 'amber',
            'deskripsi' => 'Menghambat enzim asetilkolinesterase (AChE). Efektif sebagai rotasi fogging atau larvasida.',
            'keywords' => ['malathion', 'pirimiphos', 'fenitrothion', 'temephos', 'chlorpyrifos', 'abate']
        ],
        'karbamat' => [
            'nama' => 'Karbamat',
            'warna' => 'indigo',
            'deskripsi' => 'Menghambat AChE secara reversibel. Pilihan unggulan untuk rotasi Indoor Residual Spraying (IRS).',
            'keywords' => ['bendiocarb', 'propoxur', 'carbosulfan']
        ],
        'biolarvasida' => [
            'nama' => 'Biolarvasida & IGR',
            'warna' => 'emerald',
            'deskripsi' => 'Pengendali biologis & penghambat pertumbuhan serangga (IGR). Aman lingkungan & tidak memicu resistensi silang dewasa.',
            'keywords' => ['bti', 'bacillus', 'thuringiensis', 'pyriproxyfen', 'diflubenzuron', 'methoprene']
        ]
    ];

    /**
     * Normalisasi Bahan Aktif dan Deteksi Golongan Kimia Standar WHO / IRAC
     */
    protected function normalizeInsecticide(string $raw): array
    {
        $str = strtolower(trim($raw));

        // 1. Pyrethroid (Sintetik)
        if (str_contains($str, 'alpha') || str_contains($str, 'alfa')) {
            return ['Alpha-cypermethrin', 'pyrethroid'];
        }
        if (str_contains($str, 'sipermetrin') || str_contains($str, 'sipermethrin') || str_contains($str, 'cypermethrin')) {
            return ['Cypermethrin', 'pyrethroid'];
        }
        if (str_contains($str, 'deltametrin') || str_contains($str, 'deltamethrin')) {
            return ['Deltamethrin', 'pyrethroid'];
        }
        if (str_contains($str, 'permetrin') || str_contains($str, 'permethrin')) {
            return ['Permethrin', 'pyrethroid'];
        }
        if (str_contains($str, 'lamda') || str_contains($str, 'lambda')) {
            return ['Lambda-cyhalothrin', 'pyrethroid'];
        }
        if (str_contains($str, 'cyfluthrin') || str_contains($str, 'siflutrin')) {
            return ['Cyfluthrin', 'pyrethroid'];
        }
        if (str_contains($str, 'etofenprox') || str_contains($str, 'bifenthrin') || str_contains($str, 'transfluthrin')) {
            return [ucwords($raw), 'pyrethroid'];
        }

        // 2. Organofosfat
        if (str_contains($str, 'malathion') || str_contains($str, 'malation')) {
            return ['Malathion', 'organofosfat'];
        }
        if (str_contains($str, 'temefos') || str_contains($str, 'temephos') || str_contains($str, 'abate')) {
            return ['Temephos (Abate)', 'organofosfat'];
        }
        if (str_contains($str, 'pirimiphos') || str_contains($str, 'pirimifos')) {
            return ['Pirimiphos-methyl', 'organofosfat'];
        }
        if (str_contains($str, 'fenitrothion') || str_contains($str, 'chlorpyrifos') || str_contains($str, 'klorpirifos')) {
            return [ucwords($raw), 'organofosfat'];
        }

        // 3. Karbamat
        if (str_contains($str, 'bendiocarb') || str_contains($str, 'bendiokarb')) {
            return ['Bendiocarb', 'karbamat'];
        }
        if (str_contains($str, 'propoxur') || str_contains($str, 'propoksur') || str_contains($str, 'carbosulfan')) {
            return [ucwords($raw), 'karbamat'];
        }

        // 4. Biolarvasida & IGR
        if (str_contains($str, 'bti') || str_contains($str, 'thuringiensis') || str_contains($str, 'bacillus')) {
            return ['Bacillus thuringiensis israelensis (Bti)', 'biolarvasida'];
        }
        if (str_contains($str, 'pyriproxyfen') || str_contains($str, 'diflubenzuron') || str_contains($str, 'methoprene')) {
            return ['Insect Growth Regulator (IGR)', 'biolarvasida'];
        }

        return [ucwords($raw), 'lainnya'];
    }

    /**
     * Dashboard Interaktif Rekomendasi Kebijakan
     */
    public function index(Request $request)
    {
        $data = $this->preparePolicyData($request);
        return view('rekomendasi_kebijakan', $data);
    }

    /**
     * Pratinjau Dokumen Cetak Policy Brief Resmi
     */
    public function preview(Request $request)
    {
        $data = $this->preparePolicyData($request);
        return view('rekomendasi_kebijakan_preview', $data);
    }

    /**
     * Logika Agregasi & Analisis Rekomendasi Kebijakan
     */
    protected function preparePolicyData(Request $request): array
    {
        // 1. Ambil Opsi Filter Master
        $provinsis = Provinsi::orderBy('name', 'asc')->get();

        $tahunDb = DataUjiResistensi::select('year')
            ->distinct()
            ->whereNotNull('year')
            ->pluck('year')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->toArray();
        $daftarTahun = array_values(array_unique(array_merge([(int)date('Y'), (int)date('Y') - 1], $tahunDb)));
        rsort($daftarTahun);

        $daftarNyamuk = DataUjiResistensi::select('mosquito_type')
            ->distinct()
            ->whereNotNull('mosquito_type')
            ->where('mosquito_type', '!=', '')
            ->orderBy('mosquito_type', 'asc')
            ->pluck('mosquito_type');

        // 2. Baca Parameter Filter
        $tahunFilter = $request->get('tahun', 'Semua');
        $nyamukFilter = $request->get('jenis_nyamuk', 'Semua');
        $provinsiFilter = $request->get('provinsi_id', 'Semua');
        $kabupatenFilter = $request->get('kabupaten_id', 'Semua');

        // 3. Query Dasar Terfilter
        $query = DataUjiResistensi::query();
        if ($tahunFilter !== 'Semua') {
            $query->where('data_uji_resistensis.year', (int)$tahunFilter);
        }
        if ($nyamukFilter !== 'Semua') {
            $nyamukLower = strtolower($nyamukFilter);
            if (str_contains($nyamukLower, 'aegypti')) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(data_uji_resistensis.mosquito_type) LIKE ?', ['%aegypti%']);
                });
            } elseif (str_contains($nyamukLower, 'albopictus')) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(data_uji_resistensis.mosquito_type) LIKE ?', ['%albopictus%']);
                });
            } else {
                $query->where('data_uji_resistensis.mosquito_type', $nyamukFilter);
            }
        }
        if ($kabupatenFilter !== 'Semua' && !empty($kabupatenFilter)) {
            $query->where('data_uji_resistensis.kabupaten_id', $kabupatenFilter);
        } elseif ($provinsiFilter !== 'Semua') {
            $query->where('data_uji_resistensis.provinsi_id', $provinsiFilter);
        }

        // Daftar Kabupaten untuk filter dinamis jika provinsi dipilih
        $daftarKabupaten = collect();
        if ($provinsiFilter !== 'Semua') {
            $daftarKabupaten = Kabupaten::where('provinsi_id', $provinsiFilter)
                ->orderBy('name', 'asc')
                ->get();
        }

        // Nama cakupan wilayah untuk teks laporan
        $namaWilayah = 'Tingkat Nasional (Seluruh Indonesia)';
        $selectedProvinsi = null;
        $selectedKabupaten = null;

        if ($provinsiFilter !== 'Semua') {
            $selectedProvinsi = Provinsi::find($provinsiFilter);
            if ($selectedProvinsi) {
                $namaWilayah = 'Provinsi ' . $selectedProvinsi->name;
            }
        }
        if ($kabupatenFilter !== 'Semua' && !empty($kabupatenFilter)) {
            $selectedKabupaten = Kabupaten::find($kabupatenFilter);
            if ($selectedKabupaten) {
                $namaWilayah = $selectedKabupaten->name . ($selectedProvinsi ? ', ' . $selectedProvinsi->name : '');
            }
        }

        // 4. Hitung Metrik Kunci
        $totalPemeriksaan = (clone $query)->count();
        $totalSampel = (int)(clone $query)->sum('data_uji_resistensis.sample_count');

        $totalResisten = (clone $query)->whereRaw('LOWER(data_uji_resistensis.status) = ?', ['resisten'])->count();
        $totalToleran = (clone $query)->where(function ($q) {
            $q->whereRaw('LOWER(data_uji_resistensis.status) LIKE ?', ['%toleran%'])
              ->orWhereRaw('LOWER(data_uji_resistensis.status) LIKE ?', ['%terduga%']);
        })->count();
        $totalRentan = (clone $query)->whereRaw('LOWER(data_uji_resistensis.status) = ?', ['rentan'])->count();

        $persenResisten = $totalPemeriksaan > 0 ? round(($totalResisten / $totalPemeriksaan) * 100, 1) : 0;
        $persenToleran  = $totalPemeriksaan > 0 ? round(($totalToleran / $totalPemeriksaan) * 100, 1) : 0;
        $persenRentan   = $totalPemeriksaan > 0 ? round(($totalRentan / $totalPemeriksaan) * 100, 1) : 0;

        // 5. Analisis Tingkat Kesiapsiagaan / Indeks Risiko Vektor (Alert Level)
        $alertLevel = 'RENDAH';
        $alertColor = 'emerald';
        $alertBadge = '🟢 KESIAPSIAGAAN AMAN / TERKENDALI';
        $alertSummary = 'Sebagian besar populasi vektor masih menunjukkan kerentanan tinggi terhadap insektisida uji. Program pengendalian vektor konvensional berjalan efektif.';

        if ($persenResisten >= 50) {
            $alertLevel = 'KRITIS';
            $alertColor = 'rose';
            $alertBadge = '🔴 SIAGA TINGGI (DARURAT RESISTENSI)';
            $alertSummary = 'Mayoritas pengujian menunjukkan resistensi vektor (≥ 50%). Terjadi risiko kegagalan pengendalian kimiawi massal di lapangan. Moratorium bahan aktif harus segera diberlakukan.';
        } elseif ($persenResisten >= 20 || ($persenResisten + $persenToleran) >= 45) {
            $alertLevel = 'WASPADA';
            $alertColor = 'amber';
            $alertBadge = '🟡 SIAGA SEDANG (WASPADA RESISTENSI)';
            $alertSummary = 'Terdeteksi peningkatan populasi vektor toleran dan resisten secara signifikan. Diperlukan rotasi bahan aktif lintas golongan dan pengawasan uji bioassay berkala.';
        }

        // Catatan basis bukti (surveillance evidence context)
        $catatanBukti = null;
        if ($totalPemeriksaan > 0 && $totalPemeriksaan < 5 && $tahunFilter !== 'Semua') {
            $catatanBukti = "Berdasarkan {$totalPemeriksaan} titik uji spesifik tahun {$tahunFilter} di cakupan wilayah ini. Guna memperkuat keputusan teknis operasional, rekomendasi diselaraskan dengan tren surveilans kerentanan wilayah setempat.";
        }

        // 6. Evaluasi per Bahan Aktif Insektisida (Normalized Core Policy Matrix)
        $rawRecords = (clone $query)
            ->select([
                'data_uji_resistensis.insecticide',
                'data_uji_resistensis.sample_count',
                'data_uji_resistensis.status'
            ])
            ->whereNotNull('data_uji_resistensis.insecticide')
            ->where('data_uji_resistensis.insecticide', '!=', '')
            ->get();

        $aggregated = [];
        foreach ($rawRecords as $row) {
            [$stdName, $golKey] = $this->normalizeInsecticide($row->insecticide);
            $golInfo = $this->golonganKimia[$golKey] ?? [
                'nama' => 'Golongan Lainnya',
                'warna' => 'slate',
                'deskripsi' => 'Bahan aktif dengan mekanisme kerja non-standar.'
            ];

            if (!isset($aggregated[$stdName])) {
                $aggregated[$stdName] = [
                    'nama' => $stdName,
                    'golongan_key' => $golKey,
                    'golongan_nama' => $golInfo['nama'],
                    'golongan_warna' => $golInfo['warna'],
                    'total_uji' => 0,
                    'total_sampel' => 0,
                    'resisten' => 0,
                    'toleran' => 0,
                    'rentan' => 0,
                    'raw_formulations' => []
                ];
            }

            $aggregated[$stdName]['total_uji']++;
            $aggregated[$stdName]['total_sampel'] += (int)($row->sample_count ?? 1);

            $st = strtolower(trim($row->status ?? ''));
            if ($st === 'resisten') {
                $aggregated[$stdName]['resisten']++;
            } elseif (str_contains($st, 'toleran') || str_contains($st, 'terduga')) {
                $aggregated[$stdName]['toleran']++;
            } elseif ($st === 'rentan') {
                $aggregated[$stdName]['rentan']++;
            }

            $rawLabel = trim($row->insecticide);
            if (!in_array($rawLabel, $aggregated[$stdName]['raw_formulations'])) {
                $aggregated[$stdName]['raw_formulations'][] = $rawLabel;
            }
        }

        // Urutkan berdasarkan total uji terbanyak
        uasort($aggregated, fn($a, $b) => $b['total_uji'] <=> $a['total_uji']);

        $matriksInsektisida = [];
        $dilarangList = [];
        $pengawasanList = [];
        $direkomendasikanList = [];

        foreach ($aggregated as $stdName => $agg) {
            $total = $agg['total_uji'];
            $res = $agg['resisten'];
            $tol = $agg['toleran'];
            $ren = $agg['rentan'];

            $pctRes = $total > 0 ? round(($res / $total) * 100, 1) : 0;
            $pctTol = $total > 0 ? round(($tol / $total) * 100, 1) : 0;
            $pctRen = $total > 0 ? round(($ren / $total) * 100, 1) : 0;

            // Klasifikasi Rekomendasi Kebijakan Berbasis Standar WHO / Kemenkes
            if ($pctRes >= 50 || ($res > $ren && $res > 0)) {
                $statusAksi = 'MORATORIUM';
                $badgeAksi = '❌ STOP / MORATORIUM';
                $badgeColor = 'rose';
                $catatan = 'Tidak efektif. Efikasi telah gugur di bawah ambang batas WHO (< 90%). Hentikan pengadaan dan penyemprotan rutin bahan ini.';
                $dilarangList[] = [
                    'nama' => $stdName,
                    'golongan' => $agg['golongan_nama'],
                    'pctResisten' => $pctRes,
                    'totalUji' => $total
                ];
            } elseif ($pctTol >= 30 || $pctRes > 15) {
                $statusAksi = 'PENGAWASAN';
                $badgeAksi = '⚠️ EVALUASI KETAT';
                $badgeColor = 'amber';
                $catatan = 'Mulai terbentuk kekebalan vektor. Lakukan bioassay konfirmasi ulang dalam 3-6 bulan dan kombinasikan dengan larvasida biologi.';
                $pengawasanList[] = [
                    'nama' => $stdName,
                    'golongan' => $agg['golongan_nama'],
                    'pctToleran' => $pctTol,
                    'totalUji' => $total
                ];
            } else {
                $statusAksi = 'REKOMENDASI';
                $badgeAksi = '✅ REKOMENDASI UTAMA';
                $badgeColor = 'emerald';
                $catatan = 'Vektor terbukti masih rentan (efikasi mortalitas tinggi). Sangat direkomendasikan sebagai senjata utama pengendalian.';
                $direkomendasikanList[] = [
                    'nama' => $stdName,
                    'golongan' => $agg['golongan_nama'],
                    'pctRentan' => $pctRen,
                    'totalUji' => $total
                ];
            }

            $matriksInsektisida[] = [
                'nama' => $stdName,
                'formulasi' => implode(', ', $agg['raw_formulations']),
                'golongan_key' => $agg['golongan_key'],
                'golongan_nama' => $agg['golongan_nama'],
                'golongan_warna' => $agg['golongan_warna'],
                'total_uji' => $total,
                'total_sampel' => $agg['total_sampel'],
                'resisten' => $res,
                'toleran' => $tol,
                'rentan' => $ren,
                'persen_resisten' => $pctRes,
                'persen_toleran' => $pctTol,
                'persen_rentan' => $pctRen,
                'status_aksi' => $statusAksi,
                'badge_aksi' => $badgeAksi,
                'badge_color' => $badgeColor,
                'catatan' => $catatan
            ];
        }

        // 7. Usulan Strategi Pasangan Rotasi (Rotation Pairing Logic IRAC / WHO)
        $strategiRotasi = [];
        if (count($dilarangList) > 0) {
            foreach ($dilarangList as $larang) {
                // 1. Cari alternatif dari golongan yang berbeda yang berstatus direkomendasikan di wilayah ini
                $alternatif = collect($direkomendasikanList)
                    ->filter(fn($item) => $item['golongan'] !== $larang['golongan'])
                    ->first();

                if ($alternatif) {
                    $namaAlt = $alternatif['nama'] . ' (' . $alternatif['golongan'] . ')';
                    $rasional = 'Beralih ke bahan aktif terbukti rentan dari golongan MoA berbeda guna memutus transmisi mutasi gen resistensi silang.';
                } else {
                    // 2. Jika tidak ada yang rentan di filter ini, berikan arahan ilmiah standar WHO & Kemenkes berdasarkan golongan yang dilarang
                    if (str_contains(strtolower($larang['golongan']), 'pyrethroid')) {
                        $namaAlt = 'Organofosfat (Malathion/Pirimiphos-methyl) & Biolarvasida Bti';
                        $rasional = 'Rotasi target reseptor saraf dari kanal natrium ke inhibitor asetilkolinesterase (AChE) serta intervensi pradewasa non-kimiawi.';
                    } elseif (str_contains(strtolower($larang['golongan']), 'organofosfat')) {
                        $namaAlt = 'Karbamat (Bendiocarb - IRS) & Biolarvasida Bti / IGR';
                        $rasional = 'Menghindari kelelahan reseptor AChE dan memutus siklus hidup vektor di sarang perkembangbiakan jentik.';
                    } elseif (str_contains(strtolower($larang['golongan']), 'karbamat')) {
                        $namaAlt = 'Organofosfat Terkalibrasi & Biolarvasida Bti';
                        $rasional = 'Alternatif pengendalian dewasa berbasis regulasi dosis tepat serta larvasidasi biologi.';
                    } else {
                        $namaAlt = 'Biolarvasida Bti & Pengendalian Lingkungan (PSN 3M-Plus)';
                        $rasional = 'Mengalihkan fokus ke eliminasi jentik tanpa ketergantungan racun kimiawi sintetis.';
                    }
                }

                $strategiRotasi[] = [
                    'dilarang' => $larang['nama'] . ' (' . $larang['golongan'] . ')',
                    'alternatif' => $namaAlt,
                    'alasan' => $rasional
                ];
            }
        }

        // 8. Top 5 Wilayah Paling Rawan (jika filter nasional/provinsi)
        $topWilayahRawan = [];
        if ($kabupatenFilter === 'Semua') {
            $topWilayahRawan = (clone $query)
                ->join('kabupatens', 'data_uji_resistensis.kabupaten_id', '=', 'kabupatens.id')
                ->select(
                    'kabupatens.name as nama_kabupaten',
                    DB::raw('COUNT(*) as total_uji'),
                    DB::raw("SUM(CASE WHEN LOWER(data_uji_resistensis.status) = 'resisten' THEN 1 ELSE 0 END) as resisten")
                )
                ->groupBy('kabupatens.id', 'kabupatens.name')
                ->having('resisten', '>', 0)
                ->orderByDesc('resisten')
                ->limit(5)
                ->get();
        }

        return [
            'provinsis' => $provinsis,
            'daftarTahun' => $daftarTahun,
            'daftarNyamuk' => $daftarNyamuk,
            'daftarKabupaten' => $daftarKabupaten,
            'tahunFilter' => $tahunFilter,
            'nyamukFilter' => $nyamukFilter,
            'provinsiFilter' => $provinsiFilter,
            'kabupatenFilter' => $kabupatenFilter,
            'selectedProvinsi' => $selectedProvinsi,
            'selectedKabupaten' => $selectedKabupaten,
            'namaWilayah' => $namaWilayah,
            'totalPemeriksaan' => $totalPemeriksaan,
            'totalSampel' => $totalSampel,
            'totalResisten' => $totalResisten,
            'totalToleran' => $totalToleran,
            'totalRentan' => $totalRentan,
            'persenResisten' => $persenResisten,
            'persenToleran' => $persenToleran,
            'persenRentan' => $persenRentan,
            'alertLevel' => $alertLevel,
            'alertColor' => $alertColor,
            'alertBadge' => $alertBadge,
            'alertSummary' => $alertSummary,
            'catatanBukti' => $catatanBukti,
            'matriksInsektisida' => $matriksInsektisida,
            'dilarangList' => $dilarangList,
            'pengawasanList' => $pengawasanList,
            'direkomendasikanList' => $direkomendasikanList,
            'strategiRotasi' => $strategiRotasi,
            'topWilayahRawan' => $topWilayahRawan,
            'golonganMaster' => $this->golonganKimia
        ];
    }
}
