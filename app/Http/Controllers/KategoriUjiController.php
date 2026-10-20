<?php

namespace App\Http\Controllers;

use App\Models\KategoriUji;
use App\Models\DataUjiResistensi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KategoriUjiController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'nyamuk');
        if (!in_array($tab, ['nyamuk', 'insektisida', 'metode'])) {
            $tab = 'nyamuk';
        }

        $search = $request->get('search');

        $query = KategoriUji::where('category', $tab);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('name', 'asc')
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
        $exists = KategoriUji::where('category', $validated['kategori'])
            ->where('name', trim($validated['nama']))
            ->exists();

        if ($exists) {
            return redirect()
                ->route('kategori.index', ['tab' => $validated['kategori']])
                ->with('error', "Data '{$validated['nama']}' sudah terdaftar dalam kategori ini.");
        }

        KategoriUji::create([
            'category' => $validated['kategori'],
            'name' => trim($validated['nama']),
            'description' => $validated['keterangan'] ? trim($validated['keterangan']) : null,
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
        $exists = KategoriUji::where('category', $validated['kategori'])
            ->where('name', trim($validated['nama']))
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return redirect()
                ->route('kategori.index', ['tab' => $validated['kategori']])
                ->with('error', "Data '{$validated['nama']}' sudah terdaftar dalam kategori ini.");
        }

        $oldName = $item->name ?? $item->nama;
        $newName = trim($validated['nama']);
        $category = $validated['kategori'];

        $item->update([
            'category' => $category,
            'name' => $newName,
            'description' => $validated['keterangan'] ? trim($validated['keterangan']) : null,
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : true,
        ]);

        // KASKADE UPDATE: Sinkronkan seluruh data uji laboratorium yang menggunakan parameter ini
        $affectedRows = 0;
        if ($oldName !== $newName) {
            if ($category === 'nyamuk') {
                $affectedRows = DataUjiResistensi::where('mosquito_type', $oldName)->update(['mosquito_type' => $newName]);
            } elseif ($category === 'insektisida') {
                $affectedRows = DataUjiResistensi::where('insecticide', $oldName)->update(['insecticide' => $newName]);
            } elseif ($category === 'metode') {
                $affectedRows = DataUjiResistensi::where('method', $oldName)->update(['method' => $newName]);
            }
        }

        $successMsg = "Data '{$oldName}' berhasil diperbarui!";
        if ($affectedRows > 0) {
            $successMsg .= " Sebanyak {$affectedRows} data hasil uji laboratorium otomatis disinkronkan ke '{$newName}'.";
        }

        return redirect()
            ->route('kategori.index', ['tab' => $category])
            ->with('success', $successMsg);
    }

    /**
     * Sinkronkan seluruh parameter (nyamuk, insektisida, metode) dari data uji ke master kategori
     */
    public function sync(Request $request)
    {
        $stats = self::syncWithDataUji();

        $totalAdded = $stats['nyamuk_added'] + $stats['insektisida_added'] + $stats['metode_added'];

        if ($totalAdded > 0) {
            $msg = "Sinkronisasi berhasil! Berhasil menambahkan {$totalAdded} parameter baru ke master data ({$stats['nyamuk_added']} jenis nyamuk, {$stats['insektisida_added']} insektisida, dan {$stats['metode_added']} metode).";
        } else {
            $msg = "Seluruh parameter (nyamuk, insektisida, dan metode) dari data uji sudah 100% sinkron dengan master data.";
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Logika internal sinkronisasi parameter dari data uji
     */
    public static function syncWithDataUji(): array
    {
        $stats = [
            'nyamuk_added' => 0,
            'insektisida_added' => 0,
            'metode_added' => 0,
        ];

        // 1. Jenis Nyamuk
        $nyamukList = DataUjiResistensi::whereNotNull('mosquito_type')
            ->where('mosquito_type', '!=', '')
            ->distinct()
            ->pluck('mosquito_type');

        foreach ($nyamukList as $nama) {
            $cleanName = trim($nama);
            if ($cleanName === '') continue;

            $exists = KategoriUji::where('category', 'nyamuk')
                ->whereRaw('LOWER(name) = ?', [strtolower($cleanName)])
                ->exists();

            if (!$exists) {
                KategoriUji::create([
                    'category' => 'nyamuk',
                    'name' => $cleanName,
                    'description' => 'Ditambahkan otomatis dari data hasil uji laboratorium',
                    'is_active' => true,
                ]);
                $stats['nyamuk_added']++;
            }
        }

        // 2. Insektisida
        $insList = DataUjiResistensi::whereNotNull('insecticide')
            ->where('insecticide', '!=', '')
            ->distinct()
            ->pluck('insecticide');

        foreach ($insList as $nama) {
            $cleanName = trim($nama);
            if ($cleanName === '') continue;

            $exists = KategoriUji::where('category', 'insektisida')
                ->whereRaw('LOWER(name) = ?', [strtolower($cleanName)])
                ->exists();

            if (!$exists) {
                KategoriUji::create([
                    'category' => 'insektisida',
                    'name' => $cleanName,
                    'description' => 'Ditambahkan otomatis dari data hasil uji laboratorium',
                    'is_active' => true,
                ]);
                $stats['insektisida_added']++;
            }
        }

        // 3. Metode Pengendalian
        $metodeList = DataUjiResistensi::whereNotNull('method')
            ->where('method', '!=', '')
            ->distinct()
            ->pluck('method');

        foreach ($metodeList as $nama) {
            $cleanName = trim($nama);
            if ($cleanName === '') continue;

            $exists = KategoriUji::where('category', 'metode')
                ->whereRaw('LOWER(name) = ?', [strtolower($cleanName)])
                ->exists();

            if (!$exists) {
                KategoriUji::create([
                    'category' => 'metode',
                    'name' => $cleanName,
                    'description' => 'Ditambahkan otomatis dari data hasil uji laboratorium',
                    'is_active' => true,
                ]);
                $stats['metode_added']++;
            }
        }

        return $stats;
    }

    public function destroy($id)
    {
        $item = KategoriUji::findOrFail($id);
        $tab = $item->category ?? $item->kategori;
        $nama = $item->name ?? $item->nama;

        // Cek apakah parameter ini sedang dipakai dalam data uji resistensi
        $inUse = false;
        if ($tab === 'nyamuk') {
            $inUse = DataUjiResistensi::where('mosquito_type', $nama)->exists();
        } elseif ($tab === 'insektisida') {
            $inUse = DataUjiResistensi::where('insecticide', $nama)->exists();
        } elseif ($tab === 'metode') {
            $inUse = DataUjiResistensi::where('method', $nama)->exists();
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

    /**
     * Tampilan Pratinjau Cetak Interaktif Master Data Kategori & Parameter Uji (Web Print Preview)
     */
    public function preview(Request $request)
    {
        $tab = $request->get('tab', 'nyamuk');
        $search = trim($request->get('search', ''));

        $query = KategoriUji::query();

        if ($tab && in_array($tab, ['nyamuk', 'insektisida', 'metode'])) {
            $query->where('category', $tab);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('category', 'asc')->orderBy('name', 'asc')->get();

        $totalNyamuk = KategoriUji::nyamuk()->count();
        $totalInsektisida = KategoriUji::insektisida()->count();
        $totalMetode = KategoriUji::metode()->count();
        $totalSemua = KategoriUji::count();

        $categoryLabels = [
            'nyamuk' => 'Jenis Nyamuk Vektor',
            'insektisida' => 'Insektisida / Bahan Aktif',
            'metode' => 'Metode Pengendalian / Pengujian',
            'all' => 'Seluruh Parameter Uji'
        ];

        $filterInfo = [
            'tab' => $tab,
            'tab_label' => $categoryLabels[$tab] ?? 'Parameter Uji',
            'search' => $search,
            'total_terfilter' => $data->count(),
            'total_semua' => $totalSemua,
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas Administrator'
        ];

        return view('kategori_preview', compact(
            'data',
            'tab',
            'search',
            'filterInfo',
            'totalNyamuk',
            'totalInsektisida',
            'totalMetode',
            'totalSemua'
        ));
    }

    /**
     * Unduh atau Alirkan Master Data Kategori & Parameter Uji dalam Format PDF Resmi
     */
    public function exportPdf(Request $request)
    {
        @ini_set('memory_limit', '512M');
        @ini_set('max_execution_time', '180');

        $tab = $request->get('tab', 'nyamuk');
        $search = trim($request->get('search', ''));
        $mode = $request->get('mode', 'stream');

        $query = KategoriUji::query();

        if ($tab && in_array($tab, ['nyamuk', 'insektisida', 'metode'])) {
            $query->where('category', $tab);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $data = $query->orderBy('category', 'asc')->orderBy('name', 'asc')->get();

        $totalNyamuk = KategoriUji::nyamuk()->count();
        $totalInsektisida = KategoriUji::insektisida()->count();
        $totalMetode = KategoriUji::metode()->count();
        $totalSemua = KategoriUji::count();

        $categoryLabels = [
            'nyamuk' => 'Jenis Nyamuk Vektor',
            'insektisida' => 'Insektisida / Bahan Aktif',
            'metode' => 'Metode Pengendalian / Pengujian',
            'all' => 'Seluruh Parameter Uji'
        ];

        $filterInfo = [
            'tab' => $tab,
            'tab_label' => $categoryLabels[$tab] ?? 'Parameter Uji',
            'search' => $search,
            'total_terfilter' => $data->count(),
            'total_semua' => $totalSemua,
            'dicetak_pada' => date('d F Y, H:i') . ' WIB',
            'user' => auth()->check() ? auth()->user()->name : 'Petugas Administrator'
        ];

        $logoBase64 = null;
        $logoPath = public_path('logo_bblkl.png');
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }

        $pdf = Pdf::loadView('kategori_pdf', compact('data', 'tab', 'filterInfo', 'logoBase64'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'Master-Data-Parameter-Uji-' . $tab . '-' . date('Ymd-His') . '.pdf';

        if ($mode === 'download') {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
}
