<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\DataUjiResistensi;
use App\Models\Instansi;
use App\Models\RekomendasiApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RekomendasiKebijakanController extends Controller
{
    /**
     * Peta Golongan Kimia & IRAC MoA Insektisida
     * Referensi: IRAC MoA Classification Scheme v11.0 (2023)
     *
     * KOREKSI PENTING:
     * - Organofosfat (IRAC 1B) dan Karbamat (IRAC 1A) sama-sama inhibitor AChE.
     *   Rotasi antara keduanya BUKAN rotasi MoA sejati (tidak direkomendasikan WHO sebagai anti-resistance strategy).
     * - Pyriproxyfen = Juvenile Hormone Analog (IRAC 7C), BUKAN penghambat sintesis kitin.
     *   Penghambat kitin = Benzoylurea seperti Diflubenzuron (IRAC 15).
     * - Rotasi MoA sejati: Pyrethroid (3A) → Organofosfat/Karbamat (1B/1A) → Biolarvasida Bti (11A)
     */
    protected array $golonganKimia = [
        'pyrethroid' => [
            'nama'      => 'Pyrethroid Sintetik',
            'irac_moa'  => 'IRAC 3A – Modulator Kanal Natrium',
            'warna'     => 'rose',
            'deskripsi' => 'Bekerja pada kanal natrium dependen-voltase sel saraf serangga. Umum digunakan untuk fogging, ULV, dan LLINs.',
            'keywords'  => ['cypermethrin','deltamethrin','permethrin','lambda-cyhalothrin','alpha-cypermethrin','etofenprox','bifenthrin','transfluthrin','cyfluthrin']
        ],
        'organofosfat' => [
            'nama'      => 'Organofosfat',
            'irac_moa'  => 'IRAC 1B – Inhibitor AChE (ireversibel)',
            'warna'     => 'amber',
            'deskripsi' => 'Menghambat enzim asetilkolinesterase (AChE) secara ireversibel. Digunakan sebagai adultisida (fogging/ULV) dan larvasida (Temephos).',
            'keywords'  => ['malathion','pirimiphos','fenitrothion','temephos','chlorpyrifos','abate']
        ],
        'karbamat' => [
            'nama'      => 'Karbamat',
            'irac_moa'  => 'IRAC 1A – Inhibitor AChE (reversibel)',
            'warna'     => 'indigo',
            'deskripsi' => 'Menghambat AChE secara reversibel. Digunakan untuk IRS (Indoor Residual Spraying). PERHATIAN: Rotasi Karbamat ↔ Organofosfat bukan rotasi MoA sejati karena keduanya menginhibisi AChE (target reseptor sama, hanya mekanisme ikatan berbeda).',
            'keywords'  => ['bendiocarb','propoxur','carbosulfan']
        ],
        'biolarvasida_bti' => [
            'nama'      => 'Biolarvasida Bti',
            'irac_moa'  => 'IRAC 11A – Disruptor Membran Sel Pertengahan (Protein Cry)',
            'warna'     => 'emerald',
            'deskripsi' => 'Bacillus thuringiensis israelensis (Bti) menghasilkan kristal toksin (Cry proteins) yang merusak sel epitel usus tengah jentik nyamuk. Tidak menimbulkan resistensi silang dengan insektisida kimiawi dewasa.',
            'keywords'  => ['bti','bacillus','thuringiensis']
        ],
        'igr_jha' => [
            'nama'      => 'IGR – Juvenile Hormone Analog (JHA)',
            'irac_moa'  => 'IRAC 7C – Agonis Reseptor Juvenoid',
            'warna'     => 'teal',
            'deskripsi' => 'Pyriproxyfen meniru hormon juvenil serangga, mencegah perkembangan menjadi dewasa. BUKAN penghambat sintesis kitin. Digunakan pada stadium pradewasa (jentik/pupa).',
            'keywords'  => ['pyriproxyfen']
        ],
        'igr_csi' => [
            'nama'      => 'IGR – Penghambat Sintesis Kitin (CSI)',
            'irac_moa'  => 'IRAC 15 – Penghambat Biosintesis Kitin Tipe 0',
            'warna'     => 'cyan',
            'deskripsi' => 'Benzoylurea (Diflubenzuron, dll.) menghambat sintesis kitin sehingga jentik gagal berganti kulit. Digunakan eksklusif pada stadium pradewasa.',
            'keywords'  => ['diflubenzuron','novaluron','hexaflumuron']
        ],
        'igr_ga' => [
            'nama'      => 'IGR – Growth Accelerator (Methoprene)',
            'irac_moa'  => 'IRAC 7A – Agonis Reseptor Ecdyson',
            'warna'     => 'sky',
            'deskripsi' => 'Methoprene mengganggu proses metamorfosis serangga melalui aksi agonis reseptor ecdyson. Digunakan pada stadium pradewasa.',
            'keywords'  => ['methoprene']
        ],
    ];

    /**
     * Normalisasi Bahan Aktif dan Deteksi Golongan Kimia / IRAC MoA
     */
    protected function normalizeInsecticide(string $raw): array
    {
        $str = strtolower(trim($raw));

        // 1. Pyrethroid (IRAC 3A)
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
        if (str_contains($str, 'etofenprox')) {
            return ['Etofenprox', 'pyrethroid'];
        }
        if (str_contains($str, 'bifenthrin')) {
            return ['Bifenthrin', 'pyrethroid'];
        }
        if (str_contains($str, 'transfluthrin')) {
            return ['Transfluthrin', 'pyrethroid'];
        }

        // 2. Organofosfat (IRAC 1B) – ADULTISIDA
        if (str_contains($str, 'malathion') || str_contains($str, 'malation')) {
            return ['Malathion', 'organofosfat'];
        }
        if (str_contains($str, 'pirimiphos') || str_contains($str, 'pirimifos')) {
            return ['Pirimiphos-methyl', 'organofosfat'];
        }
        if (str_contains($str, 'fenitrothion')) {
            return ['Fenitrothion', 'organofosfat'];
        }
        if (str_contains($str, 'chlorpyrifos') || str_contains($str, 'klorpirifos')) {
            return ['Chlorpyrifos', 'organofosfat'];
        }
        // Temephos: Organofosfat tapi LARVASIDA – ditandai khusus
        if (str_contains($str, 'temefos') || str_contains($str, 'temephos') || str_contains($str, 'abate')) {
            return ['Temephos/Abate (Larvasida-OP)', 'organofosfat'];
        }

        // 3. Karbamat (IRAC 1A) – ADULTISIDA/IRS
        if (str_contains($str, 'bendiocarb') || str_contains($str, 'bendiokarb')) {
            return ['Bendiocarb', 'karbamat'];
        }
        if (str_contains($str, 'propoxur') || str_contains($str, 'propoksur')) {
            return ['Propoxur', 'karbamat'];
        }
        if (str_contains($str, 'carbosulfan')) {
            return ['Carbosulfan', 'karbamat'];
        }

        // 4. Biolarvasida Bti (IRAC 11A)
        if (str_contains($str, 'bti') || str_contains($str, 'thuringiensis') || str_contains($str, 'bacillus')) {
            return ['Bacillus thuringiensis israelensis (Bti)', 'biolarvasida_bti'];
        }

        // 5. IGR – JHA Pyriproxyfen (IRAC 7C) — BUKAN penghambat kitin
        if (str_contains($str, 'pyriproxyfen')) {
            return ['Pyriproxyfen (JH Analog)', 'igr_jha'];
        }

        // 6. IGR – CSI Benzoylurea (IRAC 15)
        if (str_contains($str, 'diflubenzuron') || str_contains($str, 'novaluron')) {
            return ['Diflubenzuron (CSI)', 'igr_csi'];
        }

        // 7. IGR – Methoprene (IRAC 7A)
        if (str_contains($str, 'methoprene')) {
            return ['Methoprene', 'igr_ga'];
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
        // Verifikasi hak akses admin atau kepala/pimpinan
        if (!auth()->check() || (!auth()->user()->isAdmin() && !auth()->user()->canApproveRekomendasi())) {
            abort(403, 'Akses Ditolak: Modul Rekomendasi Kebijakan hanya dapat diakses oleh Administrator atau Kepala/Pimpinan.');
        }

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
        $tahunFilter     = $request->get('tahun', 'Semua');
        $nyamukFilter    = $request->get('jenis_nyamuk', 'Semua');
        $provinsiFilter  = $request->get('provinsi_id', 'Semua');
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
            } elseif (str_contains($nyamukLower, 'anopheles')) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(data_uji_resistensis.mosquito_type) LIKE ?', ['%anopheles%']);
                });
            } elseif (str_contains($nyamukLower, 'culex')) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(data_uji_resistensis.mosquito_type) LIKE ?', ['%culex%']);
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

        // Daftar Kabupaten untuk filter dinamis
        $daftarKabupaten = collect();
        if ($provinsiFilter !== 'Semua') {
            $daftarKabupaten = Kabupaten::where('provinsi_id', $provinsiFilter)
                ->orderBy('name', 'asc')
                ->get();
        }

        // Nama cakupan wilayah
        $namaWilayah     = 'Tingkat Nasional (Seluruh Indonesia)';
        $selectedProvinsi  = null;
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

        // Parameter Template
        $activeTemplate = $request->get('template', 'kemenkes');
        if (!in_array($activeTemplate, ['kemenkes', 'eksekutif', 'laboratorium', 'agregat'])) {
            $activeTemplate = 'kemenkes';
        }

        // 4. Hitung Metrik Kunci (agregat semua spesies – hanya untuk summary statistik, BUKAN dasar rekomendasi)
        $totalPemeriksaan = (clone $query)->count();
        $totalSampel      = (int)(clone $query)->sum('data_uji_resistensis.sample_count');

        $totalResisten = (clone $query)->whereRaw('LOWER(data_uji_resistensis.status) = ?', ['resisten'])->count();
        $totalToleran  = (clone $query)->where(function ($q) {
            $q->whereRaw('LOWER(data_uji_resistensis.status) LIKE ?', ['%toleran%'])
              ->orWhereRaw('LOWER(data_uji_resistensis.status) LIKE ?', ['%terduga%']);
        })->count();
        $totalRentan = (clone $query)->whereRaw('LOWER(data_uji_resistensis.status) = ?', ['rentan'])->count();

        $persenResisten = $totalPemeriksaan > 0 ? round(($totalResisten / $totalPemeriksaan) * 100, 1) : 0;
        $persenToleran  = $totalPemeriksaan > 0 ? round(($totalToleran  / $totalPemeriksaan) * 100, 1) : 0;
        $persenRentan   = $totalPemeriksaan > 0 ? round(($totalRentan   / $totalPemeriksaan) * 100, 1) : 0;

        // Rata-rata sampel per pengujian
        $rataRataSampelPerUji = $totalPemeriksaan > 0 ? round($totalSampel / $totalPemeriksaan, 1) : 0;

        // 5. Status Kewaspadaan – HANYA untuk Template 1 (Eksekutif) & Template 2 (Kemenkes)
        // Template 3 (Laboratorium) TIDAK menggunakan label status wilayah karena penetapan status
        // adalah kewenangan Dirjen/Dinkes, bukan laboratorium.
        // WHO (2022) tidak mendefinisikan ambang ≥50% resisten sebagai "darurat" dalam konteks kebijakan wilayah.
        $alertLevel   = 'RENDAH';
        $alertColor   = 'emerald';
        $alertBadge   = '🟢 KERENTANAN TINGGI / TERKENDALI';
        $alertSummary = 'Sebagian besar pengujian menunjukkan vektor masih rentan terhadap insektisida uji. Program pengendalian konvensional berjalan efektif.';

        $alertBadgeKemenkes   = '🟢 KERENTANAN TINGGI / TERKENDALI';
        $alertSummaryKemenkes = 'Sebagian besar populasi vektor uji masih menunjukkan kerentanan tinggi (mortalitas ≥ 98%). Pengendalian vektor kimiawi berjalan efektif dan dapat dilanjutkan dengan pemantauan bioassay berkala sesuai Permenkes No. 2 Tahun 2023 dan WHO Manual for Monitoring Insecticide Resistance in Mosquito Vectors (2022).';

        if ($persenResisten >= 50) {
            $alertLevel   = 'TINGGI';
            $alertColor   = 'rose';
            $alertBadge   = '🔴 PROPORSI RESISTEN TINGGI (≥50% Titik Uji)';
            $alertSummary = 'Lebih dari separuh titik uji menunjukkan hasil resistensi terhadap insektisida yang diuji. Catatan: penetapan status wilayah adalah kewenangan Dirjen P2P / Dinas Kesehatan setempat.';

            $alertBadgeKemenkes   = '🔴 PROPORSI RESISTEN TINGGI';
            $alertSummaryKemenkes = 'Lebih dari separuh pengujian bioassay (WHO Tube Test / Bottle Bioassay) menunjukkan mortalitas di bawah ambang kerentanan WHO 2022 (<90%). Diperlukan review operasional bahan aktif yang digunakan. Catatan: penetapan status wilayah dan moratorium insektisida adalah kewenangan Dirjen P2P Kemenkes RI atau Dinas Kesehatan setempat, bukan laboratorium.';
        } elseif ($persenResisten >= 20 || ($persenResisten + $persenToleran) >= 45) {
            $alertLevel   = 'SEDANG';
            $alertColor   = 'amber';
            $alertBadge   = '🟡 DETEKSI KEMUNGKINAN RESISTENSI (Perlu Konfirmasi)';
            $alertSummary = 'Terdeteksi sejumlah hasil pengujian dengan mortalitas 90–97% (kemungkinan resistensi) dan/atau resisten terkonfirmasi. Disarankan uji bioassay konfirmasi ulang dan uji sinergis PBO.';

            $alertBadgeKemenkes   = '🟡 KEMUNGKINAN RESISTENSI TERDETEKSI';
            $alertSummaryKemenkes = 'Terdeteksi proporsi pengujian dengan mortalitas 90–97% (kategori "kemungkinan resisten" per WHO Manual 2022) dan/atau resistensi terkonfirmasi. Direkomendasikan: (1) uji bioassay konfirmasi ulang, (2) uji sinergis PBO untuk deteksi mekanisme enzymatic detoxification, (3) koordinasi dengan Dinas Kesehatan untuk review strategi pengendalian.';
        }

        // Catatan basis bukti
        $catatanBukti = null;
        if ($totalPemeriksaan > 0 && $totalPemeriksaan < 5 && $tahunFilter !== 'Semua') {
            $catatanBukti = "Data terbatas: hanya {$totalPemeriksaan} titik uji pada tahun {$tahunFilter} dalam cakupan wilayah ini. Interpretasi harus dilakukan dengan kehati-hatian. Sampel minimum yang direkomendasikan WHO untuk pengambilan keputusan = 25 nyamuk per uji, minimal 3 pengulangan.";
        }

        // 6. Evaluasi per Bahan Aktif (Agregat semua spesies – untuk matriks visual)
        $rawRecords = (clone $query)
            ->select([
                'data_uji_resistensis.insecticide',
                'data_uji_resistensis.mosquito_type',
                'data_uji_resistensis.sample_count',
                'data_uji_resistensis.status',
                'data_uji_resistensis.year',
            ])
            ->whereNotNull('data_uji_resistensis.insecticide')
            ->where('data_uji_resistensis.insecticide', '!=', '')
            ->get();

        // Agregat per bahan aktif (semua spesies – untuk matriks ringkasan)
        $aggregated = [];
        // Agregat per bahan aktif PER SPESIES (untuk Template 3)
        $aggregatedPerSpesies = [];

        foreach ($rawRecords as $row) {
            [$stdName, $golKey] = $this->normalizeInsecticide($row->insecticide);
            $golInfo = $this->golonganKimia[$golKey] ?? [
                'nama'     => 'Golongan Lainnya',
                'irac_moa' => 'Tidak Terklasifikasi',
                'warna'    => 'slate',
                'deskripsi' => 'Bahan aktif dengan mekanisme kerja non-standar atau belum terklasifikasi.'
            ];

            // --- Agregat semua spesies ---
            if (!isset($aggregated[$stdName])) {
                $aggregated[$stdName] = [
                    'nama'           => $stdName,
                    'golongan_key'   => $golKey,
                    'golongan_nama'  => $golInfo['nama'],
                    'irac_moa'       => $golInfo['irac_moa'] ?? '-',
                    'golongan_warna' => $golInfo['warna'],
                    'total_uji'      => 0,
                    'total_sampel'   => 0,
                    'resisten'       => 0,
                    'toleran'        => 0,
                    'rentan'         => 0,
                    'raw_formulations' => [],
                    'spesies_diuji'  => [],
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

            $sp = trim($row->mosquito_type ?? 'Tidak Teridentifikasi');
            if (!in_array($sp, $aggregated[$stdName]['spesies_diuji'])) {
                $aggregated[$stdName]['spesies_diuji'][] = $sp;
            }

            // --- Agregat per spesies (untuk Template 3 Laboratorium) ---
            $spKey = strtolower(str_replace(' ', '_', $sp));
            $keyPerSp = $stdName . '||' . $spKey;
            if (!isset($aggregatedPerSpesies[$keyPerSp])) {
                $aggregatedPerSpesies[$keyPerSp] = [
                    'nama'           => $stdName,
                    'spesies'        => $sp,
                    'golongan_key'   => $golKey,
                    'golongan_nama'  => $golInfo['nama'],
                    'irac_moa'       => $golInfo['irac_moa'] ?? '-',
                    'golongan_warna' => $golInfo['warna'],
                    'total_uji'      => 0,
                    'total_sampel'   => 0,
                    'resisten'       => 0,
                    'toleran'        => 0,
                    'rentan'         => 0,
                ];
            }
            $aggregatedPerSpesies[$keyPerSp]['total_uji']++;
            $aggregatedPerSpesies[$keyPerSp]['total_sampel'] += (int)($row->sample_count ?? 1);
            if ($st === 'resisten') {
                $aggregatedPerSpesies[$keyPerSp]['resisten']++;
            } elseif (str_contains($st, 'toleran') || str_contains($st, 'terduga')) {
                $aggregatedPerSpesies[$keyPerSp]['toleran']++;
            } elseif ($st === 'rentan') {
                $aggregatedPerSpesies[$keyPerSp]['rentan']++;
            }
        }

        // Urutkan berdasarkan total uji terbanyak
        uasort($aggregated, fn($a, $b) => $b['total_uji'] <=> $a['total_uji']);

        // ===================================================================
        // ALGORITMA KLASIFIKASI WHO 2022 – KONSISTEN & ALGORITMIK
        // Referensi: WHO Manual for Monitoring Insecticide Resistance in
        // Mosquito Vectors (2022), Tabel 1, hal. 8:
        //   - Rentan       : mortalitas ≥ 98%
        //   - Kemungkinan Resisten: mortalitas 90–97%
        //   - Dikonfirmasi Resisten: mortalitas < 90%
        //
        // Karena database menyimpan STATUS (bukan % mortalitas aktual),
        // kita mapping: 'rentan' = ≥98%, 'toleran/terduga' = 90-97%, 'resisten' = <90%.
        // Klasifikasi akhir mengikuti kategori WHO berdasarkan proporsi pengujian:
        //   - MORATORIUM  : >50% pengujian = resisten ATAU resisten > rentan
        //   - PENGAWASAN  : ≥20% toleran ATAU ≥10% resisten (namun <MORATORIUM)
        //   - RENTAN/REKOMEN: semua sisanya
        //
        // PENTING: Bahan yang tidak ada data lokal TIDAK boleh direkomendasikan.
        // PENTING: Bahan di kategori MORATORIUM tidak boleh muncul sebagai "alternatif rotasi".
        // ===================================================================
        $matriksInsektisida   = [];
        $dilarangList         = [];
        $pengawasanList       = [];
        $direkomendasikanList = [];

        foreach ($aggregated as $stdName => $agg) {
            $total = $agg['total_uji'];
            $res   = $agg['resisten'];
            $tol   = $agg['toleran'];
            $ren   = $agg['rentan'];

            $pctRes = $total > 0 ? round(($res / $total) * 100, 1) : 0;
            $pctTol = $total > 0 ? round(($tol / $total) * 100, 1) : 0;
            $pctRen = $total > 0 ? round(($ren / $total) * 100, 1) : 0;
            $rataSmpl = $total > 0 ? round($agg['total_sampel'] / $total, 1) : 0;

            // KLASIFIKASI KONSISTEN (satu aturan algoritmik):
            // Prioritas: MORATORIUM > PENGAWASAN > RENTAN
            if ($pctRes >= 50 || $res > $ren) {
                // Dikonfirmasi resisten: >50% titik uji resisten, ATAU lebih banyak resisten dari rentan
                $statusAksi = 'MORATORIUM';
                $badgeAksi  = '❌ DIKONFIRMASI RESISTEN';
                $badgeColor = 'rose';
                $catatan    = "Proporsi resisten: {$pctRes}% dari {$total} titik uji. Mortalitas pada banyak pengujian kemungkinan <90%. Tidak direkomendasikan untuk program pengendalian hingga ada data bioassay ulang yang menunjukkan pemulihan kerentanan. (WHO Manual 2022)";
                $dilarangList[] = [
                    'nama'       => $stdName,
                    'golongan'   => $agg['golongan_key'],
                    'golongan_nama' => $agg['golongan_nama'],
                    'irac_moa'   => $agg['irac_moa'],
                    'pctResisten' => $pctRes,
                    'pctToleran'  => $pctTol,
                    'pctRentan'   => $pctRen,
                    'totalUji'   => $total,
                    'rataSmpl'   => $rataSmpl,
                ];
            } elseif ($pctTol >= 20 || $pctRes >= 10) {
                // Kemungkinan resisten: sinyal awal perlu dikonfirmasi
                $statusAksi = 'PENGAWASAN';
                $badgeAksi  = '⚠️ KEMUNGKINAN RESISTEN – Perlu Konfirmasi';
                $badgeColor = 'amber';
                $catatan    = "Terdeteksi {$pctTol}% toleran (mortalitas 90–97%) dan {$pctRes}% resisten dari {$total} titik uji. Disarankan: (1) bioassay konfirmasi ulang (≥3 pengulangan, ≥25 nyamuk/uji), (2) uji sinergis PBO untuk identifikasi mekanisme resistensi.";
                $pengawasanList[] = [
                    'nama'        => $stdName,
                    'golongan'    => $agg['golongan_key'],
                    'golongan_nama' => $agg['golongan_nama'],
                    'irac_moa'    => $agg['irac_moa'],
                    'pctToleran'  => $pctTol,
                    'pctResisten' => $pctRes,
                    'pctRentan'   => $pctRen,
                    'totalUji'    => $total,
                    'rataSmpl'    => $rataSmpl,
                ];
            } else {
                // Rentan terkonfirmasi: mayoritas rentan, sedikit/tidak ada sinyal resistensi
                $statusAksi = 'REKOMENDASI';
                $badgeAksi  = '✅ MASIH RENTAN';
                $badgeColor = 'emerald';
                $catatan    = "Proporsi rentan: {$pctRen}% dari {$total} titik uji. Mortalitas mayoritas pengujian kemungkinan ≥98%. Dapat dilanjutkan penggunaannya dengan pemantauan berkala.";
                $direkomendasikanList[] = [
                    'nama'       => $stdName,
                    'golongan'   => $agg['golongan_key'],
                    'golongan_nama' => $agg['golongan_nama'],
                    'irac_moa'   => $agg['irac_moa'],
                    'pctRentan'  => $pctRen,
                    'pctToleran' => $pctTol,
                    'pctResisten'=> $pctRes,
                    'totalUji'   => $total,
                    'rataSmpl'   => $rataSmpl,
                ];
            }

            $matriksInsektisida[] = [
                'nama'           => $stdName,
                'formulasi'      => implode(', ', $agg['raw_formulations']),
                'golongan_key'   => $agg['golongan_key'],
                'golongan_nama'  => $agg['golongan_nama'],
                'irac_moa'       => $agg['irac_moa'],
                'golongan_warna' => $agg['golongan_warna'],
                'total_uji'      => $total,
                'total_sampel'   => $agg['total_sampel'],
                'rata_sampel_per_uji' => $rataSmpl,
                'resisten'       => $res,
                'toleran'        => $tol,
                'rentan'         => $ren,
                'persen_resisten' => $pctRes,
                'persen_toleran'  => $pctTol,
                'persen_rentan'   => $pctRen,
                'status_aksi'    => $statusAksi,
                'badge_aksi'     => $badgeAksi,
                'badge_color'    => $badgeColor,
                'catatan'        => $catatan,
                'spesies_diuji'  => $agg['spesies_diuji'],
            ];
        }

        // ===================================================================
        // 7. MATRIKS PER SPESIES (untuk Template 3 Laboratorium)
        // ===================================================================
        $matriksPerSpesies = [];
        foreach ($aggregatedPerSpesies as $keyPerSp => $agg) {
            $total  = $agg['total_uji'];
            $res    = $agg['resisten'];
            $tol    = $agg['toleran'];
            $ren    = $agg['rentan'];
            $pctRes = $total > 0 ? round(($res / $total) * 100, 1) : 0;
            $pctTol = $total > 0 ? round(($tol / $total) * 100, 1) : 0;
            $pctRen = $total > 0 ? round(($ren / $total) * 100, 1) : 0;
            $rataSmpl = $total > 0 ? round($agg['total_sampel'] / $total, 1) : 0;

            // Klasifikasi WHO 2022
            if ($pctRes >= 50 || $res > $ren) {
                $statusWho = 'DIKONFIRMASI RESISTEN';
                $whoColor  = 'rose';
            } elseif ($pctTol >= 20 || $pctRes >= 10) {
                $statusWho = 'KEMUNGKINAN RESISTEN';
                $whoColor  = 'amber';
            } else {
                $statusWho = 'RENTAN';
                $whoColor  = 'emerald';
            }

            $spesies = $agg['spesies'];
            if (!isset($matriksPerSpesies[$spesies])) {
                $matriksPerSpesies[$spesies] = [];
            }
            $matriksPerSpesies[$spesies][] = [
                'nama'         => $agg['nama'],
                'golongan_nama'=> $agg['golongan_nama'],
                'irac_moa'     => $agg['irac_moa'],
                'total_uji'    => $total,
                'total_sampel' => $agg['total_sampel'],
                'rata_sampel'  => $rataSmpl,
                'resisten'     => $res,
                'toleran'      => $tol,
                'rentan'       => $ren,
                'pct_resisten' => $pctRes,
                'pct_toleran'  => $pctTol,
                'pct_rentan'   => $pctRen,
                'status_who'   => $statusWho,
                'who_color'    => $whoColor,
            ];
        }

        // ===================================================================
        // 8. Strategi Rotasi – HANYA berbasis data lokal yang RENTAN
        //    Jika tidak ada bahan rentan terkonfirmasi secara lokal → tidak rekomendasikan
        //    Rotasi Karbamat ↔ OP bukan rotasi MoA sejati (keduanya AChE inhibitor)
        // ===================================================================
        $strategiRotasi         = [];
        $strategiRotasiKemenkes = [];
        $adaBahanRentan         = count($direkomendasikanList) > 0;

        if (count($dilarangList) > 0) {
            foreach ($dilarangList as $larang) {
                // Cari alternatif RENTAN dari MoA BERBEDA (bukan sesama AChE inhibitor)
                $alternatif = collect($direkomendasikanList)->filter(function($item) use ($larang) {
                    $larangKey = $larang['golongan'];
                    $itemKey   = $item['golongan'];
                    // Hindari merekomendasikan sesama AChE inhibitor (OP ↔ Karbamat)
                    $achePair  = ['organofosfat', 'karbamat'];
                    if (in_array($larangKey, $achePair) && in_array($itemKey, $achePair)) {
                        return false; // bukan rotasi MoA sejati
                    }
                    return $itemKey !== $larangKey;
                })->first();

                if ($alternatif) {
                    // Ada bahan rentan dari MoA berbeda di database lokal ini
                    $namaAlt     = $alternatif['nama'] . ' (' . $alternatif['golongan_nama'] . ', ' . $alternatif['irac_moa'] . ')';
                    $rasional    = "Rotasi ke {$alternatif['nama']} yang terbukti masih rentan berdasarkan {$alternatif['totalUji']} titik uji lokal (rentan: {$alternatif['pctRentan']}%). MoA berbeda sehingga memutus tekanan seleksi gen resistensi.";
                    $rasionalKm  = $rasional . ' Sesuai prinsip IRAC Insecticide Resistance Management (IRM).';
                } else {
                    // Tidak ada bahan rentan lokal – JANGAN rekomendasi bahan tanpa data
                    $namaAlt    = '⚠️ Belum ada bahan alternatif terkonfirmasi rentan di data lokal ini.';
                    $rasional   = "Tidak ada bahan aktif yang memenuhi kriteria kerentanan (proporsi rentan dominan) dalam dataset wilayah/periode ini. Saran: (1) Lakukan bioassay terhadap bahan aktif yang belum diuji (terutama golongan berbeda dari {$larang['golongan_nama']}); (2) Konsultasikan dengan program nasional pengendalian vektor; (3) Pertimbangkan pendekatan non-kimiawi (PSN 3M-Plus, Biolarvasida Bti) selama menunggu hasil uji.";
                    $rasionalKm = $rasional;
                }

                $strategiRotasi[] = [
                    'dilarang'   => $larang['nama'] . ' (' . $larang['golongan_nama'] . ')',
                    'irac_moa'   => $larang['irac_moa'],
                    'alternatif' => $namaAlt,
                    'alasan'     => $rasional,
                ];
                $strategiRotasiKemenkes[] = [
                    'dilarang'   => $larang['nama'] . ' (' . $larang['golongan_nama'] . ')',
                    'irac_moa'   => $larang['irac_moa'],
                    'alternatif' => $namaAlt,
                    'alasan'     => $rasionalKm,
                ];
            }
        }

        // 9. Top 5 Wilayah Paling Rawan
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

        // 10. Status Persetujuan / Approval Kepala/Pimpinan BBLKL
        $docHash   = RekomendasiApproval::makeDocHash($tahunFilter, $nyamukFilter, $provinsiFilter, $kabupatenFilter, $activeTemplate);
        $scopeHash = RekomendasiApproval::makeScopeHash($tahunFilter, $nyamukFilter, $provinsiFilter, $kabupatenFilter);

        $approval = RekomendasiApproval::where(function($q) use ($docHash, $scopeHash) {
            $q->where('doc_hash', $docHash)
              ->orWhere(function($sub) use ($scopeHash) {
                  $sub->where('filter_scope', $scopeHash)->where('template', 'all');
              });
        })->where('status', 'approved')->latest('approved_at')->first();

        $isApproved     = !is_null($approval);
        $approvalStatus = $isApproved ? 'approved' : 'draft';

        // Ambil data default BBLKL & Penanggung Jawab dari Master Instansi / User
        $bblkl = Instansi::where('unit_code', 'BBLKL-01')
            ->orWhere('name', 'like', '%BBLKL%')
            ->orWhere('name', 'like', '%Balai Besar Laboratorium Kesehatan Lingkungan%')
            ->first();

        $currentUser = auth()->user();
        $defaultKepalaNama = $approval ? $approval->approver_name : (
            ($currentUser && $currentUser->isKepala()) ? $currentUser->name : ($bblkl->person_in_charge ?? 'Kepala Balai Besar Laboratorium Kesehatan Lingkungan')
        );
        $defaultKepalaNip = $approval ? $approval->approver_nip : '19720315 199803 1 002';
        $defaultKepalaJabatan = $approval ? $approval->approver_jabatan : 'Kepala Balai Besar Laboratorium Kesehatan Lingkungan (BBLKL) Salatiga';
        $defaultNomorSurat = $approval ? $approval->nomor_surat : ('LT-VEC/BBLKL/' . date('Y') . '/' . strtoupper(substr(md5($namaWilayah . $tahunFilter . $nyamukFilter . $activeTemplate), 0, 7)));

        // 11. Data Khusus Template 4: Policy Brief Agregat Wilayah & Klaster Kerentanan
        $agregatData = $this->buildAgregatPolicyData($query, $provinsiFilter, $selectedProvinsi, $namaWilayah, $tahunFilter, $nyamukFilter);

        return [
            'provinsis'               => $provinsis,
            'daftarTahun'             => $daftarTahun,
            'daftarNyamuk'            => $daftarNyamuk,
            'daftarKabupaten'         => $daftarKabupaten,
            'tahunFilter'             => $tahunFilter,
            'nyamukFilter'            => $nyamukFilter,
            'provinsiFilter'          => $provinsiFilter,
            'kabupatenFilter'         => $kabupatenFilter,
            'selectedProvinsi'        => $selectedProvinsi,
            'selectedKabupaten'       => $selectedKabupaten,
            'namaWilayah'             => $namaWilayah,
            'activeTemplate'          => $activeTemplate,
            'totalPemeriksaan'        => $totalPemeriksaan,
            'totalSampel'             => $totalSampel,
            'rataRataSampelPerUji'    => $rataRataSampelPerUji,
            'totalResisten'           => $totalResisten,
            'totalToleran'            => $totalToleran,
            'totalRentan'             => $totalRentan,
            'persenResisten'          => $persenResisten,
            'persenToleran'           => $persenToleran,
            'persenRentan'            => $persenRentan,
            'alertLevel'              => $alertLevel,
            'alertColor'              => $alertColor,
            'alertBadge'              => $alertBadge,
            'alertSummary'            => $alertSummary,
            'alertBadgeKemenkes'      => $alertBadgeKemenkes,
            'alertSummaryKemenkes'    => $alertSummaryKemenkes,
            'catatanBukti'            => $catatanBukti,
            'matriksInsektisida'      => $matriksInsektisida,
            'matriksPerSpesies'       => $matriksPerSpesies,
            'dilarangList'            => $dilarangList,
            'pengawasanList'          => $pengawasanList,
            'direkomendasikanList'    => $direkomendasikanList,
            'adaBahanRentan'          => $adaBahanRentan,
            'strategiRotasi'          => $strategiRotasi,
            'strategiRotasiKemenkes'  => $strategiRotasiKemenkes,
            'topWilayahRawan'         => $topWilayahRawan,
            'golonganMaster'          => $this->golonganKimia,
            'approval'                => $approval,
            'isApproved'              => $isApproved,
            'approvalStatus'          => $approvalStatus,
            'docHash'                 => $docHash,
            'scopeHash'               => $scopeHash,
            'defaultKepalaNama'       => $defaultKepalaNama,
            'defaultKepalaNip'        => $defaultKepalaNip,
            'defaultKepalaJabatan'    => $defaultKepalaJabatan,
            'defaultNomorSurat'       => $defaultNomorSurat,
            'bblkl'                   => $bblkl,
            'agregatData'             => $agregatData,
        ];
    }

    /**
     * Data Agregat Wilayah & Analisis Klaster Kerentanan (Template 4)
     * Format persis sesuai Standar Policy Brief Agregat Dinas Kesehatan Provinsi / BBLKL
     */
    protected function buildAgregatPolicyData($query, $provinsiFilter, $selectedProvinsi, $namaWilayah, $tahunFilter, $nyamukFilter): array
    {
        // 1. Total Kabupaten/Kota dalam Cakupan Wilayah
        if ($provinsiFilter !== 'Semua' && !empty($provinsiFilter)) {
            $totalKabupatenDiWilayah = Kabupaten::where('provinsi_id', $provinsiFilter)->count();
        } else {
            $totalKabupatenDiWilayah = Kabupaten::count();
        }
        if ($totalKabupatenDiWilayah <= 0) {
            $totalKabupatenDiWilayah = 35; // Fallback standar provinsi (e.g. Jawa Tengah)
        }

        // 2. 4 Insektisida Kunci sesuai Contoh Policy Brief Agregat:
        //    Deltamethrin (3A), Malathion (1B), Pirimiphos-methyl (1B), Bendiocarb (1A)
        $targetInsektisida = [
            [
                'key'       => 'deltamethrin',
                'nama'      => 'Deltamethrin',
                'label'     => 'Deltamethrin (3A)',
                'header_1'  => 'Delta-',
                'header_2'  => 'methrin',
                'moa'       => '3A',
                'golongan'  => 'Piretroid',
                'keywords'  => ['deltametrin', 'deltamethrin']
            ],
            [
                'key'       => 'malathion',
                'nama'      => 'Malathion',
                'label'     => 'Malathion (1B)',
                'header_1'  => 'Mala-',
                'header_2'  => 'thion',
                'moa'       => '1B',
                'golongan'  => 'Organofosfat',
                'keywords'  => ['malathion', 'malation']
            ],
            [
                'key'       => 'pirimiphos',
                'nama'      => 'Pirimiphos-methyl',
                'label'     => 'Pirimiphos-methyl (1B)',
                'header_1'  => 'Pirimiphos-',
                'header_2'  => 'methyl 1B',
                'moa'       => '1B',
                'golongan'  => 'Organofosfat',
                'keywords'  => ['pirimiphos', 'pirimifos']
            ],
            [
                'key'       => 'bendiocarb',
                'nama'      => 'Bendiocarb',
                'label'     => 'Bendiocarb (1A)',
                'header_1'  => 'Bendio-',
                'header_2'  => 'carb 1A',
                'moa'       => '1A',
                'golongan'  => 'Karbamat',
                'keywords'  => ['bendiocarb', 'bendiokarb']
            ],
        ];

        // 3. Ambil data uji lengkap dalam cakupan query yang memiliki kabupaten_id
        $ujiRecords = (clone $query)
            ->whereNotNull('data_uji_resistensis.kabupaten_id')
            ->select([
                'data_uji_resistensis.kabupaten_id',
                'data_uji_resistensis.insecticide',
                'data_uji_resistensis.status',
                'data_uji_resistensis.sample_count',
            ])
            ->get();

        // Ambil daftar kabupaten dalam wilayah
        $kabupatenQuery = Kabupaten::query();
        if ($provinsiFilter !== 'Semua' && !empty($provinsiFilter)) {
            $kabupatenQuery->where('provinsi_id', $provinsiFilter);
        }
        $daftarKabupatenObj = $kabupatenQuery->orderBy('name', 'asc')->get()->keyBy('id');

        // Petakan pengujian per kabupaten
        $kabMap = [];
        foreach ($ujiRecords as $rec) {
            $kId = $rec->kabupaten_id;
            if (!isset($kabMap[$kId])) {
                $rawKabName = $daftarKabupatenObj[$kId]->name ?? ("Kabupaten #" . $kId);
                $kabMap[$kId] = [
                    'kab_id'   => $kId,
                    'kab_name' => $rawKabName,
                    'total_uji'=> 0,
                    'ins'      => [
                        'deltamethrin' => ['resisten' => 0, 'toleran' => 0, 'rentan' => 0, 'total' => 0],
                        'malathion'    => ['resisten' => 0, 'toleran' => 0, 'rentan' => 0, 'total' => 0],
                        'pirimiphos'   => ['resisten' => 0, 'toleran' => 0, 'rentan' => 0, 'total' => 0],
                        'bendiocarb'   => ['resisten' => 0, 'toleran' => 0, 'rentan' => 0, 'total' => 0],
                    ],
                ];
            }
            $kabMap[$kId]['total_uji']++;

            $rawIns = strtolower(trim($rec->insecticide ?? ''));
            $matchedKey = null;
            foreach ($targetInsektisida as $tgt) {
                foreach ($tgt['keywords'] as $kw) {
                    if (str_contains($rawIns, $kw)) {
                        $matchedKey = $tgt['key'];
                        break 2;
                    }
                }
            }

            if ($matchedKey) {
                $st = strtolower(trim($rec->status ?? ''));
                $kabMap[$kId]['ins'][$matchedKey]['total']++;
                if ($st === 'resisten') {
                    $kabMap[$kId]['ins'][$matchedKey]['resisten']++;
                } elseif (str_contains($st, 'toleran') || str_contains($st, 'terduga')) {
                    $kabMap[$kId]['ins'][$matchedKey]['toleran']++;
                } elseif ($st === 'rentan') {
                    $kabMap[$kId]['ins'][$matchedKey]['rentan']++;
                }
            }
        }

        // 4. Hitung Status Matriks Tiap Kabupaten
        // Kode Status:
        // - RT: Resisten Terkonfirmasi (resisten >= 50% atau hanya resisten)
        // - DR: Dugaan Resisten (ada resisten tapi < 50%)
        // - KR: Kemungkinan Resisten (toleran dominan / >= 50%)
        // - RN: Rentan (rentan >= 80% atau mutlak rentan)
        // - TD: Tidak Cukup Data / Tidak Diuji
        $matriksKabupaten = [];
        $counter = 1;
        foreach ($kabMap as $kId => $kData) {
            $rowStatus = [];
            $testedCount = 0;
            foreach ($targetInsektisida as $tgt) {
                $stat = $kData['ins'][$tgt['key']];
                if ($stat['total'] === 0) {
                    $code = 'TD';
                } elseif ($stat['resisten'] > 0 && ($stat['resisten'] >= ($stat['total'] * 0.5) || $stat['resisten'] >= $stat['rentan'])) {
                    $code = 'RT';
                    $testedCount++;
                } elseif ($stat['resisten'] > 0) {
                    $code = 'DR';
                    $testedCount++;
                } elseif ($stat['toleran'] > 0 && $stat['toleran'] >= ($stat['total'] * 0.5)) {
                    $code = 'KR';
                    $testedCount++;
                } elseif ($stat['rentan'] > 0) {
                    $code = 'RN';
                    $testedCount++;
                } else {
                    $code = 'TD';
                }
                $rowStatus[$tgt['key']] = $code;
            }

            $matriksKabupaten[] = [
                'kode'         => sprintf('K-%02d', $counter++),
                'kab_id'       => $kId,
                'kab_name'     => $kData['kab_name'],
                'statuses'     => $rowStatus,
                'tested_count' => $testedCount,
            ];
        }

        // Urutkan kabupaten berdata
        usort($matriksKabupaten, fn($a, $b) => strcmp($a['kab_name'], $b['kab_name']));
        // Re-index kode K-01, K-02...
        foreach ($matriksKabupaten as $idx => &$row) {
            $row['kode'] = sprintf('K-%02d', $idx + 1);
        }
        unset($row);

        $jumlahKabupatenBerdata = count($matriksKabupaten);
        $jumlahKabupatenTanpaData = max(0, $totalKabupatenDiWilayah - $jumlahKabupatenBerdata);
        $persenKabupatenBerdata = $totalKabupatenDiWilayah > 0 ? round(($jumlahKabupatenBerdata / $totalKabupatenDiWilayah) * 100) : 0;
        $persenKabupatenTanpaData = max(0, 100 - $persenKabupatenBerdata);

        // 5. Pengelompokan Klaster Kerentanan & Implikasinya
        $klaster1Kab = [];
        $klaster2Kab = [];
        $klaster3Kab = [];
        $klaster4Kab = [];

        foreach ($matriksKabupaten as $k) {
            $s = $k['statuses'];
            $delta = $s['deltamethrin'] ?? 'TD';
            $mala  = $s['malathion'] ?? 'TD';
            $piri  = $s['pirimiphos'] ?? 'TD';
            $bendi = $s['bendiocarb'] ?? 'TD';

            // Klaster 3: Malathion RT atau DR (Multi-Resisten Organofosfat)
            if ($mala === 'RT' || $mala === 'DR') {
                $klaster3Kab[] = $k['kode'];
            }
            // Klaster 2: Piretroid RT; Malathion KR
            elseif ($delta === 'RT' && $mala === 'KR') {
                $klaster2Kab[] = $k['kode'];
            }
            // Klaster 1: Piretroid RT; Organofosfat RN
            elseif ($delta === 'RT' && ($mala === 'RN' || $piri === 'RN')) {
                $klaster1Kab[] = $k['kode'];
            }
            // Klaster 4: Deltamethrin KR / Bahan lain belum diuji
            elseif ($delta === 'KR' || ($delta === 'RT' && $mala === 'TD' && $piri === 'TD')) {
                $klaster4Kab[] = $k['kode'];
            }
            else {
                if ($delta === 'RN' || $mala === 'RN' || $piri === 'RN') {
                    $klaster1Kab[] = $k['kode'];
                } else {
                    $klaster4Kab[] = $k['kode'];
                }
            }
        }

        $klasterList = [];
        if (!empty($klaster1Kab)) {
            $klasterList[] = [
                'nomor'     => 1,
                'judul'     => 'Klaster 1 • ' . implode(', ', $klaster1Kab),
                'ringkasan' => 'Piretroid RT; organofosfat RN',
                'deskripsi' => 'Piretroid tidak direkomendasikan. Organofosfat dapat dipertimbangkan untuk fokus KLB; pantau tekanan seleksi.',
                'kabupaten' => $klaster1Kab,
            ];
        }
        if (!empty($klaster2Kab)) {
            $klasterList[] = [
                'nomor'     => 2,
                'judul'     => 'Klaster 2 • ' . implode(', ', $klaster2Kab),
                'ringkasan' => 'Piretroid RT; malathion KR',
                'deskripsi' => 'Konfirmasi malathion sebelum pengadaan. Pirimiphos-methyl satu kelompok dengan malathion: pantau resistensi silang.',
                'kabupaten' => $klaster2Kab,
            ];
        }
        if (!empty($klaster3Kab)) {
            $klasterList[] = [
                'nomor'     => 3,
                'judul'     => 'Klaster 3 • ' . implode(', ', $klaster3Kab),
                'ringkasan' => 'Malathion RT atau DR',
                'deskripsi' => 'Belum ada pilihan kimia terkonfirmasi di wilayah ini. Prioritaskan non-kimia (PSN 3M-Plus, biolarvasida Bti) dan uji kelompok MoA lain.',
                'kabupaten' => $klaster3Kab,
            ];
        }
        if (!empty($klaster4Kab)) {
            $klasterList[] = [
                'nomor'     => 4,
                'judul'     => 'Klaster 4 • ' . implode(', ', $klaster4Kab),
                'ringkasan' => 'Deltamethrin KR; bahan lain belum diuji',
                'deskripsi' => 'Uji lanjut dan konfirmasi bioassay sebelum penetapan keputusan pengadaan.',
                'kabupaten' => $klaster4Kab,
            ];
        }

        if (empty($klasterList)) {
            $klasterList[] = [
                'nomor'     => 1,
                'judul'     => 'Klaster 1 • Wilayah Terpantau',
                'ringkasan' => 'Data surveilans terbatas',
                'deskripsi' => 'Diperlukan surveilans tambahan pada kabupaten prioritas sebelum penetapan alokasi pengadaan.',
                'kabupaten' => [],
            ];
        }

        // 6. Hitung Data Grafik Batang Bertumpuk (Stacked Bar) per Bahan Aktif
        $barDataList = [];
        foreach ($targetInsektisida as $tgt) {
            $kKey = $tgt['key'];
            $rtCount = 0;
            $drCount = 0;
            $krCount = 0;
            $rnCount = 0;
            foreach ($matriksKabupaten as $kRow) {
                $code = $kRow['statuses'][$kKey] ?? 'TD';
                if ($code === 'RT') $rtCount++;
                elseif ($code === 'DR') $drCount++;
                elseif ($code === 'KR') $krCount++;
                elseif ($code === 'RN') $rnCount++;
            }
            $berdataCount = $rtCount + $drCount + $krCount + $rnCount;
            $tanpaDataCount = max(0, $totalKabupatenDiWilayah - $berdataCount);

            $barDataList[] = [
                'nama'             => $tgt['label'],
                'rt'               => $rtCount,
                'dr'               => $drCount,
                'kr'               => $krCount,
                'rn'               => $rnCount,
                'tanpa_data'       => $tanpaDataCount,
                'berdata'          => $berdataCount,
                'total_kab'        => $totalKabupatenDiWilayah,
            ];
        }

        // 7. Opsi Keputusan untuk Pejabat
        $kabupatenPrioritasCount = max(5, min(15, $jumlahKabupatenTanpaData));

        return [
            'totalKabupatenDiWilayah'   => $totalKabupatenDiWilayah,
            'jumlahKabupatenBerdata'     => $jumlahKabupatenBerdata,
            'jumlahKabupatenTanpaData'   => $jumlahKabupatenTanpaData,
            'persenKabupatenBerdata'    => $persenKabupatenBerdata,
            'persenKabupatenTanpaData'  => $persenKabupatenTanpaData,
            'targetInsektisida'         => $targetInsektisida,
            'matriksKabupaten'          => $matriksKabupaten,
            'klasterList'               => $klasterList,
            'barDataList'               => $barDataList,
            'kabupatenPrioritasCount'   => $kabupatenPrioritasCount,
        ];
    }

    /**
     * Setujui dan Sahkan Rekomendasi Kebijakan oleh Kepala/Pimpinan BBLKL
     */
    public function approve(Request $request)
    {
        if (!auth()->check() || (!auth()->user()->isAdmin() && !auth()->user()->canApproveRekomendasi())) {
            return redirect()->back()->with('error', 'Akses Ditolak: Hanya Administrator atau Kepala/Pimpinan yang dapat mengesahkan rekomendasi kebijakan.');
        }

        $validated = $request->validate([
            'tahun'            => 'required|string',
            'jenis_nyamuk'     => 'required|string',
            'provinsi_id'      => 'required|string',
            'kabupaten_id'     => 'required|string',
            'template'         => 'required|string',
            'nama_wilayah'     => 'nullable|string',
            'approver_name'    => 'required|string|max:150',
            'approver_nip'     => 'nullable|string|max:50',
            'approver_jabatan' => 'required|string|max:255',
            'nomor_surat'      => 'nullable|string|max:100',
            'notes'            => 'nullable|string|max:2000',
            'lingkup_approval' => 'required|in:template_ini,semua_template',
        ], [
            'approver_name.required' => 'Nama Kepala/Pimpinan BBLKL wajib diisi.',
            'approver_jabatan.required' => 'Jabatan pengesah wajib diisi.',
            'lingkup_approval.required' => 'Pilih lingkup pengesahan template.',
        ]);

        $targetTemplate = $validated['lingkup_approval'] === 'semua_template' ? 'all' : $validated['template'];
        $docHash   = RekomendasiApproval::makeDocHash($validated['tahun'], $validated['jenis_nyamuk'], $validated['provinsi_id'], $validated['kabupaten_id'], $targetTemplate);
        $scopeHash = RekomendasiApproval::makeScopeHash($validated['tahun'], $validated['jenis_nyamuk'], $validated['provinsi_id'], $validated['kabupaten_id']);

        $token = 'BBLKL-APP-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8)) . '-' . date('Y');

        $nomorSurat = trim($validated['nomor_surat'] ?? '');
        if (empty($nomorSurat)) {
            $nomorSurat = 'LT-VEC/BBLKL/' . date('Y') . '/' . strtoupper(substr(md5($docHash), 0, 7));
        }

        RekomendasiApproval::updateOrCreate(
            [
                'doc_hash' => $docHash,
            ],
            [
                'filter_scope'       => $scopeHash,
                'template'           => $targetTemplate,
                'tahun'              => $validated['tahun'],
                'jenis_nyamuk'       => $validated['jenis_nyamuk'],
                'provinsi_id'        => $validated['provinsi_id'],
                'kabupaten_id'       => $validated['kabupaten_id'],
                'nama_wilayah'       => $validated['nama_wilayah'] ?? null,
                'status'             => 'approved',
                'user_id'            => auth()->id(),
                'approver_name'      => $validated['approver_name'],
                'approver_nip'       => $validated['approver_nip'] ?? null,
                'approver_jabatan'   => $validated['approver_jabatan'],
                'nomor_surat'        => $nomorSurat,
                'notes'              => $validated['notes'] ?? null,
                'verification_token' => $token,
                'approved_at'        => now(),
            ]
        );

        $msg = "Rekomendasi Kebijakan berhasil DISETUJUI & DISAHKAN oleh Kepala/Pimpinan BBLKL (" . $validated['approver_name'] . "). Tanda DRAFT pada dokumen cetak telah dicabut secara resmi.";
        return redirect()->back()->with('success', $msg);
    }

    /**
     * Batalkan Pengesahan Rekomendasi Kebijakan (Kembalikan ke Status Draft)
     */
    public function revoke(Request $request)
    {
        if (!auth()->check() || (!auth()->user()->isAdmin() && !auth()->user()->canApproveRekomendasi())) {
            return redirect()->back()->with('error', 'Akses Ditolak: Hanya Administrator atau Kepala/Pimpinan yang dapat membatalkan pengesahan rekomendasi.');
        }

        $approvalId = $request->input('approval_id');
        $docHash    = $request->input('doc_hash');
        $scopeHash  = $request->input('scope_hash');

        if ($approvalId) {
            $appr = RekomendasiApproval::find($approvalId);
            if ($appr) {
                $appr->delete();
            }
        } elseif ($docHash || $scopeHash) {
            RekomendasiApproval::where(function($q) use ($docHash, $scopeHash) {
                if ($docHash) {
                    $q->where('doc_hash', $docHash);
                }
                if ($scopeHash) {
                    $q->orWhere('filter_scope', $scopeHash);
                }
            })->delete();
        }

        return redirect()->back()->with('success', 'Pengesahan rekomendasi kebijakan berhasil dibatalkan. Dokumen dikembalikan ke status DRAFT.');
    }
}
