<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class HomeSlide
 * @package App\Models
 * @author Richard Guevara
 */
class HomeSlide extends Model
{
    use SoftDeletes;

    protected $table = 'home_slides';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'background_image',
        'content',
        'button_label',
        'button_link',
        'is_active',
    ];
}