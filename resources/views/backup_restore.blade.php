<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore - PETA RESISTENSI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')
</head>

<body class="bg-slate-100 dark:bg-zinc-950 text-slate-800 dark:text-zinc-100">

    {{-- SIDEBAR --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="min-h-screen transition-all duration-300 ml-0 lg:ml-64">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-40 flex items-center justify-between border-b border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 px-4 sm:px-6 lg:px-8 py-3.5 gap-3 shadow-xs">
            <div class="min-w-0 flex items-center gap-3">
                <button type="button"
                        onclick="toggleSidebarDrawer()"
                        class="lg:hidden flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-800 text-slate-700 dark:text-zinc-200 hover:bg-slate-100 dark:hover:bg-zinc-700 transition shadow-2xs cursor-pointer focus:outline-none"
                        aria-label="Buka Menu Navigasi">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="min-w-0 flex flex-col justify-center">
                    <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 dark:text-white tracking-tight leading-snug truncate">Backup &amp; Restore Database</h1>
                    <p class="text-xs text-slate-500 dark:text-zinc-400 font-medium mt-0.5 truncate">
                        PETA RESISTENSI • Amankan dan pulihkan data laboratorium kapan saja
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @include('header_profile')
            </div>
        </header>

        {{-- ISI HALAMAN --}}
        @php
            $isAdmin = auth()->check() && auth()->user()->isAdmin();
        @endphp
        <section class="p-8">

            {{-- ALERT NOTIFIKASI --}}
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 dark:border-emerald-800/80 bg-emerald-50 dark:bg-emerald-950/60 px-6 py-4 text-emerald-800 dark:text-emerald-200 shadow-sm">
                    <svg class="h-6 w-6 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-200 dark:border-rose-900/80 bg-rose-50 dark:bg-rose-950/60 px-6 py-4 text-rose-800 dark:text-rose-200 shadow-sm">
                    <svg class="h-6 w-6 shrink-0 text-rose-600 dark:text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-semibold">{{ session('error') }}</p>
                </div>
            @endif

            {{-- INFORMASI STATUS DATABASE / DATA AKUN --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 {{ $isAdmin ? 'lg:grid-cols-4' : 'lg:grid-cols-3' }} gap-5 mb-8">
                @if ($isAdmin)
                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 dark:text-zinc-400 uppercase tracking-wider">Nama Database</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white mt-1">{{ $stats['db_name'] }}</p>
                    <span class="inline-block mt-2 rounded bg-emerald-50 dark:bg-emerald-950/70 text-emerald-700 dark:text-emerald-300 text-[10px] font-bold px-2 py-0.5 border border-emerald-200 dark:border-emerald-700/60">
                        ● Online &amp; Terhubung
                    </span>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 dark:text-zinc-400 uppercase tracking-wider">Total Uji Resistensi</p>
                    <p class="text-lg font-bold text-blue-700 dark:text-sky-400 mt-1">{{ number_format($stats['data_uji']) }} Catatan</p>
                    <p class="text-[11px] text-slate-400 dark:text-zinc-400 mt-2">Seluruh data pemeriksaan tersimpan</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 dark:text-zinc-400 uppercase tracking-wider">Master Wilayah &amp; Instansi</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white mt-1">{{ number_format($stats['provinsi'] + $stats['kabupaten']) }} Titik</p>
                    <p class="text-[11px] text-slate-400 dark:text-zinc-400 mt-2">{{ $stats['provinsi'] }} Provinsi, {{ $stats['kabupaten'] }} Kab/Kota, {{ $stats['instansi'] }} Instansi</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 dark:text-zinc-400 uppercase tracking-wider">Parameter Uji</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white mt-1">{{ number_format($stats['kategori']) }} Kategori</p>
                    <p class="text-[11px] text-slate-400 dark:text-zinc-400 mt-2">Nyamuk, Insektisida, Metode</p>
                </div>
                @else
                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 dark:text-zinc-400 uppercase tracking-wider">Akun Pengguna</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white mt-1 truncate">{{ auth()->user()->name }}</p>
                    <span class="inline-block mt-2 rounded bg-blue-50 dark:bg-blue-950/70 text-blue-700 dark:text-blue-300 text-[10px] font-bold px-2 py-0.5 border border-blue-200 dark:border-blue-700/60 uppercase">
                        Role: {{ auth()->user()->role }}
                    </span>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 dark:text-zinc-400 uppercase tracking-wider">Data Uji Milik Anda</p>
                    <p class="text-lg font-bold text-blue-700 dark:text-sky-400 mt-1">{{ number_format($stats['data_uji']) }} Catatan</p>
                    <p class="text-[11px] text-slate-400 dark:text-zinc-400 mt-2">Data pemeriksaan yang Anda kelola</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-5 shadow-sm">
                    <p class="text-xs font-bold text-slate-400 dark:text-zinc-400 uppercase tracking-wider">Cakupan Wilayah Anda</p>
                    <p class="text-lg font-bold text-slate-800 dark:text-white mt-1">{{ number_format($stats['provinsi'] + $stats['kabupaten']) }} Lokasi</p>
                    <p class="text-[11px] text-slate-400 dark:text-zinc-400 mt-2">{{ $stats['provinsi'] }} Provinsi, {{ $stats['kabupaten'] }} Kab/Kota</p>
                </div>
                @endif
            </div>

            {{-- KARTU STATUS BACKUP ONLINE OTOMATIS (KHUSUS ADMINISTRATOR) --}}
            @if ($isAdmin)
            <div class="backup-online-card mb-8 rounded-2xl border border-blue-200 dark:border-indigo-900/60 bg-gradient-to-r from-blue-50/80 via-indigo-50/50 to-white dark:from-slate-900 dark:via-indigo-950/40 dark:to-slate-900 p-6 shadow-xs">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-4">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-blue-600 text-white shadow-sm text-2xl">
                            ⏰
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h2 class="card-title text-base font-bold text-slate-800 dark:text-white">Otomatisasi Backup Harian (Pukul 01.00 WIB)</h2>
                                <span class="badge-active rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 dark:border-emerald-600/80 text-[10px] font-bold px-2.5 py-0.5 border border-emerald-300">
                                    Aktif
                                </span>
                                <span class="badge-cloud rounded-full bg-blue-100 text-blue-800 dark:bg-blue-950/80 dark:text-blue-300 dark:border-blue-600/80 text-[10px] font-bold px-2.5 py-0.5 border border-blue-300">
                                    Cloud Online
                                </span>
                            </div>
                            <p class="card-desc text-xs text-slate-600 dark:text-slate-300 mt-1 leading-relaxed">
                                Sistem secara terjadwal mengekstrak database, mengompresi ke arsip ZIP, mengunggah ke Google Drive, dan mengirimkan file backup ke alamat email.
                            </p>
                            <div class="mt-3 flex flex-wrap gap-x-6 gap-y-2 text-xs">
                                <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                                    <span class="meta-label text-slate-400 dark:text-slate-400 font-medium">Jadwal:</span>
                                    <strong class="meta-schedule font-semibold text-blue-700 dark:text-sky-400">Setiap Hari, 01:00 WIB</strong>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                                    <span class="meta-label text-slate-400 dark:text-slate-400 font-medium">Email Tujuan:</span>
                                    <code class="meta-email rounded bg-white dark:bg-slate-950 px-2 py-0.5 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-100 font-mono text-[11px] font-bold">{{ config('backup.email') ?: 'Belum disetel di .env' }}</code>
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                                    <span class="meta-label text-slate-400 dark:text-slate-400 font-medium">Google Drive:</span>
                                    @if(config('backup.google_drive.enable'))
                                        <span class="meta-value text-emerald-700 dark:text-emerald-400 font-bold">✓ Terhubung</span>
                                    @else
                                        <span class="meta-value text-slate-500 dark:text-slate-300 font-medium">Opsional (Siap dikonfigurasi)</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                                    <span class="meta-label text-slate-400 dark:text-slate-400 font-medium">Penyimpanan Server:</span>
                                    <span class="meta-value text-slate-600 dark:text-slate-300 font-medium">Retensi {{ config('backup.retention_days', 14) }} hari</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="shrink-0 pt-2 md:pt-0">
                        <form action="{{ route('backup.auto_now') }}" method="POST" onsubmit="return confirm('Jalankan backup otomatis sekarang dan kirimkan ke email {{ config('backup.email') }}?')">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 dark:hover:bg-blue-500 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition cursor-pointer">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span>Jalankan Backup &amp; Kirim Email Sekarang</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                {{-- KARTU BUAT BACKUP --}}
                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-zinc-800 pb-4 mb-4">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 dark:bg-blue-950/60 text-blue-600 dark:text-blue-400 text-xl font-bold border border-blue-200/50 dark:border-blue-800/40">
                                💾
                            </span>
                            <div>
                                <h2 class="text-base font-bold text-slate-800 dark:text-white">
                                    {{ $isAdmin ? 'Buat Backup Database Keseluruhan' : 'Buat Backup Data Uji Anda' }}
                                </h2>
                                <p class="text-xs text-slate-500 dark:text-zinc-400">
                                    {{ $isAdmin ? 'Pilih format arsip ZIP terkompresi atau berkas mentah SQL dump' : 'Cadangkan khusus data pengujian milik akun Anda ke berkas ZIP atau SQL' }}
                                </p>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 dark:text-zinc-300 leading-relaxed mb-4">
                            @if ($isAdmin)
                            Sistem akan mengekstrak struktur tabel (DDL) dan seluruh data pengujian, master wilayah, instansi, serta parameter uji ke dalam berkas arsip <strong class="text-blue-600 dark:text-sky-400">.zip</strong> terkompresi hemat ruang atau berkas mentah <strong class="text-slate-800 dark:text-white">.sql</strong> standar.
                            @else
                            Sistem akan mengekstrak seluruh data uji resistensi yang diinputkan oleh akun <strong class="text-blue-600 dark:text-sky-400">{{ auth()->user()->name }}</strong> ke dalam berkas arsip <strong class="text-blue-600 dark:text-sky-400">.zip</strong> atau berkas query <strong class="text-slate-800 dark:text-white">.sql</strong> dengan penamaan sesuai username akun Anda.
                            @endif
                        </p>

                        <div class="rounded-xl bg-blue-50/70 dark:bg-blue-950/40 border border-blue-200/60 dark:border-blue-800/60 p-3.5 mb-6 text-xs text-blue-800 dark:text-blue-200 space-y-1.5">
                            <p class="font-bold text-blue-900 dark:text-blue-100">Keuntungan Format ZIP &amp; SQL:</p>
                            <p>✓ <strong>Format ZIP:</strong> Ukuran file 5x–10x lebih hemat, unduhan cepat, dan format standar arsip.</p>
                            <p>✓ <strong>Format SQL:</strong> Berkas query SQL mentah untuk analisis manual atau import langsung via phpMyAdmin.</p>
                            <p>✓ Keduanya dapat langsung dipulihkan sewaktu-waktu melalui fitur Restore di samping.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-2.5 pt-2">
                        {{-- TOMBOL UTAMA: BACKUP ZIP TERKOMPRESI --}}
                        <form action="{{ route('backup.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="format" value="zip">
                            <input type="hidden" name="download" value="1">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 hover:bg-blue-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer active:scale-95" title="Buat backup database dan unduh langsung sebagai arsip ZIP terkompresi">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                <span>📦 Unduh Backup ZIP</span>
                            </button>
                        </form>

                        {{-- TOMBOL KEDUA: BACKUP SQL MENTAH --}}
                        <form action="{{ route('backup.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="format" value="sql">
                            <input type="hidden" name="download" value="1">
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-blue-300 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/60 px-3.5 py-2.5 text-xs font-bold text-blue-700 dark:text-blue-300 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition cursor-pointer active:scale-95" title="Buat backup database dan unduh sebagai file SQL standar">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>📄 Unduh File SQL</span>
                            </button>
                        </form>

                        @if ($isAdmin)
                        {{-- TOMBOL ADMIN: SIMPAN DI SERVER (ZIP) --}}
                        <form action="{{ route('backup.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="format" value="zip">
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 dark:border-zinc-700 bg-slate-50 dark:bg-zinc-800 px-3 py-2.5 text-xs font-bold text-slate-700 dark:text-zinc-200 hover:bg-slate-100 dark:hover:bg-zinc-700 transition shadow-2xs cursor-pointer" title="Buat arsip ZIP dan simpan di direktori storage server tanpa mengunduh">
                                <span>Simpan ZIP di Server</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                {{-- KARTU RESTORE ONLINE DATABASE (DAPAT DIAKSES OLEH ROLE BERWENANG) --}}
                <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 border-b border-slate-100 dark:border-zinc-800 pb-4 mb-4">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 text-xl font-bold border border-amber-200/50 dark:border-amber-800/40">
                                🔄
                            </span>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h2 class="text-base font-bold text-slate-800 dark:text-white">
                                        {{ $isAdmin ? 'Restore Online Database' : 'Restore Data Uji Anda' }}
                                    </h2>
                                    <span class="rounded bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-bold px-2 py-0.5 border border-emerald-300 dark:border-emerald-700">Format .sql &amp; .zip</span>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-zinc-400">
                                    {{ $isAdmin ? 'Pulihkan basis data penuh dari file berkas backup (.sql atau .zip)' : 'Pulihkan data uji resistensi akun Anda dari berkas backup (.sql atau .zip)' }}
                                </p>
                            </div>
                        </div>

                        <div class="rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200/80 dark:border-rose-900/60 p-3.5 mb-5 text-xs text-rose-800 dark:text-rose-200 leading-relaxed">
                            <strong class="font-bold text-rose-900 dark:text-rose-100">⚠️ Peringatan:</strong>
                            @if ($isAdmin)
                            Memulihkan database akan memperbarui atau menimpa tabel data saat ini dengan data yang ada di file backup. Pastikan Anda telah membuat backup terbaru terlebih dahulu.
                            @else
                            Memulihkan data akan menggantikan data uji resistensi milik akun Anda dengan data yang tersimpan di berkas backup. Data pengguna lain dan data master tidak akan terpengaruh.
                            @endif
                        </div>

                        <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data" id="restoreForm">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-bold text-slate-700 dark:text-zinc-300 mb-1.5">Pilih Berkas Backup (.sql atau .zip) *</label>
                                <input type="file" name="backup_file" accept=".sql,.zip" required
                                       class="w-full text-xs text-slate-600 dark:text-zinc-300 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 dark:file:bg-blue-950/70 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-900 border border-slate-200 dark:border-zinc-700 rounded-xl p-1 bg-slate-50 dark:bg-zinc-800 cursor-pointer" />
                            </div>

                            <button type="button" onclick="confirmRestore()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-amber-600 hover:bg-amber-500 px-5 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>{{ $isAdmin ? 'Pulihkan (Restore Online) Database' : 'Pulihkan Data Uji Akun Anda' }}</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- DAFTAR BERKAS BACKUP DI SERVER --}}
            <div class="rounded-2xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-zinc-800 pb-4 mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Daftar Berkas Backup di Server</h3>
                        <p class="text-xs text-slate-400 dark:text-zinc-400">File tersimpan di direktori storage aman</p>
                    </div>
                    <span class="rounded-lg bg-slate-100 dark:bg-zinc-800 px-3 py-1 text-xs font-bold text-slate-600 dark:text-zinc-300 border border-slate-200 dark:border-zinc-700">
                        {{ count($backups) }} File Tersedia
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 dark:bg-zinc-800/80 uppercase text-slate-500 dark:text-zinc-300 font-bold border-b border-slate-200 dark:border-zinc-700">
                            <tr>
                                <th class="px-4 py-3">Nama Berkas</th>
                                <th class="px-4 py-3">Ukuran</th>
                                <th class="px-4 py-3">Format</th>
                                <th class="px-4 py-3">Tanggal Dibuat</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-zinc-800">
                            @forelse ($backups as $b)
                                <tr class="hover:bg-slate-50 dark:hover:bg-zinc-800/50 transition">
                                    <td class="px-4 py-3.5 font-semibold text-slate-800 dark:text-zinc-100 flex items-center gap-2">
                                        <span>{{ $b['extension'] === 'ZIP' ? '📦' : '📄' }}</span>
                                        <span>{{ $b['filename'] }}</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-600 dark:text-zinc-300 font-medium">
                                        {{ $b['size'] }}
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="rounded {{ $b['extension'] === 'ZIP' ? 'bg-emerald-50 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-blue-50 dark:bg-blue-950/80 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800' }} font-bold px-2 py-0.5 text-[10px]">
                                            {{ $b['extension'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-500 dark:text-zinc-400">
                                        {{ $b['created_at'] }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('backup.download', $b['filename']) }}"
                                               class="inline-flex items-center gap-1 rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-950/60 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:text-blue-300 hover:bg-blue-600 hover:text-white dark:hover:bg-blue-600 dark:hover:text-white transition"
                                               title="Download file ini">
                                                <span>📥 Unduh</span>
                                            </a>

                                            @if ($isAdmin || !empty($b['is_user_backup']))
                                            <form action="{{ route('backup.delete', $b['filename']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file backup {{ $b['filename'] }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 rounded-lg border border-rose-200 dark:border-rose-900/60 bg-rose-50 dark:bg-rose-950/60 px-2.5 py-1 text-xs font-semibold text-rose-600 dark:text-rose-300 hover:bg-rose-600 hover:text-white dark:hover:bg-rose-600 dark:hover:text-white transition cursor-pointer"
                                                        title="Hapus file ini">
                                                    <span>🗑️ Hapus</span>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 dark:text-zinc-500">
                                        Belum ada file backup di server. Silakan klik tombol "📦 Unduh Backup ZIP" atau "📄 Unduh File SQL" di atas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </section>

    </main>

    <script>
        function confirmRestore() {
            const form = document.getElementById('restoreForm');
            if (!form) return;
            const fileInput = form.querySelector('input[type="file"]');
            if (!fileInput.value) {
                alert('Silakan pilih berkas file backup (.sql atau .zip) terlebih dahulu.');
                return;
            }
            if (confirm('PERINGATAN: Apakah Anda yakin ingin memulihkan (restore online) database dari file ini? Seluruh data yang ada saat ini akan digantikan dengan data dari backup.')) {
                form.submit();
            }
        }
    </script>

</body>

</html>
