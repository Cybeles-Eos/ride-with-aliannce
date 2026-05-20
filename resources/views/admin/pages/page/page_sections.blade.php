{{-- Enhanced Page Sections Management Interface --}}

{{-- Section Header --}}
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h4 style="border-left: 3px solid #61dbd5; padding-left: 8px; margin-bottom: 20px;">Page Sections</h4>
    </div>
</div>

{{-- Add Section Template Interface --}}
<div class="row" style="margin-bottom: 30px;">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-body" style="background-color: #f8f9fa; padding: 20px;">
                <h5 style="margin-top: 0;"><i class="fa fa-plus"></i> Add Section Template</h5>
                <div class="row">
                    <div class="col-md-8">
                        <select class="form-control" id="section-template-select">
                            <option value="">-- Select a Section Template --</option>
                            @if(isset($availableTemplates))
                                @foreach($availableTemplates as $template)
                                    <option value="{{ $template->id }}" 
                                            data-name="{{ $template->name }}" 
                                            data-slug="{{ $template->slug }}">
                                        @if($template->icon) {{ $template->icon }} @endif
                                        {{ $template->name }}
                                        @if($template->category) ({{ $template->category }}) @endif
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary btn-block" id="add-section-btn">
                            <i class="fa fa-plus"></i> Add Section
                        </button>
                    </div>
                </div>
                <small class="help-block" style="margin-top: 10px;">
                    <i class="fa fa-info-circle"></i> Choose a section template to add dynamic content blocks to this page.
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Existing Sections Display --}}
<div id="sections-container">
    @if($page->sections && $page->sections->count() > 0)
        @foreach($page->sections as $section)
            <div class="section-item" data-section-id="{{ $section->id }}" style="margin-bottom: 30px;">
                
                {{-- Section Header --}}
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="section-header" style="background: #f0f0f0; padding: 12px 15px; border: 1px solid #ddd; border-bottom: none; display: flex; justify-content: space-between; align-items: center; border-top-left-radius: 4px; border-top-right-radius: 4px;">
                            <div>
                                <strong>{{ $section->name }}</strong>
                                @if($section->template)
                                    <small class="text-muted">({{ $section->template->name }})</small>
                                @elseif($section->type)
                                    <small class="text-muted">({{ ucfirst($section->type) }})</small>
                                @endif
                            </div>
                            <div>
                                <button type="button" class="btn btn-xs btn-info toggle-section">
                                    <i class="fa fa-minus"></i> Hide
                                </button>
                                <button type="button" class="btn btn-xs btn-danger" onclick="removeSection({{ $section->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Section Content --}}
                <div class="row section-content">
                    <div class="col-md-8 col-md-offset-2">
                        <div style="border: 1px solid #ddd; border-top: none; padding: 20px; background: white; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                            
                            @if($section->section_template_id && $section->template)
                                {{-- Modern Template-Based Section --}}
                                <div class="template-section" data-template-id="{{ $section->template->id }}">
                                    @foreach($section->template->fields as $field)
                                        @php
                                            $fieldValue = '';
                                            // Get existing data for this field from section.value JSON
                                            if ($section->value) {
                                                $sectionValues = json_decode($section->value, true);
                                                if (is_array($sectionValues) && isset($sectionValues[$field->alias])) {
                                                    $fieldValue = $sectionValues[$field->alias];
                                                }
                                            }
                                        @endphp
                                        
                                        <div class="form-group">
                                            <label class="control-label">
                                                {{ $field->name }}
                                                @if($field->is_required) <span class="text-danger">*</span> @endif
                                            </label>
                                            
                                            @if($field->help_text)
                                                <small class="help-block">{{ $field->help_text }}</small>
                                            @endif
                                            
                                            @if($field->fieldType->component === 'text')
                                                <input type="text" 
                                                       name="section_{{ $section->id }}_{{ $field->alias }}" 
                                                       class="form-control"
                                                       value="{{ $fieldValue }}"
                                                       placeholder="{{ $field->placeholder ?? '' }}"
                                                       {{ $field->is_required ? 'required' : '' }}>
                                                       
                                            @elseif($field->fieldType->component === 'textarea')
                                                <textarea name="section_{{ $section->id }}_{{ $field->alias }}" 
                                                          class="form-control" 
                                                          rows="4"
                                                          placeholder="{{ $field->placeholder ?? '' }}"
                                                          {{ $field->is_required ? 'required' : '' }}>{{ $fieldValue }}</textarea>
                                                          
                                            @elseif($field->fieldType->component === 'rich-text')
                                                <textarea name="section_{{ $section->id }}_{{ $field->alias }}" 
                                                          class="form-control ckeditor" 
                                                          id="editor_{{ $section->id }}_{{ $field->id }}"
                                                          {{ $field->is_required ? 'required' : '' }}>{{ $fieldValue }}</textarea>
                                                <script>
                                                    $(document).ready(function() {
                                                        if (typeof CKEDITOR !== 'undefined') {
                                                            CKEDITOR.replace('editor_{{ $section->id }}_{{ $field->id }}');
                                                        }
                                                    });
                                                </script>
                                                
                                            @elseif($field->fieldType->component === 'image')
                                                @include('admin.components.attachment', [
                                                    'field' => 'section_' . $section->id . '_' . $field->alias, 
                                                    'label' => '', 
                                                    'value' => $fieldValue ? \App\Models\Attachment::find($fieldValue) : null,
                                                    'async' => true
                                                ])
                                                
                                            @else
                                                {{-- Default fallback for unknown field types --}}
                                                <input type="text" 
                                                       name="section_{{ $section->id }}_{{ $field->alias }}" 
                                                       class="form-control"
                                                       value="{{ $fieldValue }}"
                                                       placeholder="{{ $field->placeholder ?? '' }}"
                                                       {{ $field->is_required ? 'required' : '' }}>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                
                            @else
                                {{-- Legacy Section Support --}}
                                @if($section->isEditor)
                                    @include('admin.components.editor', ['field' => $section->alias, 'label' => '', 'value' => $section->value])
                                    
                                @elseif($section->isAttachment)
                                    @include('admin.components.attachment', ['field' => $section->alias, 'label' => '', 'value' => $section->attachment])
                                    
                                @elseif($section->isForm)
                                    <input type="hidden" name="{{ $section->alias }}">
                                    @php $form = json_decode($section->value); @endphp
                                    
                                    @if($form && isset($form->data))
                                        <div id="section-{{ $section->id }}">
                                            @foreach($form->data as $index => $data)
                                                <div class="form-field" style="margin-bottom: 20px; padding: 15px; background: #f9f9f9; border-radius: 4px;">
                                                    @foreach($data as $key => $value)
                                                        @php
                                                            $field = collect($form->fields)->first(function ($fld) use ($key) {
                                                                return $key === ($fld->alias ?? str_slug($fld->name));
                                                            });
                                                        @endphp
                                                        
                                                        @if($field)
                                                            <div class="form-group">
                                                                <label class="control-label">{{ $field->name }}</label>
                                                                
                                                                @if($field->type === 'text' || $field->type === 'numeric')
                                                                    <input type="{{ $field->type === 'numeric' ? 'number' : 'text' }}" 
                                                                           class="form-control fld" 
                                                                           data-name="{{ $field->alias ?? str_slug($field->name) }}" 
                                                                           value="{{ $value }}">
                                                                           
                                                                @elseif($field->type === 'textarea')
                                                                    <textarea class="fld form-control" 
                                                                              data-name="{{ $field->alias ?? str_slug($field->name) }}" 
                                                                              rows="4">{{ $value }}</textarea>
                                                                              
                                                                @elseif($field->type === 'attachment')
                                                                    @include('admin.components.attachment', [
                                                                        'field' => $field->alias ?? str_slug($field->name), 
                                                                        'label' => '', 
                                                                        'value' => \App\Models\Attachment::find($value), 
                                                                        'async' => true
                                                                    ])
                                                                    
                                                                @elseif($field->type === 'editor')
                                                                    @include('admin.components.editor', [
                                                                        'field' => $field->alias ?? str_slug($field->name), 
                                                                        'label' => '', 
                                                                        'value' => $value, 
                                                                        'async' => true
                                                                    ])
                                                                @endif
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @if(!$loop->last)<hr>@endif
                                            @endforeach
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
    @else
        {{-- No sections message --}}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="alert alert-info text-center" style="padding: 30px;">
                    <i class="fa fa-info-circle fa-2x" style="margin-bottom: 10px; display: block;"></i>
                    <h5>No Sections Added Yet</h5>
                    <p>This page has no content sections. Use the section template selector above to add dynamic content blocks.</p>
                </div>
            </div>
        </div>
    @endif
