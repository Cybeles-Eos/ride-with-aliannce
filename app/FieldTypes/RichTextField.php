<?php

namespace App\FieldTypes;

class RichTextField extends BaseFieldType
{
    public function render($field, $value, $settings = [])
    {
        $data = [
            'field' => $field,
            'value' => $value,
            'settings' => array_merge($this->getDefaultSettings(), $settings),
            'fieldName' => $this->getFieldName($field),
            'fieldId' => $this->getFieldId($field),
            'editor' => $settings['editor'] ?? 'ckeditor'
        ];
        
        return $this->renderView('admin.field-types.rich-text', $data);
    }
    
    public function process($value, $field = null)
    {
        // Clean HTML - remove dangerous tags but keep formatting
        $value = trim($value);
        
        // Basic HTML cleaning (in a real app, use HTMLPurifier)
        $allowedTags = '<p><br><strong><b><em><i><u><a><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote><img><table><tr><td><th>';
        
        return strip_tags($value, $allowedTags);
    }
    
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        
        // Rich text fields typically need string validation
        $rules[] = 'string';
        
        if ($field && $field->settings && isset($field->settings['max_length'])) {
            $rules[] = 'max:' . $field->settings['max_length'];
        }
        
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Rich Text',
            'component' => 'rich-text',
            'description' => 'WYSIWYG editor for formatted content',
            'icon' => 'fa-edit',
            'settings' => [
                'editor' => 'select:ckeditor,tinymce,quill',
                'height' => 'number',
                'toolbar' => 'text',
                'max_length' => 'number'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'editor' => 'ckeditor',
            'height' => 300,
            'toolbar' => 'full',
            'max_length' => null
        ];
    }
}
