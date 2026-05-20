<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SectionTemplate;
use App\Models\FieldType;
use App\Models\SectionTemplateField;
use App\Services\FormBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SectionTemplateController extends Controller
{
    protected $formBuilder;
    
    public function __construct(FormBuilderService $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = SectionTemplate::with(['fields.fieldType'])
            ->withCount('fields')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.section-templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fieldTypes = FieldType::active()->get();
        
        return view('admin.section-templates.create', compact('fieldTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:section_templates',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'fields' => 'array',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.alias' => 'required|string|max:255',
            'fields.*.field_type_id' => 'required|exists:field_types,id',
            'fields.*.is_required' => 'boolean',
            'fields.*.validation_rules' => 'nullable|array',
            'fields.*.settings' => 'nullable|array'
        ]);

        DB::beginTransaction();
        
        try {
            // Create section template
            $template = SectionTemplate::create([
                'name' => $request->name,
                'slug' => $request->slug ?: Str::slug($request->name),
                'description' => $request->description,
                'icon' => $request->icon,
                'category' => $request->category,
                'is_active' => true
            ]);

            // Create fields
            if ($request->has('fields')) {
                foreach ($request->fields as $index => $fieldData) {
                    SectionTemplateField::create([
                        'section_template_id' => $template->id,
                        'field_type_id' => $fieldData['field_type_id'],
                        'name' => $fieldData['name'],
                        'alias' => $fieldData['alias'],
                        'label' => $fieldData['label'] ?? $fieldData['name'],
                        'placeholder' => $fieldData['placeholder'] ?? null,
                        'help_text' => $fieldData['help_text'] ?? null,
                        'is_required' => $fieldData['is_required'] ?? false,
                        'validation_rules' => $fieldData['validation_rules'] ?? [],
                        'settings' => $fieldData['settings'] ?? [],
                        'sort_order' => $index + 1
                    ]);
                }
            }

            DB::commit();
            
            return redirect()
                ->route('admin.section-templates.index')
                ->with('flash_message', [
                    'title' => 'Success!',
                    'message' => 'Section template created successfully',
                    'type' => 'success'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('flash_message', [
                    'title' => 'Error!',
                    'message' => 'Failed to create section template: ' . $e->getMessage(),
                    'type' => 'error'
                ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $template = SectionTemplate::with(['fields.fieldType', 'sections'])
            ->findOrFail($id);

        return view('admin.section-templates.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $template = SectionTemplate::with(['fields.fieldType'])->findOrFail($id);
        $fieldTypes = FieldType::active()->get();
        
        return view('admin.section-templates.edit', compact('template', 'fieldTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $template = SectionTemplate::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:section_templates,slug,' . $id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'fields' => 'array',
            'fields.*.name' => 'required|string|max:255',
            'fields.*.alias' => 'required|string|max:255',
            'fields.*.field_type_id' => 'required|exists:field_types,id',
            'fields.*.is_required' => 'boolean',
            'fields.*.validation_rules' => 'nullable|array',
            'fields.*.settings' => 'nullable|array'
        ]);

        DB::beginTransaction();
        
        try {
            // Update section template
            $template->update([
                'name' => $request->name,
                'slug' => $request->slug ?: Str::slug($request->name),
                'description' => $request->description,
                'icon' => $request->icon,
                'category' => $request->category
            ]);

            // Delete existing fields and recreate them
            $template->fields()->delete();
            
            if ($request->has('fields')) {
                foreach ($request->fields as $index => $fieldData) {
                    SectionTemplateField::create([
                        'section_template_id' => $template->id,
                        'field_type_id' => $fieldData['field_type_id'],
                        'name' => $fieldData['name'],
                        'alias' => $fieldData['alias'],
                        'label' => $fieldData['label'] ?? $fieldData['name'],
                        'placeholder' => $fieldData['placeholder'] ?? null,
                        'help_text' => $fieldData['help_text'] ?? null,
                        'is_required' => $fieldData['is_required'] ?? false,
                        'validation_rules' => $fieldData['validation_rules'] ?? [],
                        'settings' => $fieldData['settings'] ?? [],
                        'sort_order' => $index + 1
                    ]);
                }
            }

            DB::commit();
            
            return redirect()
                ->route('admin.section-templates.index')
                ->with('flash_message', [
                    'title' => 'Success!',
                    'message' => 'Section template updated successfully',
                    'type' => 'success'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()
                ->withInput()
                ->with('flash_message', [
                    'title' => 'Error!',
                    'message' => 'Failed to update section template: ' . $e->getMessage(),
                    'type' => 'error'
                ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $template = SectionTemplate::findOrFail($id);
            
            // Check if template is being used
            if ($template->sections()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete template that is being used by sections'
                ], 422);
            }
            
            $template->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Section template deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete section template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle template active status
     */
    public function toggleActive($id)
    {
        try {
            $template = SectionTemplate::findOrFail($id);
            $template->update(['is_active' => !$template->is_active]);
            
            return response()->json([
                'success' => true,
                'is_active' => $template->is_active,
                'message' => 'Template status updated successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update template status'
            ], 500);
        }
    }

    /**
     * Duplicate a template
     */
    public function duplicate($id)
    {
        try {
            $original = SectionTemplate::with('fields.fieldType')->findOrFail($id);
            
            DB::beginTransaction();
            
            $duplicate = SectionTemplate::create([
                'name' => $original->name . ' (Copy)',
                'slug' => $original->slug . '-copy-' . time(),
                'description' => $original->description,
                'icon' => $original->icon,
                'category' => $original->category,
                'is_active' => false // Start as inactive
            ]);

            foreach ($original->fields as $field) {
                SectionTemplateField::create([
                    'section_template_id' => $duplicate->id,
                    'field_type_id' => $field->field_type_id,
                    'name' => $field->name,
                    'alias' => $field->alias,
                    'label' => $field->label,
                    'placeholder' => $field->placeholder,
                    'help_text' => $field->help_text,
                    'is_required' => $field->is_required,
                    'validation_rules' => $field->validation_rules,
                    'settings' => $field->settings,
                    'sort_order' => $field->sort_order
                ]);
            }
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Template duplicated successfully',
                'data' => [
                    'id' => $duplicate->id,
                    'name' => $duplicate->name,
                    'edit_url' => route('admin.section-templates.edit', $duplicate->id)
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to duplicate template: ' . $e->getMessage()
            ], 500);
        }
    }
}
