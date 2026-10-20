<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna/user admin.
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $roleFilter = $request->get('role', 'Semua');
        $statusFilter = $request->get('status', 'Semua');
        $perPageRaw = $request->get('per_page', 10);

        if ($perPageRaw === 'all' || (int)$perPageRaw >= 999999) {
            $perPage = 999999;
        } elseif (in_array((int)$perPageRaw, [5, 10, 25, 50, 100])) {
            $perPage = (int)$perPageRaw;
        } else {
            $perPage = 10;
        }

        $query = User::query()->orderBy('id', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($roleFilter && $roleFilter !== 'Semua') {
            if ($roleFilter === 'dinas_kesehatan') {
                $query->whereIn('role', ['dinas_kesehatan', 'dinkes']);
            } elseif ($roleFilter === 'balai_kekarantinaan_kesehatan') {
                $query->whereIn('role', ['balai_kekarantinaan_kesehatan', 'bkk', 'balai_karantina']);
            } elseif ($roleFilter === 'universitas') {
                $query->whereIn('role', ['universitas', 'akademisi']);
            } else {
                $query->where('role', $roleFilter);
            }
        }

        if ($statusFilter && $statusFilter !== 'Semua') {
            $query->where('status', $statusFilter);
        }

        $users = $query->paginate($perPage)->withQueryString();

        // Statistik ringkas pengguna
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'petugas' => User::where('role', 'petugas')->count(),
            'dinas_kesehatan' => User::whereIn('role', ['dinas_kesehatan', 'dinkes'])->count(),
            'balai_kekarantinaan_kesehatan' => User::whereIn('role', ['balai_kekarantinaan_kesehatan', 'bkk', 'balai_karantina'])->count(),
            'labkesmas' => User::where('role', 'labkesmas')->count(),
            'peneliti' => User::where('role', 'peneliti')->count(),
            'universitas' => User::where('role', 'universitas')->count(),
            'viewer' => User::where('role', 'viewer')->count(),
            'aktif' => User::where('status', 'aktif')->count(),
            'nonaktif' => User::where('status', 'nonaktif')->count(),
        ];

        return view('users', compact('users', 'search', 'roleFilter', 'statusFilter', 'stats', 'perPage', 'perPageRaw'));
    }

    /**
     * Simpan pengguna baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|alpha_dash|min:3|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,petugas,viewer,dinas_kesehatan,dinkes,balai_kekarantinaan_kesehatan,bkk,balai_karantina,labkesmas,kepala,pimpinan,peneliti,universitas',
            'status' => 'required|in:aktif,nonaktif',
            'telepon' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung (-) dan garis bawah (_).',
            'username.unique' => 'Username ini sudah digunakan oleh akun lain.',
            'username.min' => 'Username minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar dalam sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Pilih role / hak akses pengguna.',
            'role.in' => 'Role yang dipilih tidak valid.',
            'status.required' => 'Pilih status akun pengguna.',
        ]);

        $role = $validated['role'];
        if ($role === 'dinkes') $role = 'dinas_kesehatan';
        if ($role === 'bkk' || $role === 'balai_karantina') $role = 'balai_kekarantinaan_kesehatan';

        User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'status' => $validated['status'],
            'phone' => $validated['telepon'] ?? null,
        ]);

        return redirect()->route('users.index')->with('success', "Akun pengguna '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Perbarui data pengguna yang ada.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|alpha_dash|min:3|max:50|unique:users,username,' . $id,
            'email' => 'required|email|max:100|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:admin,petugas,viewer,dinas_kesehatan,dinkes,balai_kekarantinaan_kesehatan,bkk,balai_karantina,labkesmas,kepala,pimpinan,peneliti,universitas',
            'status' => 'required|in:aktif,nonaktif',
            'telepon' => 'nullable|string|max:20',
        ], [
            'name.required' => 'Nama lengkap pengguna wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, tanda hubung (-) dan garis bawah (_).',
            'username.unique' => 'Username ini sudah digunakan oleh akun lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.min' => 'Password baru minimal terdiri dari 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'role.required' => 'Pilih role hak akses.',
            'status.required' => 'Pilih status akun.',
        ]);

        $role = $validated['role'];
        if ($role === 'dinkes') $role = 'dinas_kesehatan';
        if ($role === 'bkk' || $role === 'balai_karantina') $role = 'balai_kekarantinaan_kesehatan';

        // Keamanan: Cegah admin menonaktifkan atau menurunkan role akunnya sendiri yang sedang aktif
        if (Auth::check() && Auth::id() === $user->id) {
            if ($validated['status'] === 'nonaktif') {
                return redirect()->back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri yang sedang digunakan.');
            }
            if ($role !== 'admin') {
                return redirect()->back()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri menjadi non-admin.');
            }
        }

        $dataUpdate = [
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'role' => $role,
            'status' => $validated['status'],
            'phone' => $validated['telepon'] ?? null,
        ];

        // Ganti password hanya jika diisi
        if (!empty($validated['password'])) {
            $dataUpdate['password'] = Hash::make($validated['password']);
        }

        $user->update($dataUpdate);

        return redirect()->route('users.index')->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Hapus pengguna dari sistem.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Keamanan: Cegah penghapusan akun diri sendiri
        if (Auth::check() && Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif login.');
        }

        // Keamanan: Cegah penghapusan admin terakhir
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus satu-satunya akun Administrator pada sistem.');
        }

        $nama = $user->name;
        $user->delete();

        return redirect()->route('users.index')->with('success', "Akun pengguna '{$nama}' berhasil dihapus secara permanen.");
    }
}
