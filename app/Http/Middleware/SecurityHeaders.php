<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Menambahkan header keamanan HTTP untuk melindungi aplikasi dari:
     * - Clickjacking (X-Frame-Options)
     * - MIME sniffing (X-Content-Type-Options)
     * - XSS & Data Injection (Content-Security-Policy & X-XSS-Protection)
     * - Kebocoran versi server / fingerprinting (Server, X-Powered-By)
     * - Pencurian cookie sesi (HttpOnly & Secure enforcement)
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Matikan expose PHP & sembunyikan banner
        @ini_set('expose_php', '0');
        if (function_exists('header_remove') && !headers_sent()) {
            @header_remove('X-Powered-By');
            @header_remove('Server');
        }

        $response = $next($request);

        // Hapus header fingerprinting dari response object
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');

        // 1. HTTP Security Headers Standar
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(self)');

        // 2. Content-Security-Policy (CSP)
        // Membatasi sumber skrip, gaya, font, gambar, dan koneksi agar terhindar dari XSS & data injection
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://unpkg.com; " .
               "style-src 'self' 'unsafe-inline' https://fonts.bunny.net https://fonts.googleapis.com https://cdn.jsdelivr.net https://unpkg.com; " .
               "img-src 'self' data: blob: https://*.tile.openstreetmap.org https://*.openstreetmap.org https://unpkg.com https://cdn.jsdelivr.net; " .
               "font-src 'self' data: https://fonts.bunny.net https://fonts.gstatic.com; " .
               "connect-src 'self' https://nominatim.openstreetmap.org https://*.tile.openstreetmap.org https://*.openstreetmap.org; " .
               "frame-src 'self'; " .
               "object-src 'none'; " .
               "base-uri 'self'; " .
               "form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        // 3. Strict-Transport-Security (HSTS)
        // Hanya dikirim saat koneksi sudah HTTPS agar tidak memblokir akses lokal via http
        if ($request->secure() || $request->header('X-Forwarded-Proto') === 'https') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // 4. Penguatan Cookie Keamanan (Session & Cookie Security)
        // Memastikan flag HttpOnly aktif pada semua cookie sesi dan CSRF agar tidak bisa dicuri script XSS
        $isHttps = $request->secure() || $request->header('X-Forwarded-Proto') === 'https';
        foreach ($response->headers->getCookies() as $cookie) {
            $updated = $cookie;

            // Pastikan HttpOnly aktif untuk mencegah pencurian cookie via JavaScript
            if (!$cookie->isHttpOnly()) {
                $updated = $updated->withHttpOnly(true);
            }

            // Jika koneksi HTTPS, pastikan flag Secure juga aktif
            if ($isHttps && !$cookie->isSecure()) {
                $updated = $updated->withSecure(true);
            }

            if ($updated !== $cookie) {
                $response->headers->setCookie($updated);
            }
        }

        return $response;
    }
}
