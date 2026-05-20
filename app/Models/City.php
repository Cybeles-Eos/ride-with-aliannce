<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 * @package App\Models
 * @author Richard Guevara
 */
class City extends Model
{
    use SoftDeletes;

    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'state_id',
        'is_default',
    ];

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id');
    }
}