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
        
        @php
            $uRole = Auth::check() ? Auth::user()->role : '';
            $avatarGrad = 'from-slate-700 to-slate-500 ring-slate-100';
            $roleLabel = 'Viewer';
            $roleColor = 'text-slate-500';
            $badgeBg = 'bg-slate-100 text-slate-700 border-slate-200';
            $badgeLabel = '👁️ Viewer';

            if ($uRole === 'admin') {
                $avatarGrad = 'from-blue-700 to-blue-500 ring-blue-100';
                $roleLabel = 'Administrator';
                $roleColor = 'text-blue-600 font-bold';
                $badgeBg = 'bg-blue-100 text-blue-700 border-blue-200';
                $badgeLabel = '🛡️ Administrator';
            } elseif ($uRole === 'petugas') {
                $avatarGrad = 'from-emerald-700 to-emerald-500 ring-emerald-100';
                $roleLabel = 'Petugas Lab';
                $roleColor = 'text-emerald-600 font-bold';
                $badgeBg = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                $badgeLabel = '🔬 Petugas Lab';
            } elseif ($uRole === 'peneliti') {
                $avatarGrad = 'from-violet-700 to-violet-500 ring-violet-100';
                $roleLabel = 'Peneliti';
                $roleColor = 'text-violet-600 font-bold';
                $badgeBg = 'bg-violet-100 text-violet-700 border-violet-200';
                $badgeLabel = '🔍 Peneliti';
            } elseif ($uRole === 'universitas') {
                $avatarGrad = 'from-sky-700 to-sky-500 ring-sky-100';
                $roleLabel = 'Universitas / Akademisi';
                $roleColor = 'text-sky-600 font-bold';
                $badgeBg = 'bg-sky-100 text-sky-700 border-sky-200';
                $badgeLabel = '🎓 Universitas';
            } elseif ($uRole === 'kepala' || $uRole === 'pimpinan') {
                $avatarGrad = 'from-indigo-700 to-indigo-500 ring-indigo-100';
                $roleLabel = 'Kepala / Pimpinan';
                $roleColor = 'text-indigo-600 font-bold';
                $badgeBg = 'bg-indigo-100 text-indigo-700 border-indigo-200';
                $badgeLabel = '🏛️ Kepala / Pimpinan';
            } elseif ($uRole === 'dinas_kesehatan' || $uRole === 'dinkes') {
                $avatarGrad = 'from-teal-700 to-teal-500 ring-teal-100';
                $roleLabel = 'Dinas Kesehatan';
                $roleColor = 'text-teal-600 font-bold';
                $badgeBg = 'bg-teal-100 text-teal-700 border-teal-200';
                $badgeLabel = '🏥 Dinas Kesehatan';
            } elseif ($uRole === 'balai_kekarantinaan_kesehatan' || $uRole === 'bkk' || $uRole === 'balai_karantina') {
                $avatarGrad = 'from-amber-700 to-amber-500 ring-amber-100';
                $roleLabel = 'Balai Kekarantinaan';
                $roleColor = 'text-amber-600 font-bold';
                $badgeBg = 'bg-amber-100 text-amber-700 border-amber-200';
                $badgeLabel = '🚢 Balai Kekarantinaan';
            } elseif ($uRole === 'labkesmas') {
                $avatarGrad = 'from-cyan-700 to-cyan-500 ring-cyan-100';
                $roleLabel = 'Labkesmas';
                $roleColor = 'text-cyan-600 font-bold';
                $badgeBg = 'bg-cyan-100 text-cyan-700 border-cyan-200';
                $badgeLabel = '🧪 Labkesmas';
            } elseif ($uRole === 'direktorat') {
                $avatarGrad = 'from-rose-700 to-rose-500 ring-rose-100';
                $roleLabel = 'Direktorat';
                $roleColor = 'text-rose-600 font-bold';
                $badgeBg = 'bg-rose-100 text-rose-700 border-rose-200';
                $badgeLabel = '🏛️ Direktorat';
            }
        @endphp

        {{-- AVATAR DENGAN LOGO KEMENKES --}}
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 p-1 shadow-xs ring-2 ring-slate-100 dark:ring-zinc-700 overflow-hidden">
            <img src="{{ asset('kemenkes.png') }}" alt="Logo Kemenkes RI" class="h-full w-full object-contain">
        </div>

        {{-- NAMA, ROLE & TANGGAL (HARI DAN TANGGAL DI BAWAH TULISAN ADMINISTRATOR) --}}
        <div class="hidden sm:block text-left">
            <p class="text-xs font-bold text-slate-800 leading-tight">
                {{ Auth::check() ? Auth::user()->name : 'Tamu (Belum Login)' }}
            </p>
            <p class="text-[10px] {{ $roleColor }} capitalize leading-tight mt-0.5">
                {{ Auth::check() ? $roleLabel : 'Klik untuk Masuk' }}
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
                    <span class="inline-flex items-center gap-1 rounded {{ $badgeBg }} px-1.5 py-0.5 text-[9px] font-bold border uppercase">
                        {{ $badgeLabel }}
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
            {{-- TOMBOL EDIT PROFIL SAYA --}}
            <button type="button"
                    id="btnEditProfileDropdown"
                    onclick="openProfileModal()"
                    class="w-full flex items-center gap-2.5 rounded-xl px-3 py-2 text-xs font-bold text-slate-700 hover:bg-slate-100 dark:text-zinc-200 dark:hover:bg-zinc-800 transition cursor-pointer text-left">
                <span>✏️</span>
                <span>Edit Profil Saya</span>
            </button>

            {{-- TOMBOL LOGOUT TERPADU --}}
            <a href="{{ route('logout') }}"
               onclick="return confirm('Apakah Anda yakin ingin keluar dari sistem Peta Resistensi?')"
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
                    track.classList.add('bg-emerald-600');
                }
                if (thumb) {
                    thumb.classList.remove('translate-x-0');
                    thumb.classList.add('translate-x-4');
                }
                if (thumbIcon) {
                    thumbIcon.className = 'h-2.5 w-2.5 text-emerald-200';
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
                    dropBadge.className = 'text-[9.5px] font-bold px-1.5 py-0.5 rounded bg-emerald-900/60 text-emerald-300 border border-emerald-700/60';
                }
            } else {
                if (track) {
                    track.classList.remove('bg-emerald-600', 'bg-blue-600');
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

{{-- FITUR AUTO-LOGOUT OTOMATIS: 30 MENIT TANPA PERGERAKAN / AKTIVITAS --}}
@if (Auth::check())
<script>
    (function() {
        // Durasi diam: 30 Menit (30 * 60 * 1000 ms)
        const INACTIVITY_TIMEOUT_MS = 30 * 60 * 1000;
        const CHECK_INTERVAL_MS = 10 * 1000; // Cek setiap 10 detik
        const STORAGE_KEY = 'simpel_last_activity_ts';
        let lastLoggedTs = Date.now();

        // Inisialisasi awal saat halaman dimuat
        try {
            const stored = localStorage.getItem(STORAGE_KEY);
            const now = Date.now();
            if (!stored || (now - parseInt(stored, 10)) > INACTIVITY_TIMEOUT_MS) {
                localStorage.setItem(STORAGE_KEY, now.toString());
            }
        } catch(e) {}

        // Fungsi memperbarui timestamp aktivitas pengguna (dengan throttle agar hemat daya CPU)
        function recordActivity() {
            const now = Date.now();
            if (now - lastLoggedTs > 3000) { // Catat maksimal sekali per 3 detik
                lastLoggedTs = now;
                try {
                    localStorage.setItem(STORAGE_KEY, now.toString());
                } catch(e) {}
            }
        }

        // Pantau seluruh interaksi fisik: pergerakan kursor mouse, klik, scroll, ketikan keyboard, sentuhan layar (mobile)
        const activityEvents = ['mousemove', 'mousedown', 'keydown', 'touchstart', 'scroll', 'wheel'];
        activityEvents.forEach(function(evt) {
            window.addEventListener(evt, recordActivity, { passive: true });
        });

        // Interval pemeriksaan keheningan / tanpa aktivitas secara hening (tanpa popup countdown)
        const idleChecker = setInterval(function() {
            try {
                const lastTs = parseInt(localStorage.getItem(STORAGE_KEY) || Date.now().toString(), 10);
                const idleDuration = Date.now() - lastTs;

                // Jika sudah melewati 30 menit tanpa ada pergerakan
                if (idleDuration >= INACTIVITY_TIMEOUT_MS) {
                    clearInterval(idleChecker);
                    activityEvents.forEach(function(evt) {
                        window.removeEventListener(evt, recordActivity);
                    });
                    localStorage.removeItem(STORAGE_KEY);

                    // Redirect otomatis ke logout dengan notifikasi sesi berakhir
                    window.location.href = "{{ route('logout') }}?reason=inactivity";
                }
            } catch(e) {}
        }, CHECK_INTERVAL_MS);
    })();
</script>

{{-- MODAL EDIT PROFIL AKUN GLOBAL (TELEPORT KE BODY AGAR TIDAK TERJEBAK DI HEADER STICKY / BACKDROP-BLUR) --}}
<div id="modalEditProfileGlobal"
     class="fixed inset-0 z-[99999] hidden bg-slate-950/75 dark:bg-black/85 backdrop-blur-sm flex items-center justify-center p-3 sm:p-6 overflow-y-auto"
     onclick="if(event.target === this) closeProfileModal()"
     style="display: none;">

    <div class="profile-modal-card relative w-full max-w-xl rounded-3xl shadow-2xl overflow-hidden my-auto"
         onclick="event.stopPropagation()">

        {{-- HEADER MODAL --}}
        <div class="profile-modal-header relative px-6 py-5 flex items-center justify-between gap-4">
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-tr {{ $avatarGrad }} font-black text-white text-lg shadow-md ring-2 ring-white/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <h3 class="profile-modal-title text-base sm:text-lg font-black tracking-tight truncate">
                        Edit Profil Akun Saya
                    </h3>
                    <p class="profile-modal-subtitle text-xs mt-0.5 truncate font-medium">
                        Perbarui informasi identitas &amp; kata sandi akun Anda
                    </p>
                </div>
            </div>
            <button type="button"
                    onclick="closeProfileModal()"
                    class="profile-modal-close flex h-9 w-9 shrink-0 items-center justify-center rounded-xl transition cursor-pointer text-sm font-bold"
                    aria-label="Tutup Modal">
                ✕
            </button>
        </div>

        {{-- FORM UPDATE PROFIL --}}
        <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-5">
            @csrf

            {{-- KARTU RINGKASAN IDENTITAS AKUN --}}
            @php
                $uRole = Auth::user()->role;
                $roleBadgeClass = 'badge-role-default';
                if ($uRole === 'admin') {
                    $roleBadgeClass = 'badge-role-admin';
                } elseif ($uRole === 'petugas') {
                    $roleBadgeClass = 'badge-role-petugas';
                } elseif ($uRole === 'direktorat') {
                    $roleBadgeClass = 'badge-role-direktorat';
                } elseif ($uRole === 'peneliti') {
                    $roleBadgeClass = 'badge-role-peneliti';
                } elseif ($uRole === 'universitas') {
                    $roleBadgeClass = 'badge-role-universitas';
                } elseif ($uRole === 'kepala' || $uRole === 'pimpinan') {
                    $roleBadgeClass = 'badge-role-kepala';
                } elseif ($uRole === 'dinas_kesehatan' || $uRole === 'dinkes') {
                    $roleBadgeClass = 'badge-role-dinkes';
                } elseif ($uRole === 'balai_kekarantinaan_kesehatan' || $uRole === 'bkk' || $uRole === 'balai_karantina') {
                    $roleBadgeClass = 'badge-role-bkk';
                } elseif ($uRole === 'labkesmas') {
                    $roleBadgeClass = 'badge-role-labkesmas';
                }
            @endphp
            <div class="profile-summary-box p-4 rounded-2xl grid grid-cols-1 sm:grid-cols-3 gap-3.5 text-xs">
                <div class="min-w-0">
                    <span class="profile-summary-label text-[10.5px] uppercase font-bold tracking-wider block mb-1">Username</span>
                    <span class="profile-summary-value font-mono font-bold truncate block text-sm">@<span>{{ Auth::user()->username }}</span></span>
                </div>
                <div class="min-w-0">
                    <span class="profile-summary-label text-[10.5px] uppercase font-bold tracking-wider block mb-1">Email Terdaftar</span>
                    <span class="profile-summary-value font-semibold truncate block text-xs" title="{{ Auth::user()->email }}">{{ Auth::user()->email }}</span>
                </div>
                <div class="min-w-0">
                    <span class="profile-summary-label text-[10.5px] uppercase font-bold tracking-wider block mb-1">Hak Akses (Role)</span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-bold border truncate {{ $roleBadgeClass }}">
                        {{ $badgeLabel }}
                    </span>
                </div>
            </div>

            {{-- NAMA LENGKAP --}}
            <div>
                <label class="profile-form-label block text-xs font-bold uppercase tracking-wider mb-1.5">
                    Nama Lengkap / Instansi <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                        👤
                    </span>
                    <input type="text"
                           name="name"
                           value="{{ Auth::user()->name }}"
                           required
                           class="profile-form-input w-full rounded-xl pl-10 pr-4 py-2.5 text-sm font-semibold transition"
                           placeholder="Masukkan nama lengkap atau nama instansi">
                </div>
                <p class="profile-helper-note text-[11px] mt-1">Nama ini digunakan pada header profil, riwayat aktivitas, dan dokumen resmi.</p>
            </div>

            {{-- NOMOR TELEPON / WHATSAPP --}}
            <div>
                <label class="profile-form-label block text-xs font-bold uppercase tracking-wider mb-1.5">
                    Nomor Telepon / WhatsApp
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 text-sm">
                        📞
                    </span>
                    <input type="text"
                           name="telepon"
                           value="{{ Auth::user()->phone ?? Auth::user()->telepon }}"
                           placeholder="Contoh: 081234567890"
                           class="profile-form-input w-full rounded-xl pl-10 pr-4 py-2.5 text-sm font-medium transition">
                </div>
            </div>

            {{-- GANTI PASSWORD --}}
            <div class="profile-pass-box rounded-2xl p-4 space-y-3">
                <div>
                    <h4 class="profile-pass-title text-xs font-bold flex items-center gap-1.5">
                        <span>🔑</span>
                        <span>Ganti Password Akun (Opsional)</span>
                    </h4>
                    <p class="profile-pass-note text-[11px] mt-0.5">
                        Kosongkan kedua kolom di bawah jika Anda tidak bermaksud mengganti password saat ini.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                    <div>
                        <label class="profile-form-label block text-[11px] font-bold mb-1">Password Baru</label>
                        <div class="relative">
                            <input type="password"
                                   id="modalProfilePass"
                                   name="password"
                                   minlength="6"
                                   placeholder="Minimal 6 karakter"
                                   class="profile-form-input w-full rounded-xl pl-3.5 pr-9 py-2 text-xs">
                            <button type="button"
                                    onclick="togglePasswordInput('modalProfilePass', this)"
                                    class="profile-eye-btn absolute inset-y-0 right-0 flex items-center pr-3 transition cursor-pointer"
                                    title="Lihat / Sembunyikan Password">
                                <svg class="h-4 w-4 icon-eye" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="h-4 w-4 icon-eye-slash hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="profile-form-label block text-[11px] font-bold mb-1">Ulangi Password Baru</label>
                        <div class="relative">
                            <input type="password"
                                   id="modalProfilePassConfirm"
                                   name="password_confirmation"
                                   minlength="6"
                                   placeholder="Ulangi password baru"
                                   class="profile-form-input w-full rounded-xl pl-3.5 pr-9 py-2 text-xs">
                            <button type="button"
                                    onclick="togglePasswordInput('modalProfilePassConfirm', this)"
                                    class="profile-eye-btn absolute inset-y-0 right-0 flex items-center pr-3 transition cursor-pointer"
                                    title="Lihat / Sembunyikan Password">
                                <svg class="h-4 w-4 icon-eye" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="h-4 w-4 icon-eye-slash hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL AKSI --}}
            <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-200 dark:border-zinc-800">
                <button type="button"
                        onclick="closeProfileModal()"
                        class="profile-btn-cancel rounded-xl px-5 py-2.5 text-xs font-bold transition cursor-pointer">
                    Batal
                </button>
                <button type="submit"
                        class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 px-6 py-2.5 text-xs font-bold text-white shadow-lg shadow-blue-500/25 transition cursor-pointer flex items-center gap-1.5">
                    <span>💾</span>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- CSS KHUSUS MODAL PROFIL: MENJAMIN KONTRAS TINGGI & TULISAN TAJAM DI SEMUA TEMA --}}
