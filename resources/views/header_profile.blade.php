{{-- KOMPONEN PROFIL & LOGOUT TERPADU DENGAN TOMBOL CEPAT TEMA --}}
{{-- TOMBOL CEPAT MODE GELAP / TERANG --}}
<button type="button"
        id="themeToggleBtn"
        onclick="toggleTheme()"
        class="flex items-center gap-2 rounded-2xl border border-slate-200 bg-white p-1.5 px-3 shadow-2xs hover:border-blue-400 hover:bg-slate-50 transition cursor-pointer select-none focus:outline-none focus:ring-2 focus:ring-blue-100"
        title="Ganti Mode Gelap / Terang">
    <div class="relative flex h-5 w-9 items-center rounded-full bg-amber-100 border border-amber-300/80 p-0.5 transition-colors duration-300" id="themeSwitchTrack">
        <div class="flex h-4 w-4 transform items-center justify-center rounded-full bg-white shadow-xs transition-transform duration-300 translate-x-0" id="themeSwitchThumb">
            <svg id="themeThumbIcon" class="h-2.5 w-2.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>
            </svg>
        </div>
    </div>
    <span id="themeToggleText" class="hidden sm:inline text-xs font-bold text-slate-700">Mode Terang</span>
</button>

<div class="relative inline-block text-left" id="userMenuDropdown">

    {{-- TOMBOL UTAMA PROFIL (SATU ELEMEN TERPADU) --}}
    <button type="button"
            onclick="toggleUserDropdown(event)"
            class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-1.5 pl-2.5 pr-3 shadow-2xs hover:border-blue-400 hover:bg-slate-50 transition cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-100"
            id="userDropdownBtn"
            aria-expanded="false"
            aria-haspopup="true"
            title="Menu Akun Pengguna">
        
        {{-- AVATAR DENGAN INISIAL --}}
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-tr {{ Auth::check() && Auth::user()->role === 'admin' ? 'from-blue-700 to-blue-500 ring-blue-100' : (Auth::check() ? 'from-emerald-700 to-emerald-500 ring-emerald-100' : 'from-slate-600 to-slate-400 ring-slate-100') }} font-extrabold text-white text-sm shadow-xs ring-2">
            {{ Auth::check() ? strtoupper(substr(Auth::user()->name, 0, 1)) : '?' }}
        </div>

        {{-- NAMA, ROLE & TANGGAL (HARI DAN TANGGAL DI BAWAH TULISAN ADMINISTRATOR) --}}
        <div class="hidden sm:block text-left">
            <p class="text-xs font-bold text-slate-800 leading-tight">
                {{ Auth::check() ? Auth::user()->name : 'Tamu (Belum Login)' }}
            </p>
            <p class="text-[10px] {{ Auth::check() && Auth::user()->role === 'admin' ? 'text-blue-600 font-bold' : (Auth::check() ? 'text-emerald-600 font-bold' : 'text-slate-400 font-medium') }} capitalize leading-tight mt-0.5">
                {{ Auth::check() ? (Auth::user()->role === 'admin' ? 'Administrator' : 'Petugas Lab') : 'Klik untuk Masuk' }}
            </p>
            <p class="text-[10px] font-semibold text-slate-500 flex items-center gap-1 mt-0.5 leading-tight">
                <svg class="h-2.5 w-2.5 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
            </p>
        </div>

        {{-- PANAH CHEVRON --}}
        <svg id="userDropdownChevron" class="h-4 w-4 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    {{-- MENU DROPDOWN KETIKA DIKLIK --}}
    <div id="userDropdownMenu"
         class="absolute right-0 mt-2 w-64 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl shadow-slate-900/10 hidden z-50 transition-all duration-150">
        
        {{-- HEADER INFO DI DALAM DROPDOWN --}}
        <div class="px-3 py-2.5 border-b border-slate-100 mb-1.5 bg-slate-50/60 rounded-xl">
            <p class="text-xs font-bold text-slate-800 truncate">
                {{ Auth::check() ? Auth::user()->name : 'Tamu (Belum Login)' }}
            </p>
            <p class="text-[11px] text-slate-500 truncate mt-0.5">
                {{ Auth::check() ? Auth::user()->email : 'Belum masuk ke sistem' }}
            </p>
            <div class="mt-1.5 flex items-center gap-1.5">
                @if (Auth::check())
                    <span class="inline-flex items-center gap-1 rounded {{ Auth::user()->role === 'admin' ? 'bg-blue-100 text-blue-700 border-blue-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200' }} px-1.5 py-0.5 text-[9px] font-bold border uppercase">
                        {{ Auth::user()->role === 'admin' ? '🛡️ Administrator' : '🔬 Petugas Lab' }}
                    </span>
                    <span class="inline-flex items-center gap-1 rounded bg-emerald-50 px-1.5 py-0.5 text-[9px] font-bold text-emerald-700 border border-emerald-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Aktif
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 rounded bg-slate-100 px-1.5 py-0.5 text-[9px] font-bold text-slate-600 border border-slate-200">
                        🔒 Belum Login
                    </span>
                @endif
            </div>
        </div>
        
        {{-- OPSI GANTI TEMA GELAP / TERANG DI DALAM DROPDOWN --}}
        <div class="px-1 py-1 mb-1 border-b border-slate-100">
            <button type="button"
                    onclick="toggleTheme()"
                    class="w-full flex items-center justify-between rounded-xl px-2.5 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100 transition cursor-pointer select-none"
                    id="dropdownThemeToggle">
                <span class="flex items-center gap-2">
                    <span id="dropdownThemeIcon">☀️</span>
                    <span id="dropdownThemeLabel">Mode Terang</span>
                </span>
                <span class="text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-700 border border-amber-300" id="dropdownThemeBadge">Aktif</span>
            </button>
        </div>

        @if (Auth::check())
            {{-- TOMBOL LOGOUT TERPADU --}}
            <a href="{{ route('logout') }}"
               onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem SIMPEL BBLKL?')"
               class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span>Keluar (Logout)</span>
            </a>
        @else
            {{-- TOMBOL LOGIN --}}
            <a href="{{ route('login') }}"
               class="flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-bold text-blue-600 hover:bg-blue-50 hover:text-blue-700 transition cursor-pointer">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                <span>Masuk (Login Akun)</span>
            </a>
        @endif
    </div>

