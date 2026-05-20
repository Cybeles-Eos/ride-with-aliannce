<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldType extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 
        'component', 
        'validation_rules', 
        'settings', 
        'is_active'
    ];
    
    protected $casts = [
        'validation_rules' => 'array', 
        'settings' => 'array',
        'is_active' => 'boolean'
    ];
    
    public function sectionTemplateFields()
    {
        return $this->hasMany(SectionTemplateField::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
