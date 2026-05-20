<?php

/* orders */
Route::get('/orders/draw', [
        'as' => 'admin.orders.draw',
        'uses' => '\App\Http\Controllers\OrderController@draw']
);

Route::post('/orders/{id}/update_status',
    ['as' => 'admin.orders.update_status',
        'uses' => '\App\Http\Controllers\OrderController@updateStatus']
);

Route::resource('/orders', 'OrderController', [
    'as' => 'admin'
]);

Route::delete('/orders/{id}/delete',
    ['as' => 'admin.orders.delete',
        'uses' => '\App\Http\Controllers\OrderController@destroy']
);
/* orders */

/* coupon_codes */
Route::resource('/coupon_codes', 'CouponCodeController', [
    'as' => 'admin'
]);

Route::delete('/coupon_codes/{id}/delete',
    ['as' => 'admin.coupon_codes.delete',
        'uses' => '\App\Http\Controllers\CouponCodeController@destroy']
);
/* coupon_codes */

/* taxes */
Route::resource('/taxes', 'TaxController', [
    'as' => 'admin'
]);

Route::delete('/taxes/{id}/delete',
    ['as' => 'admin.taxes.delete',
        'uses' => '\App\Http\Controllers\TaxController@destroy']
);
/* taxes */