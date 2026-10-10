<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data - SIMPEL BBLKL</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')
</head>

<body class="bg-slate-100 text-slate-800">

    {{-- SIDEBAR --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="ml-64 min-h-screen">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-40 flex flex-col md:flex-row md:items-center justify-between border-b border-slate-200 bg-white px-6 lg:px-8 py-3.5 gap-3 shadow-xs">
            <div class="min-w-0 flex flex-col justify-center">
                <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug">Import Data Pemeriksaan</h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Unggah berkas CSV untuk memasukkan banyak data uji resistensi sekaligus
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @include('header_profile')
            </div>
        </header>

        {{-- ISI HALAMAN --}}
        <section class="p-8">

            {{-- ALERT NOTIFIKASI --}}
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-emerald-800 shadow-sm">
                    <svg class="h-6 w-6 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-6 py-4 text-rose-800 shadow-sm">
                    <svg class="h-6 w-6 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            @endif

            {{-- STATISTIK DATA SAAT INI --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 font-bold">
                            📊
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Data Pemeriksaan Aktif</p>
                            <h3 class="text-xl font-bold text-slate-800">{{ number_format($totalData) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 font-bold">
                            🏛️
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Master Provinsi</p>
                            <h3 class="text-xl font-bold text-slate-800">{{ number_format($totalProvinsi) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 font-bold">
                            📍
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-medium">Master Kabupaten/Kota</p>
                            <h3 class="text-xl font-bold text-slate-800">{{ number_format($totalKabupaten) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- FORM UPLOAD FILE --}}
                <div class="lg:col-span-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-6">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-lg">
                                📤
                            </span>
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Unggah Berkas CSV</h2>
                                <p class="text-xs text-slate-500">Pilih berkas dari komputer atau seret file ke area upload</p>
                            </div>
                        </div>

                        <a href="{{ route('import.template') }}"
                           class="inline-flex items-center gap-1.5 rounded-xl border border-blue-200 bg-blue-50 px-3.5 py-2 text-xs font-bold text-blue-700 hover:bg-blue-600 hover:text-white transition shadow-xs">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            <span>Download Template CSV</span>
                        </a>
                    </div>

                    <form action="{{ route('import.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label class="flex flex-col items-center justify-center w-full h-56 border-2 border-dashed border-slate-300 rounded-2xl cursor-pointer bg-slate-50 hover:bg-blue-50/50 hover:border-blue-400 transition">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-12 h-12 mb-3 text-blue-500 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="mb-2 text-sm text-slate-700 font-semibold">Klik untuk memilih berkas atau seret berkas ke sini</p>
                                    <p class="text-xs text-slate-500">Mendukung format berkas <strong>.XLSX (Excel)</strong>, <strong>.CSV</strong>, atau <strong>.TXT</strong> (Maksimal 20 MB)</p>
                                    <p id="fileNamePreview" class="mt-2 text-xs font-bold text-blue-700 bg-blue-100/70 px-3 py-1 rounded-lg hidden"></p>
                                </div>
                                <input type="file" name="file" id="fileInput" accept=".xlsx, .xls, .csv, .txt" class="hidden" required onchange="showFileName(this)" />
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-slate-400">
                                💡 Pastikan susunan kolom sesuai dengan template standar data resistensi.
                            </p>
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-6 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-blue-700 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                <span>Mulai Impor Data</span>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- PETUNJUK FORMAT KOLOM --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h3 class="text-sm font-bold text-slate-800 border-b border-slate-100 pb-3 mb-4">
                        📋 Format Kolom Data Resistensi
                    </h3>

                    <ul class="space-y-2.5 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">1</span>
                            <div>
                                <strong class="text-slate-800">provinsi:</strong> Contoh: <em>Jawa Tengah, Bali, Aceh</em>.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">2</span>
                            <div>
                                <strong class="text-slate-800">kabupaten:</strong> Contoh: <em>Kudus, Grobogan, Bangli</em>. (Awalan Kab / Kabupaten di Excel otomatis diabaikan).
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">3</span>
                            <div>
                                <strong class="text-slate-800">alamat:</strong> Alamat / desa / puskesmas survei.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">4</span>
                            <div>
                                <strong class="text-slate-800">jenis_nyamuk:</strong> Contoh: <em>Ae. aegypti, Culex sp, Anopheles</em>.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">5</span>
                            <div>
                                <strong class="text-slate-800">insektisida:</strong> Contoh: <em>Deltamethrin, Malathion</em>.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">6</span>
                            <div>
                                <strong class="text-slate-800">metode:</strong> Contoh: <em>WHO Tube Bioassay, Sequencing</em>.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">7</span>
                            <div>
                                <strong class="text-slate-800">sampel_diperiksa:</strong> Jumlah sampel diperiksa (angka).
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-blue-100 text-blue-700 font-bold px-1.5 py-0.5 text-[10px]">8</span>
                            <div>
                                <strong class="text-slate-800">bulan & tahun:</strong> Contoh: <em>Oktober</em> & <em>2026</em>.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-rose-100 text-rose-700 font-bold px-1.5 py-0.5 text-[10px]">9</span>
                            <div>
                                <strong class="text-slate-800">resisten:</strong> Beri tanda <code>v</code> jika hasil uji Resisten.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-emerald-100 text-emerald-700 font-bold px-1.5 py-0.5 text-[10px]">10</span>
                            <div>
                                <strong class="text-slate-800">rentan:</strong> Beri tanda <code>v</code> jika hasil uji Rentan.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-amber-100 text-amber-800 font-bold px-1.5 py-0.5 text-[10px]">11</span>
                            <div>
                                <strong class="text-slate-800">toleran:</strong> Beri tanda <code>v</code> untuk Toleran & Terduga Resisten (isian disatukan ke kolom Toleran).
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="rounded bg-indigo-100 text-indigo-700 font-bold px-1.5 py-0.5 text-[10px]">12</span>
                            <div>
                                <strong class="text-slate-800">publikasi:</strong> Status / sumber publikasi (Contoh: <em>Publikasi BBLK 2026, Jurnal Vektor, Laporan Surveilans Dinkes</em>).
                            </div>
                        </li>
                    </ul>

                    <div class="mt-5 space-y-2.5 border-t border-slate-100 pt-4">
                        <div class="rounded-xl bg-blue-50 border border-blue-200/80 p-3 text-xs text-blue-800">
                            <strong>✨ Pencocokan Otomatis:</strong> Tulisan <em>Kab / Kabupaten / Kota</em> pada Excel diabaikan dan langsung dicocokkan dengan data master. Jika namanya sama, sistem otomatis mengaitkannya.
                        </div>
                        <div class="rounded-xl bg-amber-50 border border-amber-200/80 p-3 text-xs text-amber-800">
                            <strong>🟡 Kolom Toleran:</strong> Jika berkas Excel memiliki kolom <em>Terduga Resisten</em>, sistem otomatis memasukkannya ke dalam kolom Toleran.
                        </div>
                    </div>
                </div>

            </div>

        </section>

    </main>

    <script>
        function showFileName(input) {
            const preview = document.getElementById('fileNamePreview');
            if (input.files && input.files[0]) {
                preview.textContent = '📄 ' + input.files[0].name + ' (' + (input.files[0].size / 1024).toFixed(1) + ' KB)';
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>

</body>

</html>
