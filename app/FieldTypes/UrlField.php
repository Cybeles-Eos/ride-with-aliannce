<?php

namespace App\FieldTypes;

class UrlField extends TextField
{
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        $rules[] = 'url';
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'URL',
            'component' => 'url',
            'description' => 'URL/Website address input',
            'icon' => 'fa-link',
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
        $attributes['type'] = 'url';
        return $attributes;
    }
}



