<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentVersion extends Model
{
    use HasFactory;
    
    const UPDATED_AT = null; // Only track created_at
    
    protected $fillable = [
        'page_id',
        'section_id',
        'version_number',
        'content',
        'changes_summary',
        'created_by'
    ];
    
    protected $casts = [
        'created_at' => 'datetime'
    ];
    
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
    
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function scopeForPage($query, $pageId)
    {
        return $query->where('page_id', $pageId);
    }
    
    public function scopeForSection($query, $sectionId)
    {
        return $query->where('section_id', $sectionId);
    }
    
    public function scopeLatest($query)
    {
        return $query->orderBy('version_number', 'desc');
    }
}
