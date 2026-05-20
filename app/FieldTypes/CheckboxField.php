<?php

namespace App\FieldTypes;

class CheckboxField extends BaseFieldType
{
    public function render($field, $value, $settings = [])
    {
        $data = [
            'field' => $field,
            'value' => $value,
            'settings' => array_merge($this->getDefaultSettings(), $settings),
            'fieldName' => $this->getFieldName($field),
            'fieldId' => $this->getFieldId($field),
            'isChecked' => $this->isChecked($value),
            'attributes' => $this->buildAttributes($field, $settings)
        ];
        
        return $this->renderView('admin.field-types.checkbox', $data);
    }
    
    public function process($value, $field = null)
    {
        // Checkboxes return 1 when checked, null when unchecked
        return $value ? 1 : 0;
    }
    
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        
        // Remove required rule for checkbox as it's handled differently
        $rules = array_filter($rules, function($rule) {
            return $rule !== 'required';
        });
        
        // Add boolean validation
        $rules[] = 'boolean';
        
        if ($field && $field->is_required) {
            $rules[] = 'accepted'; // Must be checked if required
        }
        
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Checkbox',
            'component' => 'checkbox',
            'description' => 'Single checkbox for yes/no values',
            'icon' => 'fa-check-square',
            'settings' => [
                'checked_value' => 'text',
                'unchecked_value' => 'text',
                'label_text' => 'text'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'checked_value' => '1',
            'unchecked_value' => '0',
            'label_text' => null
        ];
    }
    
    private function isChecked($value)
    {
        return in_array($value, [1, '1', true, 'true', 'on', 'yes']);
    }
    
    private function buildAttributes($field, $settings)
    {
        $attributes = [
            'type' => 'checkbox',
            'class' => 'form-check-input',
            'value' => $settings['checked_value'] ?? '1'
        ];
        
        return $attributes;
    }
}
