<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data Hasil Uji Resistensi - SIMPEL BBLKL</title>

    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body, * {
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        @media print {
            aside, header, #filterCard, #kpiSection, #actionButtons, .pagination-nav, .no-print {
                display: none !important;
            }
            main {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            body {
                background: white !important;
                color: black !important;
            }
            .print-only {
                display: block !important;
            }
        }
        .print-only {
            display: none;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    {{-- SIDEBAR NAVIGASI --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="ml-64 min-h-screen flex flex-col">

        {{-- TOPBAR RESMI --}}
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 px-6 lg:px-8 py-3.5 flex items-center justify-between shadow-2xs">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                    <span>SIMPEL BBLKL</span>
                    <span>/</span>
                    <span class="text-blue-600">Export Data</span>
                </div>
                <h1 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2 mt-0.5">
                    <span>📦 Export Data Hasil Uji Resistensi</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                {{-- WIDGET PROFIL PENGGUNA --}}
                @include('header_profile')
            </div>
        </header>

        {{-- AREA ISI HALAMAN --}}
        <section class="p-6 lg:p-8 space-y-6 flex-1">

            {{-- HEADER KHUSUS KETIKA DICETAK (PRINT ONLY) --}}
            <div class="print-only mb-6 border-b-2 border-slate-800 pb-4 text-center">
                <h2 class="text-xl font-black uppercase tracking-wider text-slate-900">KEMENTERIAN KESEHATAN RI • BBLKL</h2>
                <h3 class="text-base font-bold text-slate-700">Laporan Ekspor Data Uji Resistensi Vektor</h3>
                <p class="text-xs text-slate-500 mt-1">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>

            {{-- KARTU KPI / RINGKASAN STATISTIK DATA TERFILTER --}}
            <div id="kpiSection" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 no-print">
                {{-- TOTAL REKOR DATA --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Baris Data</span>
                        <div class="h-8 w-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 text-sm">
                            📊
                        </div>
                    </div>
                    <div class="mt-2 text-2xl font-black text-slate-900 leading-tight">
                        {{ number_format($totalSemua, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-medium text-slate-400">
                        Catatan uji resistensi terfilter
                    </div>
                </div>

                {{-- TOTAL SAMPEL NYAMUK --}}
                <div class="rounded-2xl border border-blue-200 bg-blue-50/40 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Total Nyamuk</span>
                        <div class="h-8 w-8 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 text-sm font-bold">
                            🦟
                        </div>
                    </div>
                    <div class="mt-2 text-2xl font-black text-blue-900 leading-tight">
                        {{ number_format($totalSampel, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-blue-600">
                        Ekor nyamuk diuji
                    </div>
                </div>

                {{-- JUMLAH RESISTEN --}}
                <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-rose-700">Resisten</span>
                        <span class="rounded-md bg-rose-200/80 px-1.5 py-0.5 text-[10px] font-bold text-rose-800">
                            {{ $totalSemua > 0 ? round(($totalResisten / $totalSemua) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-rose-700 leading-tight">
                        {{ number_format($totalResisten, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-rose-600/80">
                        Vektor kebal insektisida
                    </div>
                </div>

                {{-- JUMLAH TOLERAN --}}
                <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">Toleran</span>
                        <span class="rounded-md bg-amber-200/80 px-1.5 py-0.5 text-[10px] font-bold text-amber-800">
                            {{ $totalSemua > 0 ? round(($totalToleran / $totalSemua) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-amber-700 leading-tight">
                        {{ number_format($totalToleran, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-amber-600/80">
                        Terduga mulai resisten
                    </div>
                </div>

                {{-- JUMLAH RENTAN --}}
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Rentan</span>
                        <span class="rounded-md bg-emerald-200/80 px-1.5 py-0.5 text-[10px] font-bold text-emerald-800">
                            {{ $totalSemua > 0 ? round(($totalRentan / $totalSemua) * 100, 1) : 0 }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-emerald-700 leading-tight">
                        {{ number_format($totalRentan, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-emerald-600/80">
                        Mati efektif oleh insektisida
                    </div>
                </div>
            </div>

            {{-- KARTU FILTER DAN OPSI EXPORT --}}
            <div id="filterCard" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs no-print">
                <div class="flex flex-wrap items-center justify-between border-b border-slate-100 pb-3.5 mb-4 gap-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-base font-bold shadow-2xs">
                            📥
                        </span>
                        <div>
                            <h2 class="text-sm font-extrabold text-slate-900 leading-tight">Filter Parameter Ekspor Data</h2>
                            <p class="text-xs text-slate-500">Pilih rentang bulan, tahun, jenis nyamuk, atau wilayah data yang ingin diunduh</p>
                        </div>
                    </div>

                    <div>
                        <span class="inline-flex items-center gap-1.5 rounded-xl bg-blue-50 border border-blue-200 px-3 py-1 text-xs font-bold text-blue-700 shadow-2xs">
                            <span>🎯</span> Data Terpilih: {{ number_format($totalSemua, 0, ',', '.') }} Baris ({{ number_format($totalSampel, 0, ',', '.') }} Sampel)
                        </span>
                    </div>
                </div>

                {{-- FORM FILTER --}}
                <form method="GET" action="{{ route('export.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                        {{-- FILTER BULAN --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Bulan</label>
                            <select name="bulan" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua" {{ $bulanFilter === 'Semua' ? 'selected' : '' }}>-- Semua Bulan --</option>
                                @foreach ($daftarBulan as $b)
                                    <option value="{{ $b }}" {{ $bulanFilter === $b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER TAHUN (DEFAULT SEMUA TAHUN DENGAN LIST DARI DB) --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Tahun</label>
                            <select name="tahun" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua" {{ $tahunFilter === 'Semua' ? 'selected' : '' }}>-- Semua Tahun --</option>
                                @foreach ($daftarTahun as $thn)
                                    <option value="{{ $thn }}" {{ (string)$tahunFilter === (string)$thn ? 'selected' : '' }}>{{ $thn }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER JENIS NYAMUK --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Jenis Nyamuk (Vektor)</label>
                            <select name="jenis_nyamuk" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Jenis Vektor --</option>
                                @foreach ($daftarNyamuk as $nyamuk)
                                    <option value="{{ $nyamuk }}" {{ $nyamukFilter === $nyamuk ? 'selected' : '' }}>{{ $nyamuk }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER PROVINSI --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Provinsi</label>
                            <select name="provinsi_id" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Provinsi --</option>
                                @foreach ($provinsis as $p)
                                    <option value="{{ $p->id }}" {{ (string)$provinsiFilter === (string)$p->id ? 'selected' : '' }}>{{ $p->nama_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- BARIS AKSI BUTTONS --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <div class="flex items-center gap-2">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-blue-700 transition cursor-pointer">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                <span>Terapkan Filter</span>
                            </button>

                            <a href="{{ route('export.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition shadow-2xs cursor-pointer">
                                <span>Reset</span>
                            </a>
                        </div>

                        {{-- TOMBOL UNDUH HASIL EXPORT --}}
                        <div id="actionButtons" class="flex flex-wrap items-center gap-2.5">
                            {{-- EXCEL / CSV --}}
                            <a href="{{ route('export.download', array_merge(request()->query(), ['format' => 'csv'])) }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-emerald-700 transition cursor-pointer"
                               title="Download file CSV kompatibel Excel dengan format lengkap">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Download Excel / CSV</span>
                            </a>

                            {{-- JSON --}}
                            <a href="{{ route('export.download', array_merge(request()->query(), ['format' => 'json'])) }}"
                               class="inline-flex items-center gap-1.5 rounded-xl border border-amber-300 bg-amber-50 hover:bg-amber-100 text-amber-800 px-3.5 py-2.5 text-xs font-bold transition shadow-2xs cursor-pointer"
                               title="Export format data terstruktur JSON">
                                <span class="font-mono text-amber-600 font-bold">&lt;/&gt;</span>
                                <span>JSON</span>
                            </a>

                            {{-- PRINT --}}
                            <button type="button" onclick="window.print()"
                                    class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 px-3.5 py-2.5 text-xs font-semibold transition shadow-2xs cursor-pointer"
                                    title="Cetak langsung dokumen pratinjau">
                                <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                <span>Cetak</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- TABEL PREVIEW HASIL EXPORT --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-white">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 leading-tight">
                            Pratinjau Data Pemeriksaan ({{ number_format($totalSemua, 0, ',', '.') }} Baris Data)
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5 no-print">
                            Menampilkan data {{ $dataPreview->firstItem() ?? 0 }} - {{ $dataPreview->lastItem() ?? 0 }} dari total {{ number_format($totalSemua, 0, ',', '.') }} data hasil uji
                        </p>
                    </div>

                    {{-- PENCARIAN CEPAT DI TABEL --}}
                    <div class="relative w-64 no-print">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text"
                               placeholder="Cari di tabel..."
                               onkeyup="filterExportTableLive(this.value)"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-9 pr-3.5 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                    </div>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left text-xs border-collapse" id="exportPreviewTable">
                        <thead class="bg-slate-900 text-white uppercase text-[11px] font-bold tracking-wider border-b border-slate-800">
                            <tr>
                                <th class="px-3.5 py-3 text-center w-12">No</th>
                                <th class="px-3.5 py-3">Provinsi</th>
                                <th class="px-3.5 py-3">Kabupaten</th>
                                <th class="px-3.5 py-3">Alamat / Lokasi</th>
                                <th class="px-3.5 py-3">Jenis Nyamuk</th>
                                <th class="px-3.5 py-3">Insektisida</th>
                                <th class="px-3.5 py-3 text-center">Metode</th>
                                <th class="px-3 py-3 text-right">Sampel</th>
                                <th class="px-3 py-3 text-center">Bulan</th>
                                <th class="px-3 py-3 text-center">Tahun</th>
                                <th class="px-3 py-3 text-center text-rose-300 bg-rose-950/60 border-x border-rose-900/50">Resisten</th>
                                <th class="px-3 py-3 text-center text-emerald-300 bg-emerald-950/60 border-r border-emerald-900/50">Rentan</th>
                                <th class="px-3 py-3 text-center text-amber-300 bg-amber-950/60 border-r border-amber-900/50">Toleran</th>
                                <th class="px-3 py-3 text-center">Mutasi</th>
                                <th class="px-3.5 py-3">Publikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="exportTableBody">
                            @forelse ($dataPreview as $index => $item)
                                @php
                                    $st = strtolower(trim((string)$item->status));
                                    $isResisten = ($st === 'resisten');
                                    $isRentan = ($st === 'rentan');
                                    $isToleran = str_contains($st, 'toleran') || str_contains($st, 'terduga');
                                @endphp
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="px-3.5 py-2.5 text-center font-bold text-slate-400">
                                        {{ $dataPreview->firstItem() + $index }}
                                    </td>
                                    <td class="px-3.5 py-2.5 font-bold text-slate-800 whitespace-nowrap">
                                        {{ $item->provinsi->nama_provinsi ?? '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 text-slate-700 whitespace-nowrap">
                                        {{ $item->kabupaten->nama_kabupaten ?? '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 text-slate-600 max-w-[180px] truncate" title="{{ $item->alamat }}">
                                        {{ $item->alamat ?? '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <span class="rounded-md bg-blue-50 px-2 py-0.5 font-bold italic text-blue-700 text-[11px] border border-blue-200/60">
                                             {{ $item->jenis_nyamuk ?: '-' }}
                                        </span>
                                    </td>
                                    <td class="px-3.5 py-2.5 text-slate-800 font-medium whitespace-nowrap">
                                        {{ $item->insektisida ?: '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 text-slate-600 text-center whitespace-nowrap">
                                        {{ $item->metode ?: '-' }}
                                    </td>
                                    <td class="px-3 py-2.5 text-right font-black text-slate-900">
                                        {{ $item->sampel_diperiksa ? number_format($item->sampel_diperiksa, 0, ',', '.') : '0' }}
                                    </td>
                                    <td class="px-3 py-2.5 text-center text-slate-600 whitespace-nowrap font-medium">
                                        {{ $item->bulan ?? '-' }}
                                    </td>
                                    <td class="px-3 py-2.5 text-center text-slate-700 whitespace-nowrap font-bold">
                                        {{ $item->tahun ?? '-' }}
                                    </td>
                                    {{-- KOLOM STATUS RESISTEN --}}
                                    <td class="px-3 py-2.5 text-center bg-rose-50/40 border-x border-rose-100">
                                        @if ($isResisten)
                                            <span class="inline-flex items-center justify-center font-black text-rose-700 bg-rose-100 rounded-md px-2 py-0.5 text-xs shadow-2xs border border-rose-200">v</span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    {{-- KOLOM STATUS RENTAN --}}
                                    <td class="px-3 py-2.5 text-center bg-emerald-50/40 border-r border-emerald-100">
                                        @if ($isRentan)
                                            <span class="inline-flex items-center justify-center font-black text-emerald-700 bg-emerald-100 rounded-md px-2 py-0.5 text-xs shadow-2xs border border-emerald-200">v</span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    {{-- KOLOM STATUS TOLERAN --}}
                                    <td class="px-3 py-2.5 text-center bg-amber-50/40 border-r border-amber-100">
                                        @if ($isToleran)
                                            <span class="inline-flex items-center justify-center font-black text-amber-800 bg-amber-100 rounded-md px-2 py-0.5 text-xs shadow-2xs border border-amber-200" title="Toleran (termasuk terduga resisten)">v</span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    {{-- KOLOM MUTASI --}}
                                    <td class="px-3 py-2.5 text-center font-mono text-[11px] text-slate-600">
                                        {{ $item->mutasi ?: '-' }}
                                    </td>
                                    {{-- KOLOM PUBLIKASI --}}
                                    <td class="px-3.5 py-2.5 text-slate-700 max-w-[200px] break-all text-[11px]">
                                        @if ($item->publikasi && str_starts_with($item->publikasi, 'http'))
                                            <a href="{{ $item->publikasi }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline break-all" title="{{ $item->publikasi }}">
                                                {{ $item->publikasi }}
                                            </a>
                                        @elseif ($item->publikasi)
                                            <span class="break-words font-medium text-slate-800">
                                                {{ $item->publikasi }}
                                            </span>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15" class="px-6 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-3xl mb-2">📋</span>
                                            <p class="font-bold text-slate-600 text-sm">Tidak ada data hasil uji yang cocok dengan filter yang dipilih</p>
                                            <p class="text-xs text-slate-400 mt-1">Silakan sesuaikan kembali pilihan filter di atas</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINASI --}}
                @if ($dataPreview->hasPages())
                    <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 pagination-nav flex items-center justify-between no-print">
                        {{ $dataPreview->links() }}
                    </div>
                @endif
            </div>

        </section>

    </main>

    <script>
        // Pencarian Cepat di Tabel Preview Ekspor
        function filterExportTableLive(keyword) {
            const term = (keyword || '').toLowerCase().trim();
            const rows = document.querySelectorAll('#exportTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

</body>
</html>
