<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMPEL BBLKL</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body, input, button, select, textarea {
            font-family: 'Plus Jakarta Sans', 'Inter', system-ui, -apple-system, sans-serif !important;
            -webkit-font-smoothing: antialiased;
        }

        .bg-mesh {
            background-color: #060b13;
            background-image: 
                radial-gradient(at 0% 0%, rgba(13, 148, 136, 0.18) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(37, 99, 235, 0.20) 0px, transparent 50%),
                radial-gradient(at 50% 0%, rgba(6, 182, 212, 0.12) 0px, transparent 50%);
        }

        .bg-grid-dots {
            background-image: radial-gradient(rgba(148, 163, 184, 0.08) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="min-h-screen bg-mesh text-slate-100 flex flex-col justify-center items-center px-4 py-8 sm:py-10 relative overflow-y-auto selection:bg-teal-500 selection:text-white">

    {{-- GRID BACKGROUND OVERLAY --}}
    <div class="fixed inset-0 bg-grid-dots pointer-events-none"></div>

    {{-- AMBIENT GLOW ACCENTS --}}
    <div class="fixed -top-32 -left-32 w-80 h-80 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed -bottom-32 -right-32 w-80 h-80 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 my-auto py-2">

        {{-- BRANDING & LOGO HEADER --}}
        <div class="text-center mb-3 sm:mb-4">
            
            {{-- LOGO BADGE KEMENKES BBLKL --}}
            <div class="inline-flex items-center justify-center rounded-2xl bg-white px-5 py-2 shadow-xl shadow-teal-500/10 border border-white/90 backdrop-blur-md mb-2.5 transition hover:scale-[1.02] duration-300">
                <img src="{{ asset('logo_bblkl.png') }}" 
                     alt="Kemenkes Labkesmas Kesehatan Lingkungan" 
                     class="h-8 sm:h-9 w-auto object-contain">
            </div>

            <div class="flex items-center justify-center gap-2 mt-0.5">
                <h1 class="text-2xl sm:text-[26px] font-black text-white tracking-tight leading-none">
                    SIMPEL <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 via-cyan-400 to-blue-500">BBLKL</span>
                </h1>
                <span class="rounded-full bg-teal-500/15 px-2.5 py-0.5 text-[10px] font-extrabold text-teal-400 border border-teal-500/30 uppercase tracking-wider">
                    v2.0
                </span>
            </div>

            <p class="text-xs text-slate-400 mt-1 font-medium leading-tight">
                Sistem Informasi Manajemen Pengujian & Uji Resistensi Vektor
            </p>
        </div>

        {{-- KARTU FORM LOGIN DENGAN PREMIUM GLASSMORPHISM --}}
        <div class="rounded-2xl border border-slate-800/80 bg-slate-900/75 backdrop-blur-2xl p-5 sm:p-6 shadow-2xl shadow-black/60 relative overflow-hidden">

            {{-- TOP ACCENT GRADIENT LINE --}}
            <div class="absolute top-0 inset-x-0 h-[2px] bg-gradient-to-r from-teal-500 via-cyan-400 to-blue-500"></div>

            {{-- NOTIFIKASI ERROR / SUKSES --}}
            @if ($errors->any())
                <div class="mb-3 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3 py-2 text-xs text-rose-300 flex items-start gap-2">
                    <span class="text-sm leading-none">⚠️</span>
                    <div class="flex-1 font-medium leading-relaxed">
                        {{ $errors->first() }}
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="mb-3 rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-3 py-2 text-xs text-emerald-300 flex items-start gap-2">
                    <span class="text-sm leading-none">✅</span>
                    <div class="flex-1 font-medium leading-relaxed">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-3 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3 py-2 text-xs text-rose-300 flex items-start gap-2">
                    <span class="text-sm leading-none">⚠️</span>
                    <div class="flex-1 font-medium leading-relaxed">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-3 sm:space-y-3.5">
                @csrf

                {{-- USERNAME / EMAIL --}}
                <div>
                    <label for="login" class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                        Username atau Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-teal-400/80">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
                        <input type="text"
                               name="login"
                               id="login"
                               value="{{ old('login') }}"
                               required
                               autofocus
                               placeholder="Masukkan username atau email"
                               class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 pl-10 pr-3.5 py-2 text-sm text-white placeholder-slate-500 transition duration-200 focus:border-cyan-400 focus:bg-slate-950/90 focus:outline-none focus:ring-2 focus:ring-cyan-500/25">
                    </div>
                </div>

                {{-- PASSWORD DENGAN LINK LUPA PASSWORD --}}
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-slate-300">
                            Password
                        </label>
                        <button type="button"
                                onclick="openModal('modalLupaPassword')"
                                class="text-[11px] font-semibold text-cyan-400 hover:text-cyan-300 transition hover:underline cursor-pointer">
                            Lupa Password?
                        </button>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-teal-400/80">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password"
                               name="password"
                               id="password"
                               required
                               placeholder="Masukkan kata sandi akun"
                               class="w-full rounded-xl border border-slate-700/80 bg-slate-950/70 pl-10 pr-10 py-2 text-sm text-white placeholder-slate-500 transition duration-200 focus:border-cyan-400 focus:bg-slate-950/90 focus:outline-none focus:ring-2 focus:ring-cyan-500/25">
                        <button type="button"
                                onclick="togglePasswordVisibility()"
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-cyan-400 transition cursor-pointer"
                                title="Lihat/Sembunyikan password">
                            <svg id="eyeOpenIcon" class="h-4.5 w-4.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <svg id="eyeCloseIcon" class="h-4.5 w-4.5 hidden" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- REMEMBER ME --}}
                <div class="flex items-center justify-between pt-0.5">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox"
                               name="remember"
                               value="1"
                               class="h-3.5 w-3.5 rounded border-slate-700 bg-slate-950 text-cyan-500 focus:ring-cyan-500 focus:ring-offset-slate-900 cursor-pointer">
                        <span class="text-xs text-slate-400">Ingat saya di perangkat ini</span>
                    </label>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="pt-1.5">
                    <button type="submit"
                            class="w-full rounded-xl bg-gradient-to-r from-teal-500 via-cyan-500 to-blue-600 py-2.5 text-sm font-extrabold text-white shadow-lg shadow-cyan-500/25 transition duration-200 hover:from-teal-400 hover:via-cyan-400 hover:to-blue-500 hover:shadow-cyan-500/40 hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-slate-900 cursor-pointer flex items-center justify-center gap-2">
                        <span>Masuk ke Sistem</span>
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>

                {{-- PEMISAH & BUAT AKUN BARU --}}
                <div class="pt-2.5 text-center border-t border-slate-800/80 mt-2">
                    <p class="text-xs text-slate-400">
                        Belum punya akun?
                        <button type="button"
                                onclick="openModal('modalBuatUser')"
                                class="font-bold text-teal-400 hover:text-teal-300 transition hover:underline cursor-pointer ml-1">
                            Buat Akun Baru
                        </button>
                    </p>
                </div>

                {{-- PETUNJUK AKUN DEMO / PENGUJIAN ROLE --}}
                <div class="mt-3 p-3 rounded-xl bg-slate-950/70 border border-slate-800/90 text-left">
                    <div class="flex items-center justify-between text-[11px] font-bold text-slate-300 mb-1.5">
                        <span class="flex items-center gap-1.5">
                            <span>🔑</span> Akun Pengujian Role:
                        </span>
                        <span class="text-[10px] text-slate-500 font-normal">Klik untuk isi otomatis</span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-[11px]">
                        <button type="button"
                                onclick="document.getElementById('login').value='admin'; document.getElementById('password').value='admin123';"
                                class="p-2 rounded-lg bg-blue-950/40 hover:bg-blue-900/50 border border-blue-800/50 text-left transition cursor-pointer group">
                            <span class="font-bold text-blue-400 group-hover:text-blue-300 block text-[11px]">🛡️ Administrator</span>
                            <span class="text-[10px] text-slate-400">User: <strong class="text-white">admin</strong></span><br>
                            <span class="text-[10px] text-slate-400">Pass: <strong class="text-white">admin123</strong></span>
                        </button>
                        <button type="button"
                                onclick="document.getElementById('login').value='petugas'; document.getElementById('password').value='petugas123';"
                                class="p-2 rounded-lg bg-emerald-950/40 hover:bg-emerald-900/50 border border-emerald-800/50 text-left transition cursor-pointer group">
                            <span class="font-bold text-emerald-400 group-hover:text-emerald-300 block text-[11px]">🔬 Petugas Lab</span>
                            <span class="text-[10px] text-slate-400">User: <strong class="text-white">petugas</strong></span><br>
                            <span class="text-[10px] text-slate-400">Pass: <strong class="text-white">petugas123</strong></span>
                        </button>
                    </div>
                </div>

            </form>

        </div>

        {{-- KEAMANAN FOOTER --}}
        <div class="mt-3 sm:mt-3.5 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-900/60 border border-slate-800/80 text-[11px] text-slate-400 shadow-sm">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Koneksi Aman Terenkripsi SSL 256-bit • SIMPEL BBLKL</span>
            </div>
            <p class="text-[10px] text-slate-500 mt-1">
                © {{ date('Y') }} Balai Besar Laboratorium Kesehatan Lingkungan • Kemenkes RI
            </p>
        </div>

    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL BUAT AKUN PENGGUNA BARU --}}
    {{-- ========================================================================= --}}
    <div id="modalBuatUser" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/80 backdrop-blur-md p-4 transition-all" onclick="if(event.target === this) closeModal('modalBuatUser')">
        <div class="min-h-full flex items-center justify-center py-6 w-full pointer-events-none">
            <div class="relative w-full max-w-lg rounded-2xl border border-slate-800 bg-slate-900/95 backdrop-blur-2xl p-6 sm:p-7 shadow-2xl shadow-black/80 my-auto text-left pointer-events-auto">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-3.5 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-teal-500/15 text-teal-400 border border-teal-500/30 font-bold text-base">
                            👤
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">Buat Akun Pengguna Baru</h3>
                            <p class="text-[11px] text-slate-400">Daftarkan akun untuk akses ke sistem SIMPEL BBLKL</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('modalBuatUser')" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-slate-200 transition cursor-pointer" title="Tutup">
                        ✕
                    </button>
                </div>

                @if ($errors->any() && (old('name') || $errors->has('name') || $errors->has('username') || $errors->has('email')))
                    <div class="mb-3.5 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3 py-2 text-xs text-rose-300 flex items-start gap-2">
                        <span class="text-sm leading-none">⚠️</span>
                        <div class="flex-1 font-medium leading-relaxed">
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                    @csrf
                    
                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                            Nama Lengkap *
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               placeholder="Contoh: Dr. Budi Santoso"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                                Username *
                            </label>
                            <input type="text"
                                   name="username"
                                   value="{{ old('username') }}"
                                   required
                                   placeholder="Contoh: budi_lab"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                                No. Telepon / WA (Opsional)
                            </label>
                            <input type="text"
                                   name="telepon"
                                   value="{{ old('telepon') }}"
                                   placeholder="Contoh: 08123456789"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                            Alamat Email *
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="Contoh: budi@kemenkes.go.id"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                                Kata Sandi *
                            </label>
                            <input type="password"
                                   name="password"
                                   minlength="6"
                                   required
                                   placeholder="Minimal 6 karakter"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                                Konfirmasi Password *
                            </label>
                            <input type="password"
                                   name="password_confirmation"
                                   minlength="6"
                                   required
                                   placeholder="Ulangi kata sandi"
                                   class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                        </div>
                    </div>

                    <div class="mt-5 flex items-center justify-end gap-2.5 pt-3.5 border-t border-slate-800">
                        <button type="button"
                                onclick="closeModal('modalBuatUser')"
                                class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-700 hover:text-white transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                                class="rounded-xl bg-gradient-to-r from-teal-500 to-cyan-600 px-5 py-2 text-xs font-bold text-white shadow-md shadow-cyan-500/20 hover:from-teal-400 hover:to-cyan-500 transition cursor-pointer">
                            Daftar Akun Baru
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- ========================================================================= --}}
    {{-- MODAL LUPA PASSWORD --}}
    {{-- ========================================================================= --}}
    <div id="modalLupaPassword" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-950/80 backdrop-blur-md p-4 transition-all" onclick="if(event.target === this) closeModal('modalLupaPassword')">
        <div class="min-h-full flex items-center justify-center py-6 w-full pointer-events-none">
            <div class="relative w-full max-w-md rounded-2xl border border-slate-800 bg-slate-900/95 backdrop-blur-2xl p-6 sm:p-7 shadow-2xl shadow-black/80 my-auto text-left pointer-events-auto">
                
                <div class="flex items-center justify-between border-b border-slate-800 pb-3.5 mb-4">
                    <div class="flex items-center gap-2.5">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 font-bold text-base">
                            🔑
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">Reset Kata Sandi</h3>
                            <p class="text-[11px] text-slate-400">Atur ulang kata sandi akun SIMPEL BBLKL Anda</p>
                        </div>
                    </div>
                    <button type="button" onclick="closeModal('modalLupaPassword')" class="rounded-lg p-1.5 text-slate-400 hover:bg-slate-800 hover:text-slate-200 transition cursor-pointer" title="Tutup">
                        ✕
                    </button>
                </div>

                @if ($errors->any() && (old('forgot_identity') || $errors->has('forgot_identity') || $errors->has('new_password')))
                    <div class="mb-3.5 rounded-xl border border-rose-500/30 bg-rose-500/10 px-3 py-2 text-xs text-rose-300 flex items-start gap-2">
                        <span class="text-sm leading-none">⚠️</span>
                        <div class="flex-1 font-medium leading-relaxed">
                            {{ $errors->first() }}
                        </div>
                    </div>
                @endif

                <form action="{{ route('password.reset.post') }}" method="POST" class="space-y-3.5">
                    @csrf

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                            Username atau Email Terdaftar *
                        </label>
                        <input type="text"
                               name="forgot_identity"
                               value="{{ old('forgot_identity') }}"
                               required
                               placeholder="Masukkan username atau email akun Anda"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                            Kata Sandi Baru *
                        </label>
                        <input type="password"
                               name="new_password"
                               minlength="6"
                               required
                               placeholder="Minimal 6 karakter baru"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-300 mb-1">
                            Konfirmasi Kata Sandi Baru *
                        </label>
                        <input type="password"
                               name="new_password_confirmation"
                               minlength="6"
                               required
                               placeholder="Ulangi kata sandi baru"
                               class="w-full rounded-xl border border-slate-700 bg-slate-950/70 px-3.5 py-2 text-sm text-white placeholder-slate-500 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-500/20">
                    </div>

                    <div class="rounded-xl border border-slate-800 bg-slate-950/60 p-3 text-xs text-slate-400 flex items-start gap-2">
                        <span class="text-sm">💡</span>
                        <span class="text-[11px] leading-relaxed">
                            Jika mengalami kendala, hubungi Helpdesk Administrator IT BBLKL untuk bantuan verifikasi akun secara manual.
                        </span>
                    </div>

                    <div class="mt-5 flex items-center justify-end gap-2.5 pt-3.5 border-t border-slate-800">
                        <button type="button"
                                onclick="closeModal('modalLupaPassword')"
                                class="rounded-xl border border-slate-700 bg-slate-800/80 px-4 py-2 text-xs font-semibold text-slate-300 hover:bg-slate-700 hover:text-white transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit"
                                class="rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2 text-xs font-bold text-white shadow-md shadow-cyan-500/20 hover:from-cyan-400 hover:to-blue-500 transition cursor-pointer">
                            Simpan Kata Sandi Baru
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpenIcon');
            const eyeClose = document.getElementById('eyeCloseIcon');
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClose.classList.remove('hidden');
            } else {
                passInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClose.classList.add('hidden');
            }
        }

        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Close modal on Escape key
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('modalBuatUser');
                closeModal('modalLupaPassword');
            }
        });

        // Auto-reopen modal if validation failed from that form
        @if ($errors->any() && (old('name') || $errors->has('name') || $errors->has('username') || $errors->has('email')))
            openModal('modalBuatUser');
        @elseif ($errors->any() && (old('forgot_identity') || $errors->has('forgot_identity') || $errors->has('new_password')))
            openModal('modalLupaPassword');
        @endif
    </script>

</body>

</html>
