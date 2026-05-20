<?php

namespace App\FieldTypes;

class TextField extends BaseFieldType
{
    public function render($field, $value, $settings = [])
    {
        $data = [
            'field' => $field,
            'value' => $value,
            'settings' => array_merge($this->getDefaultSettings(), $settings),
            'fieldName' => $this->getFieldName($field),
            'fieldId' => $this->getFieldId($field),
            'attributes' => $this->buildAttributes($field, $settings)
        ];
        
        return $this->renderView('admin.field-types.text', $data);
    }
    
    public function process($value, $field = null)
    {
        return trim($value);
    }
    
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        
        if ($field && $field->settings) {
            if (isset($field->settings['max_length'])) {
                $rules[] = 'max:' . $field->settings['max_length'];
            }
            if (isset($field->settings['min_length'])) {
                $rules[] = 'min:' . $field->settings['min_length'];
            }
        }
        
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Text',
            'component' => 'text',
            'description' => 'Single line text input',
            'icon' => 'fa-font',
            'settings' => [
                'max_length' => 'number',
                'min_length' => 'number',
                'pattern' => 'text'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'max_length' => 255,
            'min_length' => null,
            'pattern' => null
        ];
    }
    
    private function buildAttributes($field, $settings)
    {
        $attributes = [
            'type' => 'text',
            'class' => 'form-control'
        ];
        
        if ($field->placeholder) {
            $attributes['placeholder'] = $field->placeholder;
        }
        
        if (isset($settings['max_length'])) {
            $attributes['maxlength'] = $settings['max_length'];
        }
        
        if (isset($settings['pattern'])) {
            $attributes['pattern'] = $settings['pattern'];
        }
        
        return $attributes;
    }
}
