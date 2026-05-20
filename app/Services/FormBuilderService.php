<?php

namespace App\Services;

use App\FieldTypes\TextField;
use App\FieldTypes\TextareaField;
use App\FieldTypes\RichTextField;
use App\FieldTypes\ImageField;
use App\FieldTypes\SelectField;
use App\FieldTypes\CheckboxField;
use App\FieldTypes\EmailField;
use App\FieldTypes\UrlField;
use App\FieldTypes\NumberField;
use App\FieldTypes\DateField;
use App\FieldTypes\ColorField;
use App\Models\FieldType;
use App\Models\SectionTemplateField;
use Illuminate\Support\Facades\Validator;

class FormBuilderService
{
    protected $fieldTypes;
    protected $fileUploadService;
    
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->registerFieldTypes();
    }
    
    protected function registerFieldTypes()
    {
        $this->fieldTypes = collect([
            'text' => new TextField(),
            'textarea' => new TextareaField(),
            'rich-text' => new RichTextField(),
            'image' => new ImageField($this->fileUploadService),
            'select' => new SelectField(),
            'checkbox' => new CheckboxField(),
            'email' => new EmailField(),
            'url' => new UrlField(),
            'number' => new NumberField(),
            'date' => new DateField(),
            'color' => new ColorField(),
        ]);
    }
    
    /**
     * Get all available field types
     */
    public function getAvailableFieldTypes()
    {
        return $this->fieldTypes->map(function ($fieldType) {
            return $fieldType->getConfig();
        });
    }
    
    /**
     * Get a specific field type instance
     */
    public function getFieldType($component)
    {
        return $this->fieldTypes->get($component);
    }
    
    /**
     * Render a field
     */
    public function renderField($field, $value = null, $settings = [])
    {
        $fieldType = $this->getFieldType($field->field_type->component ?? $field->component);
        
        if (!$fieldType) {
            return '<div class="alert alert-warning">Unknown field type: ' . ($field->field_type->component ?? $field->component) . '</div>';
        }
        
        $mergedSettings = array_merge(
            $fieldType->getDefaultSettings(),
            $field->settings ?? [],
            $settings
        );
        
        return $fieldType->render($field, $value, $mergedSettings);
    }
    
    /**
     * Validate a field
     */
    public function validateField($field, $value)
    {
        $fieldType = $this->getFieldType($field->field_type->component ?? $field->component);
        
        if (!$fieldType) {
            return Validator::make([], []); // Return empty validator if field type not found
        }
        
        $rules = $fieldType->getValidationRules($field);
        
        return $fieldType->validate($value, $rules);
    }
    
    /**
     * Process a field value before saving
     */
    public function processField($field, $value)
    {
        $fieldType = $this->getFieldType($field->field_type->component ?? $field->component);
        
        if (!$fieldType) {
            return $value;
        }
        
        return $fieldType->process($value, $field);
    }
    
    /**
     * Render an entire section form
     */
    public function renderSectionForm($section, $data = [])
    {
        if (!$section->template || !$section->template->fields) {
            return '<div class="alert alert-info">No fields configured for this section.</div>';
        }
        
        $html = '';
        
        foreach ($section->template->fields as $field) {
            $value = $data[$field->alias] ?? null;
            $html .= '<div class="form-group mb-3">';
            $html .= $this->renderField($field, $value);
            $html .= '</div>';
        }
        
        return $html;
    }
    
    /**
     * Validate an entire section's data
     */
    public function validateSection($section, $data)
    {
        $allRules = [];
        $allMessages = [];
        
        if ($section->template && $section->template->fields) {
            foreach ($section->template->fields as $field) {
                $value = $data[$field->alias] ?? null;
                $fieldType = $this->getFieldType($field->field_type->component);
                
                if ($fieldType) {
                    $rules = $fieldType->getValidationRules($field);
                    if (!empty($rules)) {
                        $allRules[$field->alias] = $rules;
                    }
                }
            }
        }
        
        return Validator::make($data, $allRules);
    }
    
    /**
     * Process an entire section's data
     */
    public function processSection($section, $data)
    {
        $processedData = [];
        
        if ($section->template && $section->template->fields) {
            foreach ($section->template->fields as $field) {
                $value = $data[$field->alias] ?? null;
                $processedData[$field->alias] = $this->processField($field, $value);
            }
        }
        
        return $processedData;
    }
    
    /**
     * Create field type records in database
     */
    public function seedFieldTypes()
    {
        $fieldTypes = $this->getAvailableFieldTypes();
        
        foreach ($fieldTypes as $component => $config) {
            FieldType::updateOrCreate(
                ['component' => $component],
                [
                    'name' => $config['name'],
                    'component' => $component,
                    'validation_rules' => [],
                    'settings' => $config['settings'] ?? [],
                    'is_active' => true
                ]
            );
        }
        
        return $fieldTypes->count();
    }
    
    /**
     * Register a custom field type
     */
    public function registerFieldType($component, $fieldTypeInstance)
    {
        $this->fieldTypes->put($component, $fieldTypeInstance);
    }
    
    /**
     * Build form HTML for repeater fields
     */
    public function buildRepeaterField($field, $items = [])
    {
        $html = '<div class="repeater-field" data-field="' . $field->alias . '">';
        $html .= '<div class="repeater-items">';
        
        if (empty($items)) {
            $items = [[]]; // At least one empty item
        }
        
        foreach ($items as $index => $item) {
            $html .= '<div class="repeater-item" data-index="' . $index . '">';
            $html .= '<div class="repeater-item-header">';
            $html .= '<span class="repeater-item-title">Item ' . ($index + 1) . '</span>';
            $html .= '<div class="repeater-item-actions">';
            $html .= '<button type="button" class="btn btn-sm btn-secondary repeater-move-up" title="Move Up">↑</button>';
            $html .= '<button type="button" class="btn btn-sm btn-secondary repeater-move-down" title="Move Down">↓</button>';
            $html .= '<button type="button" class="btn btn-sm btn-danger repeater-remove" title="Remove">×</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="repeater-item-content">';
            
            // Render fields for this repeater item
            foreach ($field->settings['fields'] ?? [] as $subField) {
                $fieldName = $field->alias . '[' . $index . '][' . $subField['alias'] . ']';
                $fieldValue = $item[$subField['alias']] ?? null;
                // This would need to be implemented based on the sub-field structure
                $html .= '<div class="form-group">';
                $html .= '<label>' . $subField['name'] . '</label>';
                $html .= '<input type="text" name="' . $fieldName . '" value="' . $fieldValue . '" class="form-control">';
                $html .= '</div>';
            }
            
            $html .= '</div>';
            $html .= '</div>';
        }
        
        $html .= '</div>';
        $html .= '<button type="button" class="btn btn-primary repeater-add">Add Item</button>';
        $html .= '</div>';
        
        return $html;
    }
}
