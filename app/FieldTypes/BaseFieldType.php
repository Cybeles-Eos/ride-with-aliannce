<?php

namespace App\FieldTypes;

use App\Contracts\FieldTypeInterface;
use Illuminate\Support\Facades\Validator;

abstract class BaseFieldType implements FieldTypeInterface
{
    /**
     * Validate the field value
     */
    public function validate($value, $rules = [])
    {
        return Validator::make(['value' => $value], ['value' => $rules]);
    }
    
    /**
     * Process the value - default implementation returns the value as-is
     */
    public function process($value, $field = null)
    {
        return $value;
    }
    
    /**
     * Get validation rules for this field type
     */
    public function getValidationRules($field)
    {
        $rules = [];
        
        if ($field && $field->is_required) {
            $rules[] = 'required';
        }
        
        if ($field && $field->validation_rules) {
            $rules = array_merge($rules, $field->validation_rules);
        }
        
        return $rules;
    }
    
    /**
     * Get default settings for this field type
     */
    public function getDefaultSettings()
    {
        return [];
    }
    
    /**
     * Render view with common data
     */
    protected function renderView($view, $data)
    {
        return view($view, $data)->render();
    }
    
    /**
     * Get field name attribute
     */
    protected function getFieldName($field)
    {
        return $field->alias ?? $field->name ?? 'field';
    }
    
    /**
     * Get field ID attribute
     */
    protected function getFieldId($field)
    {
        return str_replace([' ', '[', ']'], ['_', '_', ''], $this->getFieldName($field));
    }
}
