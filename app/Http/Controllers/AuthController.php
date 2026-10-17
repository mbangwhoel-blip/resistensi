<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi login dengan proteksi Brute Force, Session Fixation, dan Role Check
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Masukkan username atau alamat email.',
            'password.required' => 'Masukkan kata sandi (password).',
        ]);

        $ip = $request->ip();
        $throttleKey = 'login-attempt:' . $ip . '|' . strtolower($request->input('login'));

        // Proteksi Brute Force: Batasi maksimal 5 percobaan gagal per 60 detik
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'login' => "Akses diblokir sementara demi keamanan karena terlalu banyak percobaan login yang gagal. Silakan coba kembali dalam {$seconds} detik."
            ])->withInput($request->only('login'));
        }

        $loginInput = trim($request->input('login'));
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => strtolower($loginInput),
            'password' => $request->input('password')
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Cek status aktif akun
            if ($user->status === 'nonaktif') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'login' => 'Akun Anda berstatus nonaktif. Silakan hubungi Administrator Balai untuk pengaktifan kembali.'
                ])->withInput($request->only('login'));
            }

            // Sukses: Bersihkan hitungan rate limiter
            RateLimiter::clear($throttleKey);

            // Proteksi Session Fixation: Regenerate session ID
            $request->session()->regenerate();

            // Catat log aktivitas login terakhir
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $ip,
            ]);

            return redirect()->intended(route('dashboard'))
                ->with('success', "Selamat datang kembali, {$user->name}!");
        }

        // Catat kegagalan login untuk rate limiting
        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'login' => 'Username/Email atau Password yang Anda masukkan salah.'
        ])->withInput($request->only('login'));
    }

    /**
     * Logout pengguna dan hancurkan session
     */
    public function logout(Request $request)
    {
        $isInactivity = $request->query('reason') === 'inactivity';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($isInactivity) {
            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir secara otomatis demi keamanan karena tidak ada pergerakan/aktivitas selama 30 menit. Silakan masuk kembali.');
        }

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar dari sistem Peta Resistensi.');
    }

    /**
     * Registrasi / Buat akun pengguna baru dari halaman login
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|alpha_dash|min:3|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:petugas,viewer,dinas_kesehatan,dinkes,balai_kekarantinaan_kesehatan,bkk,balai_karantina,labkesmas',
            'telepon' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung (-) dan garis bawah (_).',
            'username.unique' => 'Username ini sudah terdaftar. Silakan gunakan username lain.',
            'username.min' => 'Username minimal 3 karakter.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Pilih role / hak akses akun.',
            'role.in' => 'Pilihan role tidak valid. Silakan pilih role yang tersedia.',
        ]);

        $role = $validated['role'];
        if ($role === 'dinkes') $role = 'dinas_kesehatan';
        if ($role === 'bkk' || $role === 'balai_karantina') $role = 'balai_kekarantinaan_kesehatan';

        User::create([
            'name' => trim($validated['name']),
            'username' => strtolower(trim($validated['username'])),
            'email' => strtolower(trim($validated['email'])),
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'status' => 'aktif',
            'telepon' => !empty($validated['telepon']) ? trim($validated['telepon']) : null,
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan masuk dengan username/email dan kata sandi Anda.');
    }

    /**
     * Reset kata sandi pengguna
     */
    public function resetPassword(Request $request)
    {
        $ip = $request->ip();
        $throttleKey = 'reset-password-attempt:' . $ip;

        // Proteksi Brute Force: Batasi maksimal 3 percobaan per 2 menit
        if (RateLimiter::tooManyAttempts($throttleKey, 3)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'forgot_identity' => "Terlalu banyak permintaan reset kata sandi. Demi keamanan, silakan tunggu {$seconds} detik sebelum mencoba kembali."
            ])->withInput();
        }

        RateLimiter::hit($throttleKey, 120);

        $request->validate([
            'forgot_identity' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ], [
            'forgot_identity.required' => 'Masukkan username atau email terdaftar.',
            'new_password.required' => 'Kata sandi baru wajib diisi.',
            'new_password.min' => 'Kata sandi baru minimal 6 karakter.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        $identity = trim($request->input('forgot_identity'));
        $user = User::where('email', strtolower($identity))
            ->orWhere('username', strtolower($identity))
            ->first();

        if (!$user) {
            return back()->withErrors([
                'forgot_identity' => 'Akun dengan username atau email tersebut tidak ditemukan dalam sistem.'
            ])->withInput();
        }

        // Proteksi Kritis: Akun Administrator DILARANG di-reset via formulir publik
        if (strtolower((string)$user->role) === 'admin') {
            return back()->withErrors([
                'forgot_identity' => 'Demi alasan keamanan tingkat tinggi, kata sandi Administrator tidak dapat diubah melalui formulir publik ini. Silakan hubungi Administrator Utama sistem.'
            ])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        RateLimiter::clear($throttleKey);

        return redirect()->route('login')->with('success', "Kata sandi akun {$user->name} berhasil diperbarui! Silakan masuk dengan kata sandi baru.");
    }
}
