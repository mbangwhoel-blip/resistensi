<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Symfony\Component\HttpFoundation\Cookie;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    /**
     * Override method newCookie agar cookie XSRF-TOKEN selalu memiliki flag HttpOnly = true
     * untuk mencegah pembacaan dan pencurian token oleh skrip JavaScript pihak ketiga (XSS).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $config
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    protected function newCookie($request, $config)
    {
        return new Cookie(
            'XSRF-TOKEN',
            $request->session()->token(),
            $this->availableAt(60 * ($config['lifetime'] ?? 120)),
            $config['path'] ?? '/',
            $config['domain'] ?? null,
            $config['secure'] ?? $request->isSecure(),
            true, // HttpOnly = true (Mencegah pencurian token CSRF)
            false,
            $config['same_site'] ?? 'lax',
            $config['partitioned'] ?? false
        );
    }
}
