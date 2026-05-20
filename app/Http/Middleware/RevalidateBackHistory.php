<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class RevalidateBackHistory
 * @package App\Http\Middleware
 * @author Richard Guevara
 */
class RevalidateBackHistory
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        return $response->header('Cache-Control', 'private, no-cache, no-store,  must-revalidate, post-check=0, pre-check=0, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}