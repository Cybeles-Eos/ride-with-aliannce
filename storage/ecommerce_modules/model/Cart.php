<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Cart
 * @package App\Models
 * @author Richard Guevara
 */
class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_unit_id',
        'quantity',
        'price',
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id','product_id');
    }

    public function product_unit()
    {
        return $this->hasOne('App\Models\ProductUnit', 'id','product_unit_id');
    }

    public function getTotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}