@extends('admin.layouts.base')

@section('title', 'Section Templates')

@section('content')
    <div class="content-header">
        <div class="header-section">
            <h1>
                <i class="fa fa-puzzle-piece"></i>Section Templates<br>
                <small>Manage your reusable section templates</small>
            </h1>
        </div>
    </div>
    <ul class="breadcrumb breadcrumb-top">
        <li>Admin</li>
        <li><a href="">Section Templates</a></li>
    </ul>

    <div class="row text-center">
        <div class="col-sm-12 col-lg-12">
            <a href="{{ route('admin.section-templates.create') }}" class="widget widget-hover-effect2">
                <div class="widget-extra themed-background">
                    <h4 class="widget-content-light">
                        <strong>Create New</strong>
                        Template
                    </h4>
                </div>
                <div class="widget-extra-full">
                    <span class="h2 text-primary animation-expandOpen">
                        <i class="fa fa-plus"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>

    <div class="block full">
        <div class="block-title">
            <h2>
                <i class="fa fa-puzzle-piece"></i>
                <strong>All Templates</strong>
            </h2>
        </div>
        <div class="block-content">
                    <div class="alert alert-info alert-dismissable {{$templates->count() == 0 ? '' : 'johnCena' }}">
                <i class="fa fa-info-circle"></i> No section templates found.
            </div>
            <div class="table-responsive {{$templates->count() == 0 ? 'johnCena' : '' }}">
                <table id="templates-table" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%;">ID</th>
                            <th class="text-left" style="width: 30%;">Name</th>
                            <th class="text-center" style="width: 15%;">Category</th>
                            <th class="text-center" style="width: 10%;">Fields</th>
                            <th class="text-center" style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 10%;">Created</th>
                            <th class="text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($templates as $template)
                            <tr data-template-id="{{ $template->id }}">
                                <td class="text-center"><strong>{{ $template->id }}</strong></td>
                                <td>
                                    @if($template->icon)
                                        <i class="{{ $template->icon }}"></i>
                                    @endif
                                    <strong>{{ $template->name }}</strong>
                                    @if($template->description)
                                        <br>
                                        <small class="text-muted">{{ substr($template->description, 0, 60) . (strlen($template->description) > 60 ? '...' : '') }}</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($template->category)
                                        <span class="label label-info">{{ $template->category }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="label label-primary">{{ $template->fields_count }} fields</span>
                                </td>
                                <td class="text-center">
                                    <label class="switch switch-primary">
                                        <input type="checkbox" class="toggle-active" 
                                               data-id="{{ $template->id }}"
                                               {{ $template->is_active ? 'checked' : '' }}>
                                        <span></span>
                                    </label>
                                    <small class="text-muted">{{ $template->is_active ? 'Active' : 'Inactive' }}</small>
                                </td>
                                <td class="text-center">{{ $template->created_at->format('M j, Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-xs">
                                        <a href="{{ route('admin.section-templates.show', $template->id) }}"
                                           data-toggle="tooltip"
                                           title=""
                                           class="btn btn-default"
                                           data-original-title="View"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('admin.section-templates.edit', $template->id) }}"
                                           data-toggle="tooltip"
                                           title=""
                                           class="btn btn-default"
                                           data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0)"
                                           data-toggle="tooltip"
                                           title=""
                                           class="btn btn-default duplicate-template"
                                           data-original-title="Duplicate"
                                           data-id="{{ $template->id }}"><i class="fa fa-copy"></i></a>
                                        <a href="javascript:void(0)"
                                           data-toggle="tooltip"
                                           title=""
                                           class="btn btn-xs btn-danger delete-template"
                                           data-original-title="Delete"
                                           data-id="{{ $template->id }}"><i class="fa fa-times"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('extrascripts')
<script>
$(document).ready(function() {
    // Toggle active status
    $('.toggle-active').on('change', function() {
        const templateId = $(this).data('id');
        const isActive = $(this).is(':checked');
        
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
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    swal("Error", response.message, "error");
                    // Revert the toggle
                    $('.toggle-active[data-id="' + templateId + '"]').prop('checked', !isActive);
                }
            },
            error: function() {
                swal("Error", "Failed to update template status", "error");
                // Revert the toggle
                $('.toggle-active[data-id="' + templateId + '"]').prop('checked', !isActive);
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
                            } else {
                                location.reload();
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
                    swal("Error", "Failed to delete template", "error");
                }
            });
        });
    });
});
</script>
@endpush
