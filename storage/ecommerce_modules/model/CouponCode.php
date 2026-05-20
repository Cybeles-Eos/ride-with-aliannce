<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class CouponCode
 * @package App\Models
 * @author Richard Guevara
 */
class CouponCode extends Model
{
    use SoftDeletes;

    protected $table = 'coupon_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'code',
        'value',
        'type',
        'date_start',
        'date_end',
    ];
}