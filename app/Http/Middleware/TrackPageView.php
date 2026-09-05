<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Logs one row per real public-page GET request, for the CMS Analytics
 * page's "how many people have come to see it" numbers. Added 2026-09-02.
 *
 * Deliberately skips: CMS/admin routes, the API, assets/storage, non-GET
 * requests, and requests carrying an obvious bot/crawler user agent. This
 * is a rough traffic counter, not a security or bot-detection tool — the
 * bot filter is a light heuristic, not exhaustive.
 */
class TrackPageView
{
    private const SKIP_PREFIXES = ['cms', 'api', 'storage', 'sanctum', 'up'];

    private const BOT_SIGNATURES = [
        'bot', 'crawl', 'spider', 'slurp', 'facebookexternalhit',
        'whatsapp', 'telegrambot', 'discordbot', 'curl', 'wget',
        'python-requests', 'ahrefs', 'semrush', 'mj12bot', 'petalbot',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if ($this->shouldTrack($request)) {
            // Fire-and-forget insert — never let logging break or slow the
            // actual page response.
            try {
                PageView::create(['path' => '/'.ltrim($request->path(), '/')]);
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $next($request);
    }

    private function shouldTrack(Request $request): bool
    {
        if (! $request->isMethod('GET') || $request->ajax()) {
            return false;
        }

        $path = ltrim($request->path(), '/');
        foreach (self::SKIP_PREFIXES as $prefix) {
            if ($path === $prefix || str_starts_with($path, "{$prefix}/")) {
                return false;
            }
        }

        $ua = strtolower($request->userAgent() ?? '');
        if ($ua === '') {
            return false;
        }
        foreach (self::BOT_SIGNATURES as $signature) {
            if (str_contains($ua, $signature)) {
                return false;
            }
        }

        return true;
    }
}
