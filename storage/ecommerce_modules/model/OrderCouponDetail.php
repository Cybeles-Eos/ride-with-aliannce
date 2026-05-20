<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderCouponDetail
 * @package App\Models
 * @author Richard Guevara
 */
class OrderCouponDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_coupon_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'coupon_id',
        'coupon_code',
        'total_amount',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function coupon()
    {
        return $this->hasOne('App\Models\CouponCode', 'id', 'coupon_id');
    }
}