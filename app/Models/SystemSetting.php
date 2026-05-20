<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SystemSetting
 * @package App\Models
 * @author Richard Guevara
 */
class SystemSetting extends Model
{
    use SoftDeletes;

    protected $table = 'system_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'value',
    ];
}