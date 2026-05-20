<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderStatus
 * @package App\Models
 * @author Richard Guevara
 */
class OrderStatus extends Model
{
    use SoftDeletes;

    protected $table = 'order_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
    ];

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'order_status_id');
    }
}