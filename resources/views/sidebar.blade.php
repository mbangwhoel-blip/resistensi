<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap');

    .custom-sidebar,
    .custom-sidebar * {
        font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        box-sizing: border-box;
    }

    .custom-sidebar {
        width: 16rem;
        background-color: #0B3D3A;
        color: #f8fafc;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Scrollbar ramping */
    .custom-sidebar-nav::-webkit-scrollbar {
        width: 4px;
    }
    .custom-sidebar-nav::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-sidebar-nav::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.15);
        border-radius: 4px;
    }
    .custom-sidebar-nav::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.25);
    }

    /* Section Header */
    .nav-section-title {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.075em;
        text-transform: uppercase;
        color: #8dafa8;
        padding: 0 11px 5px 11px;
        display: flex;
        align-items: center;
        gap: 5px;
        user-select: none;
    }

    /* Menu Link (sedikit lebih lega & proporsional) */
    .nav-menu-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 8px 11px;
        border-radius: 9px;
        font-size: 13px;
        line-height: 1.35;
        text-decoration: none;
        transition: all 0.18s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    /* Inactive State */
    .nav-menu-link.inactive {
        color: #d1e2e0;
        font-weight: 500;
        background-color: transparent;
        border: 1px solid transparent;
    }

    .nav-menu-link.inactive:hover {
        color: #ffffff;
        background-color: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.08);
        transform: translateX(2px);
    }

    .nav-menu-link.inactive .nav-menu-icon {
        color: #8dafa8;
        transition: color 0.18s ease, transform 0.18s ease;
    }

    .nav-menu-link.inactive:hover .nav-menu-icon {
        color: #5eead4;
        transform: scale(1.06);
    }

    /* Active State */
    .nav-menu-link.active {
        color: #ffffff;
        font-weight: 600;
        background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
        border: 1px solid rgba(255, 255, 255, 0.22);
        box-shadow: 0 3px 12px rgba(20, 184, 166, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.25);
    }

    .nav-menu-link.active .nav-menu-icon {
        color: #ffffff;
    }

    /* Icon Container */
    .nav-menu-icon-box {
        width: 20px;
        height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .nav-menu-icon-box svg {
        width: 17px;
        height: 17px;
    }

    /* Active Pill Dot */
    .nav-active-dot {
        width: 5.5px;
        height: 5.5px;
        border-radius: 9999px;
        background-color: #ffffff;
        box-shadow: 0 0 6px rgba(255, 255, 255, 0.9);
        flex-shrink: 0;
    }
</style>

<aside class="custom-sidebar fixed inset-y-0 left-0 z-50 flex flex-col shadow-2xl">

    {{-- LOGO BRAND & APLIKASI --}}
    <div class="shrink-0 flex flex-col items-center justify-center border-b border-white/[0.08] px-3 py-3 bg-[#0B3D3A]/95 backdrop-blur-sm text-center">
        {{-- LOGO BADGE DARI FOLDER PUBLIC (UKURAN LEBIH BESAR AGAR TEKS JELAS TERBACA) --}}
        <div class="w-full flex items-center justify-center rounded-xl bg-white px-2.5 py-2 shadow-sm border border-white/90 transition hover:scale-[1.01]">
            <img src="{{ asset('logo_bblkl.png') }}" alt="Logo Kemenkes BBLKL" class="w-full h-auto max-h-[52px] object-contain">
        </div>
    </div>

    {{-- NAVIGASI MENU (LEBIH LEGA DAN TETAP FIT 1 LAYAR TANPA PERLU SCROLL) --}}
    @php
        $currentUser = Auth::user();
        $isAdmin = $currentUser && strtolower((string)$currentUser->role) === 'admin';
    @endphp
    <nav class="custom-sidebar-nav flex-1 overflow-y-auto px-3 pt-3 pb-4 space-y-3.5 text-xs">

        {{-- SEKSI 1: MENU UTAMA --}}
        <div>
            <div class="nav-section-title">
                Menu Utama
            </div>
            <div class="space-y-1">
                {{-- DASHBOARD --}}
                <a href="{{ route('dashboard') }}"
                   class="nav-menu-link {{ request()->routeIs('dashboard') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </span>
                        <span class="truncate">Dashboard</span>
                    </div>
                    @if(request()->routeIs('dashboard'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>

                {{-- INPUT DATA --}}
                <a href="{{ route('input') }}"
                   class="nav-menu-link {{ request()->routeIs('input') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </span>
                        <span class="truncate">Input Data</span>
                    </div>
                    @if(request()->routeIs('input'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>

                {{-- ANALISIS DATA (GRAFIK & STATISTIK) --}}
                <a href="{{ route('analisis.index') }}"
                   class="nav-menu-link {{ request()->routeIs('analisis.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </span>
                        <span class="truncate">Analisis Grafik</span>
                    </div>
                    @if(request()->routeIs('analisis.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>

                {{-- LAPORAN HASIL UJI --}}
                <a href="{{ route('laporan.index') }}"
                   class="nav-menu-link {{ request()->routeIs('laporan.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </span>
                        <span class="truncate">Laporan</span>
                    </div>
                    @if(request()->routeIs('laporan.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>
            </div>
        </div>

        {{-- SEKSI 2: DATA --}}
        <div>
            <div class="nav-section-title">
                Data
            </div>
            <div class="space-y-1">
                {{-- IMPORT DATA --}}
                <a href="{{ route('import.index') }}"
                   class="nav-menu-link {{ request()->routeIs('import.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V3"/>
                            </svg>
                        </span>
                        <span class="truncate">Import Data</span>
                    </div>
                    @if(request()->routeIs('import.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>

                {{-- EXPORT DATA --}}
                <a href="{{ route('export.index') }}"
                   class="nav-menu-link {{ request()->routeIs('export.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M17 10l-5-5m0 0L7 10m5-5v12"/>
                            </svg>
                        </span>
                        <span class="truncate">Export Data</span>
                    </div>
                    @if(request()->routeIs('export.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>
            </div>
        </div>

        {{-- SEKSI 3: MASTER DATA (HANYA DITAMPILKAN UNTUK ADMINISTRATOR) --}}
        @if ($isAdmin)
        <div>
            <div class="nav-section-title">
                Master Data
            </div>
            <div class="space-y-1">
                {{-- WILAYAH --}}
                <a href="{{ route('wilayah.index') }}"
                   class="nav-menu-link {{ request()->routeIs('wilayah.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                        <span class="truncate">Wilayah</span>
                    </div>
                    @if(request()->routeIs('wilayah.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>

                {{-- UNIT / INSTANSI --}}
                <a href="{{ route('instansi.index') }}"
                   class="nav-menu-link {{ request()->routeIs('instansi.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </span>
                        <span class="truncate">Unit / Instansi</span>
                    </div>
                    @if(request()->routeIs('instansi.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>

                {{-- KATEGORI PARAMETER --}}
                <a href="{{ route('kategori.index') }}"
                   class="nav-menu-link {{ request()->routeIs('kategori.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                        </span>
                        <span class="truncate">Kategori Parameter</span>
                    </div>
                    @if(request()->routeIs('kategori.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>
            </div>
        </div>
        @endif

        {{-- SEKSI 4: SISTEM --}}
        <div>
            <div class="nav-section-title">
                Sistem
            </div>
            <div class="space-y-1">
                {{-- KELOLA USER (KHUSUS ADMINISTRATOR) --}}
                @if ($isAdmin)
                <a href="{{ route('users.index') }}"
                   class="nav-menu-link {{ request()->routeIs('users.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                        <span class="truncate">Kelola User</span>
                    </div>
                    @if(request()->routeIs('users.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>
                @endif

                {{-- BACKUP & RESTORE (DITAMPILKAN UNTUK SEMUA USER) --}}
                <a href="{{ route('backup.index') }}"
                   class="nav-menu-link {{ request()->routeIs('backup.*') ? 'active' : 'inactive' }}">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="nav-menu-icon-box">
                            <svg class="nav-menu-icon" fill="none" stroke="currentColor" stroke-width="1.85" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </span>
                        <span class="truncate">Backup & Restore</span>
                    </div>
                    @if(request()->routeIs('backup.*'))
                        <span class="nav-active-dot"></span>
                    @endif
                </a>
            </div>
        </div>

    </nav>

</aside>