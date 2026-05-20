<?php

namespace App\FieldTypes;

use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use App\Models\Attachment;

class ImageField extends BaseFieldType
{
    protected $fileUploadService;
    
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    public function render($field, $value, $settings = [])
    {
        // If value is an attachment ID, load the attachment
        if ($value && is_numeric($value)) {
            $attachment = Attachment::find($value);
        } else {
            $attachment = $value;
        }
        
        $data = [
            'field' => $field,
            'value' => $value,
            'attachment' => $attachment,
            'settings' => array_merge($this->getDefaultSettings(), $settings),
            'fieldName' => $this->getFieldName($field),
            'fieldId' => $this->getFieldId($field),
            'attributes' => $this->buildAttributes($field, $settings)
        ];
        
        return $this->renderView('admin.field-types.image', $data);
    }
    
    public function process($value, $field = null)
    {
        if ($value instanceof UploadedFile) {
            // Get alt text and title from request
            $altText = request()->input($field->alias . '_alt_text');
            $title = request()->input($field->alias . '_title');
            
            $folder = 'uploads/' . date('Y/m');
            
            $attachment = $this->fileUploadService->uploadWithOptions($value, [
                'folder' => $folder,
                'alt_text' => $altText,
                'title' => $title
            ]);
            
            return $attachment->id;
        }
        
        return $value;
    }
    
    public function getValidationRules($field)
    {
        $rules = parent::getValidationRules($field);
        
        if ($field && $field->is_required) {
            $rules[] = 'file';
        } else {
            $rules[] = 'nullable';
        }
        
        $rules[] = 'image';
        
        if ($field && $field->settings) {
            if (isset($field->settings['max_size'])) {
                $rules[] = 'max:' . $field->settings['max_size']; // KB
            }
            
            if (isset($field->settings['min_width']) || isset($field->settings['min_height'])) {
                $rules[] = 'dimensions:min_width=' . ($field->settings['min_width'] ?? 1) . 
                          ',min_height=' . ($field->settings['min_height'] ?? 1);
            }
            
            if (isset($field->settings['max_width']) || isset($field->settings['max_height'])) {
                $rules[] = 'dimensions:max_width=' . ($field->settings['max_width'] ?? 5000) . 
                          ',max_height=' . ($field->settings['max_height'] ?? 5000);
            }
            
            if (isset($field->settings['mimes'])) {
                $rules[] = 'mimes:' . $field->settings['mimes'];
            }
        }
        
        return $rules;
    }
    
    public function getConfig()
    {
        return [
            'name' => 'Image',
            'component' => 'image',
            'description' => 'Image upload with alt text and title',
            'icon' => 'fa-image',
            'settings' => [
                'max_size' => 'number', // KB
                'min_width' => 'number',
                'min_height' => 'number',
                'max_width' => 'number',
                'max_height' => 'number',
                'mimes' => 'text',
                'multiple' => 'boolean'
            ]
        ];
    }
    
    public function getDefaultSettings()
    {
        return [
            'max_size' => 10240, // 10MB
            'min_width' => null,
            'min_height' => null,
            'max_width' => null,
            'max_height' => null,
            'mimes' => 'jpeg,jpg,png,gif,webp',
            'multiple' => false
        ];
    }
    
    private function buildAttributes($field, $settings)
    {
        $attributes = [
            'type' => 'file',
            'class' => 'form-control',
            'accept' => 'image/*'
        ];
        
        if (isset($settings['multiple']) && $settings['multiple']) {
            $attributes['multiple'] = 'multiple';
        }
        
        return $attributes;
    }
}
