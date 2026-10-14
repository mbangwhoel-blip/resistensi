<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data Wilayah - PETA RESISTENSI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')
</head>

<body class="bg-slate-100 text-slate-800">

    {{-- SIDEBAR --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="min-h-screen transition-all duration-300 ml-0 lg:ml-64">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-40 flex items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8 py-3.5 gap-3 shadow-xs">
            <div class="min-w-0 flex items-center gap-3">
                <button type="button"
                        onclick="toggleSidebarDrawer()"
                        class="lg:hidden flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 text-slate-700 hover:bg-slate-100 hover:text-slate-900 transition shadow-2xs cursor-pointer focus:outline-none"
                        aria-label="Buka Menu Navigasi">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="min-w-0 flex flex-col justify-center">
                    <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug truncate">Master Data Wilayah</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5 truncate">
                        PETA RESISTENSI • Kelola master data Provinsi dan Kabupaten/Kota
                    </p>
                </div>
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
                        <span>Periksa kembali data yang dimasukkan:</span>
                    </div>
                    <ul class="list-inside list-disc text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SUMMARY CARDS & ACTION BUTTONS --}}
            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Provinsi</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalProvinsi }}</h3>
                        <p class="mt-1 text-xs text-slate-400">Provinsi di seluruh Indonesia</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Kabupaten / Kota</p>
                        <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalKabupaten }}</h3>
                        <p class="mt-1 text-xs text-slate-400">Tercatat dalam basis data</p>
                    </div>
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>

                <div class="flex flex-col justify-center gap-3 rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-indigo-50 p-6 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-blue-700">Aksi Cepat Tambah Data</p>
                    <div class="flex gap-2">
                        <button onclick="openModal('modalTambahKabupaten')" class="flex-1 cursor-pointer rounded-xl bg-blue-600 px-4 py-2.5 text-center text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">
                            + Tambah Kab/Kota
                        </button>
                        <button onclick="openModal('modalTambahProvinsi')" class="flex-1 cursor-pointer rounded-xl bg-white px-4 py-2.5 text-center text-sm font-semibold text-slate-700 shadow-sm border border-slate-200 transition hover:bg-slate-50">
                            + Tambah Provinsi
                        </button>
                    </div>
                </div>
            </div>

            {{-- TABS & TAB CONTENT --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                {{-- TAB NAVIGATION --}}
                <div class="flex border-b border-slate-200 bg-slate-50/70 px-6 pt-4">
                    <a href="{{ route('wilayah.index', ['tab' => 'kabupaten']) }}"
                       class="flex items-center gap-2 border-b-2 px-6 py-3 text-sm font-semibold transition {{ $tab === 'kabupaten' ? 'border-teal-600 text-teal-600 dark:border-teal-400 dark:text-teal-400 bg-white rounded-t-xl' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Daftar Kabupaten / Kota
                    </a>
                    <a href="{{ route('wilayah.index', ['tab' => 'provinsi']) }}"
                       class="flex items-center gap-2 border-b-2 px-6 py-3 text-sm font-semibold transition {{ $tab === 'provinsi' ? 'border-teal-600 text-teal-600 dark:border-teal-400 dark:text-teal-400 bg-white rounded-t-xl' : 'border-transparent text-slate-500 hover:text-slate-800' }}">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                        Daftar Provinsi
                    </a>
                </div>

                {{-- TAB: KABUPATEN --}}
                @if ($tab === 'kabupaten')
                    <div class="p-6">
                        {{-- FILTER & SEARCH BAR --}}
                        <form method="GET" action="{{ route('wilayah.index') }}" class="mb-6 flex flex-wrap items-center gap-4">
                            <input type="hidden" name="tab" value="kabupaten">
                            <div class="w-full md:w-64">
                                <label class="mb-1 block text-xs font-semibold text-slate-500">Filter Provinsi</label>
                                <select name="provinsi_id" onchange="this.form.submit()" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none">
                                    <option value="">Semua Provinsi</option>
                                    @foreach ($allProvinsis as $p)
                                        <option value="{{ $p->id }}" {{ $selectedProvinsiId == $p->id ? 'selected' : '' }}>
                                            {{ $p->nama_provinsi }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1 min-w-[200px]">
                                <label class="mb-1 block text-xs font-semibold text-slate-500">Cari Kabupaten / Kota</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama kabupaten..." class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none">
                                    <svg class="absolute left-3.5 top-2.5 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-end gap-2 pt-5">
                                <button type="submit" class="cursor-pointer rounded-xl bg-slate-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-900">
                                    Filter
                                </button>
                                @if ($search || $selectedProvinsiId)
                                    <a href="{{ route('wilayah.index', ['tab' => 'kabupaten']) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>

                        {{-- TABEL KABUPATEN --}}
                        <div class="overflow-x-auto rounded-xl border border-slate-200">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                                    <tr>
                                        <th class="px-6 py-4">No</th>
                                        <th class="px-6 py-4">Nama Kabupaten / Kota</th>
                                        <th class="px-6 py-4">Provinsi</th>
                                        <th class="px-6 py-4">Latitude</th>
                                        <th class="px-6 py-4">Longitude</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse ($kabupatens as $index => $kab)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="px-6 py-4 font-medium text-slate-400">
                                                {{ $kabupatens->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-slate-800">
                                                {{ $kab->nama_kabupaten }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center rounded-lg bg-teal-50 px-2.5 py-1 text-xs font-medium text-teal-700 dark:bg-teal-950/40 dark:text-teal-300">
                                                    {{ $kab->provinsi?->nama_provinsi ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-xs font-mono text-slate-500">
                                                {{ $kab->latitude ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-xs font-mono text-slate-500">
                                                {{ $kab->longitude ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button onclick="editKabupaten({{ json_encode($kab) }})" class="cursor-pointer rounded-lg p-1.5 text-blue-600 hover:bg-blue-50" title="Edit">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <form method="POST" action="{{ route('wilayah.kabupaten.destroy', $kab->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kabupaten {{ $kab->nama_kabupaten }}?')">
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
                                            <td colspan="6" class="px-6 py-8 text-center text-sm text-slate-400">
                                                Tidak ada data kabupaten / kota yang sesuai dengan pencarian.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- PAGINATION --}}
                        <div class="mt-6">
                            {{ $kabupatens->links() }}
                        </div>
                    </div>
                @endif

                {{-- TAB: PROVINSI --}}
                @if ($tab === 'provinsi')
                    <div class="p-6">
                        {{-- FILTER & SEARCH BAR PROVINSI --}}
                        <form method="GET" action="{{ route('wilayah.index') }}" class="mb-6 flex flex-wrap items-center gap-4">
                            <input type="hidden" name="tab" value="provinsi">
                            <div class="flex-1 min-w-[200px]">
                                <label class="mb-1 block text-xs font-semibold text-slate-500">Cari Provinsi</label>
                                <div class="relative">
                                    <input type="text" name="search" value="{{ $search }}" placeholder="Ketik nama provinsi..." class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none">
                                    <svg class="absolute left-3.5 top-2.5 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>

                            <div class="flex items-end gap-2 pt-5">
                                <button type="submit" class="cursor-pointer rounded-xl bg-slate-800 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-slate-900">
                                    Cari
                                </button>
                                @if ($search)
                                    <a href="{{ route('wilayah.index', ['tab' => 'provinsi']) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                                        Reset
                                    </a>
                                @endif
                            </div>
                        </form>

                        <div class="overflow-x-auto rounded-xl border border-slate-200">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                                    <tr>
                                        <th class="px-6 py-4 w-16">No</th>
                                        <th class="px-6 py-4">Nama Provinsi</th>
                                        <th class="px-6 py-4 text-center">Jumlah Kab/Kota</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200">
                                    @forelse ($provinsis as $index => $prov)
                                        <tr class="hover:bg-slate-50/80 transition">
                                            <td class="px-6 py-4 font-medium text-slate-400">
                                                {{ $provinsis->firstItem() + $index }}
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-slate-800">
                                                {{ $prov->nama_provinsi }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <a href="{{ route('wilayah.index', ['tab' => 'kabupaten', 'provinsi_id' => $prov->id]) }}" class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition">
                                                    {{ $prov->kabupatens_count }} Kabupaten / Kota
                                                </a>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <button onclick="editProvinsi({{ json_encode($prov) }})" class="cursor-pointer rounded-lg p-1.5 text-blue-600 hover:bg-blue-50" title="Edit">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </button>
                                                    <form method="POST" action="{{ route('wilayah.provinsi.destroy', $prov->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus provinsi {{ $prov->nama_provinsi }}?')">
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
                                            <td colspan="4" class="px-6 py-8 text-center text-sm text-slate-400">
                                                Belum ada data provinsi.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- PAGINATION PROVINSI --}}
                        <div class="mt-6">
                            {{ $provinsis->links() }}
                        </div>
                    </div>
                @endif
            </div>

        </section>
    </main>

    {{-- MODAL TAMBAH PROVINSI --}}
    <div id="modalTambahProvinsi" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Tambah Provinsi Baru</h3>
                <button onclick="closeModal('modalTambahProvinsi')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form action="{{ route('wilayah.provinsi.store') }}" method="POST" class="mt-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Provinsi *</label>
                    <input type="text" name="nama_provinsi" required placeholder="Contoh: JAWA TIMUR" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm uppercase focus:border-blue-500 focus:outline-none">
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('modalTambahProvinsi')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT PROVINSI --}}
    <div id="modalEditProvinsi" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Provinsi</h3>
                <button onclick="closeModal('modalEditProvinsi')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form id="formEditProvinsi" method="POST" class="mt-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Provinsi *</label>
                    <input type="text" id="editProvinsiNama" name="nama_provinsi" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm uppercase focus:border-blue-500 focus:outline-none">
                </div>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" onclick="closeModal('modalEditProvinsi')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL TAMBAH KABUPATEN --}}
    <div id="modalTambahKabupaten" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Tambah Kabupaten / Kota Baru</h3>
                <button onclick="closeModal('modalTambahKabupaten')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form action="{{ route('wilayah.kabupaten.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Provinsi *</label>
                    <select name="provinsi_id" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach ($allProvinsis as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_provinsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kabupaten / Kota *</label>
                    <input type="text" name="nama_kabupaten" required placeholder="Contoh: KOTA SURABAYA atau KAB. SIDOARJO" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm uppercase focus:border-blue-500 focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Latitude (Opsional)</label>
                        <input type="text" name="latitude" placeholder="-7.2575" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Longitude (Opsional)</label>
                        <input type="text" name="longitude" placeholder="112.7521" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:border-blue-500 focus:outline-none">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalTambahKabupaten')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT KABUPATEN --}}
    <div id="modalEditKabupaten" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Kabupaten / Kota</h3>
                <button onclick="closeModal('modalEditKabupaten')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form id="formEditKabupaten" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Provinsi *</label>
                    <select id="editKabupatenProvinsiId" name="provinsi_id" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                        @foreach ($allProvinsis as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_provinsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Kabupaten / Kota *</label>
                    <input type="text" id="editKabupatenNama" name="nama_kabupaten" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm uppercase focus:border-blue-500 focus:outline-none">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Latitude</label>
                        <input type="text" id="editKabupatenLat" name="latitude" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1">Longitude</label>
                        <input type="text" id="editKabupatenLng" name="longitude" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-mono focus:border-blue-500 focus:outline-none">
                    </div>
                </div>
                <div class="mt-6 flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalEditKabupaten')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT INTERAKSI MODAL --}}
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function editProvinsi(prov) {
            document.getElementById('formEditProvinsi').action = '/wilayah/provinsi/' + prov.id;
            document.getElementById('editProvinsiNama').value = prov.nama_provinsi;
            openModal('modalEditProvinsi');
        }

        function editKabupaten(kab) {
            document.getElementById('formEditKabupaten').action = '/wilayah/kabupaten/' + kab.id;
            document.getElementById('editKabupatenProvinsiId').value = kab.provinsi_id;
            document.getElementById('editKabupatenNama').value = kab.nama_kabupaten;
            document.getElementById('editKabupatenLat').value = kab.latitude || '';
            document.getElementById('editKabupatenLng').value = kab.longitude || '';
            openModal('modalEditKabupaten');
        }

        // Tutup modal jika klik di luar box
        window.addEventListener('click', function(e) {
            const modals = ['modalTambahProvinsi', 'modalEditProvinsi', 'modalTambahKabupaten', 'modalEditKabupaten'];
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