</div>

@push('extrascripts')
<script>
jQuery(document).ready(function($) {
    // Handle async file uploads for section template image fields
    $(document).on('change', 'input[type=file].async', function(e) {
        if (e.target.files.length === 0)
            return;
        
        var $self = $(this);
        var file = e.target.files[0]; // Capture file immediately before it's consumed
        
        // Stop other handlers from interfering
        e.stopImmediatePropagation();
        
        var formData = new FormData();
        formData.append('image', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Show loading state
        var $inputGroup = $self.closest('.input-group');
        var $textInput = $inputGroup.find('input[type=text]');
        var originalText = $textInput.val();
        $textInput.val('Uploading...').prop('disabled', true);
        
        // Manually update preview since we stopped propagation
        var id = this.id.replace('input_', '');
        var previewImg = document.getElementById('preview_' + id);
        if (previewImg && file) {
            $textInput.val(file.name);
            var reader = new FileReader();
            reader.onload = function(event) {
                var anchor = previewImg.closest('a.zoom');
                previewImg.style.display = "block";
                previewImg.src = event.target.result;
                anchor.href = event.target.result;
                var removeBtn = anchor.parentElement.querySelector(".remove-image-btn");
                if (removeBtn) removeBtn.style.display = "inline-block";
            };
            reader.readAsDataURL(file);
        }
        
        $.ajax({
            type: 'POST',
            url: '{{ route('admin.upload') }}',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                console.log('Upload response:', response);
                
                if (response.status) {
                    // Find the hidden input - it's a sibling of the file input inside the same span.btn
                    var $hiddenInput = $self.closest('span.btn').find('input[type=hidden].fld');
                    
                    if ($hiddenInput.length === 0) {
                        // Fallback: try siblings method
                        $hiddenInput = $self.siblings('input[type=hidden].fld');
                    }
                    
                    if ($hiddenInput.length > 0) {
                        console.log('Before update - Hidden input value:', $hiddenInput.val());
                        console.log('Hidden input name:', $hiddenInput.attr('name'));
                        
                        // Update hidden input with attachment ID
                        $hiddenInput.val(response.data.id);
                        
                        console.log('After update - Hidden input value:', $hiddenInput.val());
                        console.log('Image uploaded successfully. ID: ' + response.data.id);
                        
                        // Update the readonly text input to show filename
                        $textInput.val(response.data.name).prop('disabled', false);
                        showNotification('Image uploaded successfully!', 'success');
                    } else {
                        console.error('Could not find hidden input field to update!');
                        console.log('File input:', $self);
                        console.log('Parent span:', $self.closest('span.btn'));
                        $textInput.val(originalText).prop('disabled', false);
                        showNotification('Upload succeeded but could not update form field', 'error');
                    }
                } else {
                    $textInput.val(originalText).prop('disabled', false);
                    showNotification('Upload failed: ' + (response.message || 'Unknown error'), 'error');
                }
            },
            error: function(xhr, status, error) {
                console.error('Upload failed:', error);
                console.error('Response:', xhr.responseJSON);
                $textInput.val(originalText).prop('disabled', false);
                
                var errorMessage = 'Image upload failed. ';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += xhr.responseJSON.message;
                } else if (xhr.status === 413) {
                    errorMessage += 'File is too large.';
                } else if (xhr.status === 403) {
                    errorMessage += 'Permission denied.';
                } else if (xhr.status === 500) {
                    errorMessage += 'Server error. Check file permissions on storage/Form directory.';
                } else {
                    errorMessage += 'Please try again.';
                }
                
                showNotification(errorMessage, 'error');
            }
        });
    });
    
    // Add section template
    $('#add-section-btn').on('click', function() {
        var templateId = $('#section-template-select').val();
        var templateName = $('#section-template-select option:selected').data('name');
        var templateSlug = $('#section-template-select option:selected').data('slug');
        
        if (!templateId) {
            alert('Please select a section template first.');
            return;
        }
        
        // Show loading state
        var $btn = $(this);
        var originalText = $btn.html();
        $btn.html('<i class="fa fa-spinner fa-spin"></i> Adding...').prop('disabled', true);
        
        // Create section via AJAX
        $.ajax({
            url: '{{ route("admin.pages.sections.attach", $page->id) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                page_id: {{ $page->id }},
                template_id: templateId,
                name: templateSlug.replace(/-/g, ' ').replace(/\b\w/g, function(l) { return l.toUpperCase(); })
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showNotification('Section added successfully!', 'success');
                    
                    // Reset form
                    $('#section-template-select').val('');
                    
                    // Refresh the page to show new section
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error: ' + (response.message || 'Could not add section'), 'error');
                }
            },
            error: function(xhr) {
                var errorMessage = 'Could not add section. ';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage += xhr.responseJSON.message;
                } else {
                    errorMessage += 'Please try again.';
                }
                showNotification('Error: ' + errorMessage, 'error');
                console.error('Ajax error:', xhr);
            },
            complete: function() {
                $btn.html(originalText).prop('disabled', false);
            }
        });
    });
    
    // Toggle section visibility
    $('.toggle-section').on('click', function() {
        var $content = $(this).closest('.section-item').find('.section-content');
        var $button = $(this);
        
        $content.slideToggle(200, function() {
            // After animation is complete, check if content is visible
            if ($content.is(':visible')) {
                $button.html('<i class="fa fa-minus"></i> Hide');
            } else {
                $button.html('<i class="fa fa-plus"></i> Show');
            }
        });
    });
    
    // Show notification helper
    function showNotification(message, type) {
        var alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        var $notification = $('<div class="alert ' + alertClass + ' alert-dismissible" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">' +
            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
            message +
            '</div>');
        
        $('body').append($notification);
        
        // Auto-remove after 5 seconds
        setTimeout(function() {
            $notification.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
});

// Remove section function
function removeSection(sectionId) {
    if (confirm('Are you sure you want to remove this section from the page?\n\nThis will not delete the section template, just remove it from this page.')) {
        $.ajax({
            url: '{{ route("admin.pages.sections.detach", $page->id) }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                page_id: {{ $page->id }},
                section_id: sectionId
            },
            success: function(response) {
                if (response.success) {
                    $('[data-section-id="' + sectionId + '"]').fadeOut(300, function() {
                        $(this).remove();
                        
                        // Show message if no sections left
                        if ($('#sections-container .section-item').length === 0) {
                            $('#sections-container').html(
                                '<div class="row">' +
                                    '<div class="col-md-8 col-md-offset-2">' +
                                        '<div class="alert alert-info text-center" style="padding: 30px;">' +
                                            '<i class="fa fa-info-circle fa-2x" style="margin-bottom: 10px; display: block;"></i>' +
                                            '<h5>No Sections Added Yet</h5>' +
                                            '<p>This page has no content sections. Use the section template selector above to add dynamic content blocks.</p>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>'
                            );
                        }
                    });
                    
                    showNotification('Section removed successfully!', 'success');
                } else {
                    alert('Error: Could not remove section');
                }
            },
            error: function() {
                alert('Error: Could not remove section. Please try again.');
            }
        });
    }
}
</script>
@endpush

{{-- Custom Styles --}}
<style>
.section-header {
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.section-header:hover {
    background-color: #e9ecef !important;
}

.section-item {
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-item:hover {
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

.template-section .form-group:last-child {
    margin-bottom: 0;
}

.alert-info {
    border-left: 4px solid #61dbd5;
}

.panel-body h5 {
    color: #495057;
    font-weight: 600;
}

.help-block {
    color: #6c757d;
    font-size: 12px;
    margin-bottom: 0;
}

#add-section-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,123,255,0.25);
}

.form-field {
    transition: all 0.2s ease;
}

.form-field:hover {
    background-color: #f5f5f5 !important;
}

.btn-xs {
    padding: 1px 5px;
    font-size: 10px;
    line-height: 1.5;
    border-radius: 2px;
}
</style>