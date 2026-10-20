<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InstansiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $provinsiId = $request->get('provinsi_id');

        $query = Instansi::with(['provinsi', 'kabupaten']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('unit_code', 'like', "%{$search}%")
                  ->orWhere('person_in_charge', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($kategori) {
            $query->where('category', $kategori);
        }

        if ($provinsiId) {
            $query->where('provinsi_id', $provinsiId);
        }

        $instansis = $query->orderBy('name', 'asc')
            ->paginate(15)
            ->withQueryString();

        $provinsis = Provinsi::orderBy('name', 'asc')->get();

        $totalInstansi = Instansi::count();
        $totalBkk = Instansi::where('category', 'like', '%BKK%')->orWhere('category', 'like', '%Kekarantinaan%')->count();
        $totalBalai = Instansi::where(function ($q) {
            $q->where('category', 'like', '%Balai%')
              ->orWhere('category', 'like', '%Lab%');
        })->where('category', 'not like', '%BKK%')->count();
        $totalDinkes = Instansi::where('category', 'like', '%Dinas%')->count();
        $totalFaskes = Instansi::where(function ($q) {
            $q->where('category', 'like', '%Rumah Sakit%')
              ->orWhere('category', 'like', '%Puskesmas%');
        })->count();

        $kategoriList = [
            'Balai Kekarantinaan Kesehatan/BKK',
            'Balai / Laboratorium',
            'Dinas Kesehatan',
            'Rumah Sakit',
            'Puskesmas',
            'Kementerian / Lembaga',
            'Instansi Lainnya',
        ];

        return view('instansi', compact(
            'instansis',
            'provinsis',
            'search',
            'kategori',
            'provinsiId',
            'totalInstansi',
            'totalBkk',
            'totalBalai',
            'totalDinkes',
            'totalFaskes',
            'kategoriList'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'kode_unit' => 'nullable|string|max:50',
            'kategori' => 'required|string|max:100',
            'provinsi_id' => 'nullable|exists:provinsis,id',
            'kabupaten_id' => 'nullable|exists:kabupatens,id',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'penanggung_jawab' => 'nullable|string|max:255',
        ], [
            'nama_instansi.required' => 'Nama unit / instansi wajib diisi.',
            'kategori.required' => 'Kategori unit / instansi wajib dipilih.',
            'email.email' => 'Format email tidak valid.',
        ]);

        Instansi::create($request->all());

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Unit / Instansi baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $instansi = Instansi::findOrFail($id);

        $request->validate([
            'nama_instansi' => 'required|string|max:255',
            'kode_unit' => 'nullable|string|max:50',
            'kategori' => 'required|string|max:100',
            'provinsi_id' => 'nullable|exists:provinsis,id',
            'kabupaten_id' => 'nullable|exists:kabupatens,id',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'penanggung_jawab' => 'nullable|string|max:255',
        ], [
            'nama_instansi.required' => 'Nama unit / instansi wajib diisi.',
            'kategori.required' => 'Kategori unit / instansi wajib dipilih.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $instansi->update($request->all());

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Data Unit / Instansi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $instansi = Instansi::findOrFail($id);
        $instansi->delete();

        return redirect()
            ->route('instansi.index')
            ->with('success', 'Unit / Instansi berhasil dihapus!');
    }

    /**
     * Tampilan Pratinjau Cetak Interaktif Master Data Unit / Instansi (Web Print Preview)
     */
    public function preview(Request $request)
    {
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $provinsiId = $request->get('provinsi_id');

        $query = Instansi::with(['provinsi', 'kabupaten']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('unit_code', 'like', "%{$search}%")
                  ->orWhere('person_in_charge', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($kategori && $kategori !== 'Semua') {
            $query->where('category', $kategori);
        }

        if ($provinsiId && $provinsiId !== 'Semua') {
            $query->where('provinsi_id', $provinsiId);
        }

        $data = $query->orderBy('name', 'asc')->get();

        $selectedProvinsi = ($provinsiId && $provinsiId !== 'Semua') ? Provinsi::find($provinsiId) : null;
        $totalInstansi = Instansi::count();

        $filterInfo = [
            'search' => $search,
            'kategori' => $kategori ?: 'Semua Kategori',
            'provinsi_id' => $provinsiId,
            'provinsi_nama' => $selectedProvinsi ? ($selectedProvinsi->name ?? $selectedProvinsi->nama_provinsi) : 'Seluruh Indonesia',
            'total_terfilter' => $data->count(),
            'total_semua' => $totalInstansi,
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas Administrator'
        ];

        return view('instansi_preview', compact('data', 'filterInfo', 'search', 'kategori', 'provinsiId'));
    }

    /**
     * Unduh atau Alirkan Master Data Unit / Instansi dalam Format PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        @ini_set('memory_limit', '512M');
        @ini_set('max_execution_time', '180');

        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $provinsiId = $request->get('provinsi_id');
        $mode = $request->get('mode', 'stream');

        $query = Instansi::with(['provinsi', 'kabupaten']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('unit_code', 'like', "%{$search}%")
                  ->orWhere('person_in_charge', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        if ($kategori && $kategori !== 'Semua') {
            $query->where('category', $kategori);
        }

        if ($provinsiId && $provinsiId !== 'Semua') {
            $query->where('provinsi_id', $provinsiId);
        }

        $data = $query->orderBy('name', 'asc')->get();
        $selectedProvinsi = ($provinsiId && $provinsiId !== 'Semua') ? Provinsi::find($provinsiId) : null;
        $totalInstansi = Instansi::count();

        $filterInfo = [
            'search' => $search,
            'kategori' => $kategori ?: 'Semua Kategori',
            'provinsi_id' => $provinsiId,
            'provinsi_nama' => $selectedProvinsi ? ($selectedProvinsi->name ?? $selectedProvinsi->nama_provinsi) : 'Seluruh Indonesia',
            'total_terfilter' => $data->count(),
            'total_semua' => $totalInstansi,
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas Administrator'
        ];

        $logoBase64 = null;
        $logoPath = public_path('logo_bblkl.png');
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $pdf = Pdf::loadView('instansi_pdf', compact('data', 'filterInfo', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Master-Data-Unit-Instansi-' . date('Ymd-His') . '.pdf';

        if ($mode === 'download') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
}
