<?php

namespace App\FieldTypes;

class DateField extends TextField
{
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        $rules[] = 'date';
        
        if ($field && $field->settings) {
            if (isset($field->settings['after'])) {
                $rules[] = 'after:' . $field->settings['after'];
            }
            if (isset($field->settings['before'])) {
                $rules[] = 'before:' . $field->settings['before'];
            }
        }
        
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Date',
            'component' => 'date',
            'description' => 'Date picker input',
            'icon' => 'fa-calendar',
            'settings' => [
                'after' => 'date',
                'before' => 'date'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'after' => null,
            'before' => null
        ];
    }
    
    protected function buildAttributes($field, $settings)
    {
        $attributes = [
            'type' => 'date',
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
        
        return $attributes;
    }
}



