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

            {{-- FLASH NOTIFIKASI SUKSES / ERROR --}}
            @if(session('success'))
                <div class="flex items-center justify-between rounded-2xl bg-emerald-50 border border-emerald-300 p-4 text-emerald-900 shadow-sm dark:bg-emerald-950/40 dark:border-emerald-800 dark:text-emerald-200">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white font-bold text-sm shadow-xs">✓</span>
                        <p class="text-xs sm:text-sm font-semibold leading-relaxed">{{ session('success') }}</p>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 text-xl font-bold px-2 cursor-pointer">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="flex items-center justify-between rounded-2xl bg-rose-50 border border-rose-300 p-4 text-rose-900 shadow-sm dark:bg-rose-950/40 dark:border-rose-800 dark:text-rose-200">
                    <div class="flex items-center gap-3">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-rose-600 text-white font-bold text-sm shadow-xs">✕</span>
                        <p class="text-xs sm:text-sm font-semibold leading-relaxed">{{ session('error') }}</p>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-700 hover:text-rose-900 text-xl font-bold px-2 cursor-pointer">&times;</button>
                </div>
            @endif

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
                        <div class="flex items-center gap-2 flex-wrap">
                            {{-- TEMPLATE 1: STANDAR TEKNIS KEMENKES RI (SESUAI PERMENKES 2/2023 & JUKNIS PVT) --}}
                            <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'kemenkes'])) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 px-3 py-1.5 text-xs font-bold text-white shadow-2xs transition active:scale-95 cursor-pointer"
                               title="Cetak format Rekomendasi Standar Teknis Kemenkes RI & WHO">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>Cetak Standar Teknis Kemenkes</span>
                            </a>

                            {{-- TEMPLATE 2: POLICY BRIEF EKSEKUTIF (FORMAT AWAL DIPERTAHANKAN) --}}
                            <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'eksekutif'])) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-700 shadow-2xs transition active:scale-95 cursor-pointer dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-700"
                               title="Cetak format Policy Brief Eksekutif (Format Awal)">
                                <svg class="h-3.5 w-3.5 text-slate-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                </svg>
                                <span>Cetak Policy Brief Eksekutif</span>
                            </a>

                            {{-- TEMPLATE 3: REKOMENDASI TEKNIS LABORATORIUM (SESUAI WHO MANUAL 2022) --}}
                            <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'laboratorium'])) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-xl bg-violet-600 hover:bg-violet-700 px-3 py-1.5 text-xs font-bold text-white shadow-2xs transition active:scale-95 cursor-pointer"
                               title="Cetak Rekomendasi Teknis Laboratorium – WHO Manual 2022, per spesies, saintifik">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                <span>Cetak Rekm. Teknis Lab</span>
                            </a>

                            {{-- TEMPLATE 4: POLICY BRIEF AGREGAT WILAYAH (FORMAT DINKES PROV / KLASTER KERENTANAN) --}}
                            <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'agregat'])) }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-xl bg-cyan-700 hover:bg-cyan-800 px-3 py-1.5 text-xs font-bold text-white shadow-2xs transition active:scale-95 cursor-pointer"
                               title="Cetak format Policy Brief Agregat Wilayah & Klaster Kerentanan">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                </svg>
                                <span>Cetak Policy Brief Agregat</span>
                            </a>

                            {{-- TULISAN CAKUPAN SEBELUM KOTAK EDIT & TAMBAH MASUKAN ONLINE --}}
                            <div class="inline-flex items-center gap-2.5">
                                <span class="text-[11px] text-slate-500 dark:text-zinc-400 font-medium whitespace-nowrap">
                                    Cakupan: <strong class="text-teal-700 dark:text-teal-400">{{ $namaWilayah }}</strong>
                                </span>

                                {{-- TOMBOL UTAMA: EDIT & TAMBAH MASUKAN ONLINE --}}
                                <a href="{{ route('rekomendasi.preview', array_merge(request()->all(), ['template' => 'kemenkes', 'edit' => '1'])) }}"
                                   target="_blank"
                                   class="inline-flex items-center gap-1.5 rounded-xl bg-amber-500 hover:bg-amber-400 px-3.5 py-1.5 text-xs font-bold text-slate-950 shadow-2xs transition active:scale-95 cursor-pointer ring-2 ring-amber-300 dark:ring-amber-500/40 whitespace-nowrap"
                                   title="Buka template dokumen dan aktifkan Mode Edit Online untuk menambahkan masukan atau catatan arahan">
                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    <span>✏️ Edit &amp; Tambah Masukan Online</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        {{-- FILTER PROVINSI --}}
                        <div>
                            <label for="provinsi_id" class="block text-[10.5px] font-bold text-slate-500 dark:text-zinc-400 uppercase tracking-wider mb-1">
                                Provinsi
                            </label>
                            <select name="provinsi_id" id="provinsi_id" onchange="document.getElementById('kabupaten_id').value = 'Semua'; this.form.submit();"
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

            {{-- 1.5 KARTU STATUS PERSETUJUAN / PENGESAHAN KEPALA BBLKL --}}
            <div class="rounded-2xl border {{ $isApproved ? 'border-emerald-300 bg-gradient-to-r from-emerald-50 via-teal-50/60 to-white dark:from-emerald-950/30 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-emerald-800' : 'border-amber-300 bg-gradient-to-r from-amber-50 via-orange-50/50 to-white dark:from-amber-950/30 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-amber-800' }} p-4 sm:p-5 shadow-2xs transition-all">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl {{ $isApproved ? 'bg-emerald-600 text-white shadow-emerald-200 dark:shadow-none shadow-md' : 'bg-amber-500 text-white shadow-amber-200 dark:shadow-none shadow-md' }} text-xl">
                            {{ $isApproved ? '🛡️' : '📝' }}
                        </div>
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-black tracking-wider uppercase {{ $isApproved ? 'bg-emerald-100 text-emerald-800 border border-emerald-300 dark:bg-emerald-900/60 dark:text-emerald-200' : 'bg-amber-100 text-amber-800 border border-amber-300 dark:bg-amber-900/60 dark:text-amber-200' }}">
                                    <span class="h-2 w-2 rounded-full {{ $isApproved ? 'bg-emerald-600' : 'bg-amber-600 animate-pulse' }}"></span>
                                    {{ $isApproved ? 'RESMI: TELAH DISAHKAN KEPALA BBLKL' : 'STATUS: DRAFT REKOMENDASI (BELUM DISETUJUI)' }}
                                </span>
                                @if($isApproved)
                                    <span class="text-xs font-mono font-bold text-emerald-800 dark:text-emerald-400 bg-emerald-100/80 dark:bg-emerald-900/40 px-2 py-0.5 rounded border border-emerald-200 dark:border-emerald-800">
                                        No. Reg: {{ $approval->nomor_surat }}
                                    </span>
                                @else
                                    <span class="text-xs font-medium text-amber-700 dark:text-amber-400 bg-amber-100/60 dark:bg-amber-900/30 px-2 py-0.5 rounded border border-amber-200 dark:border-amber-800">
                                        Watermark Cetak: <strong>DRAFT</strong>
                                    </span>
                                @endif
                            </div>
                            <h4 class="text-sm font-bold {{ $isApproved ? 'text-emerald-950 dark:text-emerald-200' : 'text-amber-950 dark:text-amber-200' }}">
                                @if($isApproved)
                                    Dokumen Rekomendasi Kebijakan Resmi BBLKL Kemenkes RI
                                @else
                                    Laporan Rekomendasi Masih Berupa DRAFT (Watermark 'DRAFT' Aktif)
                                @endif
                            </h4>
                            <p class="text-xs {{ $isApproved ? 'text-emerald-800 dark:text-emerald-300/90' : 'text-amber-800 dark:text-amber-300/90' }} leading-relaxed">
                                @if($isApproved)
                                    Telah disetujui & disahkan oleh <strong>{{ $approval->approver_name }}</strong> (NIP. {{ $approval->approver_nip ?? '-' }}) &bull; {{ $approval->approver_jabatan }} pada {{ \Carbon\Carbon::parse($approval->approved_at)->isoFormat('D MMMM Y, HH:mm') }} WIB. Seluruh template dokumen cetak berstatus resmi (tanda DRAFT dicabut).
                                @else
                                    Laporan rekomendasi untuk cakupan <strong>{{ $namaWilayah }}</strong> (Periode: {{ $tahunFilter }}, Spesies: {{ $nyamukFilter }}) belum disahkan oleh Kepala/Pimpinan BBLKL. Pada pratinjau & cetak dokumen akan tercetak watermark <strong>"DRAFT"</strong>.
                                @endif
                            </p>
                            @if($isApproved && !empty($approval->notes))
                                <div class="mt-2 text-xs italic bg-white/80 dark:bg-zinc-900/60 p-2.5 rounded-xl border border-emerald-200 dark:border-emerald-800/60 text-emerald-900 dark:text-emerald-200">
                                    <strong class="font-semibold not-italic">Catatan / Arahan Pimpinan:</strong> "{{ $approval->notes }}"
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0 self-end md:self-center">
                        @if(!$isApproved)
                            <button type="button"
                                    onclick="openApproveModal()"
                                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition active:scale-95 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>✍️ Approve / Sahkan (Kepala BBLKL)</span>
                            </button>
                        @else
                            <button type="button"
                                    onclick="openApproveModal()"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-emerald-300 bg-white hover:bg-emerald-50 text-emerald-800 font-bold text-xs transition active:scale-95 cursor-pointer dark:bg-zinc-800 dark:border-emerald-700 dark:text-emerald-300">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <span>Perbarui Pengesahan</span>
                            </button>
                            <form method="POST" action="{{ route('rekomendasi.revoke') }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengesahan rekomendasi kebijakan ini? Status dokumen akan kembali menjadi DRAFT.')">
                                @csrf
                                <input type="hidden" name="approval_id" value="{{ $approval->id }}">
                                <input type="hidden" name="doc_hash" value="{{ $docHash }}">
                                <input type="hidden" name="scope_hash" value="{{ $scopeHash }}">
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-rose-300 bg-white hover:bg-rose-50 text-rose-700 font-bold text-xs transition active:scale-95 cursor-pointer dark:bg-zinc-800 dark:border-rose-900 dark:text-rose-300">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Batalkan Pengesahan</span>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. HERO STATUS KESIAPSIAGAAN VEKTOR & PERINGATAN RISIKO --}}
            <div class="rounded-2xl border p-5 shadow-2xs relative overflow-hidden transition-all
                @if($alertLevel === 'TINGGI' || $alertLevel === 'KRITIS' || ($alertColor ?? '') === 'rose')
                    border-rose-300 bg-gradient-to-r from-rose-500/10 via-rose-50 to-white dark:from-rose-950/40 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-rose-900/50
                @elseif($alertLevel === 'SEDANG' || $alertLevel === 'WASPADA' || ($alertColor ?? '') === 'amber')
                    border-amber-300 bg-gradient-to-r from-amber-500/10 via-amber-50 to-white dark:from-amber-950/40 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-amber-900/50
                @else
                    border-emerald-300 bg-gradient-to-r from-emerald-500/10 via-emerald-50 to-white dark:from-emerald-950/40 dark:via-zinc-900/60 dark:to-zinc-900 dark:border-emerald-900/50
                @endif">

                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-black tracking-wide uppercase shadow-2xs
                                @if($alertLevel === 'TINGGI' || $alertLevel === 'KRITIS' || ($alertColor ?? '') === 'rose') bg-rose-600 text-white animate-pulse
                                @elseif($alertLevel === 'SEDANG' || $alertLevel === 'WASPADA' || ($alertColor ?? '') === 'amber') bg-amber-500 text-white
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
                                <div class="flex flex-col sm:flex-row sm:items-center gap-3 p-3 rounded-xl border border-slate-100 dark:border-zinc-800/80 bg-slate-50/60 dark:bg-zinc-800/40 hover:bg-slate-50 dark:hover:bg-zinc-800/70 transition">
                                    {{-- IDENTITAS BAHAN AKTIF (NAMA LENGKAP TIDAK TERPOTONG & GOLONGAN SEJAJAR DI BAWAHNYA) --}}
                                    <div class="w-full sm:w-56 md:w-64 shrink-0 flex flex-col justify-center">
                                        <span class="text-xs font-black text-slate-900 dark:text-white leading-tight break-words" title="{{ $m['nama'] }}">
                                            {{ $m['nama'] }}
                                        </span>
                                        <div class="mt-1 flex items-center">
                                            <span class="inline-flex items-center text-[10px] font-bold px-2 py-0.5 rounded-md bg-slate-200/80 dark:bg-zinc-700 text-slate-700 dark:text-zinc-300 whitespace-nowrap shadow-2xs">
                                                {{ $m['golongan_nama'] }}
                                            </span>
                                        </div>
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

    {{-- MODAL PENGESAHAN / APPROVAL KEPALA BBLKL --}}
    <div id="approveModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="relative w-full max-w-2xl rounded-2xl bg-white shadow-2xl border border-slate-200 overflow-hidden dark:bg-zinc-900 dark:border-zinc-800 animate-in fade-in zoom-in duration-150 my-auto max-h-[92vh] flex flex-col">

            {{-- HEADER MODAL (STICKY / FIXED AT TOP) --}}
            <div class="flex items-center justify-between border-b border-slate-100 bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-3.5 text-white shrink-0">
                <div class="flex items-center gap-3">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/20 text-white font-black text-base shrink-0">
                        🛡️
                    </span>
                    <div>
                        <h3 class="text-sm font-extrabold leading-tight">
                            Pengesahan Dokumen Rekomendasi Kebijakan
                        </h3>
                        <p class="text-[11px] text-emerald-100 mt-0.5">
                            Keluaran Resmi Balai Besar Laboratorium Kesehatan Lingkungan (BBLKL)
                        </p>
                    </div>
                </div>
                <button type="button"
                        onclick="closeApproveModal()"
                        class="flex h-8 w-8 items-center justify-center rounded-lg text-white/80 hover:bg-white/20 hover:text-white transition cursor-pointer">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- FORM BODY DENGAN SCROLLABLE CONTENT DAN FIXED FOOTER --}}
            <form method="POST" action="{{ route('rekomendasi.approve') }}" class="flex flex-col flex-1 overflow-hidden m-0">
                @csrf
                <input type="hidden" name="tahun" value="{{ $tahunFilter }}">
                <input type="hidden" name="jenis_nyamuk" value="{{ $nyamukFilter }}">
                <input type="hidden" name="provinsi_id" value="{{ $provinsiFilter }}">
                <input type="hidden" name="kabupaten_id" value="{{ $kabupatenFilter }}">
                <input type="hidden" name="template" value="{{ $activeTemplate }}">
                <input type="hidden" name="nama_wilayah" value="{{ $namaWilayah }}">

                {{-- SCROLLABLE CONTAINER --}}
                <div class="p-6 space-y-4 overflow-y-auto flex-1">
                    {{-- INFO CAKUPAN LAPORAN --}}
                    <div class="rounded-xl border border-teal-200 bg-teal-50/70 p-3.5 dark:bg-teal-950/30 dark:border-teal-800">
                        <div class="flex items-center justify-between flex-wrap gap-2 text-xs">
                            <div>
                                <span class="text-teal-700 dark:text-teal-400 font-bold uppercase tracking-wider block text-[10px]">Cakupan Dokumen:</span>
                                <strong class="text-slate-900 dark:text-white text-sm">{{ $namaWilayah }}</strong>
                            </div>
                            <div class="text-right">
                                <span class="text-slate-500 dark:text-zinc-400 text-[11px]">Periode: <strong>{{ $tahunFilter }}</strong> &bull; Spesies: <strong>{{ $nyamukFilter }}</strong></span>
                            </div>
                        </div>
                    </div>

                    {{-- PILIHAN LINGKUP TEMPLATE --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 uppercase tracking-wider mb-1.5">
                            Lingkup Pengesahan Dokumen *
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <label class="flex items-start gap-2.5 p-3 rounded-xl border border-teal-300 bg-teal-50/40 dark:bg-zinc-800 dark:border-teal-700 cursor-pointer hover:bg-teal-50">
                                <input type="radio" name="lingkup_approval" value="semua_template" checked class="mt-0.5 text-teal-600 focus:ring-teal-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 dark:text-zinc-100 block">Seluruh 4 Format Template (Direkomendasikan)</span>
                                    <span class="text-[11px] text-slate-500 dark:text-zinc-400 block mt-0.5">Sahkan format Kemenkes RI, Policy Brief Eksekutif, Rekomendasi Teknis Laboratorium, &amp; Policy Brief Agregat Wilayah sekaligus.</span>
                                </div>
                            </label>
                            <label class="flex items-start gap-2.5 p-3 rounded-xl border border-slate-200 bg-white dark:bg-zinc-800 dark:border-zinc-700 cursor-pointer hover:bg-slate-50">
                                <input type="radio" name="lingkup_approval" value="template_ini" class="mt-0.5 text-teal-600 focus:ring-teal-500">
                                <div>
                                    <span class="text-xs font-bold text-slate-800 dark:text-zinc-100 block">Hanya Format Template Ini</span>
                                    <span class="text-[11px] text-slate-500 dark:text-zinc-400 block mt-0.5">Format: <strong>{{ strtoupper($activeTemplate) }}</strong></span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- NAMA & NIP PIMPINAN --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 uppercase tracking-wider mb-1">
                                Nama Kepala / Pimpinan BBLKL *
                            </label>
                            <input type="text"
                                   name="approver_name"
                                   required
                                   value="{{ $defaultKepalaNama }}"
                                   placeholder="Nama Lengkap & Gelar Pimpinan"
                                   class="w-full h-10 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 text-xs font-medium text-slate-800 dark:text-zinc-100 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 uppercase tracking-wider mb-1">
                                NIP Kepala / Pimpinan
                            </label>
                            <input type="text"
                                   name="approver_nip"
                                   value="{{ $defaultKepalaNip }}"
                                   placeholder="NIP. 19xxxxxxxxxxxxxx"
                                   class="w-full h-10 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 text-xs font-medium text-slate-800 dark:text-zinc-100 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                    </div>

                    {{-- JABATAN & NOMOR SURAT --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 uppercase tracking-wider mb-1">
                                Jabatan Resmi *
                            </label>
                            <input type="text"
                                   name="approver_jabatan"
                                   required
                                   value="{{ $defaultKepalaJabatan }}"
                                   placeholder="Jabatan Resmi Pimpinan"
                                   class="w-full h-10 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 text-xs font-medium text-slate-800 dark:text-zinc-100 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 uppercase tracking-wider mb-1">
                                Nomor Surat / Disposisi Rekomendasi
                            </label>
                            <input type="text"
                                   name="nomor_surat"
                                   value="{{ $defaultNomorSurat }}"
                                   placeholder="Contoh: LT-VEC/BBLKL/2026/0417"
                                   class="w-full h-10 rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3.5 text-xs font-mono font-medium text-slate-800 dark:text-zinc-100 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs">
                        </div>
                    </div>

                    {{-- CATATAN / INSTRUKSI PENGESAHAN --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 uppercase tracking-wider mb-1">
                            Catatan / Arahan Pimpinan (Opsional)
                        </label>
                        <textarea name="notes"
                                  rows="3"
                                  placeholder="Contoh: Rekomendasi teknis kebijakan pengendalian vektor ini disahkan untuk diteruskan kepada Dinas Kesehatan setempat dan Dirjen P2P Kemenkes RI sebagai dasar rotasi insektisida..."
                                  class="w-full rounded-xl border border-slate-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 p-3 text-xs text-slate-800 dark:text-zinc-100 focus:border-teal-500 focus:outline-none focus:ring-1 focus:ring-teal-500 shadow-2xs leading-relaxed">{{ $approval->notes ?? 'Rekomendasi teknis kebijakan pengendalian vektor ini telah diperiksa, diverifikasi, dan disahkan sebagai rujukan operasional penanggulangan resistensi vektor di wilayah bersangkutan.' }}</textarea>
                    </div>

                    {{-- KETERANGAN RESMI --}}
                    <div class="flex items-start gap-2 text-[11px] text-slate-500 dark:text-zinc-400">
                        <span class="text-teal-600 font-bold">ℹ️</span>
                        <span>Dengan menekan tombol Setujui &amp; Sahkan, watermark <strong>"DRAFT"</strong> pada dokumen cetak akan dicabut dan digantikan dengan tanda tangan digital &amp; stempel pengesahan elektronik resmi Kepala BBLKL.</span>
                    </div>
                </div>

                {{-- ACTION BUTTONS (STICKY / FIXED AT BOTTOM) --}}
                <div class="flex items-center justify-end gap-2.5 px-6 py-4 border-t border-slate-100 dark:border-zinc-800 bg-slate-50/80 dark:bg-zinc-900/80 shrink-0">
                    <button type="button"
                            onclick="closeApproveModal()"
                            class="px-4 py-2 rounded-xl border border-slate-300 dark:border-zinc-700 text-xs font-bold text-slate-700 dark:text-zinc-300 hover:bg-slate-50 dark:hover:bg-zinc-800 transition cursor-pointer">
                        Batal
                    </button>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-extrabold shadow-md transition active:scale-95 cursor-pointer">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>✅ Setujui &amp; Sahkan Rekomendasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT DINAMIS LOAD KABUPATEN & MODAL --}}
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

        function openApproveModal() {
            const modal = document.getElementById('approveModal');
            if (modal) modal.classList.remove('hidden');
        }

        function closeApproveModal() {
            const modal = document.getElementById('approveModal');
            if (modal) modal.classList.add('hidden');
        }

        // Tutup modal dengan escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeApproveModal();
            }
        });
    </script>

</body>
</html>

