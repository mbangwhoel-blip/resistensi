<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>Master Data Parameter Uji - SIMPEL BBLKL</title>
    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')
</head>

<body class="bg-slate-100 text-slate-800">

    {{-- SIDEBAR --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="ml-64 min-h-screen">

        {{-- TOPBAR DENGAN LOGOUT DI KANAN ATAS --}}
        <header class="sticky top-0 z-40 flex flex-col md:flex-row md:items-center justify-between border-b border-slate-200 bg-white px-6 lg:px-8 py-3.5 gap-3 shadow-xs">
            <div class="min-w-0 flex flex-col justify-center">
                <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug">Master Data Kategori & Parameter Uji</h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Kelola jenis nyamuk, insektisida, dan metode pengendalian vektor
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @include('header_profile')
            </div>
        </header>

        {{-- ISI HALAMAN --}}
        <section class="p-8">

            {{-- ALERT NOTIFIKASI SUCCESS --}}
            @if (session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-emerald-800 shadow-sm">
                    <svg class="h-6 w-6 shrink-0 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif

            {{-- ALERT NOTIFIKASI ERROR --}}
            @if (session('error'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-6 py-4 text-rose-800 shadow-sm">
                    <svg class="h-6 w-6 shrink-0 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
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
            <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-3">

                {{-- KARTU 1: JENIS NYAMUK --}}
                <a href="{{ route('kategori.index', ['tab' => 'nyamuk']) }}"
                   class="block rounded-2xl border bg-white p-6 shadow-sm transition hover:shadow-md {{ $tab == 'nyamuk' ? 'border-blue-500 ring-2 ring-blue-100' : 'border-slate-200' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Jenis Nyamuk</p>
                            <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalNyamuk }}</h3>
                            <p class="mt-1 text-xs text-blue-600 font-semibold">Spesies vektor terdaftar</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- KARTU 2: INSEKTISIDA --}}
                <a href="{{ route('kategori.index', ['tab' => 'insektisida']) }}"
                   class="block rounded-2xl border bg-white p-6 shadow-sm transition hover:shadow-md {{ $tab == 'insektisida' ? 'border-amber-500 ring-2 ring-amber-100' : 'border-slate-200' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Insektisida</p>
                            <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalInsektisida }}</h3>
                            <p class="mt-1 text-xs text-amber-600 font-semibold">Bahan aktif & formulasi</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                    </div>
                </a>

                {{-- KARTU 3: METODE PENGENDALIAN --}}
                <a href="{{ route('kategori.index', ['tab' => 'metode']) }}"
                   class="block rounded-2xl border bg-white p-6 shadow-sm transition hover:shadow-md {{ $tab == 'metode' ? 'border-emerald-500 ring-2 ring-emerald-100' : 'border-slate-200' }}">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-slate-500">Metode Pengendalian</p>
                            <h3 class="mt-2 text-3xl font-bold text-slate-800">{{ $totalMetode }}</h3>
                            <p class="mt-1 text-xs text-emerald-600 font-semibold">Bioassay & metode uji</p>
                        </div>
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                    </div>
                </a>

            </div>

            {{-- KONTEN UTAMA DENGAN TABEL & TAB --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                {{-- TAB NAVIGASI --}}
                <div class="flex border-b border-slate-200 mb-6 gap-2">
                    <a href="{{ route('kategori.index', ['tab' => 'nyamuk']) }}"
                       class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm font-semibold transition {{ $tab == 'nyamuk' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                        <span>🦟 Jenis Nyamuk</span>
                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $totalNyamuk }}</span>
                    </a>
                    <a href="{{ route('kategori.index', ['tab' => 'insektisida']) }}"
                       class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm font-semibold transition {{ $tab == 'insektisida' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                        <span>🧪 Insektisida</span>
                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $totalInsektisida }}</span>
                    </a>
                    <a href="{{ route('kategori.index', ['tab' => 'metode']) }}"
                       class="flex items-center gap-2 border-b-2 px-5 py-3 text-sm font-semibold transition {{ $tab == 'metode' ? 'border-blue-600 text-blue-600' : 'border-transparent text-slate-500 hover:text-slate-700' }}">
                        <span>🔬 Metode Pengendalian</span>
                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600">{{ $totalMetode }}</span>
                    </a>
                </div>

                {{-- TOOLBAR PENCARIAN & TOMBOL TAMBAH --}}
                <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" action="{{ route('kategori.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        <div class="w-full sm:w-72 relative">
                            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama parameter..." class="w-full rounded-xl border border-slate-200 bg-white pl-10 pr-4 py-2.5 text-sm text-slate-700 shadow-sm focus:border-blue-500 focus:outline-none">
                            <svg class="absolute left-3.5 top-3 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <button type="submit" class="cursor-pointer rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-900">
                            Cari
                        </button>

                        @if ($search)
                            <a href="{{ route('kategori.index', ['tab' => $tab]) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                                Reset
                            </a>
                        @endif
                    </form>

                    <button onclick="openModalTambah('{{ $tab }}')" class="cursor-pointer rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 flex items-center gap-2">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>
                            @if ($tab == 'nyamuk') Tambah Jenis Nyamuk
                            @elseif ($tab == 'insektisida') Tambah Insektisida
                            @else Tambah Metode Pengendalian
                            @endif
                        </span>
                    </button>
                </div>

                {{-- TABEL DATA PARAMETER --}}
                <div class="overflow-x-auto rounded-xl border border-slate-200">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs uppercase font-semibold text-slate-500">
                            <tr>
                                <th class="px-6 py-4 w-16">No</th>
                                <th class="px-6 py-4">Nama Parameter</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Keterangan / Deskripsi</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center w-32">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @forelse ($items as $index => $item)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-medium text-slate-400">
                                        {{ $items->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-slate-800">
                                        {{ $item->nama }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeColor = match($item->kategori) {
                                                'nyamuk' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'insektisida' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'metode' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                default => 'bg-slate-50 text-slate-700 border-slate-200',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center rounded-lg border px-2.5 py-1 text-xs font-semibold {{ $badgeColor }}">
                                            {{ $item->kategori_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-600">
                                        {{ $item->keterangan ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($item->is_active)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-700 border border-emerald-200">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500 border border-slate-200">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="button"
                                                    onclick="openModalEdit({{ json_encode($item) }})"
                                                    class="rounded-lg border border-slate-200 p-1.5 text-slate-600 hover:bg-slate-100 hover:text-blue-600 transition"
                                                    title="Edit Parameter">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data \'{{ $item->nama }}\'?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="rounded-lg border border-slate-200 p-1.5 text-slate-600 hover:bg-rose-50 hover:text-rose-600 transition"
                                                        title="Hapus Parameter">
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
                                    <td colspan="6" class="px-6 py-12 text-center text-sm text-slate-400">
                                        Belum ada data parameter pada kategori ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($items->hasPages() || $items->total() > 0)
                    <div class="mt-6">
                        {{ $items->links() }}
                    </div>
                @endif

            </div>

        </section>

    </main>

    {{-- MODAL TAMBAH PARAMETER --}}
    <div id="modalTambah" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800" id="modalTambahTitle">Tambah Parameter Baru</h3>
                <button onclick="closeModal('modalTambah')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Parameter *</label>
                    <select id="tambahKategoriSelect" name="kategori" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="nyamuk" {{ $tab == 'nyamuk' ? 'selected' : '' }}>Jenis Nyamuk</option>
                        <option value="insektisida" {{ $tab == 'insektisida' ? 'selected' : '' }}>Insektisida</option>
                        <option value="metode" {{ $tab == 'metode' ? 'selected' : '' }}>Metode Pengendalian</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Parameter *</label>
                    <input type="text" name="nama" required placeholder="Contoh: Ae. aegypti atau Malathion..." class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Keterangan / Deskripsi</label>
                    <textarea name="keterangan" rows="3" placeholder="Deskripsi atau catatan singkat..." class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"></textarea>
                </div>
                <div class="mt-6 flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalTambah')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Simpan Parameter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL EDIT PARAMETER --}}
    <div id="modalEdit" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Data Parameter</h3>
                <button onclick="closeModal('modalEdit')" class="text-slate-400 hover:text-slate-600">✕</button>
            </div>
            <form id="formEditParameter" method="POST" class="mt-4 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kategori Parameter *</label>
                    <select id="editKategoriSelect" name="kategori" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                        <option value="nyamuk">Jenis Nyamuk</option>
                        <option value="insektisida">Insektisida</option>
                        <option value="metode">Metode Pengendalian</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Parameter *</label>
                    <input type="text" id="editNama" name="nama" required class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Keterangan / Deskripsi</label>
                    <textarea id="editKeterangan" name="keterangan" rows="3" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-blue-500 focus:outline-none"></textarea>
                </div>
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="editIsActive" name="is_active" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <label for="editIsActive" class="text-sm font-medium text-slate-700">Status Aktif (Tampil di formulir uji laboratorium)</label>
                </div>
                <div class="mt-6 flex justify-end gap-3 pt-2">
                    <button type="button" onclick="closeModal('modalEdit')" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">Batal</button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">Perbarui Parameter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT MODAL --}}
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }

        function openModalTambah(tab) {
            const select = document.getElementById('tambahKategoriSelect');
            if (select) {
                select.value = tab;
            }
            openModal('modalTambah');
        }

        function openModalEdit(item) {
            const form = document.getElementById('formEditParameter');
            form.action = `/kategori/${item.id}`;

            document.getElementById('editKategoriSelect').value = item.kategori;
            document.getElementById('editNama').value = item.nama;
            document.getElementById('editKeterangan').value = item.keterangan || '';
            document.getElementById('editIsActive').checked = item.is_active ? true : false;

            openModal('modalEdit');
        }
    </script>

</body>

</html>