<style id="style-modal-profile-contrast">
    #modalEditProfileGlobal .profile-modal-card {
        background-color: #ffffff;
        background-image: none !important;
        color: #0f172a;
        border: 1px solid #cbd5e1;
    }
    #modalEditProfileGlobal .profile-modal-header {
        background-color: #f8fafc;
        background-image: none !important;
        border-bottom: 1px solid #e2e8f0;
    }
    #modalEditProfileGlobal .profile-modal-title {
        color: #0f172a !important;
    }
    #modalEditProfileGlobal .profile-modal-subtitle {
        color: #475569 !important;
    }
    #modalEditProfileGlobal .profile-modal-close {
        background-color: #f1f5f9;
        color: #475569;
    }
    #modalEditProfileGlobal .profile-modal-close:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }
    #modalEditProfileGlobal .profile-summary-box {
        background-color: #f1f5f9;
        background-image: none !important;
        border: 1px solid #e2e8f0;
    }
    #modalEditProfileGlobal .profile-summary-label {
        color: #475569 !important;
    }
    #modalEditProfileGlobal .profile-summary-value {
        color: #0f172a !important;
    }
    #modalEditProfileGlobal .profile-summary-value * {
        color: inherit !important;
    }
    #modalEditProfileGlobal .profile-form-label {
        color: #1e293b !important;
    }
    #modalEditProfileGlobal .profile-form-input {
        background-color: #ffffff !important;
        background-image: none !important;
        color: #0f172a !important;
        border: 1.5px solid #cbd5e1 !important;
    }
    #modalEditProfileGlobal .profile-form-input::placeholder {
        color: #94a3b8 !important;
    }
    #modalEditProfileGlobal .profile-form-input:focus {
        border-color: #2563eb !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2) !important;
    }
    #modalEditProfileGlobal .profile-pass-box {
        background-color: #f8fafc;
        background-image: none !important;
        border: 1px solid #e2e8f0;
    }
    #modalEditProfileGlobal .profile-pass-title {
        color: #0f172a !important;
    }
    #modalEditProfileGlobal .profile-pass-note {
        color: #475569 !important;
    }
    #modalEditProfileGlobal .profile-helper-note {
        color: #64748b !important;
    }
    #modalEditProfileGlobal .profile-eye-btn {
        color: #64748b !important;
    }
    #modalEditProfileGlobal .profile-eye-btn:hover {
        color: #0f172a !important;
    }
    #modalEditProfileGlobal .profile-btn-cancel {
        background-color: #ffffff;
        color: #475569 !important;
        border: 1.5px solid #cbd5e1 !important;
    }
    #modalEditProfileGlobal .profile-btn-cancel:hover {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }

    /* ROLE BADGES DI MODAL - LIGHT MODE */
    #modalEditProfileGlobal .badge-role-admin {
        background-color: #dbeafe !important;
        color: #1e40af !important;
        border-color: #93c5fd !important;
    }
    #modalEditProfileGlobal .badge-role-petugas {
        background-color: #d1fae5 !important;
        color: #065f46 !important;
        border-color: #6ee7b7 !important;
    }
    #modalEditProfileGlobal .badge-role-direktorat {
        background-color: #ffe4e6 !important;
        color: #9f1239 !important;
        border-color: #fda4af !important;
    }
    #modalEditProfileGlobal .badge-role-peneliti {
        background-color: #ede9fe !important;
        color: #5b21b6 !important;
        border-color: #c4b5fd !important;
    }
    #modalEditProfileGlobal .badge-role-universitas {
        background-color: #e0f2fe !important;
        color: #075985 !important;
        border-color: #7dd3fc !important;
    }
    #modalEditProfileGlobal .badge-role-kepala,
    #modalEditProfileGlobal .badge-role-pimpinan {
        background-color: #e0e7ff !important;
        color: #3730a3 !important;
        border-color: #a5b4fc !important;
    }
    #modalEditProfileGlobal .badge-role-dinkes {
        background-color: #ccfbf1 !important;
        color: #115e59 !important;
        border-color: #5eead4 !important;
    }
    #modalEditProfileGlobal .badge-role-bkk {
        background-color: #fef3c7 !important;
        color: #92400e !important;
        border-color: #fcd34d !important;
    }
    #modalEditProfileGlobal .badge-role-labkesmas {
        background-color: #cffafe !important;
        color: #155e75 !important;
        border-color: #67e8f9 !important;
    }
    #modalEditProfileGlobal .badge-role-default {
        background-color: #f1f5f9 !important;
        color: #334155 !important;
        border-color: #cbd5e1 !important;
    }

    /* MODE GELAP (DARK MODE KONTRAST TINGGI & TEKS JELAS TERBACA) */
    html.dark #modalEditProfileGlobal .profile-modal-card {
        background-color: #141418 !important;
        background-image: none !important;
        color: #f8fafc !important;
        border: 1.5px solid #2e2e38 !important;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.85) !important;
    }
    html.dark #modalEditProfileGlobal .profile-modal-header {
        background-color: #1c1c22 !important;
        background-image: none !important;
        border-bottom: 1.5px solid #2e2e38 !important;
    }
    html.dark #modalEditProfileGlobal .profile-modal-title {
        color: #ffffff !important;
    }
    html.dark #modalEditProfileGlobal .profile-modal-subtitle {
        color: #cbd5e1 !important;
    }
    html.dark #modalEditProfileGlobal .profile-modal-close {
        background-color: #27272f !important;
        color: #e2e8f0 !important;
    }
    html.dark #modalEditProfileGlobal .profile-modal-close:hover {
        background-color: #3f3f4c !important;
        color: #ffffff !important;
    }
    html.dark #modalEditProfileGlobal .profile-summary-box {
        background-color: #1a1a20 !important;
        background-image: none !important;
        border: 1.5px solid #2e2e38 !important;
    }
    html.dark #modalEditProfileGlobal .profile-summary-label {
        color: #94a3b8 !important;
    }
    html.dark #modalEditProfileGlobal .profile-summary-value {
        color: #ffffff !important;
    }
    html.dark #modalEditProfileGlobal .profile-summary-value * {
        color: #ffffff !important;
    }
    html.dark #modalEditProfileGlobal .profile-form-label {
        color: #f1f5f9 !important;
    }
    html.dark #modalEditProfileGlobal .profile-form-input {
        background-color: #1a1a20 !important;
        background-image: none !important;
        color: #ffffff !important;
        border: 1.5px solid #3f3f4a !important;
    }
    html.dark #modalEditProfileGlobal .profile-form-input::placeholder {
        color: #64748b !important;
    }
    html.dark #modalEditProfileGlobal .profile-form-input:focus {
        border-color: #38bdf8 !important;
        background-color: #141418 !important;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25) !important;
    }
    html.dark #modalEditProfileGlobal .profile-pass-box {
        background-color: #1a1a20 !important;
        background-image: none !important;
        border: 1.5px solid #2e2e38 !important;
    }
    html.dark #modalEditProfileGlobal .profile-pass-title {
        color: #ffffff !important;
    }
    html.dark #modalEditProfileGlobal .profile-pass-note {
        color: #cbd5e1 !important;
    }
    html.dark #modalEditProfileGlobal .profile-helper-note {
        color: #94a3b8 !important;
    }
    html.dark #modalEditProfileGlobal .profile-eye-btn {
        color: #94a3b8 !important;
    }
    html.dark #modalEditProfileGlobal .profile-eye-btn:hover {
        color: #ffffff !important;
    }
    html.dark #modalEditProfileGlobal .profile-btn-cancel {
        background-color: #27272f !important;
        color: #f1f5f9 !important;
        border: 1.5px solid #3f3f4a !important;
    }
    html.dark #modalEditProfileGlobal .profile-btn-cancel:hover {
        background-color: #3f3f4c !important;
        color: #ffffff !important;
    }

    /* ROLE BADGES DI MODAL - DARK MODE (GLOW & TAJAM) */
    html.dark #modalEditProfileGlobal .badge-role-admin {
        background-color: #172554 !important;
        color: #93c5fd !important;
        border-color: #2563eb !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-petugas {
        background-color: #064e3b !important;
        color: #6ee7b7 !important;
        border-color: #059669 !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-direktorat {
        background-color: #4c0519 !important;
        color: #fda4af !important;
        border-color: #e11d48 !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-peneliti {
        background-color: #2e1065 !important;
        color: #c4b5fd !important;
        border-color: #7c3aed !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-universitas {
        background-color: #082f49 !important;
        color: #7dd3fc !important;
        border-color: #0284c7 !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-kepala,
    html.dark #modalEditProfileGlobal .badge-role-pimpinan {
        background-color: #1e1b4b !important;
        color: #a5b4fc !important;
        border-color: #4f46e5 !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-dinkes {
        background-color: #042f2e !important;
        color: #5eead4 !important;
        border-color: #0d9488 !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-bkk {
        background-color: #451a03 !important;
        color: #fde68a !important;
        border-color: #d97706 !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-labkesmas {
        background-color: #083344 !important;
        color: #67e8f9 !important;
        border-color: #0891b2 !important;
    }
    html.dark #modalEditProfileGlobal .badge-role-default {
        background-color: #1e293b !important;
        color: #e2e8f0 !important;
        border-color: #475569 !important;
    }
</style>

<script>
    function ensureModalInBody() {
        const modal = document.getElementById('modalEditProfileGlobal');
        if (modal && modal.parentElement !== document.body) {
            document.body.appendChild(modal);
        }
        return modal;
    }

    function openProfileModal() {
        // Tutup dropdown user menu
        const menu = document.getElementById('userDropdownMenu');
        if (menu) menu.classList.add('hidden');
        const chevron = document.getElementById('userDropdownChevron');
        if (chevron) chevron.classList.remove('rotate-180');

        const modal = ensureModalInBody();
        if (modal) {
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeProfileModal() {
        const modal = document.getElementById('modalEditProfileGlobal');
        if (modal) {
            modal.style.display = 'none';
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Pastikan modal langsung dipindahkan ke <body> begitu DOM siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ensureModalInBody);
    } else {
        ensureModalInBody();
    }

    if (typeof window.togglePasswordInput !== 'function') {
        window.togglePasswordInput = function(inputId, btnEl) {
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
        };
    }

    // Shortcut ESC untuk menutup modal edit profile
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeProfileModal();
        }
    });
</script>
@endif

