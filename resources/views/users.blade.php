<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna - SIMPEL BBLKL</title>

    {{-- INISIALISASI & GAYA GLOBAL DARK MODE --}}
    @include('dark_mode_head')

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body, input, button, select, textarea {
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-800">

    {{-- SIDEBAR --}}
    @include('sidebar')

    {{-- KONTEN UTAMA --}}
    <main class="ml-64 min-h-screen pb-16">

        {{-- TOPBAR --}}
        <header class="sticky top-0 z-40 flex flex-col md:flex-row md:items-center justify-between border-b border-slate-200 bg-white px-6 lg:px-8 py-3.5 gap-3 shadow-xs">
            <div class="min-w-0 flex flex-col justify-center">
                <h1 class="text-base sm:text-lg lg:text-xl font-black text-slate-800 tracking-tight leading-snug">
                    Kelola Pengguna & Hak Akses
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-1">
                    Manajemen akun administrator, petugas laboratorium, dan hak akses sistem
                </p>
            </div>

            <div class="flex items-center gap-3 shrink-0">
                @include('header_profile')
            </div>
        </header>

        <div class="p-8 space-y-6">

            {{-- NOTIFIKASI SUKSES / ERROR --}}
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800 shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="text-lg">✅</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 text-xs font-bold cursor-pointer">✕</button>
                </div>
            @endif

            @if (session('error'))
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-sm font-semibold text-rose-800 shadow-xs flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <span class="text-lg">⚠️</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 text-xs font-bold cursor-pointer">✕</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl border border-rose-200 bg-rose-50 p-4 text-xs font-semibold text-rose-800 shadow-xs">
                    <p class="font-bold mb-1">Terdapat kesalahan pengisian data:</p>
                    <ul class="list-disc pl-5 space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- KARTU STATISTIK RINGKAS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                {{-- TOTAL PENGGUNA --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengguna</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-slate-800">{{ $stats['total'] }}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Terdaftar dalam sistem</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 border border-blue-100 text-xl">
                        👥
                    </div>
                </div>

                {{-- ADMINISTRATOR --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Administrator</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-blue-700">{{ $stats['admin'] }}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Hak akses penuh admin</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 border border-indigo-100 text-xl">
                        🛡️
                    </div>
                </div>

                {{-- PETUGAS LAB --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Petugas Lab</p>
                        <h3 class="mt-1 text-2xl font-extrabold text-emerald-700">{{ $stats['petugas'] }}</h3>
                        <p class="text-[11px] text-slate-400 mt-0.5">Input & kelola data uji</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 text-xl">
                        🔬
                    </div>
                </div>

                {{-- STATUS AKTIF --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-xs flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Status Aktif</p>
                        <div class="mt-1 flex items-baseline gap-2">
                            <h3 class="text-2xl font-extrabold text-emerald-600">{{ $stats['aktif'] }}</h3>
                            <span class="text-xs text-slate-400">/ {{ $stats['nonaktif'] }} nonaktif</span>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-0.5">Dapat login ke sistem</p>
                    </div>
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 border border-emerald-100 text-xl">
                        ✨
                    </div>
                </div>
            </div>

            {{-- TOOLBAR PENCARIAN, FILTER, DAN TOMBOL TAMBAH --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-4 sm:p-5 shadow-xs">
                <form action="{{ route('users.index') }}" method="GET" class="flex flex-col lg:flex-row lg:items-center justify-between gap-3">

                    <div class="flex flex-wrap items-center gap-2.5 flex-1 min-w-0">
                        {{-- KOTAK PENCARIAN --}}
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <input type="text"
                                   name="search"
                                   value="{{ $search }}"
                                   placeholder="Cari nama, username, email..."
                                   class="h-9 w-full rounded-xl border border-slate-200 bg-slate-50 pl-10 pr-3.5 text-xs text-slate-700 transition focus:border-blue-500 focus:bg-white focus:outline-none shadow-2xs">
                        </div>

                        {{-- KONTROL TAMPIL DATA (PAGE SIZE SELECTOR) --}}
                        <div class="h-9 inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-slate-50/80 px-2.5 shadow-2xs shrink-0">
                            <label for="tablePageSizeSelect" class="text-xs font-semibold text-slate-600 whitespace-nowrap flex items-center gap-1 cursor-pointer">
                                <svg class="h-3.5 w-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                                <span>Tampil:</span>
                            </label>
                            <select id="tablePageSizeSelect" 
                                    name="per_page"
                                    onchange="this.form.submit()" 
                                    class="rounded border border-slate-200 bg-white px-2 py-0.5 text-xs font-bold text-slate-700 shadow-2xs focus:border-blue-500 focus:outline-none cursor-pointer">
                                <option value="5" {{ (string)($perPageRaw ?? $perPage) === '5' ? 'selected' : '' }}>5 data</option>
                                <option value="10" {{ (string)($perPageRaw ?? $perPage) === '10' ? 'selected' : '' }}>10 data</option>
                                <option value="25" {{ (string)($perPageRaw ?? $perPage) === '25' ? 'selected' : '' }}>25 data</option>
                                <option value="50" {{ (string)($perPageRaw ?? $perPage) === '50' ? 'selected' : '' }}>50 data</option>
                                <option value="100" {{ (string)($perPageRaw ?? $perPage) === '100' ? 'selected' : '' }}>100 data</option>
                                <option value="all" {{ (string)($perPageRaw ?? $perPage) === 'all' ? 'selected' : '' }}>Semua data</option>
                            </select>
                        </div>

                        {{-- FILTER ROLE --}}
                        <select name="role" onchange="this.form.submit()" class="h-9 rounded-xl border border-slate-200 bg-slate-50 px-3 text-xs font-medium text-slate-700 focus:border-blue-500 focus:bg-white focus:outline-none cursor-pointer shadow-2xs shrink-0">
                            <option value="Semua" {{ $roleFilter === 'Semua' ? 'selected' : '' }}>Semua Role</option>
                            <option value="admin" {{ $roleFilter === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="petugas" {{ $roleFilter === 'petugas' ? 'selected' : '' }}>Petugas Lab</option>
                            <option value="dinas_kesehatan" {{ $roleFilter === 'dinas_kesehatan' ? 'selected' : '' }}>Dinas Kesehatan</option>
                            <option value="balai_kekarantinaan_kesehatan" {{ $roleFilter === 'balai_kekarantinaan_kesehatan' ? 'selected' : '' }}>Balai Kekarantinaan Kesehatan</option>
                            <option value="labkesmas" {{ $roleFilter === 'labkesmas' ? 'selected' : '' }}>Labkesmas</option>
                            <option value="viewer" {{ $roleFilter === 'viewer' ? 'selected' : '' }}>Viewer (Lihat Saja)</option>
                        </select>

                        @if ($search || $roleFilter !== 'Semua')
                            <a href="{{ route('users.index') }}" class="h-9 inline-flex items-center rounded-xl border border-slate-200 bg-white px-3 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition shadow-2xs shrink-0">
                                Reset Filter
                            </a>
                        @endif
                    </div>

                    {{-- TOMBOL TAMBAH USER --}}
                    <div class="shrink-0">
                        <button type="button"
                                onclick="openAddModal()"
                                class="h-9 inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 text-xs font-bold text-white shadow-md shadow-blue-500/25 transition hover:from-blue-500 hover:to-indigo-500 cursor-pointer whitespace-nowrap">
                            <span class="text-sm font-bold">+</span>
                            <span>Tambah Pengguna Baru</span>
                        </button>
                    </div>

                </form>
            </div>

            {{-- TABEL PENGGUNA --}}
            <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
                <div class="overflow-x-auto bg-slate-50">
                    <table class="w-full text-left text-xs table-fixed border-collapse">
                        <thead class="bg-slate-900 text-white uppercase text-[11px] font-bold tracking-wider border-b border-slate-800">
                            <tr>
                                <th class="w-[4%] px-1.5 py-2.5 text-center">No</th>
                                <th class="w-[26%] px-2.5 py-2.5">Nama & Username</th>
                                <th class="w-[20%] px-2.5 py-2.5">Email & Telepon</th>
                                <th class="w-[14%] px-2 py-2.5 text-center whitespace-nowrap">Role / Hak Akses</th>
                                <th class="w-[8%] px-1.5 py-2.5 text-center whitespace-nowrap">Status</th>
                                <th class="w-[12%] px-2 py-2.5 text-center whitespace-nowrap">Aktivitas Terakhir</th>
                                <th class="w-[16%] px-2 py-2.5 text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($users as $index => $u)
                                <tr class="hover:bg-blue-50/40 transition align-top">
                                    <td class="px-1.5 py-2.5 text-center font-bold text-slate-400 text-xs whitespace-nowrap">
                                        {{ $users->firstItem() + $index }}
                                    </td>

                                    {{-- NAMA & USERNAME --}}
                                    <td class="px-2.5 py-2.5 text-xs">
                                        <div class="flex items-start gap-2.5">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700 font-extrabold text-xs border border-blue-200 mt-0.5">
                                                {{ strtoupper(substr($u->name, 0, 1)) }}
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <div class="font-bold text-slate-800 dark:text-slate-100 flex flex-wrap items-center gap-1.5 leading-snug break-words">
                                                    <span>{{ $u->name }}</span>
                                                    @if (Auth::id() === $u->id)
                                                        <span class="rounded bg-emerald-100 px-1 py-0.5 text-[9px] font-bold text-emerald-700 border border-emerald-200 shrink-0">
                                                            Anda
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="text-[11px] font-mono text-slate-500 dark:text-slate-400 break-words mt-0.5">
                                                    @<span>{{ $u->username ?? '-' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- EMAIL & TELEPON --}}
                                    <td class="px-2.5 py-2.5 text-xs">
                                        <div class="text-slate-700 dark:text-slate-200 font-medium break-words leading-snug">{{ $u->email }}</div>
                                        @if ($u->telepon)
                                            <div class="text-[11px] text-slate-400 dark:text-slate-400 mt-0.5 break-words">📞 {{ $u->telepon }}</div>
                                        @endif
                                    </td>

                                    {{-- ROLE --}}
                                    <td class="px-2 py-2.5 text-center whitespace-nowrap">
                                        @if ($u->role === 'admin')
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-teal-50 border border-teal-200 dark:bg-teal-950/40 dark:border-teal-800 dark:text-teal-300 px-2 py-0.5 text-[11px] font-bold text-teal-700">
                                                <span>🛡️</span>
                                                <span>Administrator</span>
                                            </span>
                                        @elseif ($u->role === 'petugas')
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[11px] font-bold text-emerald-700">
                                                <span>🔬</span>
                                                <span>Petugas Lab</span>
                                            </span>
                                        @elseif ($u->role === 'dinas_kesehatan' || $u->role === 'dinkes')
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-teal-50 border border-teal-200 px-2 py-0.5 text-[11px] font-bold text-teal-700">
                                                <span>🏥</span>
                                                <span>Dinas Kesehatan</span>
                                            </span>
                                        @elseif ($u->role === 'balai_kekarantinaan_kesehatan' || $u->role === 'bkk' || $u->role === 'balai_karantina')
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-amber-50 border border-amber-200 px-2 py-0.5 text-[11px] font-bold text-amber-700">
                                                <span>🚢</span>
                                                <span>Balai Kekarantinaan</span>
                                            </span>
                                        @elseif ($u->role === 'labkesmas')
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-cyan-50 border border-cyan-200 px-2 py-0.5 text-[11px] font-bold text-cyan-700">
                                                <span>🧪</span>
                                                <span>Labkesmas</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-lg bg-purple-50 border border-purple-200 px-2 py-0.5 text-[11px] font-bold text-purple-700">
                                                <span>👁️</span>
                                                <span>Viewer</span>
                                            </span>
                                        @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-1.5 py-2.5 text-center whitespace-nowrap">
                                        @if ($u->status === 'aktif')
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[11px] font-bold text-emerald-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                <span>Aktif</span>
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 border border-rose-200 px-2 py-0.5 text-[11px] font-bold text-rose-700">
                                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                                <span>Nonaktif</span>
                                            </span>
                                        @endif
                                    </td>

                                    {{-- AKTIVITAS TERAKHIR --}}
                                    <td class="px-2 py-2.5 text-center text-xs whitespace-nowrap">
                                        @if ($u->last_login_at)
                                            <div class="font-medium text-slate-700 dark:text-slate-200 text-[11px] leading-tight">{{ $u->last_login_at->diffForHumans() }}</div>
                                            <div class="text-[10px] text-slate-400 font-mono leading-tight mt-0.5">IP: {{ $u->last_login_ip ?? '-' }}</div>
                                        @else
                                            <span class="italic text-slate-400 text-[11px]">Belum pernah login</span>
                                        @endif
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-2 py-2.5 text-center whitespace-nowrap">
                                        <div class="inline-flex items-center justify-center gap-1">
                                            {{-- EDIT --}}
                                            <button type="button"
                                                    onclick="openEditModal({{ json_encode($u) }})"
                                                    class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2 py-1 text-[11px] font-bold text-slate-700 hover:border-blue-500 hover:text-blue-600 transition shadow-2xs cursor-pointer"
                                                    title="Edit akun pengguna">
                                                <span>✏️</span>
                                                <span>Edit</span>
                                            </button>

                                            {{-- HAPUS --}}
                                            @if (Auth::id() !== $u->id)
                                                <form action="{{ route('users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $u->name }}?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1 rounded-lg border border-rose-200 bg-rose-50 px-2 py-1 text-[11px] font-bold text-rose-600 hover:bg-rose-600 hover:text-white transition shadow-2xs cursor-pointer"
                                                            title="Hapus akun pengguna">
                                                        <span>🗑️</span>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="rounded-lg bg-slate-100 px-2 py-1 text-[11px] text-slate-400 italic">
                                                    Terkunci
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-12 text-center text-slate-400">
                                        <div class="text-3xl mb-2">🔍</div>
                                        <p class="font-semibold">Tidak ada data pengguna yang sesuai.</p>
                                        <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian atau filter yang berbeda.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if ($users->hasPages() || $users->total() > 0)
                    <div class="border-t border-slate-100 bg-white px-4 py-2.5">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

            {{-- INFORMASI KEAMANAN SISTEM --}}
            <div class="rounded-2xl border border-blue-200 dark:border-blue-900/60 bg-gradient-to-r from-blue-50/80 to-indigo-50/80 dark:from-slate-900/90 dark:to-slate-900/90 dark:bg-slate-900 p-5 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-3.5">
                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-xl shadow-md shadow-blue-500/25">
                        🛡️
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 dark:text-white">Keamanan Akses SIMPEL BBLKL</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-0.5">
                            Password akun dienkripsi menggunakan algoritma Bcrypt. Sistem dilindungi oleh proteksi Brute Force, Session Fixation, CSRF, dan HTTP Security Headers.
                        </p>
                    </div>
                </div>
            </div>

        </div>

    </main>

    {{-- ======================================================== --}}
    {{-- MODAL TAMBAH PENGGUNA BARU                               --}}
    {{-- ======================================================== --}}
    <div id="addModal" class="fixed inset-y-0 inset-x-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-sm">
                        +
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Tambah Pengguna Baru</h3>
                </div>
                <button type="button" onclick="closeAddModal()" class="text-slate-400 hover:text-slate-600 text-lg font-bold cursor-pointer">✕</button>
            </div>

            <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                    <input type="text" name="name" required placeholder="Contoh: dr. Ahmad Fauzi, M.Kes" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username *</label>
                        <input type="text" name="username" required placeholder="ahmad_fauzi" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Telepon / WA</label>
                        <input type="text" name="telepon" placeholder="081234567890" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email *</label>
                    <input type="email" name="email" required placeholder="ahmad@bblkl.go.id" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Role / Hak Akses *</label>
                        <select name="role" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none bg-white">
                            <option value="petugas">Petugas Laboratorium</option>
                            <option value="admin">Administrator</option>
                            <option value="dinas_kesehatan">Dinas Kesehatan</option>
                            <option value="balai_kekarantinaan_kesehatan">Balai Kekarantinaan Kesehatan</option>
                            <option value="labkesmas">Labkesmas</option>
                            <option value="viewer">Viewer (Lihat Saja)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Akun *</label>
                        <select name="status" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none bg-white">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Password *</label>
                        <div class="relative">
                            <input type="password" id="addPassword" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full rounded-xl border border-slate-300 pl-3.5 pr-10 py-2 text-sm focus:border-blue-500 focus:outline-none">
                            <button type="button" onclick="togglePasswordInput('addPassword', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition cursor-pointer" title="Lihat/Sembunyikan password">
                                <svg class="h-4.5 w-4.5 icon-eye" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="h-4.5 w-4.5 icon-eye-slash hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Konfirmasi Password *</label>
                        <div class="relative">
                            <input type="password" id="addPasswordConfirm" name="password_confirmation" required minlength="6" placeholder="Ulangi password" class="w-full rounded-xl border border-slate-300 pl-3.5 pr-10 py-2 text-sm focus:border-blue-500 focus:outline-none">
                            <button type="button" onclick="togglePasswordInput('addPasswordConfirm', this)" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition cursor-pointer" title="Lihat/Sembunyikan password">
                                <svg class="h-4.5 w-4.5 icon-eye" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="h-4.5 w-4.5 icon-eye-slash hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeAddModal()" class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-blue-600 px-5 py-2 text-xs font-bold text-white shadow-md shadow-blue-500/25 hover:bg-blue-700 cursor-pointer">
                        Simpan Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ======================================================== --}}
    {{-- MODAL EDIT PENGGUNA                                      --}}
    {{-- ======================================================== --}}
    <div id="editModal" class="fixed inset-y-0 inset-x-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
        <div class="w-full max-w-lg rounded-2xl bg-white shadow-2xl border border-slate-200 overflow-hidden my-8">
            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50">
                <div class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-600 text-white font-bold text-sm">
                        ✏️
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Edit Data Pengguna</h3>
                </div>
                <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600 text-lg font-bold cursor-pointer">✕</button>
            </div>

            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Lengkap *</label>
                    <input type="text" id="editName" name="name" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Username *</label>
                        <input type="text" id="editUsername" name="username" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nomor Telepon / WA</label>
                        <input type="text" id="editTelepon" name="telepon" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Alamat Email *</label>
                    <input type="email" id="editEmail" name="email" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Role / Hak Akses *</label>
                        <select id="editRole" name="role" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none bg-white">
                            <option value="petugas">Petugas Laboratorium</option>
                            <option value="admin">Administrator</option>
                            <option value="dinas_kesehatan">Dinas Kesehatan</option>
                            <option value="balai_kekarantinaan_kesehatan">Balai Kekarantinaan Kesehatan</option>
                            <option value="labkesmas">Labkesmas</option>
                            <option value="viewer">Viewer (Lihat Saja)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Status Akun *</label>
                        <select id="editStatus" name="status" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:border-blue-500 focus:outline-none bg-white">
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200">
                    <p class="text-xs font-bold text-slate-700 mb-2">Ganti Password (Opsional)</p>
                    <p class="text-[11px] text-slate-400 mb-3">Biarkan kosong jika tidak ingin mengubah password lama pengguna.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="relative">
                            <input type="password" id="editPassword" name="password" minlength="6" placeholder="Password baru" class="w-full rounded-lg border border-slate-300 bg-white pl-3 pr-9 py-1.5 text-xs focus:border-blue-500 focus:outline-none">
                            <button type="button" onclick="togglePasswordInput('editPassword', this)" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-slate-600 transition cursor-pointer" title="Lihat/Sembunyikan password">
                                <svg class="h-4 w-4 icon-eye" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="h-4 w-4 icon-eye-slash hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative">
                            <input type="password" id="editPasswordConfirm" name="password_confirmation" minlength="6" placeholder="Ulangi password baru" class="w-full rounded-lg border border-slate-300 bg-white pl-3 pr-9 py-1.5 text-xs focus:border-blue-500 focus:outline-none">
                            <button type="button" onclick="togglePasswordInput('editPasswordConfirm', this)" class="absolute inset-y-0 right-0 flex items-center pr-2.5 text-slate-400 hover:text-slate-600 transition cursor-pointer" title="Lihat/Sembunyikan password">
                                <svg class="h-4 w-4 icon-eye" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg class="h-4 w-4 icon-eye-slash hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()" class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2 text-xs font-bold text-white shadow-md shadow-indigo-500/25 hover:bg-indigo-700 cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(user) {
            document.getElementById('editForm').action = '/users/' + user.id;
            document.getElementById('editName').value = user.name || '';
            document.getElementById('editUsername').value = user.username || '';
            document.getElementById('editEmail').value = user.email || '';
            document.getElementById('editTelepon').value = user.telepon || '';
            let userRole = user.role || 'petugas';
            if (userRole === 'dinkes') userRole = 'dinas_kesehatan';
            if (userRole === 'bkk' || userRole === 'balai_karantina') userRole = 'balai_kekarantinaan_kesehatan';
            document.getElementById('editRole').value = userRole;
            document.getElementById('editStatus').value = user.status || 'aktif';

            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function togglePasswordInput(inputId, btnEl) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';

            const iconEye = btnEl.querySelector('.icon-eye');
            const iconEyeSlash = btnEl.querySelector('.icon-eye-slash');
            if (iconEye && iconEyeSlash) {
                if (isPass) {
                    iconEye.classList.add('hidden');
                    iconEyeSlash.classList.remove('hidden');
                } else {
                    iconEye.classList.remove('hidden');
                    iconEyeSlash.classList.add('hidden');
                }
            }
        }

        // Close on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
            }
        });
    </script>

</body>

</html>
