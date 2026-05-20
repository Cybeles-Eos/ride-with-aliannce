<?php

namespace App\FieldTypes;

class EmailField extends TextField
{
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        $rules[] = 'email';
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Email',
            'component' => 'email',
            'description' => 'Email address input',
            'icon' => 'fa-envelope',
            'settings' => []
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'max_length' => 255,
            'min_length' => null
        ];
    }
    
    protected function buildAttributes($field, $settings)
    {
        $attributes = parent::buildAttributes($field, $settings);
        $attributes['type'] = 'email';
        return $attributes;
    }
}



