<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\DataUjiResistensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $allProvinsis = Provinsi::orderBy('name', 'asc')->get();

        $selectedProvinsiId = $request->get('provinsi_id');
        $search = $request->get('search');
        $tab = $request->get('tab', 'kabupaten');

        // Query Provinsi untuk Tab Provinsi (dipaginate 10 data per halaman)
        $provinsisQuery = Provinsi::withCount('kabupatens')->orderBy('name', 'asc');
        if ($tab === 'provinsi' && $search) {
            $provinsisQuery->where('name', 'like', "%{$search}%");
        }
        $provinsis = $provinsisQuery->paginate(10, ['*'], 'prov_page')->withQueryString();

        // Query Kabupaten untuk Tab Kabupaten (dipaginate 15 data per halaman)
        $kabupatensQuery = Kabupaten::with('provinsi');

        if ($selectedProvinsiId) {
            $kabupatensQuery->where('provinsi_id', $selectedProvinsiId);
        }

        if ($tab === 'kabupaten' && $search) {
            $kabupatensQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('provinsi', function ($p) use ($search) {
                      $p->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $kabupatens = $kabupatensQuery->orderBy('name', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalProvinsi = Provinsi::count();
        $totalKabupaten = Kabupaten::count();

        return view('wilayah', compact(
            'allProvinsis',
            'provinsis',
            'kabupatens',
            'selectedProvinsiId',
            'search',
            'totalProvinsi',
            'totalKabupaten',
            'tab'
        ));
    }

    public function storeProvinsi(Request $request)
    {
        $request->validate([
            'nama_provinsi' => 'required|string|max:255|unique:provinsis,name',
        ], [
            'nama_provinsi.required' => 'Nama provinsi wajib diisi.',
            'nama_provinsi.unique' => 'Nama provinsi sudah ada dalam database.',
        ]);

        Provinsi::create([
            'name' => ucwords(strtolower(trim($request->nama_provinsi))),
        ]);

        return redirect()
            ->route('wilayah.index', ['tab' => 'provinsi'])
            ->with('success', 'Provinsi baru berhasil ditambahkan!');
    }

    public function updateProvinsi(Request $request, $id)
    {
        $provinsi = Provinsi::findOrFail($id);

        $request->validate([
            'nama_provinsi' => 'required|string|max:255|unique:provinsis,name,' . $id,
        ], [
            'nama_provinsi.required' => 'Nama provinsi wajib diisi.',
            'nama_provinsi.unique' => 'Nama provinsi sudah digunakan.',
        ]);

        $provinsi->update([
            'name' => ucwords(strtolower(trim($request->nama_provinsi))),
        ]);

        return redirect()
            ->route('wilayah.index', ['tab' => 'provinsi'])
            ->with('success', 'Data provinsi berhasil diperbarui!');
    }

    public function destroyProvinsi($id)
    {
        $provinsi = Provinsi::withCount(['kabupatens', 'dataUjiResistensi'])->findOrFail($id);

        if ($provinsi->kabupatens_count > 0) {
            return redirect()
                ->route('wilayah.index', ['tab' => 'provinsi'])
                ->with('error', "Tidak dapat menghapus provinsi {$provinsi->nama_provinsi} karena masih memiliki {$provinsi->kabupatens_count} data kabupaten/kota!");
        }

        if ($provinsi->data_uji_resistensi_count > 0) {
            return redirect()
                ->route('wilayah.index', ['tab' => 'provinsi'])
                ->with('error', "Tidak dapat menghapus provinsi karena terdapat data uji resistensi yang terhubung!");
        }

        $provinsi->delete();

        return redirect()
            ->route('wilayah.index', ['tab' => 'provinsi'])
            ->with('success', 'Provinsi berhasil dihapus!');
    }

    public function storeKabupaten(Request $request)
    {
        $request->validate([
            'provinsi_id' => 'required|exists:provinsis,id',
            'nama_kabupaten' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'provinsi_id.required' => 'Silakan pilih provinsi terlebih dahulu.',
            'nama_kabupaten.required' => 'Nama kabupaten/kota wajib diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka koordinat.',
            'longitude.numeric' => 'Longitude harus berupa angka koordinat.',
        ]);

        Kabupaten::create([
            'provinsi_id' => $request->provinsi_id,
            'name' => ucwords(strtolower(trim($request->nama_kabupaten))),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('wilayah.index', ['tab' => 'kabupaten'])
            ->with('success', 'Kabupaten/Kota baru berhasil ditambahkan!');
    }

    public function updateKabupaten(Request $request, $id)
    {
        $kabupaten = Kabupaten::findOrFail($id);

        $request->validate([
            'provinsi_id' => 'required|exists:provinsis,id',
            'nama_kabupaten' => 'required|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ], [
            'provinsi_id.required' => 'Silakan pilih provinsi terlebih dahulu.',
            'nama_kabupaten.required' => 'Nama kabupaten/kota wajib diisi.',
        ]);

        $kabupaten->update([
            'provinsi_id' => $request->provinsi_id,
            'name' => ucwords(strtolower(trim($request->nama_kabupaten))),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('wilayah.index', ['tab' => 'kabupaten'])
            ->with('success', 'Data Kabupaten/Kota berhasil diperbarui!');
    }

    public function destroyKabupaten($id)
    {
        $kabupaten = Kabupaten::withCount('dataUjiResistensi')->findOrFail($id);

        if ($kabupaten->data_uji_resistensi_count > 0) {
            return redirect()
                ->route('wilayah.index', ['tab' => 'kabupaten'])
                ->with('error', "Tidak dapat menghapus kabupaten {$kabupaten->nama_kabupaten} karena terdapat {$kabupaten->data_uji_resistensi_count} data uji resistensi yang terhubung!");
        }

        $kabupaten->delete();

        return redirect()
            ->route('wilayah.index', ['tab' => 'kabupaten'])
            ->with('success', 'Kabupaten/Kota berhasil dihapus!');
    }

    /**
     * Tampilan Pratinjau Cetak Interaktif Master Data Wilayah (Web Print Preview)
     */
    public function preview(Request $request)
    {
        $tab = $request->get('tab', 'kabupaten');
        $provinsiId = $request->get('provinsi_id');
        $search = trim($request->get('search', ''));
        $allProvinsis = Provinsi::orderBy('name', 'asc')->get();

        $selectedProvinsi = null;
        if ($provinsiId && $provinsiId !== 'Semua') {
            $selectedProvinsi = Provinsi::find($provinsiId);
        }

        if ($tab === 'provinsi') {
            $query = Provinsi::withCount(['kabupatens', 'dataUjiResistensi'])->orderBy('name', 'asc');
            if ($search) {
                $query->where('name', 'like', "%{$search}%");
            }
            $data = $query->get();
        } else {
            $query = Kabupaten::with('provinsi')->withCount('dataUjiResistensi');
            if ($selectedProvinsi) {
                $query->where('provinsi_id', $selectedProvinsi->id);
            }
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('provinsi', fn($p) => $p->where('name', 'like', "%{$search}%"));
                });
            }
            $data = $query->orderBy('provinsi_id', 'asc')->orderBy('name', 'asc')->get();
        }

        $totalProvinsi = Provinsi::count();
        $totalKabupaten = Kabupaten::count();
        $totalDataUji = DataUjiResistensi::count();

        $filterInfo = [
            'tab' => $tab,
            'provinsi_id' => $provinsiId,
            'provinsi_nama' => $selectedProvinsi ? ($selectedProvinsi->name ?? $selectedProvinsi->nama_provinsi) : 'Seluruh Indonesia',
            'search' => $search,
            'total_terfilter' => $data->count(),
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas Administrator'
        ];

        $logoBase64 = null;
        $logoPath = public_path('logo_bblkl.png');
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        return view('wilayah_preview', compact(
            'data',
            'tab',
            'allProvinsis',
            'selectedProvinsi',
            'totalProvinsi',
            'totalKabupaten',
            'totalDataUji',
            'filterInfo',
            'logoBase64'
        ));
    }

    /**
     * Unduh atau Alirkan (Stream) Master Data Wilayah dalam Format PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        @ini_set('memory_limit', '512M');
        @ini_set('max_execution_time', '180');

        $tab = $request->get('tab', 'kabupaten');
        $provinsiId = $request->get('provinsi_id');
        $search = trim($request->get('search', ''));
        $mode = $request->get('mode', 'stream'); // stream atau download

        $selectedProvinsi = null;
        if ($provinsiId && $provinsiId !== 'Semua') {
            $selectedProvinsi = Provinsi::find($provinsiId);
        }

        if ($tab === 'provinsi') {
            $query = Provinsi::withCount(['kabupatens', 'dataUjiResistensi'])->orderBy('name', 'asc');
            if ($search) {
                $query->where('name', 'like', "%{$search}%");
            }
            $data = $query->get();
            $filename = 'Master-Data-Provinsi-Indonesia-' . date('Ymd-His') . '.pdf';
        } else {
            $query = Kabupaten::with('provinsi')->withCount('dataUjiResistensi');
            if ($selectedProvinsi) {
                $query->where('provinsi_id', $selectedProvinsi->id);
            }
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhereHas('provinsi', fn($p) => $p->where('name', 'like', "%{$search}%"));
                });
            }
            $data = $query->orderBy('provinsi_id', 'asc')->orderBy('name', 'asc')->get();
            $filename = 'Master-Data-Kabupaten-Kota-Indonesia-' . date('Ymd-His') . '.pdf';
        }

        $totalProvinsi = Provinsi::count();
        $totalKabupaten = Kabupaten::count();
        $totalDataUji = DataUjiResistensi::count();

        $filterInfo = [
            'tab' => $tab,
            'provinsi_id' => $provinsiId,
            'provinsi_nama' => $selectedProvinsi ? ($selectedProvinsi->name ?? $selectedProvinsi->nama_provinsi) : 'Seluruh Indonesia',
            'search' => $search,
            'total_terfilter' => $data->count(),
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas Administrator'
        ];

        $logoBase64 = null;
        $logoPath = public_path('logo_bblkl.png');
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $pdf = Pdf::loadView('wilayah_pdf', compact(
            'data',
            'tab',
            'selectedProvinsi',
            'totalProvinsi',
            'totalKabupaten',
            'totalDataUji',
            'filterInfo',
            'logoBase64'
        ))
        ->setPaper('a4', 'portrait')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'sans-serif'
        ]);

        if ($mode === 'download') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
}
