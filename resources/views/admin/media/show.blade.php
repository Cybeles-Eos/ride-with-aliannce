@extends('admin.layouts.base')

@section('title', 'Media Details - ' . $media->original_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1>Media Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.media.index') }}">Media Library</a>
                            </li>
                            <li class="breadcrumb-item active">{{ $media->original_name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.media.edit', $media->id) }}" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.media.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Preview</h5>
                </div>
                <div class="card-body text-center">
                    @if($media->is_image)
                        <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="img-fluid" style="max-height: 500px;">
                    @else
                        <div class="file-preview p-5">
                            <i class="fa fa-file-o fa-5x text-muted mb-3"></i>
                            <h4>{{ $media->original_name }}</h4>
                            <p class="text-muted">{{ strtoupper($media->file_type) }} File</p>
                            <a href="{{ $media->url }}" target="_blank" class="btn btn-primary">
                                <i class="fa fa-download"></i> Download
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- File Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5>File Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $media->original_name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Type:</strong></td>
                            <td>{{ $media->mime_type }}</td>
                        </tr>
                        <tr>
                            <td><strong>Size:</strong></td>
                            <td>{{ $media->file_size }}</td>
                        </tr>
                        @if($media->is_image && isset($media->metadata['width']))
                        <tr>
                            <td><strong>Dimensions:</strong></td>
                            <td>{{ $media->metadata['width'] }} × {{ $media->metadata['height'] }}px</td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Folder:</strong></td>
                            <td>{{ $media->folder ?: 'Root' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Uploaded:</strong></td>
                            <td>{{ $media->created_at->format('M d, Y g:i A') }}</td>
                        </tr>
                        <tr>
                            <td><strong>By:</strong></td>
                            <td>{{ $media->uploader->name ?? 'Unknown' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- SEO & Accessibility -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5>SEO & Accessibility</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>Alt Text:</strong></label>
                        <p class="form-control-static">{{ $media->alt_text ?: 'Not set' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Title:</strong></label>
                        <p class="form-control-static">{{ $media->title ?: 'Not set' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><strong>Caption:</strong></label>
                        <p class="form-control-static">{{ $media->caption ?: 'Not set' }}</p>
                    </div>
                </div>
            </div>

            <!-- Usage Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Usage Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Usage Count:</strong> 
                        <span class="badge bg-{{ $media->usage_count > 0 ? 'success' : 'secondary' }}">
                            {{ $media->usage_count }} time(s)
                        </span>
                    </div>
                    @if($media->last_used_at)
                    <div class="mb-3">
                        <strong>Last Used:</strong> {{ $media->last_used_at->diffForHumans() }}
                    </div>
                    @endif
                    
                    <button type="button" class="btn btn-info btn-sm" id="show-usage">
                        <i class="fa fa-search"></i> View Usage Details
                    </button>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h5>Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ $media->url }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fa fa-external-link"></i> View Full Size
                        </a>
                        <a href="{{ $media->url }}" download class="btn btn-outline-secondary">
                            <i class="fa fa-download"></i> Download
                        </a>
                        <button type="button" class="btn btn-outline-info" id="copy-url">
                            <i class="fa fa-copy"></i> Copy URL
                        </button>
                        @if($media->usage_count == 0)
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fa fa-trash"></i> Delete File
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this file?</p>
                <p><strong>{{ $media->original_name }}</strong></p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.media.destroy', $media->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Usage Details Modal -->
<div class="modal fade" id="usageModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Usage Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="usage-details">
                <!-- Usage details loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Copy URL to clipboard
    $('#copy-url').on('click', function() {
        const url = '{{ $media->url }}';
        
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                showNotification('URL copied to clipboard!', 'success');
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = url;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showNotification('URL copied to clipboard!', 'success');
        }
    });

    // Show usage details
    $('#show-usage').on('click', function() {
        $.get('{{ route("admin.media.usage", $media->id) }}', function(response) {
            let html = '<h6>Pages using this file:</h6>';
            
            if (response.pages && response.pages.length > 0) {
                html += '<ul class="list-group list-group-flush mb-3">';
                response.pages.forEach(page => {
                    html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                        ${page.name}
                        <a href="/admin/pages/${page.id}/edit" class="btn btn-sm btn-outline-primary">Edit</a>
                    </li>`;
                });
                html += '</ul>';
            }
            
            html += '<h6>Sections using this file:</h6>';
            if (response.sections && response.sections.length > 0) {
                html += '<ul class="list-group list-group-flush">';
                response.sections.forEach(section => {
                    html += `<li class="list-group-item">${section.name} (${section.alias})</li>`;
                });
                html += '</ul>';
            } else {
                html += '<p class="text-muted">No sections using this file.</p>';
            }
            
            if (response.pages.length === 0 && response.sections.length === 0) {
                html = '<p class="text-muted">This file is not currently used anywhere.</p>';
            }
            
            $('#usage-details').html(html);
            $('#usageModal').modal('show');
        });
    });

    function showNotification(message, type) {
        const notification = $(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        
        $('body').append(notification);
        
        setTimeout(function() {
            notification.alert('close');
        }, 3000);
    }
});
</script>
@endpush
