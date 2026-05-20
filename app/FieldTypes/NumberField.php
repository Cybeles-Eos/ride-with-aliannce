<?php

namespace App\FieldTypes;

class NumberField extends TextField
{
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        $rules[] = 'numeric';
        
        if ($field && $field->settings) {
            if (isset($field->settings['min'])) {
                $rules[] = 'min:' . $field->settings['min'];
            }
            if (isset($field->settings['max'])) {
                $rules[] = 'max:' . $field->settings['max'];
            }
        }
        
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Number',
            'component' => 'number',
            'description' => 'Numeric input field',
            'icon' => 'fa-hashtag',
            'settings' => [
                'min' => 'number',
                'max' => 'number',
                'step' => 'number'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'min' => null,
            'max' => null,
            'step' => 1
        ];
    }
    
    protected function buildAttributes($field, $settings)
    {
        $attributes = [
            'type' => 'number',
            'class' => 'form-control'
        ];
        
        if ($field->placeholder) {
            $attributes['placeholder'] = $field->placeholder;
        }
        
        if (isset($settings['min'])) {
            $attributes['min'] = $settings['min'];
        }
        
        if (isset($settings['max'])) {
            $attributes['max'] = $settings['max'];
        }
        
        if (isset($settings['step'])) {
            $attributes['step'] = $settings['step'];
        }
        
        return $attributes;
    }
}



