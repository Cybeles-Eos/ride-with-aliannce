<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Illuminate\Support\Facades\Hash;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        /* custom old password validation */
        Validator::extend('old_password', function ($attribute, $value, $parameters) {
            return Hash::check($value, auth()->user()->password);
        });
        Validator::replacer('old_password', function ($message, $attribute, $rule, $parameters) {
            return 'The old password you entered is incorrect.';
        });

        if (env('APP_ENV') == 'prod_ssl') {
            url()->forceScheme('https');
        }

//        \Artisan::call('view:clear');
//        \Artisan::call('cache:clear');
//        \Artisan::call('route:clear');
//        \Artisan::call('config:clear');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
