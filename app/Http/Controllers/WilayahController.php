<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Http\Request;

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
}
