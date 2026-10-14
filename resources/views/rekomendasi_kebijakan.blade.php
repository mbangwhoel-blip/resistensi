<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Kebijakan & Rotasi Insektisida - PETA RESISTENSI</title>

    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>

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
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex transition-colors duration-200 dark:bg-zinc-950 dark:text-zinc-100">

    {{-- SIDEBAR UTAMA --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <div class="flex-1 min-w-0 flex flex-col lg:pl-64 transition-all duration-300">

        {{-- TOPBAR DENGAN PROFIL & RESPONSIF TOGGLE --}}
        <header class="sticky top-0 z-40 flex items-center justify-between border-b border-slate-200/80 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md px-4 sm:px-6 lg:px-8 py-3 gap-3 shadow-2xs">
            <div class="min-w-0 flex items-center gap-3">
                {{-- TOMBOL TOGGLE SIDEBAR MOBILE --}}
                <button type="button"
                        onclick="toggleSidebarDrawer()"
                        class="lg:hidden flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 hover:text-slate-900 dark:border-zinc-800 dark:bg-zinc-800/80 dark:text-zinc-200 transition shadow-2xs cursor-pointer focus:outline-none"
                        aria-label="Buka Menu Navigasi">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-xs sm:text-[13px] font-black text-emerald-700 dark:text-emerald-400 tracking-wider uppercase">
                            PETA RESISTENSI
                        </span>
                        <span class="hidden sm:inline-flex items-center rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200/80 dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-300 px-2.5 py-0.5 text-[10px] font-extrabold tracking-wide uppercase shrink-0">
                            BBLKL Kemenkes RI
                        </span>
                    </div>
                    <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-900 dark:text-white tracking-tight leading-snug truncate mt-0.5" title="Rekomendasi Kebijakan & Strategi Rotasi Insektisida">
                        🛡️ Rekomendasi Kebijakan & Rotasi Insektisida
                    </h1>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                {{-- PROFIL PENGGUNA & TOMBOL TEMA TERPADU --}}
                @include('header_profile')
            </div>
        </header>

        {{-- ISI UTAMA MODUL REKOMENDASI KEBIJAKAN --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-7 space-y-6">

            {{-- 1. KARTU FILTER WILAYAH, PERIODE, & SPESIES NYAMUK --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 sm:p-5 shadow-2xs dark:bg-zinc-900/90 dark:border-zinc-800">
                <form method="GET" action="{{ route('rekomendasi.index') }}" id="policyFilterForm" class="space-y-4">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-slate-100 dark:border-zinc-800">
                        <div class="flex items-center gap-2">
                            <span class="flex h-2 w-2 rounded-full bg-teal-600 ring-4 ring-teal-100 dark:ring-teal-950"></span>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                Parameter Evaluasi Kebijakan
                            </h3>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            {{-- TOMBOL CETAK / EKSPOR POLICY BRIEF RESMI --}}
                            <a href="{{ route('rekomendasi.preview', request()->all()) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 px-3.5 py-1.5 text-xs font-bold text-white shadow-2xs transition active:scale-95 cursor-pointer">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                <span>Cetak Policy Brief</span>
                            </a>

                            <span class="text-[11px] text-slate-500 dark:text-zinc-400 font-medium">
                                Evaluasi Cakupan: <strong class="text-teal-700 dark:text-teal-400">{{ $namaWilayah }}</strong>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        {{-- FILTER PROVINSI --}}
                        <div>
                            <label for="provinsi_id" class="block text-[10.5px] font-bold text-slate-500 dark:text-zinc-400 uppercase tracking-wider mb-1">
                                Provinsi
                            </label>
                            <select name="provinsi_id" id="provinsi_id" onchange="loadKabupatenOptions(this.value); this.form.submit();"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/80 px-2.5 py-1.5 text-xs font-medium text-slate-800 shadow-2xs focus:border-teal-500 focus:bg-white focus:outline-none dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-200 cursor-pointer">
                                <option value="Semua">Semua Provinsi (Nasional)</option>
                                @foreach ($provinsis as $p)
                                    <option value="{{ $p->id }}" {{ (string)$provinsiFilter === (string)$p->id ? 'selected' : '' }}>
                                        {{ $p->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER KABUPATEN / KOTA --}}
                        <div>
                            <label for="kabupaten_id" class="block text-[10.5px] font-bold text-slate-500 dark:text-zinc-400 uppercase tracking-wider mb-1">
                                Kabupaten / Kota
                            </label>
                            <select name="kabupaten_id" id="kabupaten_id" onchange="this.form.submit()"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/80 px-2.5 py-1.5 text-xs font-medium text-slate-800 shadow-2xs focus:border-teal-500 focus:bg-white focus:outline-none dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-200 cursor-pointer">
                                <option value="Semua">Semua Kabupaten/Kota</option>
                                @foreach ($daftarKabupaten as $k)
                                    <option value="{{ $k->id }}" {{ (string)$kabupatenFilter === (string)$k->id ? 'selected' : '' }}>
                                        {{ $k->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER SPESIES NYAMUK --}}
                        <div>
                            <label for="jenis_nyamuk" class="block text-[10.5px] font-bold text-slate-500 dark:text-zinc-400 uppercase tracking-wider mb-1">
                                Spesies Vektor Target
                            </label>
                            <select name="jenis_nyamuk" id="jenis_nyamuk" onchange="this.form.submit()"
                                    class="w-full rounded-xl border border-slate-200 bg-slate-50/80 px-2.5 py-1.5 text-xs font-medium text-slate-800 shadow-2xs focus:border-teal-500 focus:bg-white focus:outline-none dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-200 cursor-pointer">
                                <option value="Semua">Semua Spesies Nyamuk</option>
                                @foreach ($daftarNyamuk as $ny)
                                    <option value="{{ $ny }}" {{ $nyamukFilter === $ny ? 'selected' : '' }}>
                                        {{ $ny }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER PERIODE TAHUN & TOMBOL RESET --}}
                        <div>
                            <label for="tahun" class="block text-[10.5px] font-bold text-slate-500 dark:text-zinc-400 uppercase tracking-wider mb-1">
                                Periode Tahun
                            </label>
                            <div class="flex items-center gap-2">
                                <select name="tahun" id="tahun" onchange="this.form.submit()"
                                        class="flex-1 rounded-xl border border-slate-200 bg-slate-50/80 px-2.5 py-1.5 text-xs font-medium text-slate-800 shadow-2xs focus:border-teal-500 focus:bg-white focus:outline-none dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-200 cursor-pointer">
                                    <option value="Semua">Semua Periode</option>
                                    @foreach ($daftarTahun as $th)
                                        <option value="{{ $th }}" {{ (string)$tahunFilter === (string)$th ? 'selected' : '' }}>
                                            {{ $th }}
                                        </option>
                                    @endforeach
                                </select>

                                <a href="{{ route('rekomendasi.index') }}"
                                   class="inline-flex h-[38px] px-3 items-center justify-center rounded-xl border border-slate-200 bg-white hover:bg-slate-50 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300 text-xs font-semibold text-slate-600 transition shadow-2xs cursor-pointer whitespace-nowrap"
                                   title="Reset Filter ke Default">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2. HERO STATUS KESIAPSIAGAAN VEKTOR & PERINGATAN RISIKO --}}
            <div class="rounded-2xl border p-5 shadow-2xs relative overflow-hidden transition-all
                @if($alertLevel === 'KRITIS')
                    border-rose-300 bg-gradient-to-r from-rose-500/10 via-rose-50 to-white dark:from-rose-950/40 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-rose-900/50
                @elseif($alertLevel === 'WASPADA')
                    border-amber-300 bg-gradient-to-r from-amber-500/10 via-amber-50 to-white dark:from-amber-950/40 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-amber-900/50
                @else
                    border-emerald-300 bg-gradient-to-r from-emerald-500/10 via-emerald-50 to-white dark:from-emerald-950/40 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-emerald-900/50
                @endif">

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black tracking-wide uppercase shadow-2xs
                                @if($alertLevel === 'KRITIS') bg-rose-600 text-white animate-pulse
                                @elseif($alertLevel === 'WASPADA') bg-amber-500 text-white
                                @else bg-emerald-600 text-white
                                @endif">
                                {{ $alertBadge }}
                            </span>
                            <span class="text-xs font-bold text-slate-500 dark:text-zinc-400">
                                Wilayah: <strong>{{ $namaWilayah }}</strong> (Tahun: {{ $tahunFilter }})
                            </span>
                        </div>

                        <h2 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight">
                            Indeks Risiko Kerentanan Vektor & Arahan Kebijakan Intervensi
                        </h2>

                        <p class="text-xs sm:text-[13px] text-slate-600 dark:text-zinc-300 max-w-4xl leading-relaxed">
                            {{ $alertSummary }}
                        </p>
                        @if(!empty($catatanBukti))
                            <div class="mt-2 inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 dark:bg-teal-950/40 border border-teal-200/80 dark:border-teal-800 text-[11px] font-medium text-teal-800 dark:text-teal-300 shadow-2xs">
                                <span>💡</span>
                                <span>{{ $catatanBukti }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- STAT PILL BOX --}}
                    <div class="grid grid-cols-3 gap-2 shrink-0 bg-white/80 dark:bg-zinc-800/80 p-3 rounded-xl border border-slate-200/80 dark:border-zinc-700/80 shadow-2xs">
                        <div class="text-center px-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400">Resisten</span>
                            <p class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-0.5">{{ $persenResisten }}%</p>
                            <span class="text-[9.5px] text-slate-400">({{ $totalResisten }} uji)</span>
                        </div>
                        <div class="text-center px-2 border-x border-slate-200 dark:border-zinc-700">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Toleran</span>
                            <p class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-0.5">{{ $persenToleran }}%</p>
                            <span class="text-[9.5px] text-slate-400">({{ $totalToleran }} uji)</span>
                        </div>
                        <div class="text-center px-2">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Rentan</span>
                            <p class="text-base sm:text-lg font-black text-slate-900 dark:text-white mt-0.5">{{ $persenRentan }}%</p>
                            <span class="text-[9.5px] text-slate-400">({{ $totalRentan }} uji)</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. PROFIL VISUAL EPIDEMIOLOGIS RESISTENSI (INLINE DENGAN POLICY BRIEF) --}}
            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-2xs dark:bg-zinc-900/90 dark:border-zinc-800">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-3.5 mb-4 border-b border-slate-100 dark:border-zinc-800 gap-2">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-teal-50 text-teal-600 text-sm font-bold dark:bg-teal-950/50 dark:text-teal-300">
                            📊
                        </span>
                        <div>
                            <h3 class="text-sm font-black text-slate-900 dark:text-white leading-tight">
                                Profil Visual Epidemiologis Kerentanan Vektor & Ambang WHO
                            </h3>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-400">
                                Grafik proporsi kerentanan terintegrasi langsung dengan Lembar Policy Brief (Cakupan: {{ $namaWilayah }})
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-500 dark:text-zinc-400">
                        <span class="rounded-lg bg-slate-100 dark:bg-zinc-800 px-2.5 py-1 text-[11px]">
                            Total Basis: <strong>{{ number_format($totalPemeriksaan) }} Uji</strong> ({{ number_format($totalSampel) }} Nyamuk)
                        </span>
                    </div>
                </div>

                {{-- GRAFIK 1: WHO SUSCEPTIBILITY SPECTRUM BAR --}}
                <div class="mb-5">
                    <div class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-zinc-300 mb-2">
                        <span class="flex items-center gap-1.5">
                            <span>📈</span> Spektrum Proporsi Status Kerentanan Wilayah
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400">
                            Pedoman Interpretasi WHO GPIRM
                        </span>
                    </div>

                    <div class="w-full bg-slate-100 dark:bg-zinc-800 rounded-xl h-6 overflow-hidden flex p-1 shadow-inner gap-0.5">
                        @if ($persenResisten > 0)
                            <div class="bg-rose-500 h-full rounded-l-lg transition-all duration-500 hover:brightness-110 flex items-center justify-center text-[11px] text-white font-black"
                                 style="width: {{ $persenResisten }}%"
                                 title="Resisten: {{ $persenResisten }}% ({{ number_format($totalResisten) }} uji)">
                                @if ($persenResisten >= 7) {{ $persenResisten }}% Resisten @endif
                            </div>
                        @endif
                        @if ($persenToleran > 0)
                            <div class="bg-amber-400 h-full transition-all duration-500 hover:brightness-110 flex items-center justify-center text-[11px] text-amber-950 font-black"
                                 style="width: {{ $persenToleran }}%"
                                 title="Toleran: {{ $persenToleran }}% ({{ number_format($totalToleran) }} uji)">
                                @if ($persenToleran >= 7) {{ $persenToleran }}% Toleran @endif
                            </div>
                        @endif
                        @if ($persenRentan > 0)
                            <div class="bg-emerald-500 h-full rounded-r-lg transition-all duration-500 hover:brightness-110 flex items-center justify-center text-[11px] text-white font-black"
                                 style="width: {{ $persenRentan }}%"
                                 title="Rentan: {{ $persenRentan }}% ({{ number_format($totalRentan) }} uji)">
                                @if ($persenRentan >= 7) {{ $persenRentan }}% Rentan @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center justify-between text-[11px] text-slate-500 dark:text-zinc-400 mt-2 font-medium">
                        <div class="flex items-center gap-4">
                            <span class="inline-flex items-center gap-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-rose-500"></span>
                                <strong>Resisten:</strong> {{ $persenResisten }}% ({{ $totalResisten }} uji)
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>
                                <strong>Toleran/Terduga:</strong> {{ $persenToleran }}% ({{ $totalToleran }} uji)
                            </span>
                            <span class="inline-flex items-center gap-1.5">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                                <strong>Rentan Efektif:</strong> {{ $persenRentan }}% ({{ $totalRentan }} uji)
                            </span>
                        </div>
                        <span class="text-[10.5px] text-slate-400">
                            Threshold: &ge;50% Moratorium Mutlak | &ge;10% Konfirmasi Waspada
                        </span>
                    </div>
                </div>

                {{-- GRAFIK 2: KOMPARASI SPEKTRUM PER BAHAN AKTIF INSEKTISIDA --}}
                @if(count($matriksInsektisida) > 0)
                    <div class="pt-4 border-t border-slate-100 dark:border-zinc-800">
                        <div class="flex items-center justify-between text-xs font-bold text-slate-700 dark:text-zinc-300 mb-3">
                            <span class="flex items-center gap-1.5">
                                <span>🧪</span> Komparasi Kerentanan per Bahan Aktif Insektisida Teruji
                            </span>
                            <span class="text-[11px] font-normal text-slate-400">
                                Sumbu horizontal: 0% s/d 100% efikasi bunuh bioassay
                            </span>
                        </div>

                        <div class="space-y-2.5">
                            @foreach($matriksInsektisida as $m)
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 p-2.5 rounded-xl border border-slate-100 dark:border-zinc-800/80 bg-slate-50/60 dark:bg-zinc-800/40">
                                    <div class="w-full sm:w-56 shrink-0 flex items-center justify-between sm:justify-start gap-2">
                                        <span class="text-xs font-extrabold text-slate-900 dark:text-white truncate" title="{{ $m['nama'] }}">
                                            {{ $m['nama'] }}
                                        </span>
                                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-slate-200/80 dark:bg-zinc-700 text-slate-600 dark:text-zinc-300 whitespace-nowrap">
                                            {{ $m['golongan_nama'] }}
                                        </span>
                                    </div>

                                    <div class="flex-1 bg-slate-200 dark:bg-zinc-700 rounded-lg h-5 overflow-hidden flex p-0.5 gap-0.5 shadow-inner">
                                        @if($m['persen_resisten'] > 0)
                                            <div class="bg-rose-500 h-full rounded-l transition-all duration-300 flex items-center justify-center text-[10px] text-white font-bold"
                                                 style="width: {{ $m['persen_resisten'] }}%"
                                                 title="Resisten: {{ $m['persen_resisten'] }}%">
                                                @if($m['persen_resisten'] >= 14) {{ $m['persen_resisten'] }}% @endif
                                            </div>
                                        @endif
                                        @if($m['persen_toleran'] > 0)
                                            <div class="bg-amber-400 h-full transition-all duration-300 flex items-center justify-center text-[10px] text-amber-950 font-bold"
                                                 style="width: {{ $m['persen_toleran'] }}%"
                                                 title="Toleran: {{ $m['persen_toleran'] }}%">
                                                @if($m['persen_toleran'] >= 14) {{ $m['persen_toleran'] }}% @endif
                                            </div>
                                        @endif
                                        @if($m['persen_rentan'] > 0)
                                            <div class="bg-emerald-500 h-full rounded-r transition-all duration-300 flex items-center justify-center text-[10px] text-white font-bold"
                                                 style="width: {{ $m['persen_rentan'] }}%"
                                                 title="Rentan: {{ $m['persen_rentan'] }}%">
                                                @if($m['persen_rentan'] >= 14) {{ $m['persen_rentan'] }}% @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="w-full sm:w-40 shrink-0 flex items-center justify-between sm:justify-end gap-2 text-right">
                                        <span class="text-[11px] text-slate-500 dark:text-zinc-400">
                                            {{ $m['total_uji'] }} uji ({{ $m['total_sampel'] }} ekor)
                                        </span>
                                        @if($m['status_aksi'] === 'MORATORIUM')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300">
                                                STOP
                                            </span>
                                        @elseif($m['status_aksi'] === 'PENGAWASAN')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                                                PANTAU
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-black bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                                REKOM
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- 4. RINGKASAN REKOMENDASI STATUS BAHAN AKTIF (KARTU 3 PILAR) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- PILAR 1: DILARANG (MORATORIUM) --}}
                <div class="rounded-2xl border border-rose-200 bg-white p-4.5 shadow-2xs dark:bg-zinc-900/90 dark:border-rose-900/50">
                    <div class="flex items-center justify-between pb-3 border-b border-rose-100 dark:border-rose-950">
                        <div class="flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-rose-100 text-rose-700 font-bold text-sm dark:bg-rose-950/70 dark:text-rose-300">
                                🚫
                            </span>
                            <div>
                                <h4 class="text-xs font-black text-rose-700 dark:text-rose-400 uppercase tracking-wider">
                                    Moratorium / Stop Penggunaan
                                </h4>
                                <p class="text-[10.5px] text-slate-400">Bahan aktif yang tidak lagi efektif</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-rose-100 px-2 py-0.5 text-xs font-black text-rose-700 dark:bg-rose-950/80 dark:text-rose-300">
                            {{ count($dilarangList) }} Bahan
                        </span>
                    </div>

                    <div class="mt-3 space-y-2">
                        @forelse($dilarangList as $item)
                            <div class="p-2.5 rounded-xl border border-rose-100 bg-rose-50/50 dark:bg-rose-950/20 dark:border-rose-900/40 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $item['nama'] }}</p>
                                    <p class="text-[10px] text-rose-600 dark:text-rose-400 font-medium">{{ $item['golongan'] }}</p>
                                </div>
                                <span class="text-xs font-black text-rose-700 dark:text-rose-300 bg-white dark:bg-zinc-800 px-2 py-0.5 rounded border border-rose-200/80 dark:border-rose-800">
                                    {{ $item['pctResisten'] }}% Resisten
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Tidak ada bahan aktif yang berstatus moratorium kritis pada filter ini.</p>
                        @endforelse
                    </div>
                </div>

                {{-- PILAR 2: DALAM PENGAWASAN (EVALUASI KETAT) --}}
                <div class="rounded-2xl border border-amber-200 bg-white p-4.5 shadow-2xs dark:bg-zinc-900/90 dark:border-amber-900/50">
                    <div class="flex items-center justify-between pb-3 border-b border-amber-100 dark:border-amber-950">
                        <div class="flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-amber-100 text-amber-700 font-bold text-sm dark:bg-amber-950/70 dark:text-amber-300">
                                ⚠️
                            </span>
                            <div>
                                <h4 class="text-xs font-black text-amber-700 dark:text-amber-400 uppercase tracking-wider">
                                    Pengawasan & Evaluasi Ketat
                                </h4>
                                <p class="text-[10.5px] text-slate-400">Kekebalan mulai terbentuk (Toleran)</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-amber-100 px-2 py-0.5 text-xs font-black text-amber-700 dark:bg-amber-950/80 dark:text-amber-300">
                            {{ count($pengawasanList) }} Bahan
                        </span>
                    </div>

                    <div class="mt-3 space-y-2">
                        @forelse($pengawasanList as $item)
                            <div class="p-2.5 rounded-xl border border-amber-100 bg-amber-50/50 dark:bg-amber-950/20 dark:border-amber-900/40 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $item['nama'] }}</p>
                                    <p class="text-[10px] text-amber-600 dark:text-amber-400 font-medium">{{ $item['golongan'] }}</p>
                                </div>
                                <span class="text-xs font-black text-amber-700 dark:text-amber-300 bg-white dark:bg-zinc-800 px-2 py-0.5 rounded border border-amber-200/80 dark:border-amber-800">
                                    {{ $item['pctToleran'] }}% Toleran
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Tidak ada bahan aktif yang berstatus toleran/peringatan pada filter ini.</p>
                        @endforelse
                    </div>
                </div>

                {{-- PILAR 3: DIREKOMENDASIKAN (PILIHAN UTAMA) --}}
                <div class="rounded-2xl border border-emerald-200 bg-white p-4.5 shadow-2xs dark:bg-zinc-900/90 dark:border-emerald-900/50">
                    <div class="flex items-center justify-between pb-3 border-b border-emerald-100 dark:border-emerald-950">
                        <div class="flex items-center gap-2">
                            <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700 font-bold text-sm dark:bg-emerald-950/70 dark:text-emerald-300">
                                ✓
                            </span>
                            <div>
                                <h4 class="text-xs font-black text-emerald-700 dark:text-emerald-400 uppercase tracking-wider">
                                    Rekomendasi Pilihan Utama
                                </h4>
                                <p class="text-[10.5px] text-slate-400">Efektif membunuh vektor (Rentan)</p>
                            </div>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-black text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300">
                            {{ count($direkomendasikanList) }} Bahan
                        </span>
                    </div>

                    <div class="mt-3 space-y-2">
                        @forelse($direkomendasikanList as $item)
                            <div class="p-2.5 rounded-xl border border-emerald-100 bg-emerald-50/50 dark:bg-emerald-950/20 dark:border-emerald-900/40 flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $item['nama'] }}</p>
                                    <p class="text-[10px] text-emerald-600 dark:text-emerald-400 font-medium">{{ $item['golongan'] }}</p>
                                </div>
                                <span class="text-xs font-black text-emerald-700 dark:text-emerald-300 bg-white dark:bg-zinc-800 px-2 py-0.5 rounded border border-emerald-200/80 dark:border-emerald-800">
                                    {{ $item['pctRentan'] }}% Rentan
                                </span>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400 italic py-2">Belum ada bahan aktif yang berstatus rentan optimal pada data filter ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- 4. PANDUAN STRATEGI ROTASI INSEKTISIDA LINTAS GOLONGAN --}}
            @if(count($strategiRotasi) > 0)
                <div class="rounded-2xl border border-indigo-200/80 bg-white p-5 shadow-2xs dark:bg-zinc-900/90 dark:border-indigo-900/50">
                    <div class="flex items-center gap-2 pb-3 border-b border-indigo-100 dark:border-zinc-800">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-100 text-indigo-700 font-bold text-sm dark:bg-indigo-950/70 dark:text-indigo-300">
                            🔄
                        </span>
                        <div>
                            <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                                Rekomendasi Pasangan Rotasi Bahan Aktif Lintas Golongan
                            </h3>
                            <p class="text-[11px] text-slate-500 dark:text-zinc-400">
                                Menghindari resistensi silang (*cross-resistance*) dengan beralih ke insektisida yang memiliki reseptor kerja sel saraf berbeda
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-3.5">
                        @foreach($strategiRotasi as $rotasi)
                            <div class="rounded-xl border border-slate-200/80 bg-slate-50/70 dark:bg-zinc-800/60 dark:border-zinc-700/80 p-4 space-y-2.5">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400">Hentikan (Resisten):</span>
                                        <p class="text-xs font-black text-rose-700 dark:text-rose-300 mt-0.5">{{ $rotasi['dilarang'] }}</p>
                                    </div>
                                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-indigo-700 font-black text-xs shrink-0 dark:bg-indigo-950 dark:text-indigo-300">
                                        ➔
                                    </span>
                                    <div class="flex-1 text-right">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Ganti ke Alternatif:</span>
                                        <p class="text-xs font-black text-emerald-700 dark:text-emerald-300 mt-0.5">{{ $rotasi['alternatif'] }}</p>
                                    </div>
                                </div>
                                <div class="pt-2 border-t border-slate-200/60 dark:border-zinc-700/60 text-[11px] text-slate-600 dark:text-zinc-300 leading-relaxed">
                                    💡 <strong>Rasional Kebijakan:</strong> {{ $rotasi['alasan'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- 5. TABEL LENGKAP MATRIKS EVALUASI KEBIJAKAN SEMUA INSEKTISIDA --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white overflow-hidden shadow-2xs dark:bg-zinc-900/90 dark:border-zinc-800">
                <div class="px-5 py-4 border-b border-slate-200/80 dark:border-zinc-800 flex flex-wrap items-center justify-between gap-2">
                    <div class="flex items-center gap-2">
                        <span class="flex h-2 w-2 rounded-full bg-teal-600 ring-4 ring-teal-100 dark:ring-teal-950"></span>
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                            Matriks Lengkap Efikasi & Arahan Penggunaan Insektisida
                        </h3>
                    </div>
                    <span class="text-xs text-slate-400">Total: {{ count($matriksInsektisida) }} Bahan Aktif Teruji</span>
                </div>

                <div class="overflow-x-auto bg-slate-50 dark:bg-zinc-900">
                    <table class="w-full text-left text-xs">
                        <thead class="border-b border-slate-200 bg-slate-50 text-[10.5px] font-bold uppercase tracking-wider text-slate-500 dark:bg-zinc-800/80 dark:border-zinc-700 dark:text-zinc-400">
                            <tr>
                                <th class="w-10 px-2.5 py-3 text-center whitespace-nowrap">No</th>
                                <th class="px-3 py-3 whitespace-nowrap">Bahan Aktif Insektisida</th>
                                <th class="px-3 py-3 whitespace-nowrap">Golongan Kimia</th>
                                <th class="w-20 px-2 py-3 text-center whitespace-nowrap">Total Uji</th>
                                <th class="w-48 px-3 py-3 text-center whitespace-nowrap">Profil Kerentanan</th>
                                <th class="w-36 px-2.5 py-3 text-center whitespace-nowrap">Status Rekomendasi</th>
                                <th class="px-3 py-3 whitespace-nowrap">Arahan Aksi Operasional</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white dark:bg-zinc-900 dark:divide-zinc-800">
                            @forelse($matriksInsektisida as $index => $row)
                                <tr class="hover:bg-slate-50/80 dark:hover:bg-zinc-800/60 transition">
                                    <td class="px-2.5 py-2.5 text-center font-bold text-slate-400 text-xs">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-3 py-2.5 font-bold text-slate-900 dark:text-white text-xs">
                                        <div>{{ $row['nama'] }}</div>
                                        @if(!empty($row['formulasi']))
                                            <div class="text-[10px] text-slate-400 dark:text-zinc-500 font-normal mt-0.5" title="Formulasi/Dosis: {{ $row['formulasi'] }}">
                                                {{ $row['formulasi'] }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2.5 text-xs">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-semibold
                                            @if($row['golongan_warna'] === 'rose') bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-950/40 dark:border-rose-900 dark:text-rose-300
                                            @elseif($row['golongan_warna'] === 'amber') bg-amber-50 text-amber-700 border border-amber-200 dark:bg-amber-950/40 dark:border-amber-900 dark:text-amber-300
                                            @elseif($row['golongan_warna'] === 'indigo') bg-indigo-50 text-indigo-700 border border-indigo-200 dark:bg-indigo-950/40 dark:border-indigo-900 dark:text-indigo-300
                                            @elseif($row['golongan_warna'] === 'emerald') bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-950/40 dark:border-emerald-900 dark:text-emerald-300
                                            @else bg-slate-100 text-slate-700 border border-slate-200 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300
                                            @endif">
                                            {{ $row['golongan_nama'] }}
                                        </span>
                                    </td>
                                    <td class="px-2 py-2.5 text-center font-bold text-slate-700 dark:text-zinc-200">
                                        {{ $row['total_uji'] }}x
                                    </td>
                                    <td class="px-3 py-2.5 text-center">
                                        {{-- STACKED MINI PROGRESS BAR --}}
                                        <div class="w-full bg-slate-100 dark:bg-zinc-800 rounded-full h-2 flex overflow-hidden">
                                            <div class="bg-rose-500 h-2" style="width: {{ $row['persen_resisten'] }}%" title="Resisten: {{ $row['persen_resisten'] }}%"></div>
                                            <div class="bg-amber-500 h-2" style="width: {{ $row['persen_toleran'] }}%" title="Toleran: {{ $row['persen_toleran'] }}%"></div>
                                            <div class="bg-emerald-500 h-2" style="width: {{ $row['persen_rentan'] }}%" title="Rentan: {{ $row['persen_rentan'] }}%"></div>
                                        </div>
                                        <div class="flex items-center justify-between text-[10px] text-slate-500 dark:text-zinc-400 mt-1">
                                            <span class="text-rose-600 font-bold">{{ $row['persen_resisten'] }}% R</span>
                                            <span class="text-amber-600 font-bold">{{ $row['persen_toleran'] }}% T</span>
                                            <span class="text-emerald-600 font-bold">{{ $row['persen_rentan'] }}% Ren</span>
                                        </div>
                                    </td>
                                    <td class="px-2.5 py-2.5 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10.5px] font-black tracking-wide
                                            @if($row['status_aksi'] === 'MORATORIUM') bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-950/60 dark:border-rose-800 dark:text-rose-300
                                            @elseif($row['status_aksi'] === 'PENGAWASAN') bg-amber-100 text-amber-800 border border-amber-200 dark:bg-amber-950/60 dark:border-amber-800 dark:text-amber-300
                                            @else bg-emerald-100 text-emerald-800 border border-emerald-200 dark:bg-emerald-950/60 dark:border-emerald-800 dark:text-emerald-300
                                            @endif">
                                            {{ $row['badge_aksi'] }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-2.5 text-[11px] text-slate-600 dark:text-zinc-300 leading-relaxed max-w-md">
                                        {{ $row['catatan'] }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-slate-400">
                                        Tidak ada data insektisida yang cocok untuk filter yang dipilih.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 6. BUTIR INSTRUKSI REKOMENDASI KEBIJAKAN OPERASIONAL (ACTIONABLE POLICY POINTS) --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-2xs dark:bg-zinc-900/90 dark:border-zinc-800 space-y-4">
                <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-zinc-800">
                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-teal-100 text-teal-800 font-bold text-sm dark:bg-teal-950/70 dark:text-teal-300">
                        📋
                    </span>
                    <div>
                        <h3 class="text-xs sm:text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                            Lembar Arahan Kebijakan Operasional Pengendalian Vektor
                        </h3>
                        <p class="text-[11px] text-slate-500 dark:text-zinc-400">
                            Instruksi teknis dan manajerial bagi Kepala Dinas Kesehatan, Pengelola Program DBD/Malaria, dan Laboratorium
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                    {{-- JANGKA PENDEK --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/70 p-4 space-y-2 dark:bg-zinc-800/60 dark:border-zinc-700/80">
                        <div class="flex items-center gap-1.5 font-bold text-rose-700 dark:text-rose-400 uppercase tracking-wider">
                            <span>⚡</span>
                            <span>Aksi Segera (0 - 30 Hari)</span>
                        </div>
                        <ul class="list-disc pl-4 space-y-1.5 text-[11px] text-slate-600 dark:text-zinc-300 leading-relaxed">
                            <li><strong>Moratorium Langsung:</strong> Hentikan segera penggunaan insektisida yang berstatus resisten (< 90%) dalam kegiatan fogging / IRS di wilayah terdampak.</li>
                            <li><strong>Penarikan Stok Terbatas:</strong> Amankan sisa stok bahan aktif resisten di gudang farmasi agar tidak didistribusikan ke puskesmas.</li>
                            <li><strong>Pemberitahuan Tim Lapangan:</strong> Sosialisasi segera kepada petugas sanitarian dan juru semprot mengenai bahan aktif pengganti.</li>
                        </ul>
                    </div>

                    {{-- JANGKA MENENGAH --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/70 p-4 space-y-2 dark:bg-zinc-800/60 dark:border-zinc-700/80">
                        <div class="flex items-center gap-1.5 font-bold text-amber-700 dark:text-amber-400 uppercase tracking-wider">
                            <span>🔍</span>
                            <span>Strategi Teknis (1 - 6 Bulan)</span>
                        </div>
                        <ul class="list-disc pl-4 space-y-1.5 text-[11px] text-slate-600 dark:text-zinc-300 leading-relaxed">
                            <li><strong>Bioassay Konfirmasi:</strong> Lakukan pengujian ulang berkala setiap 3-6 bulan pada wilayah dengan status toleran (kuning).</li>
                            <li><strong>Intensifikasi Non-Kimiawi:</strong> Tingkatkan Gerakan 1 Rumah 1 Jumantik (G1R1J) dan PSN 3M Plus untuk memutus jentik tanpa bergantung pada racun serangga.</li>
                            <li><strong>Pengendalian Biologis:</strong> Perbanyak sebaran biolarvasida <em>Bacillus thuringiensis israelensis (Bti)</em> di tempat penampungan air bersih.</li>
                        </ul>
                    </div>

                    {{-- JANGKA PANJANG & ANGGARAN --}}
                    <div class="rounded-xl border border-slate-200/80 bg-slate-50/70 p-4 space-y-2 dark:bg-zinc-800/60 dark:border-zinc-700/80">
                        <div class="flex items-center gap-1.5 font-bold text-teal-700 dark:text-teal-400 uppercase tracking-wider">
                            <span>💰</span>
                            <span>Pengadaan & Anggaran (APBD/APBN)</span>
                        </div>
                        <ul class="list-disc pl-4 space-y-1.5 text-[11px] text-slate-600 dark:text-zinc-300 leading-relaxed">
                            <li><strong>Penyesuaian e-Katalog:</strong> Alihkan pos anggaran belanja insektisida tahun depan ke golongan rotasi yang masih rentan (≥ 98%).</li>
                            <li><strong>Hentikan Belanja Pemborosan:</strong> Larang pembelian insektisida yang telah terbukti resisten di wilayah bersangkutan.</li>
                            <li><strong>Alokasi Surveilans:</strong> Anggarkan dana uji resistensi berkala bekerjasama dengan BBLKL Kemenkes RI secara terjadwal.</li>
                        </ul>
                    </div>
                </div>
            </div>

        </main>

    </div>

    {{-- SCRIPT JAVASCRIPT DINAMIS LOAD KABUPATEN --}}
    <script>
        function loadKabupatenOptions(provinsiId) {
            const kabSelect = document.getElementById('kabupaten_id');
            if (!kabSelect) return;

            if (provinsiId === 'Semua') {
                kabSelect.innerHTML = '<option value="Semua">Semua Kabupaten/Kota</option>';
                return;
            }

            fetch(`/kabupaten/${provinsiId}`)
                .then(res => res.json())
                .then(data => {
                    kabSelect.innerHTML = '<option value="Semua">Semua Kabupaten/Kota</option>';
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.id;
                        opt.textContent = item.name || item.nama_kabupaten;
                        kabSelect.appendChild(opt);
                    });
                })
                .catch(err => console.error('Gagal memuat kabupaten:', err));
        }
    </script>

</body>
</html>
