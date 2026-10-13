<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PreventViewerModification
{
    /**
     * Memastikan pengguna dengan role 'viewer' tidak dapat menambah, mengedit, atau menghapus data.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = strtolower((string)$user->role);

            if ($role === 'viewer') {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin untuk melihat data (read-only).'
                    ], 403);
                }

                $previousUrl = url()->previous();
                $currentUrl = $request->fullUrl();

                if ($previousUrl === $currentUrl || empty($previousUrl)) {
                    return redirect()->route('dashboard')->with(
                        'error',
                        'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only) tanpa hak akses menambah, mengedit, atau menghapus data.'
                    );
                }

                return redirect()->back()->with(
                    'error',
                    'Akses Ditolak: Akun dengan role Viewer hanya memiliki izin melihat data (read-only) tanpa hak akses menambah, mengedit, atau menghapus data.'
                );
            }
        }

        return $next($request);
    }
}
