<?php

namespace App\Http\Controllers;

use App\Models\Instansi;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use Illuminate\Http\Request;

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
                $q->where('nama_instansi', 'like', "%{$search}%")
                  ->orWhere('kode_unit', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        if ($provinsiId) {
            $query->where('provinsi_id', $provinsiId);
        }

        $instansis = $query->orderBy('nama_instansi', 'asc')
            ->paginate(15)
            ->withQueryString();

        $provinsis = Provinsi::orderBy('nama_provinsi', 'asc')->get();

        $totalInstansi = Instansi::count();
        $totalBkk = Instansi::where('kategori', 'like', '%BKK%')->orWhere('kategori', 'like', '%Kekarantinaan%')->count();
        $totalBalai = Instansi::where(function ($q) {
            $q->where('kategori', 'like', '%Balai%')
              ->orWhere('kategori', 'like', '%Lab%');
        })->where('kategori', 'not like', '%BKK%')->count();
        $totalDinkes = Instansi::where('kategori', 'like', '%Dinas%')->count();
        $totalFaskes = Instansi::where(function ($q) {
            $q->where('kategori', 'like', '%Rumah Sakit%')
              ->orWhere('kategori', 'like', '%Puskesmas%');
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
}
