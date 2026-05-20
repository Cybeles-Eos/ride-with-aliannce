<?php

namespace App\FieldTypes;

class TextareaField extends BaseFieldType
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
        
        return $this->renderView('admin.field-types.textarea', $data);
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
            'name' => 'Textarea',
            'component' => 'textarea',
            'description' => 'Multi-line text input',
            'icon' => 'fa-align-left',
            'settings' => [
                'rows' => 'number',
                'max_length' => 'number',
                'min_length' => 'number'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'rows' => 4,
            'max_length' => null,
            'min_length' => null
        ];
    }
    
    private function buildAttributes($field, $settings)
    {
        $attributes = [
            'class' => 'form-control',
            'rows' => $settings['rows'] ?? 4
        ];
        
        if ($field->placeholder) {
            $attributes['placeholder'] = $field->placeholder;
        }
        
        if (isset($settings['max_length'])) {
            $attributes['maxlength'] = $settings['max_length'];
        }
        
        return $attributes;
    }
}
