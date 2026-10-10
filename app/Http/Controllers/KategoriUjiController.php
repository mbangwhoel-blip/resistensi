<?php

namespace App\Http\Controllers;

use App\Models\KategoriUji;
use App\Models\DataUjiResistensi;
use Illuminate\Http\Request;

class KategoriUjiController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'nyamuk');
        if (!in_array($tab, ['nyamuk', 'insektisida', 'metode'])) {
            $tab = 'nyamuk';
        }

        $search = $request->get('search');

        $query = KategoriUji::where('kategori', $tab);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('nama', 'asc')
            ->paginate(15)
            ->withQueryString();

        $totalNyamuk = KategoriUji::nyamuk()->count();
        $totalInsektisida = KategoriUji::insektisida()->count();
        $totalMetode = KategoriUji::metode()->count();
        $totalSemua = KategoriUji::count();

        return view('kategori', compact(
            'items',
            'tab',
            'search',
            'totalNyamuk',
            'totalInsektisida',
            'totalMetode',
            'totalSemua'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|in:nyamuk,insektisida,metode',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
        ], [
            'nama.required' => 'Nama parameter / kategori wajib diisi.',
            'kategori.required' => 'Pilih jenis kategori parameter.',
        ]);

        // Cek duplikasi dalam kategori yang sama
        $exists = KategoriUji::where('kategori', $validated['kategori'])
            ->where('nama', trim($validated['nama']))
            ->exists();

        if ($exists) {
            return redirect()
                ->route('kategori.index', ['tab' => $validated['kategori']])
                ->with('error', "Data '{$validated['nama']}' sudah terdaftar dalam kategori ini.");
        }

        KategoriUji::create([
            'kategori' => $validated['kategori'],
            'nama' => trim($validated['nama']),
            'keterangan' => $validated['keterangan'] ? trim($validated['keterangan']) : null,
            'is_active' => true,
        ]);

        $label = match ($validated['kategori']) {
            'nyamuk' => 'Jenis Nyamuk',
            'insektisida' => 'Insektisida',
            'metode' => 'Metode Pengendalian',
        };

        return redirect()
            ->route('kategori.index', ['tab' => $validated['kategori']])
            ->with('success', "Data {$label} '{$validated['nama']}' berhasil ditambahkan!");
    }

    public function update(Request $request, $id)
    {
        $item = KategoriUji::findOrFail($id);

        $validated = $request->validate([
            'kategori' => 'required|in:nyamuk,insektisida,metode',
            'nama' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ], [
            'nama.required' => 'Nama parameter / kategori wajib diisi.',
        ]);

        // Cek duplikasi dengan ID lain
        $exists = KategoriUji::where('kategori', $validated['kategori'])
            ->where('nama', trim($validated['nama']))
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('kategori.index', ['tab' => $validated['kategori']])
                ->with('error', "Data '{$validated['nama']}' sudah terdaftar dalam kategori ini.");
        }

        $oldName = $item->nama;

        $item->update([
            'kategori' => $validated['kategori'],
            'nama' => trim($validated['nama']),
            'keterangan' => $validated['keterangan'] ? trim($validated['keterangan']) : null,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        return redirect()
            ->route('kategori.index', ['tab' => $validated['kategori']])
            ->with('success', "Data '{$oldName}' berhasil diperbarui!");
    }

    public function destroy($id)
    {
        $item = KategoriUji::findOrFail($id);
        $tab = $item->kategori;
        $nama = $item->nama;

        // Cek apakah parameter ini sedang dipakai dalam data uji resistensi
        $inUse = false;
        if ($tab === 'nyamuk') {
            $inUse = DataUjiResistensi::where('jenis_nyamuk', $nama)->exists();
        } elseif ($tab === 'insektisida') {
            $inUse = DataUjiResistensi::where('insektisida', $nama)->exists();
        } elseif ($tab === 'metode') {
            $inUse = DataUjiResistensi::where('metode', $nama)->exists();
        }

        if ($inUse) {
            return redirect()
                ->route('kategori.index', ['tab' => $tab])
                ->with('error', "Tidak dapat menghapus '{$nama}' karena telah digunakan pada data hasil uji laboratorium!");
        }

        $item->delete();

        return redirect()
            ->route('kategori.index', ['tab' => $tab])
            ->with('success', "Data '{$nama}' berhasil dihapus dari master kategori!");
    }
}
