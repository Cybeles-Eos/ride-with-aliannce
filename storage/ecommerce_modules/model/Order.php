<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @author Richard Guevara
 */
class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'reference_no',
        'subtotal_amount',
        'total_amount',
        'order_status_id',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'order_status_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\OrderItemDetail', 'order_id');
    }

    public function billing_address()
    {
        return $this->hasOne('App\Models\OrderAddressDetail', 'order_id')->where('type', 1);
    }

    public function shipping_address()
    {
        return $this->hasOne('App\Models\OrderAddressDetail', 'order_id')->where('type', 2);
    }

    public function shipping_details()
    {
        return $this->hasOne('App\Models\OrderShippingDetail', 'order_id');
    }

    public function payment_details()
    {
        return $this->hasOne('App\Models\OrderPaymentDetail', 'order_id');
    }

    public function tax_details()
    {
        return $this->hasOne('App\Models\OrderTaxDetail', 'order_id');
    }

    public function coupon_details()
    {
        return $this->hasOne('App\Models\OrderCouponDetail', 'order_id');
    }
}