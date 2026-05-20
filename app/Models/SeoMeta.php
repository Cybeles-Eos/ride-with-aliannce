<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class SeoMeta
 * @package App\Models
 * @author Richard Guevara
 */
class SeoMeta extends Model
{
    use SoftDeletes;

    protected $table = 'seo_metas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_title',
        'meta_keywords',
        'meta_description',
        'canonical_link',
    ];
}