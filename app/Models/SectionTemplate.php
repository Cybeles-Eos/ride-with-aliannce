<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTemplate extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'icon', 
        'category', 
        'is_active'
    ];
    
    protected $casts = [
        'is_active' => 'boolean'
    ];
    
    public function fields()
    {
        return $this->hasMany(SectionTemplateField::class)->orderBy('sort_order');
    }
    
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
