<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderPaymentDetail
 * @package App\Models
 * @author Richard Guevara
 */
class OrderPaymentDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_payment_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'transaction_id',
        'gateway',
        'total_amount',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}