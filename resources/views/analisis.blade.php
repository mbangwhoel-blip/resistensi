<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisis Data Hasil Uji Resistensi - SIMPEL BBLKL</title>

    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- CHART.JS LIBRARY --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            aside, header, #filterSection, #actionButtons, .no-print {
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
            .chart-card {
                break-inside: avoid;
                page-break-inside: avoid;
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
                    <span class="text-blue-600">Analisis Data</span>
                </div>
                <h1 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2 mt-0.5">
                    <span>📊 Analisis & Visualisasi Grafik Resistensi</span>
                </h1>
            </div>

            <div class="flex items-center gap-3">
                {{-- WIDGET PROFIL PENGGUNA --}}
                @include('header_profile')
            </div>
        </header>

        {{-- AREA ISI HALAMAN --}}
        <section class="p-6 lg:p-8 space-y-6 flex-1">

            {{-- HEADER PRINT ONLY --}}
            <div class="print-only mb-6 border-b-2 border-slate-800 pb-4 text-center">
                <h2 class="text-xl font-black uppercase tracking-wider text-slate-900">KEMENTERIAN KESEHATAN RI • BBLKL</h2>
                <h3 class="text-base font-bold text-slate-700">Laporan Analisis Grafik Uji Resistensi Insektisida Vektor</h3>
                <p class="text-xs text-slate-500 mt-1">Dicetak pada: {{ now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB</p>
            </div>

            {{-- KARTU KPI / RINGKASAN STATISTIK --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3.5">
                {{-- TOTAL PENGUJIAN --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">Total Uji</span>
                        <div class="h-8 w-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-600 text-sm">
                            📋
                        </div>
                    </div>
                    <div class="mt-2 text-2xl font-black text-slate-900 leading-tight">
                        {{ number_format($totalPemeriksaan, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-medium text-slate-400">
                        Catatan uji terfilter
                    </div>
                </div>

                {{-- TOTAL SAMPEL NYAMUK --}}
                <div class="rounded-2xl border border-blue-200 bg-blue-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Total Nyamuk</span>
                        <div class="h-8 w-8 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 text-sm">
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

                {{-- KASUS RESISTEN --}}
                <div class="rounded-2xl border border-rose-200 bg-rose-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-rose-700">Resisten</span>
                        <span class="rounded-md bg-rose-200/80 px-1.5 py-0.5 text-[10px] font-bold text-rose-800">
                            {{ $persenResisten }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-rose-700 leading-tight">
                        {{ number_format($totalResisten, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-rose-600/80">
                        Vektor kebal insektisida
                    </div>
                </div>

                {{-- KASUS TOLERAN --}}
                <div class="rounded-2xl border border-amber-200 bg-amber-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-amber-700">Toleran</span>
                        <span class="rounded-md bg-amber-200/80 px-1.5 py-0.5 text-[10px] font-bold text-amber-800">
                            {{ $persenToleran }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-amber-700 leading-tight">
                        {{ number_format($totalToleran, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-amber-600/80">
                        Terduga mulai kebal
                    </div>
                </div>

                {{-- KASUS RENTAN --}}
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-700">Rentan</span>
                        <span class="rounded-md bg-emerald-200/80 px-1.5 py-0.5 text-[10px] font-bold text-emerald-800">
                            {{ $persenRentan }}%
                        </span>
                    </div>
                    <div class="mt-2 text-2xl font-black text-emerald-700 leading-tight">
                        {{ number_format($totalRentan, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-emerald-600/80">
                        Efektif terbunuh
                    </div>
                </div>

                {{-- WILAYAH TERPANTAU --}}
                <div class="rounded-2xl border border-indigo-200 bg-indigo-50/50 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-indigo-700">Provinsi</span>
                        <div class="h-8 w-8 rounded-xl bg-indigo-100 flex items-center justify-center text-indigo-700 text-sm">
                            🗺️
                        </div>
                    </div>
                    <div class="mt-2 text-2xl font-black text-indigo-900 leading-tight">
                        {{ $totalProvinsi }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-indigo-600/80">
                        Provinsi terpantau
                    </div>
                </div>
            </div>

            {{-- PANEL FILTER INTERAKTIF ANALISIS --}}
            <div id="filterSection" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs no-print">
                <div class="flex flex-wrap items-center justify-between border-b border-slate-100 pb-3.5 mb-4 gap-3">
                    <div class="flex items-center gap-3">
                        <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-base font-bold shadow-2xs">
                            🔍
                        </span>
                        <div>
                            <h2 class="text-sm font-extrabold text-slate-900 leading-tight">Filter Parameter Analisis</h2>
                            <p class="text-xs text-slate-500">Sesuaikan rentang data untuk melihat visualisasi grafik yang spesifik</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-2xs transition cursor-pointer">
                            <svg class="h-4 w-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            <span>Cetak Grafik</span>
                        </button>
                    </div>
                </div>

                {{-- FORM FILTER --}}
                <form method="GET" action="{{ route('analisis.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5">
                        {{-- FILTER TAHUN --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Tahun Pengujian</label>
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

                        {{-- FILTER INSEKTISIDA --}}
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1">Insektisida</label>
                            <select name="insektisida" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3.5 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Insektisida --</option>
                                @foreach ($daftarInsektisida as $insek)
                                    <option value="{{ $insek }}" {{ $insektisidaFilter === $insek ? 'selected' : '' }}>{{ $insek }}</option>
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

                    <div class="flex items-center gap-2 pt-1">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-blue-700 transition cursor-pointer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <span>Terapkan Filter</span>
                        </button>

                        <a href="{{ route('analisis.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition shadow-2xs cursor-pointer">
                            <span>Reset</span>
                        </a>
                    </div>
                </form>
            </div>

            {{-- SECTION GRAFIK UTAMA (GRID 2 KOLOM) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- GRAFIK 1: TREN TAHUNAN STATUS RESISTENSI (SPAN 2 KOLOM) --}}
                <div class="chart-card lg:col-span-2 rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-3">
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                    <span>📈</span>
                                    <span>Tren Status Resistensi Antar Tahun</span>
                                </h3>
                                <p class="text-xs text-slate-500 mt-0.5">Perkembangan jumlah uji Resisten, Toleran, dan Rentan dari tahun ke tahun</p>
                            </div>
                            <span class="rounded-lg bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-700 border border-blue-200/60">
                                2021 – 2026
                            </span>
                        </div>
                        <div class="mt-4 relative h-[310px] w-full">
                            <canvas id="chartTrenTahun"></canvas>
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between text-[11px] text-slate-500">
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span> Resisten</span>
                            <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span> Toleran</span>
                            <span class="inline-flex items-center gap-1.5"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span> Rentan</span>
                        </div>
                        <span class="italic text-slate-400">Total data terhitung: {{ $totalPemeriksaan }} uji</span>
                    </div>
                </div>

                {{-- GRAFIK 2: PROPORSI KESELURUHAN STATUS RESISTENSI (DONUT) --}}
                <div class="chart-card rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                <span>🎯</span>
                                <span>Proporsi Status Resistensi</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Persentase keseluruhan kategori resistensi</p>
                        </div>
                        <div class="mt-4 relative h-[210px] w-full flex items-center justify-center">
                            <canvas id="chartStatusDonut"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Uji</span>
                                <span class="text-xl font-black text-slate-800 leading-none mt-0.5">{{ number_format($totalPemeriksaan, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- RINCIAN STATUS RATA KIRI --}}
                        <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-left">
                            <div class="flex items-center justify-between p-2 rounded-xl bg-rose-50/70 border border-rose-200/80">
                                <div class="flex items-center gap-2.5 text-left">
                                    <span class="h-3 w-3 rounded-full bg-rose-600 shrink-0 shadow-2xs"></span>
                                    <span class="text-xs font-bold text-rose-900 text-left">Resisten</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-rose-700">{{ number_format($totalResisten, 0, ',', '.') }} uji</span>
                                    <span class="text-[11px] font-bold text-rose-500 ml-1">({{ $persenResisten }}%)</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-xl bg-amber-50/70 border border-amber-200/80">
                                <div class="flex items-center gap-2.5 text-left">
                                    <span class="h-3 w-3 rounded-full bg-amber-500 shrink-0 shadow-2xs"></span>
                                    <span class="text-xs font-bold text-amber-900 text-left">Toleran</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-amber-700">{{ number_format($totalToleran, 0, ',', '.') }} uji</span>
                                    <span class="text-[11px] font-bold text-amber-600 ml-1">({{ $persenToleran }}%)</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-2 rounded-xl bg-emerald-50/70 border border-emerald-200/80">
                                <div class="flex items-center gap-2.5 text-left">
                                    <span class="h-3 w-3 rounded-full bg-emerald-600 shrink-0 shadow-2xs"></span>
                                    <span class="text-xs font-bold text-emerald-900 text-left">Rentan</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs font-black text-emerald-700">{{ number_format($totalRentan, 0, ',', '.') }} uji</span>
                                    <span class="text-[11px] font-bold text-emerald-600 ml-1">({{ $persenRentan }}%)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 pt-2 text-left text-[11px] text-slate-500 font-medium flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Klasifikasi Efektivitas Resistensi Laboratorium</span>
                    </div>
                </div>

            </div>

            {{-- SECTION GRAFIK KEDUA (GRID 2 KOLOM) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- GRAFIK 3: RESISTENSI PER SPESIES NYAMUK (GROUPED BAR) --}}
                <div class="chart-card rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <span>🦟</span>
                            <span>Status Resistensi per Spesies Vektor</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Tingkat resistensi pada jenis nyamuk yang paling sering diuji</p>
                    </div>
                    <div class="mt-4 relative h-[300px] w-full">
                        <canvas id="chartNyamukBar"></canvas>
                    </div>
                </div>

                {{-- GRAFIK 4: RESISTENSI PER INSEKTISIDA (HORIZONTAL BAR) --}}
                <div class="chart-card rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs">
                    <div class="border-b border-slate-100 pb-3">
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <span>🧪</span>
                            <span>Tingkat Resistensi per Insektisida</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">Perbandingan resistensi terhadap senyawa insektisida utama</p>
                    </div>
                    <div class="mt-4 relative h-[300px] w-full">
                        <canvas id="chartInsektisidaBar"></canvas>
                    </div>
                </div>

            </div>

            {{-- SECTION GRAFIK KETIGA (GRID 2 KOLOM PROPORSIONAL) --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                {{-- GRAFIK 5: TOP 10 WILAYAH KASUS RESISTEN (SPAN 7 KOLOM) --}}
                <div class="chart-card lg:col-span-7 rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs">
                    <div class="border-b border-slate-100 pb-3 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3">
                        <div class="min-w-0 pr-2">
                            <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                <span>🗺️</span>
                                <span>10 Provinsi dengan Temuan Resisten Tertinggi</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Prioritas daerah untuk kewaspadaan dan evaluasi strategi intervensi vektor</p>
                        </div>
                        <div class="shrink-0 flex items-center justify-center">
                            <span class="inline-flex items-center justify-center gap-1.5 rounded-full bg-rose-50 px-3.5 py-1 text-xs font-black text-rose-700 border border-rose-300 ring-4 ring-rose-500/10 shadow-xs whitespace-nowrap text-center tracking-wide">
                                <span class="relative flex h-2 w-2 shrink-0">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-600"></span>
                                </span>
                                <span class="text-center">Peringatan Dini</span>
                            </span>
                        </div>
                    </div>
                    <div class="mt-4 relative h-[290px] w-full">
                        <canvas id="chartProvinsiBar"></canvas>
                    </div>
                </div>

                {{-- GRAFIK 6: DISTRIBUSI METODE UJI LABORATORIUM (SPAN 5 KOLOM) --}}
                <div class="chart-card lg:col-span-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs flex flex-col justify-between">
                    <div>
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                                <span>⚗️</span>
                                <span>Metode Pengujian Laboratorium</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">Proporsi metode bioassay dan standar uji yang digunakan</p>
                        </div>

                        {{-- DIAGRAM DONUT TEBAL & JELAS DENGAN COUNTER TENGAH --}}
                        <div class="mt-4 relative h-[210px] w-full flex items-center justify-center">
                            <canvas id="chartMetodePie"></canvas>
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-center">
                                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Total Uji</span>
                                <span class="text-xl font-black text-slate-800 leading-none mt-0.5">{{ number_format($totalPemeriksaan, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        {{-- DAFTAR RINCIAN METODE: RATA KIRI, RAPI, TIDAK TERPOTONG --}}
                        <div class="mt-4 pt-3 border-t border-slate-100 space-y-2 text-left">
                            @php
                                $colorsMetode = [
                                    '#2563eb', // Blue-600
                                    '#0284c7', // Sky-600
                                    '#10b981', // Emerald-500
                                    '#f59e0b', // Amber-500
                                    '#8b5cf6', // Purple-500
                                    '#f43f5e', // Rose-500
                                    '#64748b'  // Slate-500
                                ];
                                $totalMetodeCount = array_sum($chartMetodeData);
                            @endphp
                            @foreach ($chartMetodeLabels as $i => $metode)
                                @php
                                    $val = $chartMetodeData[$i] ?? 0;
                                    $pct = $totalMetodeCount > 0 ? round(($val / $totalMetodeCount) * 100, 1) : 0;
                                    $color = $colorsMetode[$i % count($colorsMetode)];
                                @endphp
                                <div class="flex items-start justify-between gap-2.5 text-xs p-1.5 rounded-xl hover:bg-slate-50 transition border border-transparent hover:border-slate-100">
                                    <div class="flex items-start gap-2.5 min-w-0 flex-1 text-left">
                                        <span class="h-3 w-3 rounded-full shrink-0 mt-0.5 shadow-2xs" style="background-color: {{ $color }}"></span>
                                        <span class="font-bold text-slate-700 text-left leading-snug break-words" title="{{ $metode }}">{{ $metode }}</span>
                                    </div>
                                    <div class="text-right shrink-0 flex items-center gap-1.5 font-mono whitespace-nowrap pt-0.5">
                                        <span class="font-extrabold text-slate-900 text-xs">{{ $val }} uji</span>
                                        <span class="text-[11px] font-semibold text-slate-400">({{ $pct }}%)</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- FOOTER KETERANGAN RATA KIRI --}}
                    <div class="mt-3 pt-2 text-left text-[11px] text-slate-500 font-medium flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Standar WHO Bioassay & CDC Bottle Test</span>
                    </div>
                </div>

            </div>

            {{-- TABEL MATRIKS ANALISIS: EFEKTIVITAS INSEKTISIDA VS VEKTOR --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-2xs overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3 bg-white">
                    <div>
                        <h3 class="text-sm font-extrabold text-slate-900 flex items-center gap-2">
                            <span>🔬</span>
                            <span>Matriks Analisis: Efektivitas Insektisida terhadap Vektor</span>
                        </h3>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Kombinasi pasangan vektor dan insektisida dengan tingkat resistensi tertinggi untuk rekomendasi tindak lanjut
                        </p>
                    </div>

                    {{-- LIVE SEARCH TABEL MATRIKS --}}
                    <div class="relative w-64 no-print">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </span>
                        <input type="text"
                               placeholder="Cari kombinasi vektor / insektisida..."
                               onkeyup="filterMatriksTable(this.value)"
                               class="w-full rounded-xl border border-slate-200 bg-slate-50/70 pl-9 pr-3.5 py-1.5 text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                    </div>
                </div>

                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left text-xs border-collapse" id="matriksTable">
                        <thead class="bg-slate-900 text-white uppercase text-[11px] font-bold tracking-wider border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-center w-12">No</th>
                                <th class="px-4 py-3">Jenis Nyamuk (Vektor)</th>
                                <th class="px-4 py-3">Senyawa Insektisida</th>
                                <th class="px-3 py-3 text-right">Total Uji</th>
                                <th class="px-3 py-3 text-right">Total Sampel</th>
                                <th class="px-3 py-3 text-center text-rose-300 bg-rose-950/60 border-x border-rose-900/50">Resisten</th>
                                <th class="px-3 py-3 text-center text-amber-300 bg-amber-950/60 border-r border-amber-900/50">Toleran</th>
                                <th class="px-3 py-3 text-center text-emerald-300 bg-emerald-950/60 border-r border-emerald-900/50">Rentan</th>
                                <th class="px-4 py-3 text-center">% Resistensi</th>
                                <th class="px-4 py-3 text-center">Status Dominan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="matriksTableBody">
                            @forelse ($matriksAnalisis as $idx => $m)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-4 py-2.5 text-center font-bold text-slate-400">
                                        {{ $idx + 1 }}
                                    </td>
                                    <td class="px-4 py-2.5 font-bold italic text-slate-900">
                                        {{ $m->jenis_nyamuk }}
                                    </td>
                                    <td class="px-4 py-2.5 font-semibold text-slate-800">
                                        {{ $m->insektisida }}
                                    </td>
                                    <td class="px-3 py-2.5 text-right font-bold text-slate-700">
                                        {{ $m->total_uji }}x
                                    </td>
                                    <td class="px-3 py-2.5 text-right font-black text-slate-900">
                                        {{ number_format($m->total_sampel, 0, ',', '.') }}
                                    </td>
                                    <td class="px-3 py-2.5 text-center font-bold text-rose-700 bg-rose-50/40 border-x border-rose-100">
                                        {{ $m->resisten }}
                                    </td>
                                    <td class="px-3 py-2.5 text-center font-bold text-amber-700 bg-amber-50/40 border-r border-amber-100">
                                        {{ $m->toleran }}
                                    </td>
                                    <td class="px-3 py-2.5 text-center font-bold text-emerald-700 bg-emerald-50/40 border-r border-emerald-100">
                                        {{ $m->rentan }}
                                    </td>
                                    <td class="px-4 py-2.5 text-center font-black">
                                        <div class="flex items-center justify-center gap-1.5">
                                            <div class="w-14 bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                                <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ min(100, $m->persen_resisten) }}%"></div>
                                            </div>
                                            <span class="text-xs {{ $m->persen_resisten >= 50 ? 'text-rose-600 font-extrabold' : 'text-slate-600 font-bold' }}">
                                                {{ $m->persen_resisten }}%
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-2.5 text-center whitespace-nowrap">
                                        @if ($m->status_dominan === 'Resisten')
                                            <span class="inline-flex items-center gap-1 rounded-md bg-rose-100 border border-rose-200 px-2.5 py-0.5 text-[11px] font-bold text-rose-700">
                                                ⚠️ Resisten
                                            </span>
                                        @elseif ($m->status_dominan === 'Rentan')
                                            <span class="inline-flex items-center gap-1 rounded-md bg-emerald-100 border border-emerald-200 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700">
                                                ✓ Rentan (Efektif)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-md bg-amber-100 border border-amber-200 px-2.5 py-0.5 text-[11px] font-bold text-amber-800">
                                                ⚡ Toleran
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-10 text-center text-slate-400">
                                        Tidak ada data matriks yang mencukupi untuk filter yang dipilih
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

    </main>

    {{-- INISIALISASI GRAFIK CHART.JS --}}
    <script>
        // Konfigurasi Global Chart.js responsif terhadap mode gelap / terang
        const allCharts = [];
        const isDarkInit = document.documentElement.classList.contains('dark');
        const chartTextColor = isDarkInit ? '#94a3b8' : '#64748b';
        const chartGridColor = isDarkInit ? 'rgba(51, 65, 85, 0.6)' : '#f1f5f9';
        Chart.defaults.font.family = "'Plus Jakarta Sans', 'Inter', system-ui, sans-serif";
        Chart.defaults.color = chartTextColor;

        // 1. GRAFIK TREN TAHUNAN STATUS RESISTENSI
        const ctxTren = document.getElementById('chartTrenTahun').getContext('2d');
        new Chart(ctxTren, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartTahunLabels) !!},
                datasets: [
                    {
                        label: 'Resisten',
                        data: {!! json_encode($chartTahunResisten) !!},
                        borderColor: '#e11d48',
                        backgroundColor: 'rgba(225, 29, 72, 0.1)',
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#e11d48',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5,
                        borderWidth: 2.5
                    },
                    {
                        label: 'Toleran',
                        data: {!! json_encode($chartTahunToleran) !!},
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.08)',
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#f59e0b',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5,
                        borderWidth: 2.5
                    },
                    {
                        label: 'Rentan',
                        data: {!! json_encode($chartTahunRentan) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        fill: true,
                        tension: 0.35,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4.5,
                        pointHoverRadius: 6.5,
                        borderWidth: 2.5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 12,
                            boxHeight: 12,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 11, weight: 'bold' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 10
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: 'bold' } }
                    }
                }
            }
        });

        // 2. GRAFIK DONUT PROPORSI KESELURUHAN
        const ctxDonut = document.getElementById('chartStatusDonut').getContext('2d');
        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartStatusData['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chartStatusData['data']) !!},
                    backgroundColor: ['#e11d48', '#f59e0b', '#10b981'],
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '62%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const val = context.raw || 0;
                                const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${val} uji (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });

        // 3. GRAFIK RESISTENSI PER SPESIES NYAMUK (GROUPED BAR)
        const ctxNyamuk = document.getElementById('chartNyamukBar').getContext('2d');
        new Chart(ctxNyamuk, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartNyamukLabels) !!},
                datasets: [
                    {
                        label: 'Resisten',
                        data: {!! json_encode($chartNyamukResisten) !!},
                        backgroundColor: '#e11d48',
                        borderRadius: 5
                    },
                    {
                        label: 'Toleran',
                        data: {!! json_encode($chartNyamukToleran) !!},
                        backgroundColor: '#f59e0b',
                        borderRadius: 5
                    },
                    {
                        label: 'Rentan',
                        data: {!! json_encode($chartNyamukRentan) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 11, weight: 'bold' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 10
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10.5, style: 'italic' },
                            maxRotation: 20
                        }
                    }
                }
            }
        });

        // 4. GRAFIK RESISTENSI PER INSEKTISIDA (HORIZONTAL BAR)
        const ctxInsek = document.getElementById('chartInsektisidaBar').getContext('2d');
        new Chart(ctxInsek, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartInsekLabels) !!},
                datasets: [
                    {
                        label: 'Resisten',
                        data: {!! json_encode($chartInsekResisten) !!},
                        backgroundColor: '#e11d48',
                        borderRadius: 5
                    },
                    {
                        label: 'Toleran',
                        data: {!! json_encode($chartInsekToleran) !!},
                        backgroundColor: '#f59e0b',
                        borderRadius: 5
                    },
                    {
                        label: 'Rentan',
                        data: {!! json_encode($chartInsekRentan) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 5
                    }
                ]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 11, weight: 'bold' }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 10
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 10 } }
                    },
                    y: {
                        stacked: false,
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: 'bold' } }
                    }
                }
            }
        });

        // 5. GRAFIK TOP 10 PROVINSI KASUS RESISTEN
        const ctxProv = document.getElementById('chartProvinsiBar').getContext('2d');
        new Chart(ctxProv, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartProvLabels) !!},
                datasets: [{
                    label: 'Kasus Resisten',
                    data: {!! json_encode($chartProvData) !!},
                    backgroundColor: '#e11d48',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(ctx) {
                                return ` ${ctx.raw} Uji Resisten`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 11 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10.5, weight: 'bold' },
                            maxRotation: 30
                        }
                    }
                }
            }
        });

        // 6. GRAFIK METODE PENGUJIAN LABORATORIUM (DOUGHNUT TAJAM & JELAS)
        const ctxMetode = document.getElementById('chartMetodePie').getContext('2d');
        new Chart(ctxMetode, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartMetodeLabels) !!},
                datasets: [{
                    data: {!! json_encode($chartMetodeData) !!},
                    backgroundColor: [
                        '#2563eb', // Blue-600
                        '#0284c7', // Sky-600
                        '#10b981', // Emerald-500
                        '#f59e0b', // Amber-500
                        '#8b5cf6', // Purple-500
                        '#f43f5e', // Rose-500
                        '#64748b'  // Slate-500
                    ],
                    borderWidth: 3.5,
                    borderColor: '#ffffff',
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '58%',
                plugins: {
                    legend: {
                        display: false // Menggunakan daftar rincian HTML rata kiri yang rapi di bawah chart
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const val = context.raw || 0;
                                const pct = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                return ` ${context.label}: ${val} uji (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });

        // LIVE SEARCH UNTUK TABEL MATRIKS ANALISIS
        function filterMatriksTable(keyword) {
            const term = (keyword || '').toLowerCase().trim();
            const rows = document.querySelectorAll('#matriksTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(term)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Sinkronisasi Grafik saat Ganti Mode Gelap / Terang
        window.addEventListener('themeChanged', function(e) {
            const isDark = e.detail && e.detail.isDark;
            const newTextColor = isDark ? '#94a3b8' : '#64748b';
            const newGridColor = isDark ? 'rgba(51, 65, 85, 0.6)' : '#f1f5f9';
            Chart.defaults.color = newTextColor;
            if (window.Chart && window.Chart.instances) {
                Object.values(window.Chart.instances).forEach(c => {
                    if (c && c.options && c.options.scales) {
                        if (c.options.scales.y && c.options.scales.y.grid) c.options.scales.y.grid.color = newGridColor;
                        if (c.options.scales.x && c.options.scales.x.grid) c.options.scales.x.grid.color = newGridColor;
                    }
                    c.update();
                });
            }
        });
    </script>

</body>
</html>
