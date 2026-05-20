<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TemplateCamelCase
 * @package App\Models
 * @author Richard Guevara
 */
class TemplateCamelCase extends Model
{
    use SoftDeletes;

    protected $table = 'template_snake_case_plural';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'banner_image',
        'file',
        'content',
        'is_active',
    ];
}