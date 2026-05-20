<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderItemDetail
 * @package App\Models
 * @author Richard Guevara
 */
class OrderItemDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_item_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'name',
        'product_unit',
        'quantity',
        'price',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}