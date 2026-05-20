<?php

/* carts */
Route::post('/carts/store', [
    'uses' => '\App\Http\Controllers\CartController@store',
    'as' => 'carts.store'
]);

Route::put('/carts/{id}/update',
    ['as' => 'carts.update',
        'uses' => '\App\Http\Controllers\CartController@update']
);

Route::delete('/carts/{id}/delete',
    ['as' => 'carts.delete',
        'uses' => '\App\Http\Controllers\CartController@destroy']
);