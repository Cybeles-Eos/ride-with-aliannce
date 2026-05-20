@extends('admin.layouts.base')

@section('title', 'Edit Media - ' . $media->original_name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1>Edit Media</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.media.index') }}">Media Library</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.media.show', $media->id) }}">{{ substr($media->original_name, 0, 30) . (strlen($media->original_name) > 30 ? '...' : '') }}</a>
                            </li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.media.show', $media->id) }}" class="btn btn-secondary">
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
                    <h5>File Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.media.update', $media->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="alt_text" class="form-label">
                                        Alt Text <span class="text-danger">*</span>
                                        <small class="text-muted d-block">Describe the image for screen readers and SEO</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('alt_text') is-invalid @enderror" 
                                           id="alt_text" 
                                           name="alt_text" 
                                           value="{{ old('alt_text', $media->alt_text) }}"
                                           placeholder="Brief description of the image">
                                    @error('alt_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">
                                        Title
                                        <small class="text-muted d-block">Optional title for the image</small>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           id="title" 
                                           name="title" 
                                           value="{{ old('title', $media->title) }}"
                                           placeholder="Image title">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="caption" class="form-label">
                                Caption
                                <small class="text-muted d-block">Longer description or caption for the image</small>
                            </label>
                            <textarea class="form-control @error('caption') is-invalid @enderror" 
                                      id="caption" 
                                      name="caption" 
                                      rows="3"
                                      placeholder="Detailed caption or description">{{ old('caption', $media->caption) }}</textarea>
                            @error('caption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="folder" class="form-label">
                                Folder
                                <small class="text-muted d-block">Organize files into folders</small>
                            </label>
                            <input type="text" 
                                   class="form-control @error('folder') is-invalid @enderror" 
                                   id="folder" 
                                   name="folder" 
                                   value="{{ old('folder', $media->folder) }}"
                                   placeholder="e.g., images/gallery">
                            @error('folder')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Changes
                            </button>
                            
                            <a href="{{ route('admin.media.show', $media->id) }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Preview -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5>Preview</h5>
                </div>
                <div class="card-body text-center">
                    @if($media->is_image)
                        <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="img-fluid mb-3" style="max-height: 200px;">
                    @else
                        <div class="file-preview p-3">
                            <i class="fa fa-file-o fa-4x text-muted mb-3"></i>
                            <h6>{{ $media->original_name }}</h6>
                        </div>
                    @endif
                    
                    <div class="text-muted small">
                        <strong>Current Alt Text:</strong><br>
                        <span id="current-alt">{{ $media->alt_text ?: 'Not set' }}</span>
                    </div>
                </div>
            </div>

            <!-- File Details -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5>File Details</h5>
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
                            <td><strong>Uploaded:</strong></td>
                            <td>{{ $media->created_at->format('M d, Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- SEO Tips -->
            <div class="card">
                <div class="card-header">
                    <h5>SEO Tips</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6>Alt Text Best Practices:</h6>
                        <ul class="mb-0 small">
                            <li>Be descriptive but concise</li>
                            <li>Don't start with "Image of..." or "Picture of..."</li>
                            <li>Include relevant keywords naturally</li>
                            <li>Keep it under 125 characters</li>
                            <li>Skip decorative images</li>
                        </ul>
                    </div>
                    
                    <div id="alt-text-stats" class="text-muted small">
                        <strong>Alt text length:</strong> <span id="alt-length">{{ strlen($media->alt_text ?? '') }}</span>/125 characters
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Update alt text character count
    $('#alt_text').on('input', function() {
        const length = $(this).val().length;
        $('#alt-length').text(length);
        $('#current-alt').text($(this).val() || 'Not set');
        
        if (length > 125) {
            $('#alt-length').addClass('text-danger');
        } else {
            $('#alt-length').removeClass('text-danger');
        }
    });

    // Initialize character count
    const initialLength = $('#alt_text').val().length;
    $('#alt-length').text(initialLength);
    if (initialLength > 125) {
        $('#alt-length').addClass('text-danger');
    }

    // Auto-populate alt text if empty
    if (!$('#alt_text').val()) {
        const filename = '{{ pathinfo($media->original_name, PATHINFO_FILENAME) }}';
        const autoAlt = filename.replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        $('#alt_text').attr('placeholder', autoAlt);
    }

    // Form validation
    $('form').on('submit', function(e) {
        const altText = $('#alt_text').val().trim();
        
        if (!altText) {
            e.preventDefault();
            alert('Alt text is required for accessibility and SEO.');
            $('#alt_text').focus();
            return false;
        }
        
        if (altText.length > 125) {
            e.preventDefault();
            alert('Alt text should be under 125 characters for optimal SEO.');
            $('#alt_text').focus();
            return false;
        }
    });

    // Success message handling
    @if(session('success'))
    const notification = $(`
        <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);
    
    $('body').append(notification);
    
    setTimeout(function() {
        notification.alert('close');
    }, 5000);
    @endif
});
</script>
@endpush
