<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class ClearanceMiddleware
 * @package App\Http\Middleware
 * @author Richard Guevara
 */
class ClearanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         * Defined the redirect to 401 page in methods for accuracy
         * */
//        if ($request->is('admin/posts/create'))//If user is creating a post
//        {
//            if (!auth()->user()->hasPermissionTo('Create Post')) {
//                abort('401');
//            } else {
//                return $next($request);
//            }
//        }
//
//        if ($request->is('admin/posts/*/edit')) //If user is editing a post
//        {
//            if (!auth()->user()->hasPermissionTo('Edit Post')) {
//                abort('401');
//            } else {
//                return $next($request);
//            }
//        }
//
//        if ($request->is('admin/posts/*')) //If user is viewing a post
//        {
//            if (!auth()->user()->hasPermissionTo('View Post')) {
//                abort('401');
//            } else {
//                return $next($request);
//            }
//        }
//
//        if ($request->isMethod('Delete')) //If user is deleting a post
//        {
//            if (!auth()->user()->hasPermissionTo('Delete Post')) {
//                abort('401');
//            } else {
//                return $next($request);
//            }
//        }

        return $next($request);
    }
}