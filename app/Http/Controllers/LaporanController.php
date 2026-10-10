<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\DataUjiResistensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    /**
     * Tampilan Halaman Laporan Interaktif (Web View)
     */
    public function index(Request $request)
    {
        // 1. Ambil opsi filter master
        $provinsis = Provinsi::orderBy('nama_provinsi', 'asc')->get();

        $daftarBulan = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Daftar tahun dari database + rentang tahun sistem
        $tahunDb = DataUjiResistensi::select('tahun')
            ->distinct()
            ->whereNotNull('tahun')
            ->pluck('tahun')
            ->map(fn($y) => (int)$y)
            ->filter(fn($y) => $y > 2000 && $y < 2100)
            ->toArray();
        $daftarTahun = array_values(array_unique(array_merge([(int)date('Y'), (int)date('Y') - 1, (int)date('Y') - 2], $tahunDb)));
        rsort($daftarTahun);

        // Daftar jenis nyamuk & insektisida
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

        // 2. Baca parameter filter
        $provinsiId = $request->get('provinsi_id');
        $kabupatenId = $request->get('kabupaten_id');
        $tahun = $request->get('tahun', 'Semua');
        $bulan = $request->get('bulan', 'Semua');
        $jenisNyamuk = $request->get('jenis_nyamuk', 'Semua');
        $insektisida = $request->get('insektisida', 'Semua');
        $status = $request->get('status', 'Semua');
        $search = trim($request->get('search', ''));
        $perPage = (int)$request->get('per_page', 25);
        if ($perPage <= 0 || $perPage > 200) $perPage = 25;

        // Kabupaten list jika provinsi dipilih
        $kabupatens = collect([]);
        if ($provinsiId && $provinsiId !== 'Semua') {
            $kabupatens = Kabupaten::where('provinsi_id', $provinsiId)
                ->orderBy('nama_kabupaten', 'asc')
                ->get();
        }

        // 3. Bangun query dasar
        $baseQuery = $this->buildFilteredQuery($request);

        // 4. Hitung ringkasan statistik (KPI) dari keseluruhan data terfilter
        $statsQuery = clone $baseQuery;
        $totalPemeriksaan = (clone $statsQuery)->count();
        $totalSampel = (int)(clone $statsQuery)->sum('sampel_diperiksa');
        
        $totalResisten = (clone $statsQuery)->where('status', 'resisten')->count();
        $totalToleran = (clone $statsQuery)->where('status', 'toleran')->count();
        $totalRentan = (clone $statsQuery)->where('status', 'rentan')->count();

        $persenResisten = $totalPemeriksaan > 0 ? round(($totalResisten / $totalPemeriksaan) * 100, 1) : 0;
        $persenToleran = $totalPemeriksaan > 0 ? round(($totalToleran / $totalPemeriksaan) * 100, 1) : 0;
        $persenRentan = $totalPemeriksaan > 0 ? round(($totalRentan / $totalPemeriksaan) * 100, 1) : 0;

        $stats = [
            'total_pemeriksaan' => $totalPemeriksaan,
            'total_sampel' => $totalSampel,
            'total_resisten' => $totalResisten,
            'persen_resisten' => $persenResisten,
            'total_toleran' => $totalToleran,
            'persen_toleran' => $persenToleran,
            'total_rentan' => $totalRentan,
            'persen_rentan' => $persenRentan,
        ];

        // 5. Ambil data dengan pagination
        $dataUji = $baseQuery->orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('laporan', compact(
            'dataUji',
            'provinsis',
            'kabupatens',
            'daftarTahun',
            'daftarBulan',
            'daftarNyamuk',
            'daftarInsektisida',
            'stats',
            'provinsiId',
            'kabupatenId',
            'tahun',
            'bulan',
            'jenisNyamuk',
            'insektisida',
            'status',
            'search',
            'perPage'
        ));
    }

    /**
     * Pratinjau Dokumen Cetak Resmi (Berformat HTML, 100% Aman dari Intersep IDM)
     */
    public function preview(Request $request)
    {
        // 1. Bangun query terfilter
        $query = $this->buildFilteredQuery($request);

        $dataUji = $query->orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->limit(2000)
            ->get();

        // 2. Hitung statistik ringkasan
        $totalPemeriksaan = $dataUji->count();
        $totalSampel = $dataUji->sum('sampel_diperiksa');
        $totalResisten = $dataUji->where('status', 'Resisten')->count();
        $totalToleran = $dataUji->where('status', 'Toleran')->count();
        $totalRentan = $dataUji->where('status', 'Rentan')->count();

        $stats = [
            'total_pemeriksaan' => $totalPemeriksaan,
            'total_sampel' => $totalSampel,
            'total_resisten' => $totalResisten,
            'persen_resisten' => $totalPemeriksaan > 0 ? round(($totalResisten / $totalPemeriksaan) * 100, 1) : 0,
            'total_toleran' => $totalToleran,
            'persen_toleran' => $totalPemeriksaan > 0 ? round(($totalToleran / $totalPemeriksaan) * 100, 1) : 0,
            'total_rentan' => $totalRentan,
            'persen_rentan' => $totalPemeriksaan > 0 ? round(($totalRentan / $totalPemeriksaan) * 100, 1) : 0,
        ];

        // 3. Keterangan filter aktif
        $provinsiNama = 'Semua Provinsi';
        if ($request->filled('provinsi_id') && $request->provinsi_id !== 'Semua') {
            $p = Provinsi::find($request->provinsi_id);
            if ($p) $provinsiNama = $p->nama_provinsi;
        }

        $kabupatenNama = 'Semua Kabupaten / Kota';
        if ($request->filled('kabupaten_id') && $request->kabupaten_id !== 'Semua') {
            $k = Kabupaten::find($request->kabupaten_id);
            if ($k) $kabupatenNama = $k->nama_kabupaten;
        }

        $filterInfo = [
            'provinsi' => $provinsiNama,
            'kabupaten' => $kabupatenNama,
            'tahun' => $request->get('tahun', 'Semua'),
            'bulan' => $request->get('bulan', 'Semua'),
            'jenis_nyamuk' => $request->get('jenis_nyamuk', 'Semua'),
            'insektisida' => $request->get('insektisida', 'Semua'),
            'status' => $request->get('status', 'Semua'),
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas SIMPEL BBLKL'
        ];

        return view('laporan_preview', compact('dataUji', 'stats', 'filterInfo'));
    }

    /**
     * Cetak atau Unduh Laporan dalam Format PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        // 1. Bangun query terfilter
        $query = $this->buildFilteredQuery($request);

        // Ambil data untuk laporan (maksimal 2.000 baris untuk efisiensi render PDF)
        $dataUji = $query->orderBy('tahun', 'desc')
            ->orderBy('id', 'desc')
            ->limit(2000)
            ->get();

        // 2. Hitung statistik ringkasan
        $totalPemeriksaan = $dataUji->count();
        $totalSampel = $dataUji->sum('sampel_diperiksa');
        $totalResisten = $dataUji->where('status', 'Resisten')->count();
        $totalToleran = $dataUji->where('status', 'Toleran')->count();
        $totalRentan = $dataUji->where('status', 'Rentan')->count();

        $stats = [
            'total_pemeriksaan' => $totalPemeriksaan,
            'total_sampel' => $totalSampel,
            'total_resisten' => $totalResisten,
            'persen_resisten' => $totalPemeriksaan > 0 ? round(($totalResisten / $totalPemeriksaan) * 100, 1) : 0,
            'total_toleran' => $totalToleran,
            'persen_toleran' => $totalPemeriksaan > 0 ? round(($totalToleran / $totalPemeriksaan) * 100, 1) : 0,
            'total_rentan' => $totalRentan,
            'persen_rentan' => $totalPemeriksaan > 0 ? round(($totalRentan / $totalPemeriksaan) * 100, 1) : 0,
        ];

        // 3. Keterangan filter aktif
        $provinsiNama = 'Semua Provinsi';
        if ($request->filled('provinsi_id') && $request->provinsi_id !== 'Semua') {
            $p = Provinsi::find($request->provinsi_id);
            if ($p) $provinsiNama = $p->nama_provinsi;
        }

        $kabupatenNama = 'Semua Kabupaten / Kota';
        if ($request->filled('kabupaten_id') && $request->kabupaten_id !== 'Semua') {
            $k = Kabupaten::find($request->kabupaten_id);
            if ($k) $kabupatenNama = $k->nama_kabupaten;
        }

        $filterInfo = [
            'provinsi' => $provinsiNama,
            'kabupaten' => $kabupatenNama,
            'tahun' => $request->get('tahun', 'Semua'),
            'bulan' => $request->get('bulan', 'Semua'),
            'jenis_nyamuk' => $request->get('jenis_nyamuk', 'Semua'),
            'insektisida' => $request->get('insektisida', 'Semua'),
            'status' => $request->get('status', 'Semua'),
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas SIMPEL BBLKL'
        ];

        // 4. Logo Base64
        $logoBase64 = null;
        $logoPath = public_path('logo_bblkl.png');
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        // 5. Generate PDF dengan DomPDF (Kertas A4 Landscape)
        $pdf = Pdf::loadView('laporan_pdf', compact('dataUji', 'stats', 'filterInfo', 'logoBase64'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Laporan-Uji-Resistensi-' . date('Ymd-His') . '.pdf';

        if ($request->get('mode') === 'download') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    /**
     * Helper untuk membangun query terfilter
     */
    private function buildFilteredQuery(Request $request)
    {
        $query = DataUjiResistensi::with(['provinsi', 'kabupaten']);

        // Filter Provinsi
        if ($request->filled('provinsi_id') && $request->provinsi_id !== 'Semua') {
            $query->where('provinsi_id', $request->provinsi_id);
        }

        // Filter Kabupaten
        if ($request->filled('kabupaten_id') && $request->kabupaten_id !== 'Semua') {
            $query->where('kabupaten_id', $request->kabupaten_id);
        }

        // Filter Tahun
        if ($request->filled('tahun') && $request->tahun !== 'Semua') {
            $query->where('tahun', (int)$request->tahun);
        }

        // Filter Bulan
        if ($request->filled('bulan') && $request->bulan !== 'Semua') {
            $query->where('bulan', $request->bulan);
        }

        // Filter Jenis Nyamuk
        if ($request->filled('jenis_nyamuk') && $request->jenis_nyamuk !== 'Semua') {
            $query->where('jenis_nyamuk', $request->jenis_nyamuk);
        }

        // Filter Insektisida
        if ($request->filled('insektisida') && $request->insektisida !== 'Semua') {
            $query->where('insektisida', $request->insektisida);
        }

        // Filter Status
        if ($request->filled('status') && $request->status !== 'Semua') {
            $valStatus = strtolower(trim($request->status));
            $query->where('status', $valStatus);
        }

        // Filter Pencarian Teks
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('jenis_nyamuk', 'like', "%{$search}%")
                    ->orWhere('insektisida', 'like', "%{$search}%")
                    ->orWhere('metode', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('mutasi', 'like', "%{$search}%")
                    ->orWhere('publikasi', 'like', "%{$search}%")
                    ->orWhereHas('provinsi', function ($qp) use ($search) {
                        $qp->where('nama_provinsi', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kabupaten', function ($qk) use ($search) {
                        $qk->where('nama_kabupaten', 'like', "%{$search}%");
                    });
            });
        }

        return $query;
    }
}
