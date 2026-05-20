<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderAddressDetail
 * @package App\Models
 * @author Richard Guevara
 */
class OrderAddressDetail extends Model
{
    use SoftDeletes;

    protected $table = 'order_address_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'ext',
        'company',
        'address',
        'address_2',
        'city',
        'state',
        'zip',
        'country',
        'type',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
}