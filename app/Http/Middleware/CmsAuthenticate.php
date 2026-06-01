<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsAuthenticate
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('cms_authenticated') === true) {
            return $next($request);
        }

        return redirect()->route('cms.login');
    }
}

