<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backup & Restore - SIMPEL BBLKL</title>
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
                <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug">Backup & Restore Database</h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Amankan dan pulihkan data laboratorium SIMPEL BBLKL kapan saja
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

            {{-- INFORMASI STATUS DATABASE --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Nama Database</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ $stats['db_name'] }}</p>
                    <span class="inline-block mt-2 rounded bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2 py-0.5 border border-emerald-200">
                        ● Online & Terhubung
                    </span>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Uji Resistensi</p>
                    <p class="text-lg font-bold text-blue-700 mt-1">{{ number_format($stats['data_uji']) }} Catatan</p>
                    <p class="text-[11px] text-slate-400 mt-2">Data pemeriksaan tersimpan</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Master Wilayah & Instansi</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ number_format($stats['provinsi'] + $stats['kabupaten']) }} Titik</p>
                    <p class="text-[11px] text-slate-400 mt-2">{{ $stats['provinsi'] }} Provinsi, {{ $stats['kabupaten'] }} Kab/Kota, {{ $stats['instansi'] }} Instansi</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Parameter Uji</p>
                    <p class="text-lg font-bold text-slate-800 mt-1">{{ number_format($stats['kategori']) }} Kategori</p>
                    <p class="text-[11px] text-slate-400 mt-2">Nyamuk, Insektisida, Metode</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

                {{-- KARTU BUAT BACKUP --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-4">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600 text-xl font-bold">
                                💾
                            </span>
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Buat Backup Database</h2>
                                <p class="text-xs text-slate-500">Mencakup seluruh tabel dan data sistem ke file SQL dump</p>
                            </div>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed mb-4">
                            Sistem akan mengekstrak struktur tabel (DDL) dan seluruh data pengujian, master wilayah, instansi, serta parameter uji ke dalam satu file <strong>.sql</strong> standar yang dapat disimpan secara lokal.
                        </p>

                        <div class="rounded-xl bg-blue-50/70 border border-blue-200/60 p-3.5 mb-6 text-xs text-blue-800 space-y-1">
                            <p class="font-semibold">Keuntungan Backup Rutin:</p>
                            <p>✓ Menjaga integritas data pemeriksaan laboratorium dari kehilangan.</p>
                            <p>✓ Dapat dipulihkan sewaktu-waktu ke server lokal maupun produksi.</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 pt-2">
                        <form action="{{ route('backup.create') }}" method="POST">
                            @csrf
                            <input type="hidden" name="download" value="1">
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-blue-700 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                <span>Buat & Unduh Backup SQL</span>
                            </button>
                        </form>

                        <form action="{{ route('backup.create') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition shadow-2xs">
                                <span>Simpan di Server Saja</span>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- KARTU RESTORE DATABASE --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-3 border-b border-slate-100 pb-4 mb-4">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600 text-xl font-bold">
                                🔄
                            </span>
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Restore Database dari File</h2>
                                <p class="text-xs text-slate-500">Pulihkan basis data dari file berkas backup (.sql)</p>
                            </div>
                        </div>

                        <div class="rounded-xl bg-rose-50 border border-rose-200/80 p-3.5 mb-5 text-xs text-rose-800">
                            <strong>⚠️ Peringatan:</strong> Memulihkan database akan memperbarui atau menimpa tabel data saat ini dengan data yang ada di file backup. Pastikan Anda telah membuat backup terbaru terlebih dahulu.
                        </div>

                        <form action="{{ route('backup.restore') }}" method="POST" enctype="multipart/form-data" id="restoreForm">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Berkas SQL Backup (.sql) *</label>
                                <input type="file" name="backup_file" accept=".sql" required
                                       class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-slate-200 rounded-xl p-1 bg-slate-50" />
                            </div>

                            <button type="button" onclick="confirmRestore()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-amber-600 px-5 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-amber-700 transition">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Pulihkan (Restore) Database</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>

            {{-- DAFTAR BERKAS BACKUP DI SERVER --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <div>
                        <h3 class="text-sm font-bold text-slate-800">Daftar Berkas Backup di Server</h3>
                        <p class="text-xs text-slate-400">File tersimpan di direktori storage aman</p>
                    </div>
                    <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-bold text-slate-600">
                        {{ count($backups) }} File Tersedia
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 uppercase text-slate-500 font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-4 py-3">Nama Berkas</th>
                                <th class="px-4 py-3">Ukuran</th>
                                <th class="px-4 py-3">Format</th>
                                <th class="px-4 py-3">Tanggal Dibuat</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($backups as $b)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-4 py-3.5 font-semibold text-slate-800 flex items-center gap-2">
                                        <span>📄</span>
                                        <span>{{ $b['filename'] }}</span>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-600">
                                        {{ $b['size'] }}
                                    </td>
                                    <td class="px-4 py-3.5">
                                        <span class="rounded bg-blue-50 text-blue-700 font-bold px-2 py-0.5 text-[10px]">
                                            {{ $b['extension'] }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3.5 text-slate-500">
                                        {{ $b['created_at'] }}
                                    </td>
                                    <td class="px-4 py-3.5 text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('backup.download', $b['filename']) }}"
                                               class="inline-flex items-center gap-1 rounded-lg border border-blue-200 bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-600 hover:text-white transition"
                                               title="Download file ini">
                                                <span>📥 Unduh</span>
                                            </a>

                                            <form action="{{ route('backup.delete', $b['filename']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file backup {{ $b['filename'] }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-600 hover:bg-rose-600 hover:text-white transition"
                                                        title="Hapus file ini">
                                                    <span>🗑️ Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-slate-400">
                                        Belum ada file backup di server. Silakan klik tombol "Buat & Unduh Backup SQL" di atas.
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
            const fileInput = form.querySelector('input[type="file"]');
            if (!fileInput.value) {
                alert('Silakan pilih berkas file .sql backup terlebih dahulu.');
                return;
            }
            if (confirm('PERINGATAN: Apakah Anda yakin ingin memulihkan (restore) database dari file ini? Seluruh data yang ada saat ini akan digantikan dengan data dari backup.')) {
                form.submit();
            }
        }
    </script>

</body>

</html>
