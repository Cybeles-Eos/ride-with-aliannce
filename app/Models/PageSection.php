<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PageSection
 * @package App\Models
 * @author Richard Guevara
 */
class PageSection extends Model
{
    use SoftDeletes;

    public $timestamps = true;
    protected $table = 'page_sections';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'section',
        'content',
        'type',
        'position',
    ];

    public function page()
    {
        return $this->belongsTo('App\Models\Page', 'page_id');
    }
}