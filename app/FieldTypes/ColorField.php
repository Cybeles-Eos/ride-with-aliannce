<?php

namespace App\FieldTypes;

class ColorField extends TextField
{
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        $rules[] = 'regex:/^#[a-fA-F0-9]{6}$/';
        return $rules;
    }
    
    public function process($value, $field = null)
    {
        // Ensure color value always has # prefix
        $value = trim($value);
        if (!empty($value) && $value[0] !== '#') {
            $value = '#' . $value;
        }
        return strtolower($value);
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Color',
            'component' => 'color',
            'description' => 'Color picker input',
            'icon' => 'fa-palette',
            'settings' => []
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'default_color' => '#000000'
        ];
    }
    
    protected function buildAttributes($field, $settings)
    {
        $attributes = [
            'type' => 'color',
            'class' => 'form-control'
        ];
        
        if ($field->placeholder) {
            $attributes['placeholder'] = $field->placeholder;
        }
        
        return $attributes;
    }
}



