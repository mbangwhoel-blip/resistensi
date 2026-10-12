<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Menambahkan header keamanan HTTP untuk melindungi aplikasi dari Clickjacking, MIME sniffing, XSS, dan kebocoran informasi.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hapus banner X-Powered-By agar fingerprinting server tidak bocor
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        // Terapkan header keamanan HTTP standar
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');

        // HSTS: paksa browser selalu memakai HTTPS pada kunjungan berikutnya.
        // Hanya dikirim saat koneksi sudah HTTPS agar tidak memblokir akses lokal via http.
        if ($request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
