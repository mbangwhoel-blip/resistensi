<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Unit / Instansi - SIMPEL BBLKL</title>
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
                <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug">Master Data Unit / Instansi</h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Kelola data balai, laboratorium, dinas kesehatan, dan fasilitas kesehatan
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
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-6 py-4 text-rose-800 shadow-sm">
                    <svg class="h-6 w-6 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-sm">{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 p-6 text-rose-800 shadow-sm">
                    <div class="flex items-center gap-2 font-semibold text-rose-900 mb-2">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Periksa kembali input data:</span>
                    </div>
                    <ul class="list-inside list-disc text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SUMMARY STATS CARDS --}}
            <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Instansi</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalInstansi }}</h3>
                        <p class="mt-1 text-xs text-slate-400">Semua unit terdaftar</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Balai / Laboratorium</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalBalai }}</h3>
                        <p class="mt-1 text-xs text-slate-400">Unit lab lingkungan</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Dinas Kesehatan</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalDinkes }}</h3>
                        <p class="mt-1 text-xs text-slate-400">Dinkes Prov / Kab / Kota</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Fasilitas Kesehatan</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalFaskes }}</h3>
                        <p class="mt-1 text-xs text-slate-400">RS & Puskesmas</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- KONTEN UTAMA TABEL --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                
                {{-- HEADER FILTER & TOMBOL TAMBAH --}}
                <div class="mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-3.5">
                    <form method="GET" action="{{ route('instansi.index') }}" class="flex flex-wrap items-center gap-2.5 flex-1">
                        {{-- SEARCH BOX & TOMBOL CARI SEJAJAR --}}
                        <div class="flex items-center gap-2">
                            <div class="relative w-48 sm:w-56 md:w-64">
                                <input type="text"
                                       name="search"
                                       value="{{ $search }}"
                                       placeholder="Cari unit, kode, penanggung jawab..."
                                       class="w-full h-10 rounded-xl border border-slate-200 bg-white pl-9 pr-3 text-sm text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none transition">
                                <svg class="absolute left-3 top-3 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <button type="submit"
                                    class="cursor-pointer h-10 rounded-xl bg-slate-800 px-3.5 text-sm font-semibold text-white shadow-2xs hover:bg-slate-900 active:bg-slate-950 transition flex items-center gap-1.5 shrink-0">
                                <span>Cari</span>
                            </button>
                        </div>

                        {{-- FILTER KATEGORI --}}
                        <div class="w-36 sm:w-44">
                            <select name="kategori"
                                    onchange="this.form.submit()"
                                    class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none transition">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoriList as $kat)
                                    <option value="{{ $kat }}" {{ $kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- FILTER PROVINSI --}}
                        <div class="w-36 sm:w-44">
                            <select name="provinsi_id"
                                    onchange="this.form.submit()"
                                    class="w-full h-10 rounded-xl border border-slate-200 bg-white px-3 text-sm text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none transition">
                                <option value="">Semua Provinsi</option>
                                @foreach ($provinsis as $p)
                                    <option value="{{ $p->id }}" {{ $provinsiId == $p->id ? 'selected' : '' }}>{{ $p->nama_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- TOMBOL RESET --}}
                        @if ($search || $kategori || $provinsiId)
                            <a href="{{ route('instansi.index') }}"
                               class="inline-flex items-center gap-1.5 h-10 rounded-xl border border-slate-200 bg-slate-50 hover:bg-slate-100 text-slate-600 px-3.5 text-sm font-semibold transition shadow-2xs shrink-0"
                               title="Reset semua filter">
                                <svg class="h-3.5 w-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>Reset</span>
                            </a>
                        @endif
                    </form>

                    {{-- TOMBOL TAMBAH UNIT / INSTANSI --}}
                    <div class="shrink-0">
                        <button onclick="openModal('modalTambahInstansi')"
                                class="cursor-pointer h-10 rounded-xl bg-blue-600 px-4 sm:px-5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 active:bg-blue-800 transition flex items-center gap-2">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Tambah Instansi</span>
                        </button>
                    </div>
                </div>

                {{-- TABEL INSTANSI --}}
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                            <tr>
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Nama Unit / Instansi</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Wilayah</th>
                                <th class="px-6 py-4">Kontak</th>
                                <th class="px-6 py-4">Penanggung Jawab</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($instansis as $index => $item)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-medium text-slate-400">
                                        {{ $instansis->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-slate-800">{{ $item->nama_instansi }}</p>
                                        @if ($item->kode_unit)
                                            <p class="text-xs font-mono text-slate-400">Kode: {{ $item->kode_unit }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeClass = match(true) {
                                                str_contains($item->kategori, 'BKK') || str_contains($item->kategori, 'Kekarantinaan') => 'bg-cyan-50 text-cyan-700 border-cyan-200',
                                                str_contains($item->kategori, 'Balai') || str_contains($item->kategori, 'Lab') => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                str_contains($item->kategori, 'Dinas') => 'bg-amber-50 text-amber-700 border-amber-200',
                                                str_contains($item->kategori, 'Sakit') || str_contains($item->kategori, 'Puskesmas') => 'bg-purple-50 text-purple-700 border-purple-200',
                                                default => 'bg-blue-50 text-blue-700 border-blue-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-medium {{ $badgeClass }}">
                                            {{ $item->kategori }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-xs font-semibold text-slate-700">{{ $item->provinsi?->nama_provinsi ?? '-' }}</p>
                                        <p class="text-xs text-slate-500">{{ $item->kabupaten?->nama_kabupaten ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-xs">
                                        @if ($item->telepon)
                                            <p class="text-slate-700 font-medium">📞 {{ $item->telepon }}</p>
                                        @endif
                                        @if ($item->email)
                                            <p class="text-slate-500">✉️ {{ $item->email }}</p>
                                        @endif
                                        @if (!$item->telepon && !$item->email)
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs font-medium text-slate-700">
                                        {{ $item->penanggung_jawab ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button onclick="editInstansi({{ json_encode($item) }})" class="cursor-pointer rounded-lg p-1.5 text-blue-600 hover:bg-blue-50" title="Edit">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <form method="POST" action="{{ route('instansi.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit {{ $item->nama_instansi }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="cursor-pointer rounded-lg p-1.5 text-rose-600 hover:bg-rose-50" title="Hapus">
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-400">
                                        Belum ada data unit / instansi yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="mt-6">
                    {{ $instansis->links() }}
                </div>

            </div>

        </section>
    </main>

    {{-- MODAL TAMBAH INSTANSI --}}
    <div id="modalTambahInstansi" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Tambah Instansi Baru</h3>
                <button onclick="closeModal('modalTambahInstansi')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form action="{{ route('instansi.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Unit / Instansi *</label>
                        <input type="text" name="nama_instansi" required placeholder="Contoh: Balai Besar Lab Kesling Surabaya" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Unit</label>
                        <input type="text" name="kode_unit" placeholder="Contoh: BBLKL-01" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori *</label>
                        <select name="kategori" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                            @foreach ($kategoriList as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Provinsi</label>
                        <select id="tambahProvinsi" name="provinsi_id" onchange="fetchKabupatenForTambah(this.value)" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinsis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kabupaten / Kota</label>
                        <select id="tambahKabupaten" name="kabupaten_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                            <option value="">-- Pilih Provinsi Dulu --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                        <input type="text" name="telepon" placeholder="Contoh: (031) 5021450" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                        <input type="email" name="email" placeholder="info@instansi.go.id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Penanggung Jawab / Kepala Unit</label>
                        <input type="text" name="penanggung_jawab" placeholder="Nama & Gelar atau Jabatan" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" placeholder="Alamat jalan, gedung, nomor..." class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalTambahInstansi')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Simpan Unit</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT INSTANSI --}}
    <div id="modalEditInstansi" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-2xl rounded-2xl bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Data Unit / Instansi</h3>
                <button onclick="closeModal('modalEditInstansi')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form id="formEditInstansi" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Unit / Instansi *</label>
                        <input type="text" id="editNamaInstansi" name="nama_instansi" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Unit</label>
                        <input type="text" id="editKodeUnit" name="kode_unit" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori *</label>
                        <select id="editKategori" name="kategori" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                            @foreach ($kategoriList as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Provinsi</label>
                        <select id="editProvinsi" name="provinsi_id" onchange="fetchKabupatenForEdit(this.value)" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach ($provinsis as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_provinsi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Kabupaten / Kota</label>
                        <select id="editKabupaten" name="kabupaten_id" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                            <option value="">-- Pilih Kabupaten --</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                        <input type="text" id="editTelepon" name="telepon" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                        <input type="email" id="editEmail" name="email" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Penanggung Jawab / Kepala Unit</label>
                        <input type="text" id="editPenanggungJawab" name="penanggung_jawab" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap</label>
                        <textarea id="editAlamat" name="alamat" rows="2" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"></textarea>
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalEditInstansi')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Perbarui Unit</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT INTERAKSI MODAL & DINAMIS KABUPATEN --}}
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function fetchKabupatenForTambah(provinsiId) {
            const kabSelect = document.getElementById('tambahKabupaten');
            kabSelect.innerHTML = '<option value="">Memuat data kabupaten...</option>';

            if (!provinsiId) {
                kabSelect.innerHTML = '<option value="">-- Pilih Provinsi Dulu --</option>';
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
                })
                .catch(() => {
                    kabSelect.innerHTML = '<option value="">Gagal memuat kabupaten</option>';
                });
        }

        function fetchKabupatenForEdit(provinsiId, selectedKabId = null) {
            const kabSelect = document.getElementById('editKabupaten');
            kabSelect.innerHTML = '<option value="">Memuat data kabupaten...</option>';

            if (!provinsiId) {
                kabSelect.innerHTML = '<option value="">-- Pilih Provinsi Dulu --</option>';
                return;
            }

            fetch('/kabupaten/' + provinsiId)
                .then(res => res.json())
                .then(data => {
                    let html = '<option value="">-- Pilih Kabupaten / Kota --</option>';
                    data.forEach(kab => {
                        const isSelected = selectedKabId && selectedKabId == kab.id ? 'selected' : '';
                        html += `<option value="${kab.id}" ${isSelected}>${kab.nama_kabupaten}</option>`;
                    });
                    kabSelect.innerHTML = html;
                })
                .catch(() => {
                    kabSelect.innerHTML = '<option value="">Gagal memuat kabupaten</option>';
                });
        }

        function editInstansi(item) {
            document.getElementById('formEditInstansi').action = '/instansi/' + item.id;
            document.getElementById('editNamaInstansi').value = item.nama_instansi;
            document.getElementById('editKodeUnit').value = item.kode_unit || '';
            document.getElementById('editKategori').value = item.kategori;
            document.getElementById('editProvinsi').value = item.provinsi_id || '';
            document.getElementById('editTelepon').value = item.telepon || '';
            document.getElementById('editEmail').value = item.email || '';
            document.getElementById('editPenanggungJawab').value = item.penanggung_jawab || '';
            document.getElementById('editAlamat').value = item.alamat || '';

            if (item.provinsi_id) {
                fetchKabupatenForEdit(item.provinsi_id, item.kabupaten_id);
            } else {
                document.getElementById('editKabupaten').innerHTML = '<option value="">-- Pilih Kabupaten --</option>';
            }

            openModal('modalEditInstansi');
        }

        // Tutup modal jika klik di luar box
        window.addEventListener('click', function(e) {
            const modals = ['modalTambahInstansi', 'modalEditInstansi'];
            modals.forEach(function(id) {
                const modal = document.getElementById(id);
                if (modal && e.target === modal) {
                    closeModal(id);
                }
            });
        });
    </script>
</body>
</html>
