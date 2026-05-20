<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class SiteRestrictedController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class SiteRestrictedController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SiteRestricted Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles system settings.
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        /*
         * Model namespace
         * using $this->system_setting_model can also access $this->system_setting_model->where('id', 1)->get();
         * */

        /*
         * Repository namespace
         * this class may include methods that can be used by other controllers, like getting of system_settings with other data (related tables).
         * */

//        $this->middleware(['isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $site_password = env('SITE_RESTRICTION_PASSWORD');
        $this->validate($request, [
            'site_restricted_password' => [
                'required',
                function ($attribute, $value, $fail) use ($site_password) {
                    if ($value != $site_password) {
                        $fail('Password is invalid.');
                    }
                },
            ]
        ]);

        if (env('SITE_RESTRICTED')) {
            if (env('SITE_RESTRICTION_TYPE') == 'cookie') {
                /* cookie */
                cookie()->queue(env('SITE_RESTRICTION_VAR'), TRUE, 1440);
            } else {
                /* session */
                session()->put(env('SITE_RESTRICTION_VAR'), TRUE);
            }
        }
        return redirect()->back();
    }
}
