<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Input Data - SIMPEL BBLKL</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')
</head>


<body class="bg-slate-50 text-slate-800">

    {{-- SIDEBAR --}}

    @include('sidebar')


    {{-- MAIN--}}
    @php
        $currentUser = Auth::user();
        $isViewer = $currentUser && (strtolower((string)$currentUser->role) === 'viewer' || (method_exists($currentUser, 'isViewer') && $currentUser->isViewer()));
    @endphp
    <main class="ml-64 min-h-screen">

        {{-- TOPBAR DENGAN PROFIL & LOGOUT DI KANAN ATAS --}}
        <header class="sticky top-0 z-40 flex flex-col md:flex-row md:items-center justify-between border-b border-slate-200 bg-white px-6 lg:px-8 py-3.5 gap-3 shadow-xs">
            <div class="min-w-0 flex flex-col justify-center">
                <div class="flex items-center gap-2">
                    <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug">
                        {{ $isViewer ? 'Data Hasil Uji Resistensi' : 'Input Data Uji Resistensi' }}
                    </h1>
                    @if ($isViewer)
                        <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 border border-amber-200 px-2 py-0.5 text-[10px] font-bold text-amber-700">
                            <span>👁️</span> Mode Viewer (Lihat Saja)
                        </span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Balai Besar Laboratorium Kesehatan Lingkungan (BBLKL)
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @include('header_profile')
            </div>
        </header>

        <section class="p-6 lg:p-8 space-y-5">

            {{-- ALERT NOTIFIKASI SUKSES / ERROR --}}
            @if (session('success'))
                <div class="flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-emerald-800 shadow-2xs">
                    <svg class="h-5 w-5 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-3.5 text-rose-800 shadow-2xs">
                    <svg class="h-5 w-5 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xs font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            {{-- BANNER HAK AKSES ROLE VIEWER --}}
            @if ($isViewer)
                <div id="viewerBanner" class="viewer-alert-banner flex items-center justify-between gap-3 rounded-2xl border border-amber-300/80 bg-amber-50 px-5 py-3.5 text-xs text-amber-950 shadow-2xs">
                    <div class="flex items-center gap-3.5">
                        <div class="viewer-banner-icon flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-800 font-bold text-base border border-amber-200 shadow-2xs">
                            👁️
                        </div>
                        <div>
                            <p class="viewer-banner-title font-extrabold text-amber-950 text-xs tracking-tight">Hak Akses: Viewer (Lihat Saja)</p>
                            <p class="viewer-banner-desc text-[11px] text-amber-900/90 font-medium mt-0.5 leading-relaxed">Akun Anda hanya dapat melihat, mencari, dan memfilter data uji resistensi. Fitur penambahan, pengubahan, dan penghapusan data dinonaktifkan.</p>
                        </div>
                    </div>
                    <span class="viewer-banner-badge shrink-0 inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-amber-200/80 text-amber-950 border border-amber-400/80 shadow-2xs">
                        Read-Only
                    </span>
                </div>
            @endif

            {{-- HEADER KARTU & FILTER PERIODE BULANAN (RINGKAS & PROPORSIONAL) --}}
            <div class="rounded-2xl border border-slate-200/80 bg-white p-4 sm:p-5 shadow-xs">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    
                    {{-- SISI KIRI: JUDUL & INFORMASI LAB --}}
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white shadow-xs font-bold text-base">
                            📊
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="text-lg font-bold text-slate-800">
                                    Input Data Bulanan
                                </h2>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/70">
                                    Periode: 
                                    @if($bulan == 'Semua' && $tahun == 'Semua')
                                        Semua Periode
                                    @elseif($bulan == 'Semua')
                                        Semua Bulan ({{ $tahun }})
                                    @elseif($tahun == 'Semua')
                                        {{ $bulan }} (Semua Tahun)
                                    @else
                                        {{ $bulan }} {{ $tahun }}
                                    @endif
                                </span>
                            </div>
                            <p class="mt-0.5 text-xs text-slate-500">
                                Penginputan & rekapitulasi data uji resistensi vektor • Lab: <span class="font-semibold text-slate-700">BBLKL</span>
                            </p>
                        </div>
                    </div>

                    {{-- SISI KANAN: FORM FILTER BULAN & TAHUN RINGKAS --}}
                    <form id="formFilterBulanTahun" method="GET" action="{{ route('input') }}" class="flex flex-wrap items-center gap-2.5">
                        @if(!empty($search))
                            <input type="hidden" name="search" value="{{ $search }}">
                        @endif
                        @if(request('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif

                        {{-- FILTER BULAN --}}
                        <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50/80 px-3 py-1.5 shadow-2xs hover:border-slate-300 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 transition">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Bulan:</span>
                            <select name="bulan" onchange="document.getElementById('formFilterBulanTahun').submit()" class="bg-transparent text-xs font-bold text-slate-700 focus:outline-none cursor-pointer pr-1">
                                <option value="Semua" {{ $bulan == 'Semua' ? 'selected' : '' }}>Semua Bulan</option>
                                @foreach ($daftarBulan as $b)
                                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER TAHUN --}}
                        <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50/80 px-3 py-1.5 shadow-2xs hover:border-slate-300 focus-within:border-blue-500 focus-within:bg-white focus-within:ring-2 focus-within:ring-blue-100 transition">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tahun:</span>
                            <select name="tahun" onchange="document.getElementById('formFilterBulanTahun').submit()" class="bg-transparent text-xs font-bold text-slate-700 focus:outline-none cursor-pointer pr-1">
                                <option value="Semua" {{ $tahun == 'Semua' ? 'selected' : '' }}>Semua Tahun</option>
                                @foreach ($daftarTahun as $y)
                                    <option value="{{ $y }}" {{ (string)$tahun == (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        @if($bulan != 'Semua' || $tahun != 'Semua' || !empty($search) || (request('per_page') && request('per_page') != 10))
                            <a href="{{ route('input') }}" class="inline-flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100 hover:text-slate-800 transition shadow-2xs" title="Reset filter ke default">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Reset</span>
                            </a>
                        @endif
                    </form>

                </div>
            </div>

            {{-- 4 KOTAK STATISTIK (PROPORSIONAL, RAPI & RINGKAS) --}}
            <div class="grid grid-cols-1 gap-3.5 sm:grid-cols-2 xl:grid-cols-4">
        
                {{-- ITEM PERIODE / FILTER --}}
                <div class="flex items-center justify-between rounded-xl border border-slate-200/90 bg-white p-3.5 shadow-2xs hover:shadow-xs hover:border-blue-300 transition">
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">
                            Item <span class="text-slate-300 font-normal">|</span> <span class="text-slate-500 font-medium normal-case">Filter Periode</span>
                        </p>
                        <div class="mt-1 flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-slate-800 tracking-tight leading-none">
                                {{ number_format($totalFilteredItem) }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-400">data pengujian</span>
                        </div>
                    </div>
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600 border border-blue-100">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>

                {{-- SAMPEL PERIODE / FILTER --}}
                <div class="flex items-center justify-between rounded-xl border border-slate-200/90 bg-white p-3.5 shadow-2xs hover:shadow-xs hover:border-indigo-300 transition">
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">
                            Sampel <span class="text-slate-300 font-normal">|</span> <span class="text-slate-500 font-medium normal-case">Filter Periode</span>
                        </p>
                        <div class="mt-1 flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-slate-800 tracking-tight leading-none">
                                {{ number_format($totalFilteredSampel) }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-400">ekor spesimen</span>
                        </div>
                    </div>
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                </div>

                {{-- ITEM TAHUN BERJALAN / KESELURUHAN --}}
                <div class="flex items-center justify-between rounded-xl border border-slate-200/90 bg-white p-3.5 shadow-2xs hover:shadow-xs hover:border-amber-300 transition">
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">
                            Item <span class="text-slate-300 font-normal">|</span> <span class="text-slate-500 font-medium normal-case">{{ $tahun == 'Semua' ? 'Semua Tahun' : 'Tahun ' . $tahun }}</span>
                        </p>
                        <div class="mt-1 flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-slate-800 tracking-tight leading-none">
                                {{ number_format($dataTahunBerjalan->count()) }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-400">{{ $tahun == 'Semua' ? 'total keseluruhan' : 'total tahun ' . $tahun }}</span>
                        </div>
                    </div>
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-100">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                {{-- SAMPEL TAHUN BERJALAN / KESELURUHAN --}}
                <div class="flex items-center justify-between rounded-xl border border-slate-200/90 bg-white p-3.5 shadow-2xs hover:shadow-xs hover:border-emerald-300 transition">
                    <div class="min-w-0">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 truncate">
                            Sampel <span class="text-slate-300 font-normal">|</span> <span class="text-slate-500 font-medium normal-case">{{ $tahun == 'Semua' ? 'Semua Tahun' : 'Tahun ' . $tahun }}</span>
                        </p>
                        <div class="mt-1 flex items-baseline gap-1.5">
                            <span class="text-2xl font-black text-slate-800 tracking-tight leading-none">
                                {{ number_format($dataTahunBerjalan->sum('sampel_diperiksa')) }}
                            </span>
                            <span class="text-[11px] font-medium text-slate-400">{{ $tahun == 'Semua' ? 'total spesimen' : 'total tahun ' . $tahun }}</span>
                        </div>
                    </div>
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100">
                        <svg class="h-4.5 w-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>

            </div>

        @php
    $daftarNyamuk = !empty($daftarNyamuk) ? $daftarNyamuk : [
        'Ae. aegypti', 'Culex sp', 'Anhopheles', 'Aedes sp', 'An. Farauti', 'An. Vagus',
        'An. tessellatus', 'An. sundaicus s.I', 'An. punctulatus s.I.', 'An. peditaeniatus',
        'An. parensis', 'An. letifer', 'An. koliensis', 'An. kochi', 'An. indefinitus',
        'An. hyrcanus s.I.', 'An. farauti s.s', 'An. barbirostris', 'An. aconitus', 'An. Albopictus'
    ];

    $daftarInsektisida = !empty($daftarInsektisida) ? $daftarInsektisida : [
        'Cypermethrin', 'Lamdacyhalothrin', 'Deltamethrin', 'Alphacypermethrin',
        'Cyfluthrin', 'Permethrin', 'Malathion', 'Deltamethrin 0,025%',
        'Lambda-cyhalothrin 0,0025%', 'Temefos (Abate)', 'Bendiocarb', 'Sipermethrin'
    ];

    $daftarMetode = !empty($daftarMetode) ? $daftarMetode : [
        'Sequencing', 'WHO Tube Bioassay', 'WHO larval bioassay',
        'WHO susceptibilitity test', 'WHO test kit_adults', 'CDC bottle_adults',
        'CDC bottle bioassay', 'WHO standards bioassay'
    ];
@endphp

        {{-- NOTIFIKASI SUCCESS --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-emerald-800 shadow-sm">
                <svg class="h-6 w-6 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
        @endif

        {{-- NOTIFIKASI ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-6 text-rose-800 shadow-sm">
                <div class="flex items-center gap-2 font-semibold text-rose-900 mb-2">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Data belum dapat disimpan:</span>
                </div>
                <ul class="list-inside list-disc text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- TABEL DATA UJI RESISTENSI --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            {{-- HEADER TABEL: SEARCH BOX + IMPORT EXCEL + TAMBAH DATA --}}
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 border-b border-slate-200 px-6 py-4.5 bg-white">
                <div>
                    <div class="flex items-center gap-2.5">
                        <div class="h-3 w-3 rounded-full bg-blue-600 ring-4 ring-blue-100"></div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-800">
                            Data Uji Resistensi
                        </h2>
                    </div>
                    <p class="mt-1 text-xs text-slate-500 flex flex-wrap items-center gap-1.5">
                        <span>Periode:</span>
                        <span class="font-semibold text-slate-700">
                            @if($bulan === 'Semua' && $tahun === 'Semua')
                                Semua Periode
                            @elseif($bulan === 'Semua')
                                Semua Bulan ({{ $tahun }})
                            @elseif($tahun === 'Semua')
                                {{ $bulan }} (Semua Tahun)
                            @else
                                {{ $bulan }} {{ $tahun }}
                            @endif
                        </span>
                        <span class="text-slate-300">•</span>
                        <span>Total:</span>
                        <span class="font-bold text-blue-600">{{ number_format($data->total()) }} Data</span>
                        @if(!empty($search))
                            <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-0.5 text-[11px] font-semibold text-blue-700 border border-blue-200">
                                🔍 Kata kunci: "{{ $search }}"
                            </span>
                        @endif
                    </p>
                </div>

                {{-- TOOLBAR KANAN: KOTAK PENCARIAN + KONTROL TAMPIL DATA + TOMBOL IMPORT EXCEL + TOMBOL TAMBAH DATA --}}
                <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                    {{-- KOTAK PENCARIAN (DIPENDEKKAN AGAR SEJAJAR SEBARIS) --}}
                    <form method="GET" action="{{ route('input') }}" class="relative flex items-center">
                        @if(request('bulan') && request('bulan') !== 'Semua')
                            <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                        @endif
                        @if(request('tahun') && request('tahun') !== 'Semua')
                            <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                        @endif
                        @if(request('per_page'))
                            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                        @endif
                        
                        <div class="relative w-36 sm:w-44 lg:w-48">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-slate-400">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search ?? '' }}"
                                placeholder="Cari data..." 
                                class="w-full rounded-xl border border-slate-200 bg-slate-50/80 py-2 pl-8 pr-7 text-xs font-medium text-slate-800 placeholder-slate-400 shadow-2xs transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"
                            >
                            @if(!empty($search))
                                <a href="{{ route('input', array_merge(['bulan' => $bulan, 'tahun' => $tahun], request('per_page') ? ['per_page' => request('per_page')] : [])) }}" 
                                   class="absolute inset-y-0 right-0 flex items-center pr-2 text-slate-400 hover:text-rose-500 transition" 
                                   title="Hapus pencarian">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>

                    {{-- KONTROL TAMPIL DATA (PAGE SIZE SELECTOR - TANPA ICON & LABEL AGAR RINGKAS) --}}
                    <select id="tablePageSizeSelect" 
                            onchange="changeTablePageSize(this.value)" 
                            class="rounded-xl border border-slate-200 bg-slate-50/80 px-2.5 py-2 text-xs font-bold text-slate-700 shadow-2xs transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100 cursor-pointer"
                            title="Pilih jumlah data per halaman">
                        <option value="5" {{ (string)($perPageRaw ?? request('per_page', 10)) === '5' ? 'selected' : '' }}>5 data</option>
                        <option value="10" {{ (string)($perPageRaw ?? request('per_page', 10)) === '10' ? 'selected' : '' }}>10 data</option>
                        <option value="25" {{ (string)($perPageRaw ?? request('per_page', 10)) === '25' ? 'selected' : '' }}>25 data</option>
                        <option value="50" {{ (string)($perPageRaw ?? request('per_page', 10)) === '50' ? 'selected' : '' }}>50 data</option>
                        <option value="100" {{ (string)($perPageRaw ?? request('per_page', 10)) === '100' ? 'selected' : '' }}>100 data</option>
                        <option value="all" {{ (string)($perPageRaw ?? request('per_page', 10)) === 'all' ? 'selected' : '' }}>Semua data</option>
                    </select>

                    @if (!$isViewer)
                    {{-- TOMBOL IMPORT EXCEL --}}
                    <button 
                        type="button" 
                        onclick="openModal('modalImportExcel')"
                        class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-300 bg-emerald-50 px-3.5 py-2 text-xs font-bold text-emerald-700 shadow-2xs transition hover:bg-emerald-600 hover:text-white hover:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-300 cursor-pointer dark:bg-emerald-950/70 dark:border-emerald-700 dark:text-white"
                        title="Import data pemeriksaan dari berkas Excel (.xlsx / .csv)"
                    >
                        <svg class="h-4 w-4 dark:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Import Excel</span>
                    </button>

                    {{-- TOMBOL TAMBAH DATA --}}
                    <button 
                        type="button" 
                        onclick="openModal('modalTambahData')"
                        class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-3.5 py-2 text-xs font-bold text-white shadow-2xs transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 cursor-pointer"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Input Data</span>
                    </button>
                    @endif
                </div>
            </div>

            {{-- TABEL KONTEN --}}
            <div class="overflow-x-auto bg-slate-50">
                <table class="w-full text-left text-xs min-w-[1020px]">
                    <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                        <tr>
                            <th class="w-12 px-2.5 py-3 text-center text-slate-500 whitespace-nowrap">No</th>
                            <th class="min-w-[130px] px-3 py-3 whitespace-nowrap">Kab/Prov</th>
                            <th class="min-w-[220px] px-3 py-3 whitespace-nowrap">Alamat / Lokasi</th>
                            <th class="min-w-[140px] px-3 py-3 whitespace-nowrap">Jenis Nyamuk</th>
                            <th class="min-w-[150px] px-3 py-3 whitespace-nowrap">Insektisida / Metode</th>
                            <th class="w-20 px-2 py-3 text-center whitespace-nowrap">Sampel</th>
                            <th class="w-28 px-2 py-3 text-center whitespace-nowrap">Status</th>
                            <th class="min-w-[115px] px-3 py-3 text-center whitespace-nowrap">Periode</th>
                            @if (!$isViewer)
                            <th class="w-32 px-2 py-3 text-center whitespace-nowrap">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($data as $item)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-2.5 py-2.5 text-center font-bold text-slate-400 text-xs whitespace-nowrap">
                                    {{ $data->firstItem() + $loop->index }}
                                </td>
                                <td class="px-3 py-2.5 text-xs">
                                    <div class="font-bold text-slate-800 leading-tight" title="{{ $item->kabupaten->nama_kabupaten ?? '-' }}">
                                        {{ $item->kabupaten->nama_kabupaten ?? '-' }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-normal leading-tight" title="{{ $item->provinsi->nama_provinsi ?? '-' }}">
                                        {{ $item->provinsi->nama_provinsi ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-3 py-2.5 text-xs text-slate-700 leading-snug">
                                    @if (!empty($item->alamat))
                                        <div class="inline-flex items-start gap-1 font-medium text-slate-700" title="{{ $item->alamat }}">
                                            <span class="text-blue-500 shrink-0 mt-0.5">📍</span>
                                            <span class="break-words">{{ $item->alamat }}</span>
                                        </div>
                                    @else
                                        <span class="italic text-slate-400">Belum diisi</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5 whitespace-nowrap">
                                    <span class="inline-block rounded-md bg-blue-50 border border-blue-100 px-2 py-0.5 text-[11px] font-semibold text-blue-700 whitespace-nowrap" title="{{ $item->jenis_nyamuk }}">
                                        {{ $item->jenis_nyamuk }}
                                    </span>
                                </td>
                                <td class="px-3 py-2.5 text-xs">
                                    <div class="font-semibold text-slate-800 leading-tight" title="{{ $item->insektisida ?? '-' }}">
                                        {{ $item->insektisida ?? '-' }}
                                    </div>
                                    <div class="text-[11px] text-slate-500 font-normal leading-tight" title="{{ $item->metode ?? '-' }}">
                                        {{ $item->metode ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-2 py-2.5 text-center font-bold text-slate-800 text-xs whitespace-nowrap">
                                    {{ number_format($item->sampel_diperiksa) }}
                                </td>
                                <td class="px-2 py-2.5 text-center whitespace-nowrap">
                                    @if ($item->status === 'Resisten')
                                        <span class="inline-flex items-center gap-1 rounded-md bg-rose-50 border border-rose-200 px-2 py-0.5 text-[11px] font-bold text-rose-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Resisten
                                        </span>
                                    @elseif ($item->status === 'Rentan')
                                        <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[11px] font-bold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Rentan
                                        </span>
                                    @elseif (in_array($item->status, ['Toleran/Terduga Resisten', 'Toleran', 'Terduga Resisten']))
                                        <span class="inline-flex items-center gap-1 rounded-md bg-amber-50 border border-amber-200 px-2 py-0.5 text-[11px] font-bold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Toleran
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400 italic">-</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2.5 text-center text-[11px] text-slate-600 font-medium whitespace-nowrap">
                                    {{ $item->bulan }} {{ $item->tahun }}
                                </td>
                                @if (!$isViewer)
                                <td class="px-2 py-2.5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-1">
                                        <button 
                                            type="button" 
                                            onclick='openEditModal(@json($item))'
                                            class="inline-flex items-center gap-0.5 rounded-md border border-amber-200 bg-amber-50 px-2 py-1 text-[11px] font-semibold text-amber-700 hover:bg-amber-100 transition shadow-2xs cursor-pointer"
                                            title="Edit Data"
                                        >
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span>Edit</span>
                                        </button>
                                        <button 
                                            type="button" 
                                            onclick="openDeleteModal({{ $item->id }})"
                                            class="inline-flex items-center gap-0.5 rounded-md border border-rose-200 bg-rose-50 px-2 py-1 text-[11px] font-semibold text-rose-700 hover:bg-rose-100 transition shadow-2xs cursor-pointer"
                                            title="Hapus Data"
                                        >
                                            <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span>Hapus</span>
                                        </button>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isViewer ? 8 : 9 }}" class="px-6 py-12 text-center">
                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 mb-3.5 border border-blue-100 shadow-2xs">
                                        @if(!empty($search))
                                            <svg class="h-7 w-7 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                            </svg>
                                        @else
                                            <svg class="h-7 w-7 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        @endif
                                    </div>

                                    @if(!empty($search))
                                        <p class="text-sm font-bold text-slate-800">Tidak ada data yang cocok dengan pencarian</p>
                                        <p class="mt-1 text-xs text-slate-500 max-w-md mx-auto">
                                            Tidak ditemukan hasil untuk kata kunci <span class="font-bold text-slate-700">"{{ $search }}"</span> pada filter periode saat ini.
                                        </p>
                                        <div class="mt-4 flex flex-wrap items-center justify-center gap-2">
                                            <a href="{{ route('input', array_merge(['bulan' => 'Semua', 'tahun' => 'Semua', 'search' => $search], request('per_page') ? ['per_page' => request('per_page')] : [])) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-2xs">
                                                🔍 Cari di Semua Periode
                                            </a>
                                            <a href="{{ route('input', array_merge(['bulan' => $bulan, 'tahun' => $tahun], request('per_page') ? ['per_page' => request('per_page')] : [])) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 transition">
                                                Hapus Kata Kunci
                                            </a>
                                        </div>
                                    @else
                                        <p class="text-sm font-bold text-slate-800">Belum ada data uji resistensi untuk periode ini</p>
                                        <p class="mt-1 text-xs text-slate-500 max-w-md mx-auto">
                                            Tidak ada catatan pemeriksaan untuk periode <span class="font-bold text-slate-700">{{ $bulan }} {{ $tahun }}</span>.
                                            @if($totalSemuaData > 0)
                                                <br><span class="text-blue-600 font-semibold">Tersedia {{ number_format($totalSemuaData) }} data di database</span> dari hasil import Excel / pemeriksaan sebelumnya.
                                            @endif
                                        </p>
                                        <div class="mt-4 flex flex-wrap items-center justify-center gap-2.5">
                                            @if($totalSemuaData > 0)
                                                <a href="{{ route('input', array_merge(['bulan' => 'Semua', 'tahun' => 'Semua'], request('per_page') ? ['per_page' => request('per_page')] : [])) }}" class="inline-flex items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-2 text-xs font-bold text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-2xs">
                                                    📊 Tampilkan Semua Periode ({{ number_format($totalSemuaData) }} Data)
                                                </a>
                                            @endif
                                            @if (!$isViewer)
                                            <button 
                                                type="button" 
                                                onclick="openModal('modalImportExcel')" 
                                                class="inline-flex items-center gap-1.5 rounded-xl border border-emerald-300 bg-emerald-50 px-4 py-2 text-xs font-bold text-emerald-700 hover:bg-emerald-600 hover:text-white transition shadow-2xs cursor-pointer"
                                            >
                                                📥 Import File Excel
                                            </button>
                                            <button 
                                                type="button" 
                                                onclick="openModal('modalTambahData')" 
                                                class="inline-flex items-center gap-1.5 rounded-xl bg-blue-600 px-4 py-2 text-xs font-bold text-white shadow-2xs hover:bg-blue-700 transition cursor-pointer"
                                            >
                                                + Input Data
                                            </button>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if ($data->hasPages() || $data->total() > 0)
                <div class="border-t border-slate-100 bg-white px-4 py-2.5">
                    {{ $data->links() }}
                </div>
            @endif

        </div>

    </section>

</main>

    {{-- ========================================================================= --}}
    {{-- MODAL TAMBAH, EDIT, HAPUS & IMPORT DATA (HANYA DIRENDER UNTUK NON-VIEWER) --}}
    {{-- ========================================================================= --}}
    @if (!$isViewer)
    <div id="modalImportExcel" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs p-4 sm:p-6 transition-all">
        <div class="min-h-full flex items-center justify-center py-6 w-full">
            <div class="relative w-full max-w-2xl rounded-2xl bg-white p-6 sm:p-8 shadow-2xl border border-slate-100 my-auto">
                {{-- HEADER MODAL --}}
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100/80 text-emerald-700 dark:bg-emerald-900/80 dark:text-white font-bold border border-emerald-200/80 dark:border-emerald-700/60">
                            <svg class="h-5 w-5 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Import Data dari Excel</h3>
                            <p class="text-xs text-slate-500">Unggah berkas spreadsheet Excel (.xlsx) untuk memasukkan data uji resistensi ke sistem</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('modalImportExcel')" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition" title="Tutup">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- FORM UPLOAD FILE --}}
                <form method="POST" action="{{ route('import.process') }}" enctype="multipart/form-data" class="mt-6 space-y-5">
                    @csrf

                    {{-- DOWNLOAD TEMPLATE EXCEL BANNER --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3.5 p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200 dark:bg-emerald-950/40 dark:border-emerald-700/60 shadow-xs">
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-xs">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900 dark:text-white leading-snug">
                                    Template Resmi Excel (.xlsx)
                                </h4>
                                <p class="text-xs font-semibold text-slate-700 dark:text-emerald-200 mt-0.5">
                                    Kolom sudah terformat rapi dan siap diisi data pemeriksaan
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('import.template', ['format' => 'xlsx']) }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:scale-95 px-4 py-2.5 text-xs font-bold text-white transition shrink-0 shadow-xs cursor-pointer" title="Download template Excel (.xlsx) dengan kolom rapi dan border tabel">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Unduh Template Excel</span>
                        </a>
                    </div>

                    {{-- DRAG & DROP FILE ZONE --}}
                    <div>
                        <label class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer bg-slate-50/70 hover:bg-emerald-50/40 hover:border-emerald-400 transition">
                            <div class="flex flex-col items-center justify-center pt-4 pb-5 px-4 text-center">
                                <div class="w-11 h-11 mb-2.5 rounded-xl bg-emerald-100/70 text-emerald-600 dark:bg-emerald-900/60 dark:text-white flex items-center justify-center animate-bounce">
                                    <svg class="w-6 h-6 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                </div>
                                <p class="text-xs sm:text-sm text-slate-700 font-bold">
                                    Pilih atau seret berkas spreadsheet Excel ke sini
                                </p>
                                <p class="text-[11px] text-slate-400 mt-1">
                                    Format berkas: <strong>.XLSX (Excel)</strong> atau <strong>.XLS</strong>
                                </p>
                                <div id="modalFileNamePreview" class="mt-2.5 hidden items-center gap-1.5 text-xs font-bold text-emerald-800 bg-emerald-100/80 px-3 py-1 rounded-lg border border-emerald-200">
                                    <span>📄</span>
                                    <span id="modalFileNameText">nama_file.xlsx</span>
                                </div>
                            </div>
                            <input type="file" name="file" id="modalFileInput" accept=".xlsx, .xls, .csv, .txt" class="hidden" required onchange="showModalFileName(this)" />
                        </label>
                    </div>

                    {{-- RINGKASAN PETUNJUK FORMAT KOLOM --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50/80 p-3.5 text-xs text-slate-600 space-y-1.5">
                        <div class="font-bold text-slate-700 flex items-center gap-1.5">
                            <span>💡</span> Format Kolom Excel yang Didukung:
                        </div>
                        <p class="text-[11px] text-slate-500 leading-relaxed">
                            Kolom: <strong>provinsi</strong>, <strong>kabupaten</strong>, <strong>alamat</strong>, <strong>jenis_nyamuk</strong>, <strong>insektisida</strong>, <strong>metode</strong>, <strong>sampel_diperiksa</strong>, <strong>bulan</strong>, <strong>tahun</strong>, status resistensi (<strong>resisten</strong>, <strong>rentan</strong>, <strong>toleran</strong>), <strong>mutasi</strong>, dan <strong>publikasi</strong>.
                        </p>
                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
                        <button type="button" onclick="closeModal('modalImportExcel')" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-xs font-bold text-white shadow-2xs hover:bg-emerald-700 transition cursor-pointer">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                            </svg>
                            <span>Mulai Impor ke Tabel</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL TAMBAH DATA --}}
    {{-- ========================================================================= --}}
    <div id="modalTambahData" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs p-4 sm:p-6 transition-all">
        <div class="min-h-full flex items-center justify-center py-6 w-full">
            <div class="relative w-full max-w-3xl rounded-2xl bg-white p-6 sm:p-8 shadow-2xl border border-slate-100 my-auto">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 font-bold text-lg">
                            🔬
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Tambah Data Pengujian</h3>
                            <p class="text-xs text-slate-500">Isi formulir pemeriksaan laboratorium dan lokasi survei vektor</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('modalTambahData')" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition" title="Tutup">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form method="POST" action="{{ route('input.store') }}" autocomplete="off" class="mt-6 space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                        {{-- BULAN --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Bulan Pemeriksaan *</label>
                            <select name="bulan" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                @foreach ($daftarBulan as $b)
                                    <option value="{{ $b }}" {{ $bulanAktif == $b ? 'selected' : '' }}>
                                        {{ $b }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TAHUN --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tahun *</label>
                            <input type="number" name="tahun" value="{{ $tahun == 'Semua' ? date('Y') : $tahun }}" required autocomplete="off" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                        </div>

                        {{-- PROVINSI --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Provinsi *</label>
                            <select id="tambahProvinsi" name="provinsi_id" onchange="fetchKabupatenForTambah(this.value)" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($provinsis as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KABUPATEN --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kabupaten / Kota *</label>
                            <select id="tambahKabupaten" name="kabupaten_id" required disabled class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 disabled:cursor-not-allowed transition">
                                <option value="">-- Pilih Provinsi Dahulu --</option>
                            </select>
                        </div>

                        {{-- ALAMAT / LOKASI --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Alamat / Lokasi Survei
                            </label>
                            <textarea name="alamat" rows="2" autocomplete="off" placeholder="Contoh: RT 03/RW 02 Desa Sukamaju, Puskesmas Melati / Lokasi Penangkapan Vektor" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition placeholder:text-slate-400"></textarea>
                            <p class="mt-1.5 text-[11px] text-slate-400 flex items-center gap-1">
                                <span>📍</span> Alamat ini akan ditampilkan di popup peta sebaran dashboard saat titik lokasi diklik.
                            </p>
                        </div>

                        {{-- JENIS NYAMUK --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jenis Nyamuk *</label>
                            <select name="jenis_nyamuk" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Jenis Nyamuk --</option>
                                @foreach ($daftarNyamuk as $nyamuk)
                                    <option value="{{ $nyamuk }}">{{ $nyamuk }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- INSEKTISIDA --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Insektisida *</label>
                            <select name="insektisida" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Insektisida --</option>
                                @foreach ($daftarInsektisida as $ins)
                                    <option value="{{ $ins }}">{{ $ins }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- METODE --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Metode *</label>
                            <select name="metode" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Metode --</option>
                                @foreach ($daftarMetode as $met)
                                    <option value="{{ $met }}">{{ $met }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- JUMLAH SAMPEL --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jumlah Sampel Diperiksa *</label>
                            <input type="number" name="sampel_diperiksa" min="1" required autocomplete="off" placeholder="Contoh: 100" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                        </div>

                        {{-- MUTASI (OPSIONAL) --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Mutasi (Opsional)</label>
                            <input type="text" name="mutasi" autocomplete="off" placeholder="Contoh: V1016G, F1534C / Negatif" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition placeholder:text-slate-400">
                        </div>

                        {{-- PUBLIKASI --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Publikasi / Jurnal</label>
                            <input type="text" name="publikasi" autocomplete="off" placeholder="Contoh: Publikasi BBLKL 2026, Jurnal Vektor / Link URL" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition placeholder:text-slate-400">
                        </div>

                        {{-- KALKULATOR CEPAT MORTALITAS WHO (OPSIONAL) --}}
                        <div class="md:col-span-2 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/90 p-3.5 shadow-2xs">
                            <div class="flex flex-wrap items-center justify-between gap-1.5 mb-2">
                                <span class="text-xs font-bold text-blue-900 flex items-center gap-1.5">
                                    <span>🔬</span> Kalkulator Cepat Mortalitas Bioassay (Standar WHO)
                                </span>
                                <span id="calcHasilTambah" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white text-blue-700 border border-blue-200 shadow-2xs">
                                    Bantu tentukan status otomatis
                                </span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nyamuk Diuji (Ekor)</label>
                                    <input type="number" id="calcUjiTambah" min="1" placeholder="Contoh: 100" class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nyamuk Mati (Ekor)</label>
                                    <input type="number" id="calcMatiTambah" min="0" placeholder="Contoh: 85" class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="col-span-2 sm:col-span-1 flex flex-col justify-end">
                                    <button type="button" onclick="hitungMortalitasOtomatis('tambah')" class="w-full py-1.5 px-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-1">
                                        ⚡ Hitung & Terapkan
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- STATUS KERENTANAN (3 KATEGORI: RESISTEN, RENTAN, TOLERAN/TERDUGA RESISTEN) --}}
                        <div class="md:col-span-2 rounded-xl bg-slate-50/80 border border-slate-200/80 p-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Status Kerentanan Uji *
                                </label>
                                <span class="text-[11px] font-medium text-slate-400">Pilih salah satu kategori hasil uji</span>
                            </div>
                            <select name="status" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Status Kerentanan --</option>
                                <option value="Resisten">🔴 Resisten</option>
                                <option value="Rentan">🟢 Rentan</option>
                                <option value="Toleran">🟡 Toleran</option>
                            </select>
                            <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                <span class="font-medium text-slate-600">Panduan Kategori:</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 font-semibold border border-rose-200 text-[11px]">Resisten</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200 text-[11px]">Rentan</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 font-semibold border border-amber-200 text-[11px]">Toleran/Terduga Resisten</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeModal('modalTambahData')" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition shadow-2xs">
                            Batal
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL EDIT DATA --}}
    {{-- ========================================================================= --}}
    <div id="modalEditData" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs p-4 sm:p-6 transition-all">
        <div class="min-h-full flex items-center justify-center py-6 w-full">
            <div class="relative w-full max-w-3xl rounded-2xl bg-white p-6 sm:p-8 shadow-2xl border border-slate-100 my-auto">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 font-bold text-lg">
                            ✏️
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">Edit Data Uji Resistensi</h3>
                            <p class="text-xs text-slate-500">Perbarui hasil pemeriksaan laboratorium dan lokasi survei</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('modalEditData')" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600 transition" title="Tutup">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form id="formEditData" method="POST" autocomplete="off" class="mt-6 space-y-5">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-5">
                        {{-- BULAN --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Bulan Pemeriksaan *</label>
                            <select id="editBulan" name="bulan" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                @foreach ($daftarBulan as $b)
                                    <option value="{{ $b }}">{{ $b }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TAHUN --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Tahun *</label>
                            <input type="number" id="editTahun" name="tahun" required autocomplete="off" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                        </div>

                        {{-- PROVINSI --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Provinsi *</label>
                            <select id="editProvinsi" name="provinsi_id" onchange="fetchKabupatenForEdit(this.value)" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Provinsi --</option>
                                @foreach ($provinsis as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- KABUPATEN --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Kabupaten / Kota *</label>
                            <select id="editKabupaten" name="kabupaten_id" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Kabupaten --</option>
                            </select>
                        </div>

                        {{-- ALAMAT / LOKASI --}}
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Alamat / Lokasi Survei
                            </label>
                            <textarea id="editAlamat" name="alamat" rows="2" autocomplete="off" placeholder="Contoh: RT 03/RW 02 Desa Sukamaju, Puskesmas Melati / Lokasi Penangkapan Vektor" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition placeholder:text-slate-400"></textarea>
                            <p class="mt-1.5 text-[11px] text-slate-400 flex items-center gap-1">
                                <span>📍</span> Alamat ini akan ditampilkan di popup peta sebaran dashboard saat titik lokasi diklik.
                            </p>
                        </div>

                        {{-- JENIS NYAMUK --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jenis Nyamuk *</label>
                            <select id="editJenisNyamuk" name="jenis_nyamuk" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Jenis Nyamuk --</option>
                                @foreach ($daftarNyamuk as $nyamuk)
                                    <option value="{{ $nyamuk }}">{{ $nyamuk }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- INSEKTISIDA --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Insektisida *</label>
                            <select id="editInsektisida" name="insektisida" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Insektisida --</option>
                                @foreach ($daftarInsektisida as $ins)
                                    <option value="{{ $ins }}">{{ $ins }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- METODE --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Metode *</label>
                            <select id="editMetode" name="metode" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Metode --</option>
                                @foreach ($daftarMetode as $met)
                                    <option value="{{ $met }}">{{ $met }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- JUMLAH SAMPEL --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Jumlah Sampel Diperiksa *</label>
                            <input type="number" id="editSampelDiperiksa" name="sampel_diperiksa" min="1" required autocomplete="off" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                        </div>

                        {{-- MUTASI (OPSIONAL) --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Mutasi (Opsional)</label>
                            <input type="text" id="editMutasi" name="mutasi" autocomplete="off" placeholder="Contoh: V1016G, F1534C / Negatif" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition placeholder:text-slate-400">
                        </div>

                        {{-- PUBLIKASI --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Publikasi / Jurnal</label>
                            <input type="text" id="editPublikasi" name="publikasi" autocomplete="off" placeholder="Contoh: Publikasi BBLKL 2026, Jurnal Vektor / Link URL" class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition placeholder:text-slate-400">
                        </div>

                        {{-- KALKULATOR CEPAT MORTALITAS WHO (OPSIONAL) --}}
                        <div class="md:col-span-2 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200/90 p-3.5 shadow-2xs">
                            <div class="flex flex-wrap items-center justify-between gap-1.5 mb-2">
                                <span class="text-xs font-bold text-blue-900 flex items-center gap-1.5">
                                    <span>🔬</span> Kalkulator Cepat Mortalitas Bioassay (Standar WHO)
                                </span>
                                <span id="calcHasilEdit" class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-white text-blue-700 border border-blue-200 shadow-2xs">
                                    Bantu tentukan status otomatis
                                </span>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nyamuk Diuji (Ekor)</label>
                                    <input type="number" id="calcUjiEdit" min="1" placeholder="Contoh: 100" class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-semibold text-slate-600 mb-1">Nyamuk Mati (Ekor)</label>
                                    <input type="number" id="calcMatiEdit" min="0" placeholder="Contoh: 85" class="w-full rounded-lg border border-slate-300 bg-white px-2.5 py-1.5 text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="col-span-2 sm:col-span-1 flex flex-col justify-end">
                                    <button type="button" onclick="hitungMortalitasOtomatis('edit')" class="w-full py-1.5 px-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs shadow-xs transition flex items-center justify-center gap-1">
                                        ⚡ Hitung & Terapkan
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- STATUS KERENTANAN (3 KATEGORI: RESISTEN, RENTAN, TOLERAN/TERDUGA RESISTEN) --}}
                        <div class="md:col-span-2 rounded-xl bg-slate-50/80 border border-slate-200/80 p-4">
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Status Kerentanan Uji *
                                </label>
                                <span class="text-[11px] font-medium text-slate-400">Pilih salah satu kategori hasil uji</span>
                            </div>
                            <select id="editStatus" name="status" required class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-semibold text-slate-800 shadow-2xs focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100 transition">
                                <option value="">-- Pilih Status Kerentanan --</option>
                                <option value="Resisten">🔴 Resisten</option>
                                <option value="Rentan">🟢 Rentan</option>
                                <option value="Toleran">🟡 Toleran</option>
                                <option value="Toleran/Terduga Resisten" class="hidden">🟡 Toleran/Terduga Resisten</option>
                            </select>
                            <div class="mt-2.5 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                <span class="font-medium text-slate-600">Panduan Kategori:</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-700 font-semibold border border-rose-200 text-[11px]">Resisten</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold border border-emerald-200 text-[11px]">Rentan</span>
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 font-semibold border border-amber-200 text-[11px]">Toleran/Terduga Resisten</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" onclick="closeModal('modalEditData')" class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-slate-800 transition shadow-2xs">
                            Batal
                        </button>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 transition">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Perbarui Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL KONFIRMASI HAPUS --}}
    {{-- ========================================================================= --}}
    <div id="deleteModal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs p-4 transition-all">
        <div class="min-h-full flex items-center justify-center py-6 w-full">
            <div class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-2xl border border-slate-100 my-auto">
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-rose-100">
                        <span class="text-2xl font-bold text-rose-600">!</span>
                    </div>

                    <h3 class="mt-4 text-lg font-bold text-slate-800">Hapus Data Pemeriksaan?</h3>
                    <p class="mt-2 text-xs text-slate-500">
                        Tindakan ini tidak dapat dibatalkan. Data hasil uji resistensi ini akan dihapus permanen dari sistem.
                    </p>
                </div>

                <div class="mt-6 flex justify-center gap-3">
                    <button 
                        type="button"
                        onclick="closeDeleteModal()"
                        class="w-1/2 rounded-xl border border-slate-200 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50 transition"
                    >
                        Batal
                    </button>

                    <form id="deleteForm" method="POST" class="w-1/2">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-rose-600 py-2.5 text-sm font-semibold text-white hover:bg-rose-700 shadow-sm transition"
                        >
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- SCRIPT INTERAKSI MODAL & DINAMIS KABUPATEN --}}
    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        function showModalFileName(input) {
            const preview = document.getElementById('modalFileNamePreview');
            const text = document.getElementById('modalFileNameText');
            if (input.files && input.files[0]) {
                text.textContent = input.files[0].name + ' (' + (input.files[0].size / 1024).toFixed(1) + ' KB)';
                preview.classList.remove('hidden');
                preview.classList.add('inline-flex');
            } else {
                preview.classList.add('hidden');
                preview.classList.remove('inline-flex');
            }
        }

        function fetchKabupatenForTambah(provinsiId) {
            const kabSelect = document.getElementById('tambahKabupaten');
            kabSelect.innerHTML = '<option value="">Memuat data kabupaten...</option>';
            kabSelect.disabled = true;

            if (!provinsiId) {
                kabSelect.innerHTML = '<option value="">-- Pilih Provinsi Dahulu --</option>';
                return;
            }

            fetch('/kabupaten/' + provinsiId)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Kabupaten / Kota --</option>';
                    data.forEach(kab => {
                        html += `<option value="${kab.id}">${kab.nama_kabupaten}</option>`;
                    });
                    kabSelect.innerHTML = html;
                    kabSelect.disabled = false;
                    kabSelect.classList.remove('bg-slate-50');
                })
                .catch(() => {
                    kabSelect.innerHTML = '<option value="">Gagal memuat kabupaten</option>';
                });
        }

        function fetchKabupatenForEdit(provinsiId, selectedKabId = null) {
            const kabSelect = document.getElementById('editKabupaten');
            kabSelect.innerHTML = '<option value="">Memuat data kabupaten...</option>';

            if (!provinsiId) {
                kabSelect.innerHTML = '<option value="">-- Pilih Provinsi Dahulu --</option>';
                return;
            }

            fetch('/kabupaten/' + provinsiId)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Kabupaten / Kota --</option>';
                    data.forEach(kab => {
                        const isSelected = selectedKabId && kab.id == selectedKabId ? 'selected' : '';
                        html += `<option value="${kab.id}" ${isSelected}>${kab.nama_kabupaten}</option>`;
                    });
                    kabSelect.innerHTML = html;
                })
                .catch(() => {
                    kabSelect.innerHTML = '<option value="">Gagal memuat kabupaten</option>';
                });
        }

        function openEditModal(item) {
            const form = document.getElementById('formEditData');
            form.action = '/input/' + item.id;

            document.getElementById('editBulan').value = item.bulan || '';
            document.getElementById('editTahun').value = item.tahun || '';
            document.getElementById('editProvinsi').value = item.provinsi_id || '';
            document.getElementById('editAlamat').value = item.alamat || '';
            document.getElementById('editJenisNyamuk').value = item.jenis_nyamuk || '';
            document.getElementById('editInsektisida').value = item.insektisida || '';
            document.getElementById('editMetode').value = item.metode || '';
            document.getElementById('editSampelDiperiksa').value = item.sampel_diperiksa || '';
            document.getElementById('editMutasi').value = item.mutasi || '';
            document.getElementById('editPublikasi').value = item.publikasi || '';
            let currentStatus = item.status || '';
            if (['Toleran', 'Terduga Resisten', 'Toleran/Terduga Resisten'].includes(currentStatus)) {
                document.getElementById('editStatus').value = 'Toleran';
            } else {
                document.getElementById('editStatus').value = currentStatus;
            }

            // Ambil kabupaten untuk provinsi yang dipilih dan set kabupatennya
            if (item.provinsi_id) {
                fetchKabupatenForEdit(item.provinsi_id, item.kabupaten_id);
            }

            openModal('modalEditData');
        }

        window.openDeleteModal = function(id) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');

            if (!modal || !form) return;

            form.action = '/input/' + id;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        };

        window.closeDeleteModal = function() {
            const modal = document.getElementById('deleteModal');
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        };

        // Fungsi Hitung Mortalitas Cepat Standar WHO
        window.hitungMortalitasOtomatis = function(mode) {
            const isTambah = mode === 'tambah';
            const ujiInput = document.getElementById(isTambah ? 'calcUjiTambah' : 'calcUjiEdit');
            const matiInput = document.getElementById(isTambah ? 'calcMatiTambah' : 'calcMatiEdit');
            const hasilBadge = document.getElementById(isTambah ? 'calcHasilTambah' : 'calcHasilEdit');
            const sampelTarget = isTambah 
                ? document.querySelector('#modalTambahData [name="sampel_diperiksa"]')
                : document.getElementById('editSampelDiperiksa');
            const statusSelect = isTambah 
                ? document.querySelector('#modalTambahData [name="status"]')
                : document.getElementById('editStatus');

            const uji = parseFloat(ujiInput.value);
            const mati = parseFloat(matiInput.value);

            if (isNaN(uji) || uji <= 0) {
                alert('Silakan masukkan Jumlah Nyamuk yang Diuji (angka lebih dari 0).');
                ujiInput.focus();
                return;
            }
            if (isNaN(mati) || mati < 0) {
                alert('Silakan masukkan Jumlah Nyamuk yang Mati.');
                matiInput.focus();
                return;
            }
            if (mati > uji) {
                alert('Jumlah nyamuk mati tidak boleh melebihi jumlah nyamuk yang diuji!');
                matiInput.focus();
                return;
            }

            const persen = (mati / uji) * 100;
            let statusRes = 'Resisten';

            // Standar Pedoman WHO:
            // Mortalitas < 90% = Resisten
            // Mortalitas 90% - 97% = Toleran / Terduga Resisten
            // Mortalitas >= 98% = Rentan
            if (persen < 90) {
                statusRes = 'Resisten';
            } else if (persen < 98) {
                statusRes = 'Toleran';
            } else {
                statusRes = 'Rentan';
            }

            // Set ke form utama
            if (sampelTarget) sampelTarget.value = uji;
            if (statusSelect) statusSelect.value = statusRes;

            hasilBadge.innerHTML = `Mortalitas: <strong>${persen.toFixed(1)}%</strong> → Auto: <strong>${statusRes}</strong>`;
            hasilBadge.className = 'text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 border border-emerald-300 shadow-2xs';
        };

        // Kontrol Page Size (Tampil X Data) Tabel Data Uji Resistensi
        window.changeTablePageSize = function(val) {
            const url = new URL(window.location.href);
            url.searchParams.set('per_page', val);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        };
    </script>

</body>

</html>