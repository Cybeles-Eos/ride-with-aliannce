<?php

/*
|--------------------------------------------------------------------------
| Main Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "main" middleware group. Now create something great!
|
*/

//Route::group(
//    [
//        "middleware" => ['isAdmin', 'revalidate'],
//        "prefix" => 'admin'
//    ], function () {
//
//    /* dashboard routes */
//    Route::get('/', function () {
//        return redirect('/admin/dashboard');
//    });
//
//    /* dashboard */
//    Route::get('/dashboard', [
//        'uses' => '\App\Http\Controllers\AdminDashboardController@index',
//        'as' => 'admin.dashboard',
//    ]);
//    /* dashboard */
//
//    /* users */
//    Route::resource('/users', 'UserController', [
//        'as' => 'admin'
//    ]);
//
//    Route::delete('/users/{id}/delete',
//        ['as' => 'admin.users.delete',
//            'uses' => '\App\Http\Controllers\UserController@destroy']
//    );
//    /* users */
//
//    /* roles */
//    Route::resource('/roles', 'RoleController', [
//        'as' => 'admin'
//    ]);
//
//    Route::delete('/roles/{id}/delete',
//        ['as' => 'admin.roles.delete',
//            'uses' => '\App\Http\Controllers\RoleController@destroy']
//    );
//    /* roles */
//
//    /* permissions */
//    Route::resource('/permissions', 'PermissionController', [
//        'as' => 'admin'
//    ]);
//
//    Route::delete('/permissions/{id}/delete',
//        ['as' => 'admin.permissions.delete',
//            'uses' => '\App\Http\Controllers\PermissionController@destroy']
//    );
//    /* permissions */
//
//    /* permission groups */
//    Route::resource('/permission_groups', 'PermissionGroupController', [
//        'as' => 'admin'
//    ]);
//
//    Route::delete('/permission_groups/{id}/delete',
//        ['as' => 'admin.permission_groups.delete',
//            'uses' => '\App\Http\Controllers\PermissionGroupController@destroy']
//    );
//    /* permission groups */
//
//    /* system settings */
//    Route::resource('/system_settings', 'SystemSettingController', [
//        'as' => 'admin',
//    ]);
//
//    Route::delete('/system_settings/{id}/delete',
//        ['as' => 'admin.system_settings.delete',
//            'uses' => '\App\Http\Controllers\SystemSettingController@destroy']
//    );
//    /* system settings */
//
//    /* posts */
//    Route::resource('/posts', 'PostController', [
//        'as' => 'admin'
//    ]);
//
//    Route::delete('/posts/{id}/delete',
//        ['as' => 'admin.posts.delete',
//            'uses' => '\App\Http\Controllers\PostController@destroy']
//    );
//    /* posts */
//
//    /* pages */
//    Route::resource('/pages', 'PageController', [
//        'as' => 'admin'
//    ]);
//
//    Route::delete('/pages/{id}/delete',
//        ['as' => 'admin.pages.delete',
//            'uses' => '\App\Http\Controllers\PageController@destroy']
//    );
//    /* pages */
//
//
//    /* ckeditor image upload */
//    Route::post('/ckeditor_image_upload',
//        ['as' => 'admin.ckeditor_image_upload',
//            'uses' => '\App\Http\Controllers\PageController@ckEditorImageUpload']
//    );
//    /* ckeditor image upload */
//});

Route::group(
    [
        "middleware" => ['isFront', 'revalidate'],
        "prefix" => 'customer'
    ], function () {

    /* dashboard routes */
    Route::get('/', function () {
        return redirect('customer/dashboard');
    });

    Route::get('/dashboard', [
        'uses' => '\App\Http\Controllers\FrontDashboardController@index',
        'as' => 'customer.dashboard',
    ]);
});

Route::group(
    [
        "middleware" => ['revalidate'],
    ], function () {

    /* contacts */
    Route::post('/contact/store', [
        'uses' => '\App\Http\Controllers\ContactController@store',
        'as' => 'contact.store'
    ]);
    /* contact */

//    Route::get('/', '\App\Http\Controllers\PageController@home');

    Route::get('/{slug?}', '\App\Http\Controllers\PageController@showPages');
});