<?php

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

/* for site restriction post */
Route::post('/site_restricted', ['as' => 'site_restricted', 'uses' => 'SiteRestrictedController@index']);

Route::group(
    [
        "middleware" => ['revalidate'],
    ], function () {

    /*
    * Admin
    */
    /* Login Routes */
    Route::get('/admin/login', ['as' => 'admin.login', 'uses' => 'Admin\Auth\LoginController@showLoginForm']);
    Route::post('/admin/login', ['as' => 'admin.login.post', 'uses' => 'Admin\Auth\LoginController@login']);
    Route::get('/admin/logout', ['as' => 'admin.logout', 'uses' => 'Admin\Auth\LoginController@logout']);
    Route::post('/admin/logout', ['as' => 'admin.logout.post', 'uses' => 'Admin\Auth\LoginController@logout']);

    /* Registration Routes */
//    Route::get('/admin/register', ['as' => 'admin.register', 'uses' => 'Admin\Auth\RegisterController@showRegistrationForm']);
//    Route::post('/admin/register', ['as' => 'admin.register.post', 'uses' => 'Admin\Auth\RegisterController@register']);

    /* Forgot Password Routes */
//    Route::get('/admin/password/email', ['as' => 'admin.password.email', 'uses' => 'Admin\Auth\ForgotPasswordController@showLinkRequestForm']);
//    Route::post('/admin/password/email', ['as' => 'admin.password.email.post', 'uses' => 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail']);
//    Route::get('/admin/password/reset/{token}', ['as' => 'admin.password.reset', 'uses' => 'Admin\Auth\ResetPasswordController@showResetForm']);
//    Route::post('/admin/password/reset', ['as' => 'admin.password.reset.post', 'uses' => 'Admin\Auth\ResetPasswordController@reset']);

    /*
     * Front
     */
    /* Login Routes */
    Route::get('/customer/login', ['as' => 'customer.login', 'uses' => 'Front\Auth\LoginController@showLoginForm']);
    Route::post('/customer/login', ['as' => 'customer.login.post', 'uses' => 'Front\Auth\LoginController@login']);
    Route::get('/customer/logout', ['as' => 'customer.logout', 'uses' => 'Front\Auth\LoginController@logout']);
    Route::post('/customer/logout', ['as' => 'customer.logout.post', 'uses' => 'Front\Auth\LoginController@logout']);

    /* Registration Routes */
    Route::get('/customer/register', ['as' => 'customer.register', 'uses' => 'Front\Auth\RegisterController@showRegistrationForm']);
    Route::post('/customer/register', ['as' => 'customer.register.post', 'uses' => 'Front\Auth\RegisterController@register']);

    /* Forgot Password Routes */
    Route::get('/customer/password/email', ['as' => 'customer.password.email', 'uses' => 'Front\Auth\ForgotPasswordController@showLinkRequestForm']);
    Route::post('/customer/password/email', ['as' => 'customer.password.email.post', 'uses' => 'Front\Auth\ForgotPasswordController@sendResetLinkEmail']);
    Route::get('/customer/password/reset/{token}', ['as' => 'customer.password.reset', 'uses' => 'Front\Auth\ResetPasswordController@showResetForm']);
    Route::post('/customer/password/reset', ['as' => 'customer.password.reset.post', 'uses' => 'Front\Auth\ResetPasswordController@reset']);
});