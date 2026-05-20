<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class OrderLog
 * @package App\Models
 * @author Richard Guevara
 */
class OrderLog extends Model
{
    use SoftDeletes;

    protected $table = 'order_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'order_status_id',
        'user_id',
        'comments',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

    public function status()
    {
        return $this->hasOne('App\Models\OrderStatus', 'id', 'order_status_id');
    }
}