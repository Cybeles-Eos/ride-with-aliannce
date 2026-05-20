<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'original_name',
        'mime_type',
        'size',
        'path',
        'url',
        'alt_text',
        'title',
        'caption',
        'alias',
        'folder',
        'extension',
        'disk',
        'metadata',
        'is_active',
        'uploaded_by',
        'usage_count',
        'last_used_at',
        'identifier'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'metadata' => 'array',
        'is_active' => 'boolean',
        'last_used_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Relationships
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    
    public function pages()
    {
        return $this->morphedByMany(Page::class, 'attachable');
    }
    
    public function sections()
    {
        return $this->morphedByMany(Section::class, 'attachable');
    }

    // Auto-generate URLs
    public function getUrlAttribute()
    {
        if ($this->attributes['url']) {
            return $this->attributes['url'];
        }
        
        if ($this->path && $this->disk) {
            return Storage::disk($this->disk)->url($this->path);
        }
        
        // Fallback to old method
        $path = $this->attributes['folder'] . '/' . $this->attributes['alias'];
        return url("public/storage/$path");
    }
    
    // Image optimization
    public function getOptimizedUrlAttribute()
    {
        if (str_starts_with($this->mime_type, 'image/')) {
            return $this->url . '?w=800&q=80'; // Add image optimization
        }
        return $this->url;
    }
    
    // Get alt text with fallback
    public function getAltTextAttribute($value)
    {
        return $value ?: $this->original_name ?: $this->name ?: 'Image';
    }
    
    // Get title with fallback
    public function getTitleAttribute($value)
    {
        return $value ?: $this->original_name ?: $this->name ?: '';
    }
    
    public function getFileSizeAttribute()
    {
        return $this->formatBytes($this->size);
    }
    
    public function getFileTypeAttribute()
    {
        return $this->mime_type ? explode('/', $this->mime_type)[0] : 'unknown';
    }
    
    public function getIsImageAttribute()
    {
        return str_starts_with($this->mime_type, 'image/');
    }
    
    public function getThumbnailUrlAttribute()
    {
        if ($this->is_image) {
            return $this->url . '?w=150&h=150&fit=crop';
        }
        return $this->getFileIconUrl();
    }
    
    // Media management methods
    public function incrementUsage()
    {
        $this->increment('usage_count');
        $this->update(['last_used_at' => now()]);
    }
    
    // Generate proper img tag with all attributes
    public function toImgTag($attributes = [])
    {
        $defaultAttributes = [
            'src' => $this->url,
            'alt' => $this->alt_text,
            'title' => $this->title,
            'loading' => 'lazy'
        ];
        
        $attributes = array_merge($defaultAttributes, $attributes);
        
        $tag = '<img';
        foreach ($attributes as $key => $value) {
            if ($value) {
                $tag .= ' ' . $key . '="' . htmlspecialchars($value) . '"';
            }
        }
        $tag .= '>';
        
        return $tag;
    }
    
    private function formatBytes($size, $precision = 2)
    {
        if (!$size) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        return round($size, $precision) . ' ' . $units[$i];
    }
    
    private function getFileIconUrl()
    {
        $extension = pathinfo($this->original_name ?: $this->name, PATHINFO_EXTENSION);
        $iconMap = [
            'pdf' => 'pdf-icon.png',
            'doc' => 'word-icon.png',
            'docx' => 'word-icon.png',
            'xls' => 'excel-icon.png',
            'xlsx' => 'excel-icon.png',
            'zip' => 'archive-icon.png',
            'rar' => 'archive-icon.png'
        ];
        
        $icon = $iconMap[$extension] ?? 'file-icon.png';
        return asset('images/file-icons/' . $icon);
    }

    /**
     * Return the url when serialized.
     *
     * @return string
     */
    public final function __toString() : string
    {
        return $this->getUrlAttribute();
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }
}
