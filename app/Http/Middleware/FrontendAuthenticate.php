<?php

namespace App\Http\Middleware;

use Closure;

class FrontendAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('frontend_login')) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                session()->put('frontend_redirect_url', $request->fullUrl());
                return redirect('login');
            }
        }

        return $next($request);
    }
}
