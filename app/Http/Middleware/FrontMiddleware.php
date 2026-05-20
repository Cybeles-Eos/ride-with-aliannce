<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class FrontMiddleware
 * @package App\Http\Middleware
 * @author Richard Guevara
 */
class FrontMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = NULL)
    {
        if (!auth()->check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('/customer/login');
            }
        }

        /*
         * This will determine which roles can access the front site
         * */
        if (!auth()->user()->hasAnyRole(['Customer'])) {
            abort('401', '401');
        }

        return $next($request);
    }
}