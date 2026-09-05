<?php

use App\Http\Middleware\CmsAuthenticate;
use App\Http\Middleware\SecurityHeaders;
use App\Http\Middleware\TrackPageView;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'cms.auth' => CmsAuthenticate::class,
        ]);

        // 2026-09-02 full review: baseline security headers + a lightweight
        // pageview counter, both previously missing entirely.
        $middleware->web(append: [
            SecurityHeaders::class,
            TrackPageView::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 2026-09-04: a CMS photo/gallery upload exceeding PHP's own
        // post_max_size/upload_max_filesize ini limits used to reach the
        // user as Laravel's raw PostTooLargeException page — happened for
        // real on a team-member photo upload even though our own
        // validation rule allows up to 5MB, because upload_max_filesize
        // was only 2M (fixed alongside this, see php.ini / deploy notes).
        // Client-side size checks in <x-cms.image-upload> now stop most of
        // these before they're ever submitted; this is the fallback for
        // whatever still gets through (JS disabled, several large gallery
        // files summing past post_max_size even though each is
        // individually under the per-file limit) — a friendly redirect
        // back to the form instead of a blank exception page.
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            $message = 'That upload was too large for the server to accept. Try fewer images at once, or smaller file sizes (max 5MB per image).';

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 413);
            }

            return back()->with('error', $message);
        });
    })->create();
