<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderShippingDetail
 * @package App\Models
 * @author Richard Guevara
 */
class OrderShippingDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_shipping_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'shipping_method',
        'reference_no',
        'total_amount',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}