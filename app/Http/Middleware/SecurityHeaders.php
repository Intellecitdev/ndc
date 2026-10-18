<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Browser hardening headers on every response: no framing by other sites (clickjacking),
 * no MIME sniffing, no full URLs leaked to other sites, HSTS once the site runs on HTTPS.
 */
class SecurityHeaders
{
    private const HEADERS = [
        'X-Frame-Options' => 'SAMEORIGIN',
        'X-Content-Type-Options' => 'nosniff',
        'Referrer-Policy' => 'strict-origin-when-cross-origin',
        'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=(), usb=()',
        // Only directives that can't break the app's own pages (inline scripts/Alpine keep working).
        'Content-Security-Policy' => "frame-ancestors 'self'; object-src 'none'; base-uri 'self'",
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        foreach (self::HEADERS as $name => $value) {
            if (! $response->headers->has($name)) {
                $response->headers->set($name, $value);
            }
        }

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Don't advertise the PHP version.
        if (! headers_sent()) {
            header_remove('X-Powered-By');
        }

        return $response;
    }
}
