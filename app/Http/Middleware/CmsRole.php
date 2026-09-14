<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * `cms.role:admin` — admits users whose role ranks at or above the given
 * one (see User::ROLES). Runs after cms.auth, so a user is always present.
 */
class CmsRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user()?->hasRoleAtLeast($role)) {
            abort(403, 'Your account does not have access to this section.');
        }

        return $next($request);
    }
}
