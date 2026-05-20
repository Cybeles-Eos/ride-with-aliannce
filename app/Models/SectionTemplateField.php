<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTemplateField extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'section_template_id',
        'field_type_id',
        'name',
        'alias',
        'label',
        'placeholder',
        'help_text',
        'is_required',
        'validation_rules',
        'settings',
        'sort_order'
    ];
    
    protected $casts = [
        'is_required' => 'boolean',
        'validation_rules' => 'array',
        'settings' => 'array'
    ];
    
    public function sectionTemplate()
    {
        return $this->belongsTo(SectionTemplate::class);
    }
    
    public function fieldType()
    {
        return $this->belongsTo(FieldType::class);
    }
    
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }
    
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
