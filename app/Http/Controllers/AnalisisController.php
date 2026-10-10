<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\DataUjiResistensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalisisController extends Controller
{
    /**
     * Halaman Analisis Data Hasil Uji Resistensi Berbasis Grafik
     */
    public function index(Request $request)
    {
        // 1. Ambil Opsi Filter Master
        $provinsis = Provinsi::orderBy('nama_provinsi', 'asc')->get();

        $tahunDb = DataUjiResistensi::select('tahun')
            ->distinct()
            ->whereNotNull('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->toArray();
        $daftarTahun = array_values(array_unique(array_merge([(int)date('Y'), (int)date('Y') - 1], $tahunDb)));
        rsort($daftarTahun);

        $daftarNyamuk = DataUjiResistensi::select('jenis_nyamuk')
            ->distinct()
            ->whereNotNull('jenis_nyamuk')
            ->where('jenis_nyamuk', '!=', '')
            ->orderBy('jenis_nyamuk', 'asc')
            ->pluck('jenis_nyamuk');

        $daftarInsektisida = DataUjiResistensi::select('insektisida')
            ->distinct()
            ->whereNotNull('insektisida')
            ->where('insektisida', '!=', '')
            ->orderBy('insektisida', 'asc')
            ->pluck('insektisida');

        // 2. Baca Parameter Filter
        $tahunFilter = $request->get('tahun', 'Semua');
        $nyamukFilter = $request->get('jenis_nyamuk', 'Semua');
        $insektisidaFilter = $request->get('insektisida', 'Semua');
        $provinsiFilter = $request->get('provinsi_id', 'Semua');

        // 3. Query Dasar Terfilter
        $query = DataUjiResistensi::query();

        if ($tahunFilter !== 'Semua') {
            $query->where('tahun', (int)$tahunFilter);
        }
        if ($nyamukFilter !== 'Semua') {
            $query->where('jenis_nyamuk', $nyamukFilter);
        }
        if ($insektisidaFilter !== 'Semua') {
            $query->where('insektisida', $insektisidaFilter);
        }
        if ($provinsiFilter !== 'Semua') {
            $query->where('provinsi_id', $provinsiFilter);
        }

        // 4. Hitung Statistik Ringkasan (KPI)
        $totalPemeriksaan = (clone $query)->count();
        $totalSampel = (int)(clone $query)->sum('sampel_diperiksa');

        $totalResisten = (clone $query)->whereRaw('LOWER(status) = ?', ['resisten'])->count();
        $totalToleran = (clone $query)->where(function ($q) {
            $q->whereRaw('LOWER(status) LIKE ?', ['%toleran%'])
              ->orWhereRaw('LOWER(status) LIKE ?', ['%terduga%']);
        })->count();
        $totalRentan = (clone $query)->whereRaw('LOWER(status) = ?', ['rentan'])->count();

        $totalProvinsi = (clone $query)->distinct('provinsi_id')->count('provinsi_id');
        $totalMutasi = (clone $query)
            ->whereNotNull('mutasi')
            ->where('mutasi', '!=', '')
            ->where('mutasi', '!=', '-')
            ->count();

        $persenResisten = $totalPemeriksaan > 0 ? round(($totalResisten / $totalPemeriksaan) * 100, 1) : 0;
        $persenToleran = $totalPemeriksaan > 0 ? round(($totalToleran / $totalPemeriksaan) * 100, 1) : 0;
        $persenRentan = $totalPemeriksaan > 0 ? round(($totalRentan / $totalPemeriksaan) * 100, 1) : 0;

        // 5. Data Grafik 1: Tren Status Resistensi Antar Tahun
        $trenTahunQuery = clone $query;
        $rawTrenTahun = $trenTahunQuery
            ->selectRaw('tahun,
                SUM(CASE WHEN LOWER(status) = "resisten" THEN 1 ELSE 0 END) as resisten,
                SUM(CASE WHEN LOWER(status) LIKE "%toleran%" OR LOWER(status) LIKE "%terduga%" THEN 1 ELSE 0 END) as toleran,
                SUM(CASE WHEN LOWER(status) = "rentan" THEN 1 ELSE 0 END) as rentan,
                SUM(COALESCE(sampel_diperiksa, 0)) as total_sampel,
                COUNT(*) as total_uji')
            ->whereNotNull('tahun')
            ->groupBy('tahun')
            ->orderBy('tahun', 'asc')
            ->get();

        $chartTahunLabels = [];
        $chartTahunResisten = [];
        $chartTahunToleran = [];
        $chartTahunRentan = [];
        $chartTahunSampel = [];

        foreach ($rawTrenTahun as $row) {
            $chartTahunLabels[] = (string)$row->tahun;
            $chartTahunResisten[] = (int)$row->resisten;
            $chartTahunToleran[] = (int)$row->toleran;
            $chartTahunRentan[] = (int)$row->rentan;
            $chartTahunSampel[] = (int)$row->total_sampel;
        }

        // 6. Data Grafik 2: Proporsi Keseluruhan Status Resistensi
        $chartStatusData = [
            'labels' => ['Resisten', 'Toleran / Terduga Resisten', 'Rentan'],
            'data' => [$totalResisten, $totalToleran, $totalRentan],
            'colors' => ['#e11d48', '#f59e0b', '#10b981']
        ];

        // 7. Data Grafik 3: Analisis Tingkat Resistensi per Spesies Nyamuk (Top 7)
        $rawNyamuk = (clone $query)
            ->selectRaw('jenis_nyamuk,
                SUM(CASE WHEN LOWER(status) = "resisten" THEN 1 ELSE 0 END) as resisten,
                SUM(CASE WHEN LOWER(status) LIKE "%toleran%" OR LOWER(status) LIKE "%terduga%" THEN 1 ELSE 0 END) as toleran,
                SUM(CASE WHEN LOWER(status) = "rentan" THEN 1 ELSE 0 END) as rentan,
                COUNT(*) as total_uji')
            ->whereNotNull('jenis_nyamuk')
            ->where('jenis_nyamuk', '!=', '')
            ->groupBy('jenis_nyamuk')
            ->orderByDesc('total_uji')
            ->limit(7)
            ->get();

        $chartNyamukLabels = [];
        $chartNyamukResisten = [];
        $chartNyamukToleran = [];
        $chartNyamukRentan = [];

        foreach ($rawNyamuk as $row) {
            $chartNyamukLabels[] = $row->jenis_nyamuk;
            $chartNyamukResisten[] = (int)$row->resisten;
            $chartNyamukToleran[] = (int)$row->toleran;
            $chartNyamukRentan[] = (int)$row->rentan;
        }

        // 8. Data Grafik 4: Peringkat Efektivitas Berdasarkan Jenis Insektisida (Top 8)
        $rawInsektisida = (clone $query)
            ->selectRaw('insektisida,
                SUM(CASE WHEN LOWER(status) = "resisten" THEN 1 ELSE 0 END) as resisten,
                SUM(CASE WHEN LOWER(status) LIKE "%toleran%" OR LOWER(status) LIKE "%terduga%" THEN 1 ELSE 0 END) as toleran,
                SUM(CASE WHEN LOWER(status) = "rentan" THEN 1 ELSE 0 END) as rentan,
                COUNT(*) as total_uji')
            ->whereNotNull('insektisida')
            ->where('insektisida', '!=', '')
            ->groupBy('insektisida')
            ->orderByDesc('total_uji')
            ->limit(8)
            ->get();

        $chartInsekLabels = [];
        $chartInsekResisten = [];
        $chartInsekToleran = [];
        $chartInsekRentan = [];

        foreach ($rawInsektisida as $row) {
            $chartInsekLabels[] = $row->insektisida;
            $chartInsekResisten[] = (int)$row->resisten;
            $chartInsekToleran[] = (int)$row->toleran;
            $chartInsekRentan[] = (int)$row->rentan;
        }

        // 9. Data Grafik 5: Top 10 Provinsi dengan Kasus Resisten Tertinggi
        $rawProvinsiResisten = (clone $query)
            ->selectRaw('provinsi_id,
                COUNT(*) as kasus_resisten,
                SUM(COALESCE(sampel_diperiksa, 0)) as total_sampel')
            ->whereRaw('LOWER(status) = ?', ['resisten'])
            ->whereNotNull('provinsi_id')
            ->groupBy('provinsi_id')
            ->orderByDesc('kasus_resisten')
            ->limit(10)
            ->get();

        $chartProvLabels = [];
        $chartProvData = [];
        foreach ($rawProvinsiResisten as $row) {
            $prov = $provinsis->firstWhere('id', $row->provinsi_id);
            $namaProv = $prov ? $prov->nama_provinsi : 'Provinsi #' . $row->provinsi_id;
            // Singkat nama jika terlalu panjang untuk tampilan grafik yang rapi
            $chartProvLabels[] = str_replace(['Provinsi ', 'Kepulauan '], ['', 'Kep. '], $namaProv);
            $chartProvData[] = (int)$row->kasus_resisten;
        }

        // 10. Data Grafik 6: Distribusi Metode Pengujian Laboratorium
        $rawMetode = (clone $query)
            ->selectRaw('metode, COUNT(*) as total')
            ->whereNotNull('metode')
            ->where('metode', '!=', '')
            ->groupBy('metode')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $chartMetodeLabels = [];
        $chartMetodeData = [];
        foreach ($rawMetode as $row) {
            $chartMetodeLabels[] = $row->metode;
            $chartMetodeData[] = (int)$row->total;
        }

        // 11. Matriks Analisis Uji: Hubungan Vektor & Insektisida (Tabel Analisis)
        $matriksAnalisis = (clone $query)
            ->selectRaw('jenis_nyamuk, insektisida,
                COUNT(*) as total_uji,
                SUM(COALESCE(sampel_diperiksa, 0)) as total_sampel,
                SUM(CASE WHEN LOWER(status) = "resisten" THEN 1 ELSE 0 END) as resisten,
                SUM(CASE WHEN LOWER(status) LIKE "%toleran%" OR LOWER(status) LIKE "%terduga%" THEN 1 ELSE 0 END) as toleran,
                SUM(CASE WHEN LOWER(status) = "rentan" THEN 1 ELSE 0 END) as rentan')
            ->whereNotNull('jenis_nyamuk')
            ->where('jenis_nyamuk', '!=', '')
            ->whereNotNull('insektisida')
            ->where('insektisida', '!=', '')
            ->groupBy('jenis_nyamuk', 'insektisida')
            ->havingRaw('total_uji >= 2')
            ->orderByDesc('resisten')
            ->orderByDesc('total_uji')
            ->limit(20)
            ->get()
            ->map(function ($item) {
                $item->persen_resisten = $item->total_uji > 0 ? round(($item->resisten / $item->total_uji) * 100, 1) : 0;
                if ($item->resisten > $item->rentan && $item->resisten > $item->toleran) {
                    $item->status_dominan = 'Resisten';
                    $item->badge_color = 'rose';
                } elseif ($item->rentan > $item->resisten && $item->rentan > $item->toleran) {
                    $item->status_dominan = 'Rentan';
                    $item->badge_color = 'emerald';
                } else {
                    $item->status_dominan = 'Toleran';
                    $item->badge_color = 'amber';
                }
                return $item;
            });

        return view('analisis', compact(
            'provinsis',
            'daftarTahun',
            'daftarNyamuk',
            'daftarInsektisida',
            'tahunFilter',
            'nyamukFilter',
            'insektisidaFilter',
            'provinsiFilter',
            'totalPemeriksaan',
            'totalSampel',
            'totalResisten',
            'totalToleran',
            'totalRentan',
            'totalProvinsi',
            'totalMutasi',
            'persenResisten',
            'persenToleran',
            'persenRentan',
            'chartTahunLabels',
            'chartTahunResisten',
            'chartTahunToleran',
            'chartTahunRentan',
            'chartTahunSampel',
            'chartStatusData',
            'chartNyamukLabels',
            'chartNyamukResisten',
            'chartNyamukToleran',
            'chartNyamukRentan',
            'chartInsekLabels',
            'chartInsekResisten',
            'chartInsekToleran',
            'chartInsekRentan',
            'chartProvLabels',
            'chartProvData',
            'chartMetodeLabels',
            'chartMetodeData',
            'matriksAnalisis'
        ));
    }
}
