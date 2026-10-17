<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /**
     * Memastikan hanya pengguna dengan hak akses role Administrator yang dapat mengakses rute ini.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu dengan akun Administrator untuk mengakses halaman ini.');
        }

        $userRole = strtolower((string)Auth::user()->role);
        $allowedRoles = ['admin', 'kepala', 'pimpinan', 'kepala_balai', 'kepala_bblkl', 'pimpinan_bblkl'];

        if (!in_array($userRole, $allowedRoles)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses Ditolak: Halaman ini hanya dapat diakses oleh Administrator atau Kepala/Pimpinan.'
                ], 403);
            }

            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Menu Rekomendasi Kebijakan & Master Data hanya dapat diakses oleh Administrator atau Kepala/Pimpinan BBLKL.');
        }


        return $next($request);
    }
}
