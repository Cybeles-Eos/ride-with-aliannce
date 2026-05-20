<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionData extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'section_id',
        'page_id',
        'data',
        'sort_order'
    ];
    
    protected $casts = [
        'data' => 'array'
    ];
    
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
    
    public function scopeForSection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }
    
    public function scopeForPage($query, $pageId)
    {
        return $query->where('page_id', $pageId);
    }
}
