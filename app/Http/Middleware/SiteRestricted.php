<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class SiteRestricted
 * @package App\Http\Middleware
 * @author Richard Guevara
 */
class SiteRestricted
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
        /* uncomment to test and show the form */
        /* session */
//        session()->forget(env('SITE_RESTRICTION_VAR)');

        /* cookie */
//        Cookie::queue(
//            Cookie::forget(env('SITE_RESTRICTION_VAR)')
//        );
        /* uncomment to test and show the restricted page */

        if (env('SITE_RESTRICTED')) {
            if (env('SITE_RESTRICTION_TYPE') == 'cookie') {
                /* cookie */
                if (!($request->cookies->has(env('SITE_RESTRICTION_VAR')) && $request->cookie(env('SITE_RESTRICTION_VAR')))) {
                    if (!($request->getMethod() == 'POST' && $request->getPathInfo() == '/site_restricted')) {
                        return response(view('errors.site_restricted'));
                    }
                }
            } else {
                /* session */
                if (!session()->has(env('SITE_RESTRICTION_VAR')) && !session()->get(env('SITE_RESTRICTION_VAR'))) {
                    if (!($request->getMethod() == 'POST' && $request->getPathInfo() == '/site_restricted')) {
                        return response(view('errors.site_restricted'));
                    }
                }
            }
        }

        return $next($request);
    }
}
