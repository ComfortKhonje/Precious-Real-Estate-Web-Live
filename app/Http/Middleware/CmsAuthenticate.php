<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CmsAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        // Allow either legacy session flag or a logged-in user (web guard)
        if ($request->session()->get('cms_authenticated') === true || Auth::check()) {
            return $next($request);
        }

        return redirect()->route('cms.login');
    }
}
