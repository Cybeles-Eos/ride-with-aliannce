<?php

namespace App\FieldTypes;

class SelectField extends BaseFieldType
{
    public function render($field, $value, $settings = [])
    {
        $data = [
            'field' => $field,
            'value' => $value,
            'settings' => array_merge($this->getDefaultSettings(), $settings),
            'fieldName' => $this->getFieldName($field),
            'fieldId' => $this->getFieldId($field),
            'options' => $this->getOptions($field, $settings),
            'attributes' => $this->buildAttributes($field, $settings)
        ];
        
        return $this->renderView('admin.field-types.select', $data);
    }
    
    public function process($value, $field = null)
    {
        return $value;
    }
    
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        
        if ($field && $field->settings && isset($field->settings['options'])) {
            $validOptions = array_keys($this->parseOptions($field->settings['options']));
            if (!empty($validOptions)) {
                $rules[] = 'in:' . implode(',', $validOptions);
            }
        }
        
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Select Dropdown',
            'component' => 'select',
            'description' => 'Dropdown select with predefined options',
            'icon' => 'fa-caret-down',
            'settings' => [
                'options' => 'textarea',
                'multiple' => 'boolean',
                'default_option' => 'text'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'options' => '',
            'multiple' => false,
            'default_option' => 'Choose an option...'
        ];
    }
    
    private function getOptions($field, $settings)
    {
        $options = [];
        
        if ($field && $field->settings && isset($field->settings['options'])) {
            $options = $this->parseOptions($field->settings['options']);
        }
        
        return $options;
    }
    
    private function parseOptions($optionsString)
    {
        $options = [];
        
        if (is_array($optionsString)) {
            return $optionsString;
        }
        
        // Parse different formats:
        // "key:value\nkey2:value2" or "value1\nvalue2"
        $lines = explode("\n", $optionsString);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) continue;
            
            if (strpos($line, ':') !== false) {
                [$key, $value] = explode(':', $line, 2);
                $options[trim($key)] = trim($value);
            } else {
                $options[$line] = $line;
            }
        }
        
        return $options;
    }
    
    private function buildAttributes($field, $settings)
    {
        $attributes = [
            'class' => 'form-control'
        ];
        
        if (isset($settings['multiple']) && $settings['multiple']) {
            $attributes['multiple'] = 'multiple';
            $attributes['name'] = $this->getFieldName($field) . '[]';
        }
        
        return $attributes;
    }
}
