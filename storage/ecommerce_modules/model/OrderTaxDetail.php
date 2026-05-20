<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderTaxDetail
 * @package App\Models
 * @author Richard Guevara
 */
class OrderTaxDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_tax_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'tax_percentage',
        'total_amount',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}