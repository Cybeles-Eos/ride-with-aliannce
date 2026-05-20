<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Attachments\HasAttachment;

class Section extends Model
{
    use SoftDeletes, HasAttachment;

    const EDITOR = 1;
    const ATTACHMENT = 2;
    const FORM = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'alias',
        'section_template_id',
        'type',
        'value',
        'settings',
        'is_active'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = ['pivot', 'deleted_at'];

    /**
     * Checks to see if this section is an editor.
     *
     * @return bool
     */
    public final function getIsEditorAttribute()
    {
        return $this->attributes['type'] === self::EDITOR;
    }

    /**
     * Checks to see if this section is an attachment.
     *
     * @return bool
     */
    public final function getIsAttachmentAttribute()
    {
        return $this->attributes['type'] === self::ATTACHMENT;
    }

    /**
     * Checks to see if this section is a form.
     *
     * @return bool
     */
    public final function getIsFormAttribute()
    {
        return $this->attributes['type'] === self::FORM;
    }

    /**
     * Checks to see if this section is a repeater.
     *
     * @return bool
     */
    public final function getIsRepeaterAttribute()
    {
        return $this->type === 'repeater';
    }

    /**
     * Generate a slug base on the section name.
     *
     * @return string
     */
    public final function getAliasAttribute()
    {
        return str_slug($this->attributes['name']);
    }

    /**
     * Get and parse the section content.
     *
     * @param Builder $query
     * @param string $name
     * @return false|mixed|string
     */
    public final function scopeContent(Builder $query,$name)
    {
        $section = $query->whereName($name)->first();

        if (empty($section)) return '';

        if ($section->isAttachment)
            return $section->attachment;

        if ($section->isEditor)
            return parse($section->value);

        if ($section->isForm)
            return json_decode($section->value);

        return '';
    }

    public function template()
    {
        return $this->belongsTo(SectionTemplate::class, 'section_template_id');
    }
    
    public function pages()
    {
        return $this->belongsToMany(Page::class, 'page_section_order')
                    ->withPivot('sort_order', 'is_active')
                    ->orderBy('page_section_order.sort_order');
    }
    
    public function data()
    {
        return $this->hasMany(SectionData::class)->orderBy('sort_order');
    }
    
    public function scopeForPage($query, $pageId)
    {
        return $query->whereHas('pages', function($q) use ($pageId) {
            $q->where('pages.id', $pageId);
        })->orderBy('page_section_order.sort_order');
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
