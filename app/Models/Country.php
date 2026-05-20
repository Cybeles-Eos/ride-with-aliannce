<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Country
 * @package App\Models
 * @author Richard Guevara
 */
class Country extends Model
{
    use SoftDeletes;

    protected $table = 'countries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'is_default',
    ];

    public function states()
    {
        return $this->hasMany('App\Models\State', 'country_id', 'id');
    }
}