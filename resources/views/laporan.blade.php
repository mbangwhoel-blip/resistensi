<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Hasil Uji Resistensi - SIMPEL BBLKL</title>

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
    <div class="pl-64 flex flex-col min-h-screen">

        {{-- HEADER TOP BAR --}}
        <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 px-6 py-3.5 flex items-center justify-between shadow-2xs">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                    <span>SIMPEL BBLKL</span>
                    <span>/</span>
                    <span class="text-blue-600">Laporan</span>
                </div>
                <h1 class="text-lg font-extrabold text-slate-900 tracking-tight flex items-center gap-2 mt-0.5">
                    <span>📑 Laporan Hasil Uji Resistensi Vektor</span>
                </h1>
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
                <div class="rounded-2xl border border-blue-200 bg-blue-50/40 p-4 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-blue-700">Total Nyamuk</span>
                        <div class="h-8 w-8 rounded-xl bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">
                            🦟
                        </div>
                    </div>
                    <div class="mt-2 text-2xl font-black text-blue-900 leading-tight">
                        {{ number_format($stats['total_sampel'], 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-[11px] font-semibold text-blue-600">
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

            {{-- FORM FILTER PENCARIAN LAPORAN --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-2xs">
                <div class="flex items-center justify-between pb-3.5 mb-4 border-b border-slate-100">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600 text-sm font-bold">
                            🔍
                        </span>
                        <div>
                            <h2 class="text-sm font-extrabold text-slate-900 leading-tight">Filter Parameter Laporan</h2>
                            <p class="text-[11px] text-slate-500">Sesuaikan kriteria data yang ingin ditampilkan dan dicetak ke PDF</p>
                        </div>
                    </div>
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

                        {{-- TAHUN --}}
                        <div>
                            <label for="tahun" class="block text-[11px] font-bold text-slate-700 mb-1 uppercase tracking-wider">
                                Tahun
                            </label>
                            <select name="tahun" id="tahun" class="w-full rounded-xl border border-slate-200 bg-slate-50/70 px-3 py-2 text-xs text-slate-800 focus:bg-white focus:border-blue-500 focus:outline-none transition shadow-2xs">
                                <option value="Semua">-- Semua Tahun --</option>
                                @foreach($daftarTahun as $thn)
                                    <option value="{{ $thn }}" {{ (string)$tahun === (string)$thn ? 'selected' : '' }}>
                                        {{ $thn }}
                                    </option>
                                @endforeach
                            </select>
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
                                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25 Data</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50 Data</option>
                                <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100 Data</option>
                            </select>
                        </div>
                    </div>

                    {{-- TOMBOL AKSI FILTER --}}
                    <div class="flex flex-wrap items-center justify-between gap-3 pt-2">
                        <div class="flex items-center gap-2.5">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-5 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                </svg>
                                <span>Terapkan Filter</span>
                            </button>

                            <a href="{{ route('laporan.index') }}" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-600 shadow-2xs transition cursor-pointer">
                                <span>Reset Filter</span>
                            </a>
                        </div>

                        {{-- TOMBOL ACTION DENGAN FILTER AKTIF --}}
                        @php
                            $pdfQuery = request()->query();
                        @endphp
                        <div class="flex items-center gap-2.5">
                            <a href="{{ route('laporan.preview', $pdfQuery) }}"
                               target="_blank"
                               class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer"
                               title="Buka pratinjau dokumen di layar">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>Lihat Pratinjau</span>
                            </a>

                            <a href="{{ route('laporan.pdf', array_merge($pdfQuery, ['mode' => 'download'])) }}"
                               class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer"
                               title="Unduh langsung file berkas PDF">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Unduh File PDF</span>
                            </a>
                        </div>
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

                    {{-- LIVE SEARCH TABLE --}}
                    <div class="relative w-64">
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
                </div>

                {{-- TABEL DATA --}}
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="w-full text-left text-xs border-collapse" id="laporanTable">
                        <thead>
                            <tr class="bg-slate-900 text-white font-bold uppercase tracking-wider text-[11px] border-b border-slate-800">
                                <th class="px-3.5 py-3 text-center w-12">No</th>
                                <th class="px-3.5 py-3">Periode</th>
                                <th class="px-3.5 py-3">Wilayah</th>
                                <th class="px-3.5 py-3">Desa / Alamat</th>
                                <th class="px-3.5 py-3">Vektor (Nyamuk)</th>
                                <th class="px-3.5 py-3">Insektisida</th>
                                <th class="px-3.5 py-3 text-center">Metode</th>
                                <th class="px-3.5 py-3 text-right">Sampel</th>
                                <th class="px-3.5 py-3 text-center">Status</th>
                                <th class="px-3.5 py-3 text-center">Mutasi</th>
                                <th class="px-3.5 py-3 text-center">Publikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100" id="laporanTableBody">
                            @forelse($dataUji as $idx => $row)
                                @php
                                    $st = strtolower((string)$row->status);
                                @endphp
                                <tr class="hover:bg-blue-50/40 transition">
                                    <td class="px-3.5 py-2.5 text-center text-slate-500 font-semibold">
                                        {{ $dataUji->firstItem() + $idx }}
                                    </td>
                                    <td class="px-3.5 py-2.5 whitespace-nowrap">
                                        <span class="font-bold text-slate-800">{{ $row->bulan ?: '-' }}</span>
                                        <span class="text-slate-500 text-[11px] block">{{ $row->tahun }}</span>
                                    </td>
                                    <td class="px-3.5 py-2.5">
                                        <div class="font-bold text-slate-800">{{ $row->kabupaten ? $row->kabupaten->nama_kabupaten : '-' }}</div>
                                        <div class="text-[11px] text-slate-500">{{ $row->provinsi ? $row->provinsi->nama_provinsi : '-' }}</div>
                                    </td>
                                    <td class="px-3.5 py-2.5 text-slate-700 max-w-xs truncate" title="{{ $row->alamat }}">
                                        {{ $row->alamat ?: '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 font-medium italic text-slate-800">
                                        {{ $row->jenis_nyamuk ?: '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 font-medium text-slate-800">
                                        {{ $row->insektisida ?: '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 text-center text-slate-600">
                                        {{ $row->metode ?: '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 text-right font-bold text-slate-900">
                                        {{ $row->sampel_diperiksa ? number_format($row->sampel_diperiksa, 0, ',', '.') : '0' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 text-center">
                                        @if($st === 'resisten')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-100 border border-rose-200 px-2 py-0.5 text-[10px] font-bold text-rose-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span> Resisten
                                            </span>
                                        @elseif($st === 'toleran')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 border border-amber-200 px-2 py-0.5 text-[10px] font-bold text-amber-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Toleran
                                            </span>
                                        @elseif($st === 'rentan')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 border border-emerald-200 px-2 py-0.5 text-[10px] font-bold text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Rentan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600">
                                                {{ ucfirst($st ?: '-') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3.5 py-2.5 text-center text-slate-600 font-mono text-[11px]">
                                        {{ $row->mutasi ?: '-' }}
                                    </td>
                                    <td class="px-3.5 py-2.5 text-left text-slate-700 max-w-[200px] break-all text-[11px]">
                                        @if($row->publikasi && str_starts_with($row->publikasi, 'http'))
                                            <a href="{{ $row->publikasi }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline break-all" title="{{ $row->publikasi }}">
                                                {{ $row->publikasi }}
                                            </a>
                                        @else
                                            <span class="break-words">{{ $row->publikasi ?: '-' }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-12 text-center text-slate-400">
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
                    <div class="px-5 py-3 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        {{ $dataUji->links() }}
                    </div>
                @endif
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
    </script>

</body>
</html>
