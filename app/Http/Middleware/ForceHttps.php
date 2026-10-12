<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * Paksa seluruh trafik aplikasi berjalan melalui HTTPS saat dijalankan di server produksi
     * (mis. di belakang Cloudflare / reverse proxy). Di lingkungan lokal (FORCE_HTTPS=false)
     * middleware ini tidak melakukan apa-apa sehingga development via http tetap berjalan normal.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('app.force_https')) {
            return $next($request);
        }

        URL::forceScheme('https');

        // Jika request masih datang via HTTP dan bukan dari proxy yang meneruskan HTTPS,
        // alihkan ke versi HTTPS agar tidak muncul peringatan "Not secure".
        // Hanya metode aman (GET/HEAD) yang dialihkan agar body request POST tidak hilang.
        if (! $request->secure() && $request->isMethodSafe()) {
            return redirect()->to($request->getRequestUri(), 301);
        }

        return $next($request);
    }
}
