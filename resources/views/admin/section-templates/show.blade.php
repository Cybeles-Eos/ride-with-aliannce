@extends('admin.layouts.base')

@section('title', $template->name . ' - Section Template')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.section-templates.index') }}">Section Templates</a></li>
        <li><a href="">{{ $template->name }}</a></li>
    </ul>

    <div class="row">
        <div class="col-md-8">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-info-circle"></i> <strong>Template Details</strong></h2>
                </div>
                <div class="block-content">
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-sm-3"><strong>Name:</strong></div>
                        <div class="col-sm-9">
                            @if($template->icon)
                                <i class="{{ $template->icon }}"></i>
                            @endif
                            {{ $template->name }}
                        </div>
                    </div>
                    
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-sm-3"><strong>Slug:</strong></div>
                        <div class="col-sm-9">
                            <code>{{ $template->slug }}</code>
                        </div>
                    </div>
                    
                    @if($template->description)
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-sm-3"><strong>Description:</strong></div>
                            <div class="col-sm-9">{{ $template->description }}</div>
                        </div>
                    @endif
                    
                    @if($template->category)
                        <div class="row" style="margin-bottom: 15px;">
                            <div class="col-sm-3"><strong>Category:</strong></div>
                            <div class="col-sm-9">
                                <span class="label label-info">{{ $template->category }}</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-sm-3"><strong>Status:</strong></div>
                        <div class="col-sm-9">
                            @if($template->is_active)
                                <span class="label label-success">Active</span>
                            @else
                                <span class="label label-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-sm-3"><strong>Fields Count:</strong></div>
                        <div class="col-sm-9">{{ $template->fields->count() }} fields</div>
                    </div>
                    
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-sm-3"><strong>Usage:</strong></div>
                        <div class="col-sm-9">
                            Used in {{ $template->sections->count() }} sections
                            @if($template->sections->count() > 0)
                                <button class="btn btn-xs btn-default" data-toggle="collapse" data-target="#usageDetails">
                                    View Details
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    @if($template->sections->count() > 0)
                        <div class="collapse" id="usageDetails">
                            <div class="alert alert-info" style="margin-top: 10px;">
                                <h5>Sections using this template:</h5>
                                <ul style="margin-bottom: 0;">
                                    @foreach($template->sections as $section)
                                        <li>{{ $section->name }} ({{ $section->alias }})</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-sm-3"><strong>Created:</strong></div>
                        <div class="col-sm-9">{{ $template->created_at->format('F j, Y \a\t g:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-bolt"></i> <strong>Quick Actions</strong></h2>
                </div>
                <div class="block-content" style="padding: 15px;">
                    <a href="{{ route('admin.section-templates.edit', $template->id) }}" 
                       class="btn btn-warning btn-block" style="margin-bottom: 10px;">
                        <i class="fa fa-pencil"></i> Edit Template
                    </a>
                    
                    <button class="btn btn-default btn-block duplicate-template" 
                            data-id="{{ $template->id }}" style="margin-bottom: 10px;">
                        <i class="fa fa-copy"></i> Duplicate Template
                    </button>
                    
                    <button class="btn btn-{{ $template->is_active ? 'default' : 'success' }} btn-block toggle-active" 
                            data-id="{{ $template->id }}" style="margin-bottom: 10px;">
                        <i class="fa fa-toggle-{{ $template->is_active ? 'on' : 'off' }}"></i>
                        {{ $template->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                    
                    @if($template->sections->count() == 0)
                        <button class="btn btn-danger btn-block delete-template" 
                                data-id="{{ $template->id }}">
                            <i class="fa fa-times"></i> Delete Template
                        </button>
                    @else
                        <button class="btn btn-danger btn-block" disabled title="Cannot delete template in use">
                            <i class="fa fa-times"></i> Delete Template
                        </button>
                        <small class="text-muted">Template is being used by {{ $template->sections->count() }} section(s)</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($template->fields->count() > 0)
        <div class="row">
            <div class="col-md-12">
                <div class="block full">
                    <div class="block-title">
                        <h2><i class="fa fa-list"></i> <strong>Template Fields ({{ $template->fields->count() }})</strong></h2>
                    </div>
                    <div class="block-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%;">Order</th>
                                        <th class="text-left" style="width: 25%;">Name</th>
                                        <th class="text-center" style="width: 15%;">Alias</th>
                                        <th class="text-center" style="width: 15%;">Type</th>
                                        <th class="text-center" style="width: 10%;">Required</th>
                                        <th class="text-left" style="width: 30%;">Settings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($template->fields->sortBy('sort_order') as $field)
                                        <tr>
                                            <td class="text-center">
                                                <span class="label label-default">{{ $field->sort_order }}</span>
                                            </td>
                                            <td>
                                                <strong>{{ $field->name }}</strong>
                                                @if($field->label && $field->label !== $field->name)
                                                    <br><small class="text-muted">Label: {{ $field->label }}</small>
                                                @endif
                                                @if($field->help_text)
                                                    <br><small class="text-muted">Help: {{ $field->help_text }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <code>{{ $field->alias }}</code>
                                            </td>
                                            <td class="text-center">
                                                <span class="label label-primary">{{ $field->fieldType->name }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if($field->is_required)
                                                    <span class="label label-warning">Required</span>
                                                @else
                                                    <span class="label label-default">Optional</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($field->placeholder)
                                                    <small><strong>Placeholder:</strong> {{ $field->placeholder }}<br></small>
                                                @endif
                                                @if($field->validation_rules && count($field->validation_rules) > 0)
                                                    <small><strong>Validation:</strong> {{ implode(', ', $field->validation_rules) }}<br></small>
                                                @endif
                                                @if($field->settings && count($field->settings) > 0)
                                                    <small><strong>Settings:</strong> {{ count($field->settings) }} custom</small>
                                                @endif
                                                @if(!$field->placeholder && (!$field->validation_rules || count($field->validation_rules) == 0) && (!$field->settings || count($field->settings) == 0))
                                                    <small class="text-muted">Default settings</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('extrascripts')
<script>
$(document).ready(function() {
    // Toggle active status
    $('.toggle-active').on('click', function() {
        const templateId = $(this).data('id');
        const $btn = $(this);
        
        $.ajax({
            url: `/admin/section-templates/${templateId}/toggle-active`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    swal({
                        title: "Success!",
                        text: "Template status updated successfully",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    }, function() {
                        location.reload();
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function() {
                swal("Error", "Failed to update template status", "error");
            }
        });
    });
    
    // Duplicate template
    $('.duplicate-template').on('click', function() {
        const templateId = $(this).data('id');
        
        swal({
            title: "Are you sure?",
            text: "Do you want to duplicate this template?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, duplicate it!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: `/admin/section-templates/${templateId}/duplicate`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        swal({
                            title: "Duplicated!",
                            text: response.message,
                            type: "success",
                            showCancelButton: true,
                            confirmButtonText: "Edit Now",
                            cancelButtonText: "Stay Here"
                        }, function(isConfirm) {
                            if (isConfirm) {
                                window.location.href = response.data.edit_url;
                            }
                        });
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function() {
                    swal("Error", "Failed to duplicate template", "error");
                }
            });
        });
    });
    
    // Delete template
    $('.delete-template').on('click', function() {
        const templateId = $(this).data('id');
        
        swal({
            title: "Are you sure?",
            text: "This action cannot be undone!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: `/admin/section-templates/${templateId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        swal({
                            title: "Deleted!",
                            text: response.message,
                            type: "success",
                            timer: 1500,
                            showConfirmButton: false
                        }, function() {
                            window.location.href = '{{ route("admin.section-templates.index") }}';
                        });
                        setTimeout(function() {
                            window.location.href = '{{ route("admin.section-templates.index") }}';
                        }, 1500);
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function() {
                    swal("Error", "Failed to delete template", "error");
                }
            });
        });
    });
});
</script>
@endpush
