<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class AdminRedirectIfAuthenticated
 * @package App\Http\Middleware
 * @author Richard Guevara
 */
class AdminRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (auth()->guard($guard)->check()) {
            return redirect('/admin/dashboard');
        }

        return $next($request);
    }
}
