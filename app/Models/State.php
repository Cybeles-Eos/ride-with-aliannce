<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class State
 * @package App\Models
 * @author Richard Guevara
 */
class State extends Model
{
    use SoftDeletes;

    protected $table = 'states';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'country_id',
        'tax',
        'is_default',
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function cities()
    {
        return $this->hasMany('App\Models\City', 'state_id', 'id');
    }
}