</div>

<script>
    if (typeof window.initUserDropdown !== 'function') {
        window.initUserDropdown = function() {
            window.toggleUserDropdown = function(event) {
                event.stopPropagation();
                const menu = document.getElementById('userDropdownMenu');
                const chevron = document.getElementById('userDropdownChevron');
                if (!menu) return;
                const isHidden = menu.classList.contains('hidden');
                if (isHidden) {
                    menu.classList.remove('hidden');
                    if (chevron) chevron.classList.add('rotate-180');
                } else {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            };

            // Tutup dropdown jika klik di luar
            document.addEventListener('click', function(e) {
                const dropdown = document.getElementById('userMenuDropdown');
                const menu = document.getElementById('userDropdownMenu');
                const chevron = document.getElementById('userDropdownChevron');
                if (dropdown && menu && !dropdown.contains(e.target)) {
                    menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            });

            // Tutup dropdown jika tekan tombol ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const menu = document.getElementById('userDropdownMenu');
                    const chevron = document.getElementById('userDropdownChevron');
                    if (menu) menu.classList.add('hidden');
                    if (chevron) chevron.classList.remove('rotate-180');
                }
            });
        };
        window.initUserDropdown();
    }

    // Fungsi Pengatur Tema (Dark / Light Mode)
    if (typeof window.updateThemeUI !== 'function') {
        window.updateThemeUI = function(isDark) {
            const track = document.getElementById('themeSwitchTrack');
            const thumb = document.getElementById('themeSwitchThumb');
            const thumbIcon = document.getElementById('themeThumbIcon');
            const text = document.getElementById('themeToggleText');
            const dropIcon = document.getElementById('dropdownThemeIcon');
            const dropLabel = document.getElementById('dropdownThemeLabel');
            const dropBadge = document.getElementById('dropdownThemeBadge');

            if (isDark) {
                if (track) {
                    track.classList.remove('bg-amber-100', 'bg-slate-200');
                    track.classList.add('bg-blue-600');
                }
                if (thumb) {
                    thumb.classList.remove('translate-x-0');
                    thumb.classList.add('translate-x-4');
                }
                if (thumbIcon) {
                    thumbIcon.className = 'h-2.5 w-2.5 text-blue-200';
                    thumbIcon.innerHTML = '<path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>';
                }
                if (text) {
                    text.textContent = 'Mode Gelap';
                    text.classList.remove('text-slate-700');
                    text.classList.add('text-slate-200');
                }
                if (dropIcon) dropIcon.textContent = '🌙';
                if (dropLabel) dropLabel.textContent = 'Mode Gelap';
                if (dropBadge) {
                    dropBadge.textContent = 'Aktif';
                    dropBadge.className = 'text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-blue-900/60 text-blue-300 border border-blue-700/60';
                }
            } else {
                if (track) {
                    track.classList.remove('bg-blue-600');
                    track.classList.add('bg-amber-100');
                }
                if (thumb) {
                    thumb.classList.remove('translate-x-4');
                    thumb.classList.add('translate-x-0');
                }
                if (thumbIcon) {
                    thumbIcon.className = 'h-2.5 w-2.5 text-amber-500';
                    thumbIcon.innerHTML = '<path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd"/>';
                }
                if (text) {
                    text.textContent = 'Mode Terang';
                    text.classList.remove('text-slate-200');
                    text.classList.add('text-slate-700');
                }
                if (dropIcon) dropIcon.textContent = '☀️';
                if (dropLabel) dropLabel.textContent = 'Mode Terang';
                if (dropBadge) {
                    dropBadge.textContent = 'Aktif';
                    dropBadge.className = 'text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-amber-100 text-amber-700 border border-amber-300';
                }
            }
        };

        window.toggleTheme = function() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('simpel_theme', isDark ? 'dark' : 'light');
            window.updateThemeUI(isDark);
            if (typeof window.updateMapTheme === 'function') {
                window.updateMapTheme(isDark);
            }
            window.dispatchEvent(new CustomEvent('themeChanged', { detail: { isDark } }));
        };

        // Sinkronisasi status awal UI saat dokumen siap
        document.addEventListener('DOMContentLoaded', function() {
            const currentIsDark = document.documentElement.classList.contains('dark');
            window.updateThemeUI(currentIsDark);
        });
    }
</script>
