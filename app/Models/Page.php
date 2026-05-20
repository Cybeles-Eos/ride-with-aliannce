<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\Attachments\HasAttachment;

class Page extends Model
{
    use SoftDeletes, HasAttachment;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'content',
        'is_active',
        'seo_meta_id',
        'page_type_id',
    ];

    /**
     * Generate a url representing this resource.
     *
     * @return string
     */
    public final function getUrlAttribute()
    {
        return url($this->attributes['slug']);
    }

    /**
     * Checks to see if the current request is exactly for this page.
     *
     * @return bool
     */
    public final function getIsCurrentRouteAttribute()
    {
        return request()->is($this->attributes['slug']);
    }

    /**
     * Collects only active pages.
     *
     * @param Builder $query
     * @return Builder
     */
    public final function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public final function seoMeta()
    {
        return $this->belongsTo(SeoMeta::class);
    }

    public final function pageType()
    {
        return $this->hasOne(PageType::class);
    }

    public function sections()
    {
        return $this->belongsToMany(Section::class, 'page_section_order')
                    ->withPivot('sort_order', 'is_active')
                    ->orderBy('page_section_order.sort_order');
    }
    
    public function activeSections()
    {
        return $this->sections()->wherePivot('is_active', true);
    }
    
    public function versions()
    {
        return $this->hasMany(ContentVersion::class);
    }
    
    // Get page title for SEO
    public function getSeoTitleAttribute()
    {
        if ($this->seoMeta && $this->seoMeta->meta_title) {
            return $this->seoMeta->meta_title;
        }
        return $this->name . ' - ' . config('app.name');
    }
    
    // Get page description for SEO
    public function getSeoDescriptionAttribute()
    {
        if ($this->seoMeta && $this->seoMeta->meta_description) {
            return $this->seoMeta->meta_description;
        }
        return \Illuminate\Support\Str::limit(strip_tags($this->content), 160);
    }
    
    // Get page keywords for SEO
    public function getSeoKeywordsAttribute()
    {
        if ($this->seoMeta && $this->seoMeta->meta_keywords) {
            return $this->seoMeta->meta_keywords;
        }
        return '';
    }
    
    // Get canonical URL
    public function getCanonicalUrlAttribute()
    {
        if ($this->seoMeta && $this->seoMeta->canonical_link) {
            return $this->seoMeta->canonical_link;
        }
        return url($this->slug);
    }
    
    // Add section to page with ordering
    public function addSection($sectionId, $sortOrder = null)
    {
        if ($sortOrder === null) {
            $sortOrder = $this->sections()->max('page_section_order.sort_order') + 1;
        }
        
        $this->sections()->attach($sectionId, [
            'sort_order' => $sortOrder,
            'is_active' => true
        ]);
    }
    
    // Update section order
    public function updateSectionOrder($sectionOrders)
    {
        foreach ($sectionOrders as $sectionId => $order) {
            $this->sections()->updateExistingPivot($sectionId, [
                'sort_order' => $order
            ]);
        }
    }
    
    // Duplicate page with all sections and data
    public function duplicate($newName = null, $newSlug = null)
    {
        $duplicate = $this->replicate();
        $duplicate->name = $newName ?: $this->name . ' (Copy)';
        $duplicate->slug = $newSlug ?: $this->slug . '-copy-' . time();
        $duplicate->is_active = false; // Start as inactive
        $duplicate->save();
        
        // Duplicate sections with their data
        foreach ($this->sections as $section) {
            $duplicate->addSection($section->id, $section->pivot->sort_order);
            
            // If it's a repeater section, duplicate the data
            if ($section->isRepeater) {
                $this->duplicateSectionData($section, $duplicate);
            }
        }
        
        // Duplicate SEO meta if exists
        if ($this->seoMeta) {
            $duplicateSeoMeta = $this->seoMeta->replicate();
            $duplicateSeoMeta->save();
            $duplicate->seo_meta_id = $duplicateSeoMeta->id;
            $duplicate->save();
        }
        
        return $duplicate;
    }
    
    private function duplicateSectionData($originalSection, $duplicatePage)
    {
        $originalData = $originalSection->data()->get();
        
        foreach ($originalData as $data) {
            SectionData::create([
                'section_id' => $originalSection->id,
                'page_id' => $duplicatePage->id,
                'data' => $data->data,
                'sort_order' => $data->sort_order
            ]);
        }
    }
}