<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CanBackupRestore
{
    /**
     * Memastikan semua pengguna kecuali role viewer (visitor) dapat mengakses menu Backup & Restore.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu untuk mengakses halaman ini.');
        }

        $user = Auth::user();
        $isViewer = strtolower((string)$user->role) === 'viewer' || (method_exists($user, 'isViewer') && $user->isViewer());

        if ($isViewer) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses Ditolak: Akun dengan role Viewer (Visitor) tidak memiliki izin mengakses menu Backup & Restore.'
                ], 403);
            }

            return redirect()->route('dashboard')->with('error', 'Akses Ditolak: Akun dengan role Viewer (Visitor) tidak memiliki izin mengakses menu Backup & Restore.');
        }

        return $next($request);
    }
}
