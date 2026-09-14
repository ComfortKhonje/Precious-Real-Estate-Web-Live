<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CmsAuthenticate
{
    /** Routes a user with a pending forced password change can still reach. */
    private const PASSWORD_CHANGE_ALLOWED = ['cms.settings.index', 'cms.settings.password', 'cms.logout'];

    public function handle(Request $request, Closure $next): Response
    {
        // 2026-09-14: the old `cms_authenticated` session flag (set by an
        // env-password login that has since been removed) is no longer
        // accepted on its own — every CMS request needs a real user so its
        // role can be checked.
        if (! Auth::check()) {
            return redirect()->route('cms.login');
        }

        if (Auth::user()->must_change_password && ! $request->routeIs(...self::PASSWORD_CHANGE_ALLOWED)) {
            return redirect()->route('cms.settings.index')
                ->with('error', 'Please choose a new password before continuing.');
        }

        return $next($request);
    }
}
