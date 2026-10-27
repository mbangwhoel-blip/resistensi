<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Hasil Uji Resistensi - PETA RESISTENSI</title>

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
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen">

    {{-- SIDEBAR NAVIGASI UTAMA --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <div class="transition-all duration-300 pl-0 lg:pl-64 flex flex-col min-h-screen">

        {{-- HEADER TOP BAR --}}
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 px-4 sm:px-6 py-3.5 flex items-center justify-between shadow-2xs">
            <div class="flex items-center gap-3">
                <button type="button"
                        onclick="toggleSidebarDrawer()"
                        class="lg:hidden flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition shadow-2xs cursor-pointer focus:outline-none"
                        aria-label="Buka Menu Navigasi">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div>
                    <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                        <span>PETA RESISTENSI</span>
                        <span>/</span>
                        <span class="text-teal-600 dark:text-teal-400">Laporan</span>
                    </div>
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2 mt-0.5 truncate">
                        <span>📑 Laporan Hasil Uji Resistensi Vektor</span>
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- WIDGET PROFIL PENGGUNA --}}
                @include('header_profile')
            </div>
        </header>

        {{-- AREA KONTEN --}}
        <main class="flex-1 p-6 space-y-6">

            {{-- KARTU KPI / RINGKASAN STATISTIK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
                {{-- TOTAL PEMERIKSAAN --}}
                <div class="rounded-2xl border border-slate-200/90 bg-white p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Uji</span>
                        <div class="h-8 w-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600">
                            📊
                        </div>
                    </div>
                    <div class="mt-2 text-2xl font-black text-slate-900 leading-tight">
                        {{ number_format($stats['total_pemeriksaan'], 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-medium text-slate-400">
                        Catatan pemeriksaan terfilter
                    </div>
                </div>

                {{-- TOTAL SAMPEL NYAMUK --}}
                <div class="rounded-2xl border border-teal-200 bg-teal-50/40 dark:bg-teal-950/20 dark:border-teal-800/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700 dark:text-teal-300">Total Nyamuk</span>
                        <div class="h-8 w-8 rounded-xl bg-teal-100 dark:bg-teal-900/40 flex items-center justify-center text-teal-700 dark:text-teal-300 font-bold text-xs">
                            🦟
                        </div>
                    </div>
                    <div class="mt-2 text-2xl font-black text-teal-900 dark:text-white leading-tight">
                        {{ number_format($stats['total_sampel'], 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-teal-600 dark:text-teal-400">
                        Ekor nyamuk diuji
                    </div>
                </div>

                {{-- RESISTEN (MERAH) --}}
                <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-rose-700">Resisten</span>
                        <span class="rounded-md bg-rose-200/80 px-1.5 py-0.5 text-[10px] font-bold text-rose-800">
                            {{ $stats['persen_resisten'] }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-rose-700 leading-tight">
                        {{ number_format($stats['total_resisten'], 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-rose-600/80">
                        Populasi kebal insektisida
                    </div>
                </div>

                {{-- TOLERAN / TERDUGA (KUNING / ORANYE) --}}
                <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">Toleran</span>
                        <span class="rounded-md bg-amber-200/80 px-1.5 py-0.5 text-[10px] font-bold text-amber-800">
                            {{ $stats['persen_toleran'] }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-amber-700 leading-tight">
                        {{ number_format($stats['total_toleran'], 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-amber-600/80">
                        Terduga mulai resisten
                    </div>
                </div>

                {{-- RENTAN (HIJAU) --}}
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Rentan</span>
                        <span class="rounded-md bg-emerald-200/80 px-1.5 py-0.5 text-[10px] font-bold text-emerald-800">
                            {{ $stats['persen_rentan'] }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-emerald-700 leading-tight">
                        {{ number_format($stats['total_rentan'], 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-emerald-600/80">
                        Mati efektif oleh insektisida
                    </div>
                </div>
            </div>

            {{-- WHO EPIDEMIOLOGICAL HEALTH BAR (DISTRIBUSI PROPORSI RESISTENSI) --}}
            <div class="rounded-2xl border border-slate-200/90 bg-white p-4 sm:p-5 shadow-2xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 mb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-teal-50 text-teal-700 font-bold text-sm border border-teal-200/60 dark:bg-teal-950/40 dark:border-teal-800">
                            📈
                        </span>
                        <div>
                            <h3 class="text-xs font-black uppercase tracking-wider text-slate-800 dark:text-slate-100 flex items-center gap-1.5">
                                <span>Rasio Kesehatan Kerentanan Vektor (Standar WHO)</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-200 dark:bg-teal-900/50 dark:text-teal-300">
                                    Total {{ number_format($stats['total_pemeriksaan']) }} Uji
                                </span>
                            </h3>
                            <p class="text-[11px] text-slate-500 mt-0.5">
                                Proporsi komparatif efektivitas insektisida terhadap populasi vektor berdasarkan filter aktif
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5 text-xs font-bold">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 dark:bg-rose-950/40 dark:border-rose-800">
                            <span class="h-2 w-2 rounded-full bg-rose-500"></span> Resisten: {{ $stats['persen_resisten'] }}%
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-700 dark:bg-amber-950/40 dark:border-amber-800">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span> Toleran: {{ $stats['persen_toleran'] }}%
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700 dark:bg-emerald-950/40 dark:border-emerald-800">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Rentan: {{ $stats['persen_rentan'] }}%
                        </span>
                    </div>
                </div>

                {{-- STACKED MULTI-SEGMENT PROGRESS BAR --}}
                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-xl h-4 overflow-hidden flex p-0.5 shadow-inner gap-0.5">
                    @if ($stats['persen_resisten'] > 0)
                        <div class="bg-rose-500 h-full rounded-l-lg transition-all duration-500 hover:brightness-110 flex items-center justify-center text-[10px] text-white font-black" 
                             style="width: {{ $stats['persen_resisten'] }}%" 
                             title="Resisten: {{ $stats['persen_resisten'] }}% ({{ number_format($stats['total_resisten']) }} uji)">
                            @if ($stats['persen_resisten'] >= 8) {{ $stats['persen_resisten'] }}% @endif
                        </div>
                    @endif
                    @if ($stats['persen_toleran'] > 0)
                        <div class="bg-amber-400 h-full transition-all duration-500 hover:brightness-110 flex items-center justify-center text-[10px] text-amber-950 font-black" 
                             style="width: {{ $stats['persen_toleran'] }}%" 
                             title="Toleran: {{ $stats['persen_toleran'] }}% ({{ number_format($stats['total_toleran']) }} uji)">
                            @if ($stats['persen_toleran'] >= 8) {{ $stats['persen_toleran'] }}% @endif
                        </div>
                    @endif
                    @if ($stats['persen_rentan'] > 0)
                        <div class="bg-emerald-500 h-full rounded-r-lg transition-all duration-500 hover:brightness-110 flex items-center justify-center text-[10px] text-white font-black" 
                             style="width: {{ $stats['persen_rentan'] }}%" 
                             title="Rentan: {{ $stats['persen_rentan'] }}% ({{ number_format($stats['total_rentan']) }} uji)">
                            @if ($stats['persen_rentan'] >= 8) {{ $stats['persen_rentan'] }}% @endif
                        </div>
                    @endif
                </div>

                <div class="flex flex-wrap items-center justify-between text-[11px] text-slate-500 mt-2 font-medium">
                    <span>Status Epidemiologis: 
                        @if ($stats['persen_resisten'] >= 50)
                            <strong class="text-rose-600 font-bold">⚠️ Tingkat Resistensi Tinggi (&gt;50%) - Segera lakukan evaluasi rotasi insektisida</strong>
                        @elseif ($stats['persen_toleran'] >= 30)
                            <strong class="text-amber-600 font-bold">⚡ Populasi Toleran Signifikan - Perlu monitoring berkala bioassay konfirmasi</strong>
                        @else
                            <strong class="text-emerald-600 font-bold">✓ Efektivitas Pengendalian Vektor Masih Terjaga Baik</strong>
                        @endif
                    </span>
                    <span class="text-slate-400">Total Basis: {{ number_format($stats['total_pemeriksaan']) }} uji ({{ number_format($stats['total_sampel']) }} ekor)</span>
                </div>
            </div>

            {{-- FORM FILTER PENCARIAN LAPORAN --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3.5 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600 text-sm font-bold">
                            🔍
                        </span>
                        <div>
                            <h2 class="text-sm font-extrabold text-slate-900 leading-tight">Filter Parameter Laporan</h2>
                            <p class="text-[11px] text-slate-500">Sesuaikan kriteria data yang ingin ditampilkan dan dicetak ke PDF</p>
                        </div>
                    </div>

                    {{-- TOMBOL ACTION DENGAN FILTER AKTIF (SAAS STYLE) --}}
                    @php
                        $pdfQuery = request()->query();
                    @endphp
                    <div class="flex items-center gap-2.5 flex-wrap sm:flex-nowrap">
                        <a href="{{ route('laporan.preview', $pdfQuery) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2 text-xs font-bold text-white shadow-xs transition hover:shadow-md cursor-pointer"
                           title="Buka pratinjau dokumen di layar">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <span>Lihat Pratinjau</span>
                        </a>

                        <a href="{{ route('laporan.pdf', array_merge($pdfQuery, ['mode' => 'download'])) }}"
                           class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2 text-xs font-bold text-white shadow-xs transition hover:shadow-md cursor-pointer"
                           title="Unduh langsung file berkas PDF">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh File PDF</span>
                        </a>
                    </div>
                </div>

                {{-- QUICK PRESETS FILTER PILLS --}}
                <div class="flex flex-wrap items-center gap-2 pb-3.5 mb-3.5 border-b border-slate-100">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1 mr-1">
                        <span>⚡</span> Preset Cepat:
                    </span>
                    <button type="button" onclick="applyQuickFilter('semua')" 
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-bold transition shadow-2xs cursor-pointer {{ request()->except(['page']) ? 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300' : 'bg-blue-600 text-white shadow-xs' }}">
                        ✨ Semua Data
                    </button>
                    <button type="button" onclick="applyQuickFilter('tahun_ini')" 
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-bold transition shadow-2xs cursor-pointer {{ ((string)request('tahun_mulai') === (string)date('Y') && (string)request('tahun_selesai') === (string)date('Y')) || (string)request('tahun') === (string)date('Y') ? 'bg-blue-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300' }}">
                        📅 Tahun {{ date('Y') }}
                    </button>
                    <button type="button" onclick="applyQuickFilter('resisten')" 
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-bold transition shadow-2xs cursor-pointer {{ strtolower(request('status')) === 'resisten' ? 'bg-rose-600 text-white shadow-xs' : 'bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 dark:bg-rose-950/40 dark:border-rose-800' }}">
                        🔴 Hanya Resisten
                    </button>
                    <button type="button" onclick="applyQuickFilter('rentan')" 
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-bold transition shadow-2xs cursor-pointer {{ strtolower(request('status')) === 'rentan' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100 border border-emerald-200 dark:bg-emerald-950/40 dark:border-emerald-800' }}">
                        🟢 Hanya Rentan
                    </button>
                    <button type="button" onclick="applyQuickFilter('aedes')" 
                            class="inline-flex items-center gap-1 px-3 py-1 rounded-xl text-xs font-bold transition shadow-2xs cursor-pointer {{ request('jenis_nyamuk') === 'Ae. aegypti' ? 'bg-teal-600 text-white shadow-xs' : 'bg-teal-50 text-teal-700 hover:bg-teal-100 border border-teal-200 dark:bg-teal-950/40 dark:border-teal-800' }}">
                        🦟 Aedes aegypti
                    </button>
                </div>

                <form action="{{ route('laporan.index') }}" method="GET" id="formFilterLaporan" class="space-y-4">

                    {{-- BARIS 1: WILAYAH & PERIODE --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                        {{-- PROVINSI --}}
                        <div>
                            <label for="provinsi_id" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Provinsi
                            </label>
                            <select name="provinsi_id" id="provinsi_id" onchange="loadKabupatenOptions(this.value)" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Provinsi --</option>
                                @foreach($provinsis as $p)
                                    <option value="{{ $p->id }}" {{ (string)$provinsiId === (string)$p->id ? 'selected' : '' }}>
                                        {{ $p->nama_provinsi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KABUPATEN / KOTA --}}
                        <div>
                            <label for="kabupaten_id" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Kabupaten / Kota
                            </label>
                            <select name="kabupaten_id" id="kabupaten_id" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Kabupaten --</option>
                                @foreach($kabupatens as $k)
                                    <option value="{{ $k->id }}" {{ (string)$kabupatenId === (string)$k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kabupaten }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- RENTANG TAHUN --}}
                        <div>
                            <label class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Rentang Tahun
                            </label>
                            <div class="grid grid-cols-2 gap-1.5">
                                <select name="tahun_mulai" id="tahun_mulai" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-2 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs" title="Tahun Mulai (Dari)">
                                    <option value="Semua">Dari...</option>
                                    @foreach($daftarTahunAsc as $thn)
                                        <option value="{{ $thn }}" {{ (string)($tahunMulai ?? '') === (string)$thn ? 'selected' : '' }}>
                                            {{ $thn }}
                                        </option>
                                    @endforeach
                                </select>
                                <select name="tahun_selesai" id="tahun_selesai" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-2 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs" title="Tahun Selesai (Sampai)">
                                    <option value="Semua">Sampai...</option>
                                    @foreach($daftarTahun as $thn)
                                        <option value="{{ $thn }}" {{ (string)($tahunSelesai ?? '') === (string)$thn ? 'selected' : '' }}>
                                            {{ $thn }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- BULAN --}}
                        <div>
                            <label for="bulan" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Bulan
                            </label>
                            <select name="bulan" id="bulan" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Bulan --</option>
                                @foreach($daftarBulan as $bln)
                                    <option value="{{ $bln }}" {{ $bulan === $bln ? 'selected' : '' }}>
                                        {{ $bln }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- BARIS 2: VEKTOR, INSEKTISIDA, STATUS & PER PAGE --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                        {{-- JENIS NYAMUK --}}
                        <div>
                            <label for="jenis_nyamuk" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Jenis Nyamuk (Vektor)
                            </label>
                            <select name="jenis_nyamuk" id="jenis_nyamuk" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Jenis Nyamuk --</option>
                                @foreach($daftarNyamuk as $nyk)
                                    <option value="{{ $nyk }}" {{ $jenisNyamuk === $nyk ? 'selected' : '' }}>
                                        {{ $nyk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- INSEKTISIDA --}}
                        <div>
                            <label for="insektisida" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Bahan Insektisida
                            </label>
                            <select name="insektisida" id="insektisida" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Insektisida --</option>
                                @foreach($daftarInsektisida as $ins)
                                    <option value="{{ $ins }}" {{ $insektisida === $ins ? 'selected' : '' }}>
                                        {{ $ins }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- STATUS KERENTANAN --}}
                        <div>
                            <label for="status" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Status Kerentanan
                            </label>
                            <select name="status" id="status" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Status --</option>
                                <option value="Resisten" {{ strtolower($status) === 'resisten' ? 'selected' : '' }}>Resisten</option>
                                <option value="Toleran" {{ strtolower($status) === 'toleran' ? 'selected' : '' }}>Toleran / Terduga Resisten</option>
                                <option value="Rentan" {{ strtolower($status) === 'rentan' ? 'selected' : '' }}>Rentan</option>
                            </select>
                        </div>

                        {{-- TAMPILKAN PER HALAMAN --}}
                        <div>
                            <label for="per_page" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Baris per Halaman
                            </label>
                            <select name="per_page" id="per_page" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="5" {{ (string)($perPageRaw ?? $perPage) == '5' ? 'selected' : '' }}>5 Data</option>
                                <option value="10" {{ (string)($perPageRaw ?? $perPage) == '10' ? 'selected' : '' }}>10 Data</option>
                                <option value="25" {{ (string)($perPageRaw ?? $perPage) == '25' ? 'selected' : '' }}>25 Data</option>
                                <option value="50" {{ (string)($perPageRaw ?? $perPage) == '50' ? 'selected' : '' }}>50 Data</option>
                                <option value="100" {{ (string)($perPageRaw ?? $perPage) == '100' ? 'selected' : '' }}>100 Data</option>
                                <option value="all" {{ (string)($perPageRaw ?? $perPage) == 'all' ? 'selected' : '' }}>Semua Data</option>
                            </select>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI FILTER --}}
                    <div class="flex items-center gap-2.5 pt-2">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-5 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>Terapkan Filter</span>
                        </button>

                        <a href="{{ route('laporan.index') }}" class="btn-reset-filter inline-flex items-center gap-1.5 rounded-xl px-4 py-2.5 text-xs font-bold transition shadow-2xs cursor-pointer">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span>Reset Filter</span>
                        </a>
                    </div>

                </form>
            </div>

            {{-- TABEL DATA HASIL UJI LAPORAN --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-white">
                    <div>
                        <h3 class="text-sm font-bold text-slate-900 leading-tight">Data Hasil Pemeriksaan Laboratorium</h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Menampilkan {{ $dataUji->firstItem() ?? 0 }} - {{ $dataUji->lastItem() ?? 0 }} dari {{ number_format($dataUji->total(), 0, ',', '.') }} data hasil uji resistensi
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5">
                        {{-- LIVE SEARCH TABLE --}}
                        <div class="relative w-56 sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text"
                                   id="tableSearchInput"
                                   placeholder="Cari cepat di tabel..."
                                   onkeyup="filterTableLive(this.value)"
                                   class="w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-9 pr-3.5 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                        </div>

                        {{-- KONTROL TAMPIL DATA (PAGE SIZE SELECTOR) --}}
                        <div class="flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50/80 px-2.5 py-1 shadow-2xs">
                            <label for="tablePageSizeSelect" class="text-xs font-semibold text-slate-600 whitespace-nowrap flex items-center gap-1">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <span>Tampil:</span>
                            </label>
                            <select id="tablePageSizeSelect" 
                                    onchange="changeTablePageSize(this.value)" 
                                    class="rounded border border-slate-200 bg-white px-2 py-0.5 text-xs font-bold text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none cursor-pointer">
                                <option value="5" {{ (string)($perPageRaw ?? $perPage) === '5' ? 'selected' : '' }}>5 data</option>
                                <option value="10" {{ (string)($perPageRaw ?? $perPage) === '10' ? 'selected' : '' }}>10 data</option>
                                <option value="25" {{ (string)($perPageRaw ?? $perPage) === '25' ? 'selected' : '' }}>25 data</option>
                                <option value="50" {{ (string)($perPageRaw ?? $perPage) === '50' ? 'selected' : '' }}>50 data</option>
                                <option value="100" {{ (string)($perPageRaw ?? $perPage) === '100' ? 'selected' : '' }}>100 data</option>
                                <option value="all" {{ (string)($perPageRaw ?? $perPage) === 'all' ? 'selected' : '' }}>Semua data</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="overflow-x-auto bg-slate-50">
                    <table class="w-full text-left text-xs table-fixed border-collapse" id="laporanTable">
                        <thead>
                            <tr class="bg-slate-900 text-white font-bold uppercase tracking-wider text-[11px] border-b border-slate-800">
                                <th class="w-[3.5%] px-1.5 py-2.5 text-center">No</th>
                                <th class="w-[11.5%] px-2.5 py-2.5 whitespace-nowrap">Kab/Prov</th>
                                <th class="w-[16%] px-2.5 py-2.5">Alamat / Lokasi</th>
                                <th class="w-[12%] px-2 py-2.5">Jenis Nyamuk</th>
                                <th class="w-[16%] px-2.5 py-2.5">Insektisida / Metode</th>
                                <th class="w-[7%] px-2 py-2.5 text-center whitespace-nowrap">Sampel</th>
                                <th class="w-[8.5%] px-2 py-2.5 text-center whitespace-nowrap">Status</th>
                                <th class="w-[7.5%] px-2 py-2.5 text-center whitespace-nowrap">Periode</th>
                                <th class="w-[5%] px-1.5 py-2.5 text-center whitespace-nowrap">Mutasi</th>
                                <th class="w-[13%] px-2.5 py-2.5 text-left">Publikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white" id="laporanTableBody">
                            @forelse($dataUji as $idx => $row)
                                @php
                                     $st = strtolower((string)$row->status);
                                @endphp
                                <tr class="hover:bg-blue-50/40 transition align-top">
                                    <td class="px-1.5 py-2.5 text-center text-slate-400 font-bold text-xs whitespace-nowrap">
                                        {{ $dataUji->firstItem() + $idx }}
                                    </td>
                                    <td class="px-2.5 py-2.5 text-xs">
                                        <div class="font-bold text-slate-800 dark:text-slate-100 leading-snug break-words">{{ $row->kabupaten ? $row->kabupaten->nama_kabupaten : '-' }}</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400 font-normal leading-snug break-words">{{ ($row->kabupaten && $row->kabupaten->provinsi) ? $row->kabupaten->provinsi->nama_provinsi : ($row->provinsi ? $row->provinsi->nama_provinsi : '-') }}</div>
                                    </td>
                                    <td class="px-2.5 py-2.5 text-xs text-slate-700 dark:text-slate-200 leading-snug break-words">
                                        @if(!empty($row->alamat))
                                            <div class="flex items-start gap-1 font-medium">
                                                <span class="text-teal-600 dark:text-teal-400 shrink-0 text-xs mt-0.5">📍</span>
                                                <span class="break-words leading-snug">{{ $row->alamat }}</span>
                                            </div>
                                        @else
                                            <span class="italic text-slate-400">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2.5">
                                        <span class="inline-block rounded-md bg-teal-50 dark:bg-teal-950/40 border border-teal-200 dark:border-teal-800/60 px-2 py-0.5 text-[11px] font-semibold text-teal-700 dark:text-teal-300 break-words leading-tight">
                                            {{ $row->jenis_nyamuk ?: '-' }}
                                        </span>
                                    </td>
                                    <td class="px-2.5 py-2.5 text-xs">
                                        <div class="font-semibold text-slate-800 dark:text-slate-100 leading-snug break-words">
                                            {{ $row->insektisida ?: '-' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400 font-normal leading-snug break-words mt-0.5">
                                            {{ $row->metode ?: '-' }}
                                        </div>
                                    </td>
                                    <td class="px-2 py-2.5 text-center font-bold text-slate-900 dark:text-slate-100 text-xs whitespace-nowrap">
                                        {{ $row->sampel_diperiksa ? number_format($row->sampel_diperiksa, 0, ',', '.') : '0' }}
                                    </td>
                                    <td class="px-2 py-2.5 text-center whitespace-nowrap">
                                        @if($st === 'resisten')
                                            <span class="inline-flex items-center gap-1 rounded-md bg-rose-50 border border-rose-200 px-1.5 py-0.5 text-[11px] font-bold text-rose-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Resisten
                                            </span>
                                        @elseif(in_array($st, ['toleran', 'terduga resisten', 'toleran/terduga resisten']))
                                            <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 border border-amber-200 px-1.5 py-0.5 text-[11px] font-bold text-amber-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Toleran
                                            </span>
                                        @elseif($st === 'rentan')
                                            <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 border border-emerald-200 px-1.5 py-0.5 text-[11px] font-bold text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Rentan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-md bg-slate-100 px-1.5 py-0.5 text-[11px] font-bold text-slate-600">
                                                {{ ucfirst($st ?: '-') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-2 py-2.5 text-center whitespace-nowrap text-[11px]">
                                        <span class="font-bold text-slate-800 dark:text-slate-100 block">{{ $row->bulan ?: '-' }}</span>
                                        <span class="text-slate-500 dark:text-slate-400 text-[11px] block">{{ $row->tahun }}</span>
                                    </td>
                                    <td class="px-1.5 py-2.5 text-center text-slate-600 dark:text-slate-400 font-mono text-[11px] whitespace-nowrap">
                                        {{ $row->mutasi ?: '-' }}
                                    </td>
                                    <td class="px-2.5 py-2.5 text-left text-[11px] leading-snug">
                                        @if($row->publikasi && str_starts_with($row->publikasi, 'http'))
                                            <a href="{{ $row->publikasi }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline break-all block" title="{{ $row->publikasi }}">
                                                {{ $row->publikasi }}
                                            </a>
                                        @elseif($row->publikasi)
                                            <span class="text-slate-700 dark:text-slate-300 break-words block">{{ $row->publikasi }}</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center text-slate-400">
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-3xl mb-2">📋</span>
                                            <p class="font-bold text-slate-600 text-sm">Tidak ada data hasil uji resistensi yang ditemukan</p>
                                            <p class="text-xs text-slate-400 mt-1">Coba sesuaikan filter pencarian Anda di atas</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION FOOTER --}}
                @if($dataUji->hasPages())
                    <div class="border-t border-slate-100 bg-white px-4 py-2.5">
                        {{ $dataUji->links() }}
                    </div>
                @endif
            </div>

            {{-- KOTAK KETERANGAN STATUS RESISTENSI STANDAR KEMENKES RI / WHO --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-2xs">
                <div class="flex items-center gap-2 mb-3 pb-2 border-b border-slate-100">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-blue-600 ring-2 ring-blue-100"></span>
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">
                        Keterangan Kategori Status Resistensi Vektor (Standar Kemenkes RI / WHO)
                    </h4>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                    <div class="rounded-xl border border-rose-200 bg-rose-50/50 p-3">
                        <div class="font-bold text-rose-700 flex items-center gap-1.5 mb-1">
                            <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                            <span>Resisten (Mortalitas &lt; 90%)</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Populasi vektor telah kebal/resisten terhadap insektisida. Pengendalian vektor dengan bahan aktif ini perlu dievaluasi atau diganti.</p>
                    </div>
                    <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-3">
                        <div class="font-bold text-amber-700 flex items-center gap-1.5 mb-1">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                            <span>Toleran / Terduga (Mortalitas 90% - 97%)</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Indikasi awal toleransi atau kecurigaan resistensi vektor. Diperlukan pengujian konfirmasi dan pengawasan berkala.</p>
                    </div>
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50/50 p-3">
                        <div class="font-bold text-emerald-700 flex items-center gap-1.5 mb-1">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <span>Rentan (Mortalitas 98% - 100%)</span>
                        </div>
                        <p class="text-[11px] text-slate-600 leading-relaxed">Insektisida masih sangat efektif membunuh populasi vektor target dalam kegiatan pengendalian penyakit.</p>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Load opsi kabupaten secara dinamis saat user memilih provinsi
        function loadKabupatenOptions(provinsiId) {
            const kabSelect = document.getElementById('kabupaten_id');
            if (!kabSelect) return;

            kabSelect.innerHTML = '<option value="Semua">-- Memuat Kabupaten... --</option>';

            if (!provinsiId || provinsiId === 'Semua') {
                kabSelect.innerHTML = '<option value="Semua">-- Semua Kabupaten --</option>';
                return;
            }

            fetch('{{ url("/kabupaten") }}/' + provinsiId)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="Semua">-- Semua Kabupaten --</option>';
                    if (Array.isArray(data)) {
                        data.forEach(item => {
                            html += `<option value="${item.id}">${item.nama_kabupaten}</option>`;
                        });
                    }
                    kabSelect.innerHTML = html;
                })
                .catch(err => {
                    console.error('Gagal memuat kabupaten:', err);
                    kabSelect.innerHTML = '<option value="Semua">-- Semua Kabupaten --</option>';
                });
        }

        // Live table search di halaman saat ini
        function filterTableLive(keyword) {
            const term = (keyword || '').toLowerCase().trim();
            const rows = document.querySelectorAll('#laporanTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Kontrol Page Size (Tampil X Data) Tabel Data Laporan
        function changeTablePageSize(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }

        // Quick Preset Filter Handler
        function applyQuickFilter(preset) {
            const form = document.getElementById('formFilterLaporan');
            if (!form) return;
            
            if (preset === 'semua') {
                window.location.href = "{{ route('laporan.index') }}";
                return;
            }

            if (preset === 'tahun_ini') {
                const tahunMulaiSelect = document.getElementById('tahun_mulai');
                const tahunSelesaiSelect = document.getElementById('tahun_selesai');
                if (tahunMulaiSelect) tahunMulaiSelect.value = "{{ date('Y') }}";
                if (tahunSelesaiSelect) tahunSelesaiSelect.value = "{{ date('Y') }}";
            } else if (preset === 'resisten') {
                const statusSelect = document.getElementById('status');
                if (statusSelect) statusSelect.value = "Resisten";
            } else if (preset === 'rentan') {
                const statusSelect = document.getElementById('status');
                if (statusSelect) statusSelect.value = "Rentan";
            } else if (preset === 'aedes') {
                const nyamukSelect = document.getElementById('jenis_nyamuk');
                if (nyamukSelect) nyamukSelect.value = "Ae. aegypti";
            }

            form.submit();
        }
    </script>

</body>
</html>
