<?php

namespace App\Contracts;

interface FieldTypeInterface
{
    /**
     * Render the field for admin forms
     *
     * @param object $field The field configuration
     * @param mixed $value The current value
     * @param array $settings Additional settings
     * @return string The rendered HTML
     */
    public function render($field, $value, $settings = []);
    
    /**
     * Validate the field value
     *
     * @param mixed $value The value to validate
     * @param array $rules Validation rules
     * @return \Illuminate\Validation\Validator
     */
    public function validate($value, $rules = []);
    
    /**
     * Process the value before saving
     *
     * @param mixed $value The raw value
     * @param object $field The field configuration
     * @return mixed The processed value
     */
    public function process($value, $field = null);
    
    /**
     * Get validation rules for this field type
     *
     * @param object $field The field configuration
     * @return array Validation rules
     */
    public function getValidationRules($field);
    
    /**
     * Get the field type configuration
     *
     * @return array Field type configuration
     */
    public function getConfig();
    
    /**
     * Get default settings for this field type
     *
     * @return array Default settings
     */
    public function getDefaultSettings();
}
