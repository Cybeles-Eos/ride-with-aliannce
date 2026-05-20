@extends('admin.layouts.base')

@section('title', 'Create Section Template')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.section-templates.index') }}">Section Templates</a></li>
        <li><a href="">Create Template</a></li>
    </ul>
    
    {{  Form::open([
        'method' => 'POST',
        'id' => 'template-form',
        'route' => ['admin.section-templates.store'],
        'class' => 'form-horizontal',
        ])
    }}
    
    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-puzzle-piece"></i> <strong>Template Information</strong></h2>
                </div>
                
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="name">Template Name <span class="text-danger">*</span></label>
                    <div class="col-md-9">
                        <input type="text" id="name" name="name" class="form-control" 
                               value="{{ old('name') }}" required placeholder="Enter template name...">
                        @if($errors->has('name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="slug">Slug</label>
                    <div class="col-md-9">
                        <input type="text" id="slug" name="slug" class="form-control" 
                               value="{{ old('slug') }}" placeholder="Leave blank to auto-generate">
                        <span class="help-block">Leave blank to auto-generate from name</span>
                        @if($errors->has('slug'))
                            <span class="help-block animation-slideDown">{{ $errors->first('slug') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="category">Category</label>
                    <div class="col-md-9">
                        <input type="text" id="category" name="category" class="form-control" 
                               value="{{ old('category') }}" placeholder="e.g., Content, Media, Layout">
                        @if($errors->has('category'))
                            <span class="help-block animation-slideDown">{{ $errors->first('category') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('icon') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="icon">Icon Class</label>
                    <div class="col-md-9">
                        <input type="text" id="icon" name="icon" class="form-control" 
                               value="{{ old('icon') }}" placeholder="e.g., fa-puzzle-piece">
                        <span class="help-block">FontAwesome icon class</span>
                        @if($errors->has('icon'))
                            <span class="help-block animation-slideDown">{{ $errors->first('icon') }}</span>
                        @endif
                    </div>
                </div>
                
                <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="description">Description</label>
                    <div class="col-md-9">
                        <textarea id="description" name="description" class="form-control" rows="3" 
                                  placeholder="Enter template description...">{{ old('description') }}</textarea>
                        @if($errors->has('description'))
                            <span class="help-block animation-slideDown">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger">
                    <h4><i class="fa fa-exclamation-triangle"></i> Validation Errors</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <div class="block-options pull-right">
                        <select id="new-field-type" class="form-control" style="width: 200px; display: inline-block;">
                            <option value="">Select Field Type</option>
                            @foreach($fieldTypes as $fieldType)
                                <option value="{{ $fieldType->id }}" data-component="{{ $fieldType->component }}">
                                    {{ $fieldType->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="button" id="add-field-btn" class="btn btn-success">
                            <i class="fa fa-plus"></i> Add Field
                        </button>
                    </div>
                    <h2><i class="fa fa-list"></i> <strong>Template Fields</strong></h2>
                </div>
                
                <div id="fields-container">
                    <div id="fields-list" style="display: none;">
                        <!-- Dynamic fields will be added here -->
                    </div>
                    <div id="no-fields-message" class="text-center" style="padding: 40px 0;">
                        <i class="fa fa-plus-circle fa-3x text-muted" style="margin-bottom: 15px;"></i>
                        <h4 class="text-muted">No fields added yet</h4>
                        <p class="text-muted">Select a field type above and click "Add Field" to get started.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group form-actions">
                <div class="col-md-9 col-md-offset-3">
                    <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Create Template</button>
                    <a href="{{ route('admin.section-templates.index') }}" class="btn btn-sm btn-warning">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    
    {{ Form::close() }}


<!-- Field Template -->
<div id="field-template" style="display: none;">
    <div class="field-item well" style="margin-bottom: 15px; position: relative; border: 1px solid #ddd;" data-field-id="">
        <div class="field-header" style="margin-bottom: 15px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
            <div class="pull-left">
                <span class="field-type-badge label label-primary"></span>
                <strong class="field-name" style="margin-left: 10px;"></strong>
            </div>
            <div class="pull-right">
                <button type="button" class="btn btn-xs btn-default move-up" title="Move Up">
                    <i class="fa fa-arrow-up"></i>
                </button>
                <button type="button" class="btn btn-xs btn-default move-down" title="Move Down">
                    <i class="fa fa-arrow-down"></i>
                </button>
                <button type="button" class="btn btn-xs btn-danger remove-field" title="Remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="field-config form-horizontal">
            <div class="form-group">
                <label class="col-md-3 control-label">Field Name <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="fields[][name]" class="form-control field-name-input" required />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Field Alias <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" name="fields[][alias]" class="form-control field-alias-input" required />
                    <span class="help-block">Used in templates (auto-generated from name)</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Label (optional)</label>
                <div class="col-md-9">
                    <input type="text" name="fields[][label]" class="form-control" />
                    <span class="help-block">Display label (uses name if empty)</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Placeholder</label>
                <div class="col-md-9">
                    <input type="text" name="fields[][placeholder]" class="form-control" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Help Text</label>
                <div class="col-md-9">
                    <textarea name="fields[][help_text]" class="form-control" rows="2"></textarea>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-md-3 control-label">Required Field</label>
                <div class="col-md-9">
                    <input type="hidden" name="fields[][is_required]" value="0">
                    <label class="switch switch-primary">
                        <input type="checkbox" name="fields[][is_required]" value="1">
                        <span></span>
                    </label>
                </div>
            </div>
            
            <input type="hidden" name="fields[][field_type_id]" class="field-type-id" />
            <input type="hidden" name="fields[][sort_order]" class="sort-order" />
        </div>
    </div>
</div>
@endsection

@push('extrascripts')
<script>
$(document).ready(function() {
    let fieldCounter = 0;
    const fieldTypes = @json($fieldTypes);
    
    // Auto-generate slug from name
    $('#name').on('input', function() {
        if (!$('#slug').val()) {
            const slug = $(this).val().toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            $('#slug').val(slug);
        }
    });
    
    // Add field
    $('#add-field-btn').on('click', function() {
        const fieldTypeId = $('#new-field-type').val();
        if (!fieldTypeId) {
            swal("Error", "Please select a field type first.", "error");
            return;
        }
        
        const fieldType = fieldTypes.find(ft => ft.id == fieldTypeId);
        addField(fieldType);
        $('#new-field-type').val('');
        updateFieldsVisibility();
    });
    
    function addField(fieldType) {
        fieldCounter++;
        const template = document.getElementById('field-template');
        const fieldElement = template.querySelector('.field-item').cloneNode(true);
        
        // Update field data
        fieldElement.setAttribute('data-field-id', fieldCounter);
        
        // Update field type info
        fieldElement.querySelector('.field-type-badge').textContent = fieldType.name;
        fieldElement.querySelector('.field-name').textContent = 'New Field';
        
        // Update form inputs - replace ALL [] occurrences
        const inputs = fieldElement.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace(/\[\]/g, `[${fieldCounter}]`));
            }
        });
        
        // Set field type ID
        fieldElement.querySelector('.field-type-id').value = fieldType.id;
        
        document.getElementById('fields-list').appendChild(fieldElement);
        updateSortOrders();
    }
    
    // Auto-generate alias from name
    $(document).on('input', '.field-name-input', function() {
        const $fieldItem = $(this).closest('.field-item');
        const $aliasInput = $fieldItem.find('.field-alias-input');
        const $fieldName = $fieldItem.find('.field-name');
        
        const name = $(this).val();
        const alias = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '_')
            .replace(/_+/g, '_')
            .trim('_');
        
        if (!$aliasInput.val() || $aliasInput.data('auto-generated')) {
            $aliasInput.val(alias).data('auto-generated', true);
        }
        
        $fieldName.text(name || 'New Field');
    });
    
    // Manual alias editing
    $(document).on('input', '.field-alias-input', function() {
        $(this).data('auto-generated', false);
    });
    
    // Remove field
    $(document).on('click', '.remove-field', function() {
        swal({
            title: "Are you sure?",
            text: "Remove this field from the template?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, remove it!",
            closeOnConfirm: true
        }, function() {
            $(this).closest('.field-item').remove();
            updateSortOrders();
            updateFieldsVisibility();
        }.bind(this));
    });
    
    // Move field up
    $(document).on('click', '.move-up', function() {
        const $field = $(this).closest('.field-item');
        const $prev = $field.prev('.field-item');
        if ($prev.length) {
            $field.insertBefore($prev);
            updateSortOrders();
        }
    });
    
    // Move field down
    $(document).on('click', '.move-down', function() {
        const $field = $(this).closest('.field-item');
        const $next = $field.next('.field-item');
        if ($next.length) {
            $field.insertAfter($next);
            updateSortOrders();
        }
    });
    
    function updateSortOrders() {
        $('#fields-list .field-item').each(function(index) {
            $(this).find('.sort-order').val(index + 1);
        });
    }
    
    function updateFieldsVisibility() {
        const hasFields = $('#fields-list .field-item').length > 0;
        if (hasFields) {
            $('#no-fields-message').hide();
            $('#fields-list').show();
        } else {
            $('#no-fields-message').show();
            $('#fields-list').hide();
        }
    }
    
    // Form validation
    $('#template-form').on('submit', function(e) {
        // Count only fields that are NOT in the template
        const fieldsCount = $('#fields-list .field-item').length;
        if (fieldsCount === 0) {
            e.preventDefault();
            swal("Error", "Please add at least one field to the template.", "error");
            return false;
        }
        
        // Validate field names and aliases (only in fields-list, not in template)
        let valid = true;
        $('#fields-list .field-item').each(function() {
            const name = $(this).find('.field-name-input').val().trim();
            const alias = $(this).find('.field-alias-input').val().trim();
            
            if (!name || !alias) {
                valid = false;
                return false;
            }
        });
        
        if (!valid) {
            e.preventDefault();
            swal("Error", "Please fill in all required field information (name and alias).", "error");
            return false;
        }
        
        // Debug: Verify fields are being submitted
        console.log('=== FORM SUBMISSION DEBUG ===');
        console.log('Fields in DOM:', fieldsCount);
        console.log('Fields inside form:', $('#template-form .field-item').length);
        console.log('Fields inside #fields-list:', $('#fields-list .field-item').length);
        console.log('#fields-list inside form?:', $('#template-form').find('#fields-list').length > 0);
        
        // CRITICAL FIX: Ensure fields-list is inside the form
        if ($('#template-form').find('#fields-list').length === 0) {
            console.error('CRITICAL: #fields-list is OUTSIDE the form! Moving it inside...');
            $('#fields-list').appendTo('#template-form');
        }
        
        const formData = new FormData(this);
        let fieldDataCount = 0;
        console.log('Form data entries:');
        for (let [key, value] of formData.entries()) {
            if (key.startsWith('fields[')) {
                console.log('  ' + key + ' = ' + value);
                fieldDataCount++;
            }
        }
        console.log('Total field data entries:', fieldDataCount);
        
        if (fieldDataCount === 0) {
            console.error('WARNING: No field data in form submission!');
            console.log('Field HTML sample:', $('#fields-list .field-item').first().html());
            console.log('Form HTML:', $('#template-form').html().substring(0, 500));
            
            // Last resort: prevent submission and show error
            e.preventDefault();
            swal("Error", "Fields were not properly attached to the form. Please try again or contact support.", "error");
            return false;
        }
    });
    
    // Initial state
    updateFieldsVisibility();
    
    // CRITICAL FIX: Verify form structure on page load
    console.log('=== PAGE LOAD DIAGNOSTIC ===');
    console.log('#fields-list exists:', $('#fields-list').length);
    console.log('#fields-list inside form?:', $('#template-form').find('#fields-list').length > 0);
    console.log('Form ID:', $('#template-form').attr('id'));
    
    // If fields-list is outside the form, something is wrong with the HTML structure
    if ($('#fields-list').length > 0 && $('#template-form').find('#fields-list').length === 0) {
        console.error('CRITICAL ERROR: #fields-list is rendered OUTSIDE the form element!');
        console.error('This is a template structure issue. Fields will not submit.');
        console.error('Attempting to fix by moving #fields-container inside form...');
        
        // Move the entire fields-container inside the form, before the submit buttons
        const $submitRow = $('#template-form .form-actions').closest('.row');
        $('#fields-container').closest('.row').insertBefore($submitRow);
    }
});
</script>
@endpush
