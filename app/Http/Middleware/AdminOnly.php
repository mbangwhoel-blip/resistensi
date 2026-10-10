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

        if (strtolower((string)Auth::user()->role) !== 'admin') {
            abort(403, 'Akses Ditolak: Anda tidak memiliki izin Administrator untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
