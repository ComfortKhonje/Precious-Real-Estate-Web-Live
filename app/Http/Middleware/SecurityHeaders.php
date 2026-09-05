<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Baseline security headers — added 2026-09-02 from the full-site review
 * (the app previously shipped a completely stock Laravel .htaccess with no
 * hardening headers at all).
 *
 * Deliberately NOT including a Content-Security-Policy here. The site loads
 * third-party scripts (Google Fonts, GSAP from cdnjs, Alpine.js from
 * jsdelivr) and a strict CSP needs to be built and tested against every
 * page before going live, or it silently breaks things. Getting a real CSP
 * in place is flagged as a follow-up in the maintenance plan doc — better
 * to ship the safe headers now than delay them waiting on a CSP that
 * needs real browser testing this session can't do (no local server
 * running).
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}
