@extends('admin.layouts.base')

@section('title', 'Media Library')

@push('styles')
<style>
.media-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    padding: 20px 0;
}

.media-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.media-item:hover {
    border-color: #007bff;
    box-shadow: 0 4px 12px rgba(0,123,255,0.15);
    transform: translateY(-2px);
}

.media-item.selected {
    border-color: #007bff;
    background-color: #f8f9ff;
}

.media-thumbnail {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 10px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.media-thumbnail img {
    max-width: 100%;
    max-height: 100%;
    border-radius: 4px;
}

.file-icon {
    font-size: 48px;
    color: #6c757d;
}

.media-info {
    font-size: 12px;
}

.media-title {
    font-weight: bold;
    margin-bottom: 5px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.media-meta {
    color: #6c757d;
}

.upload-area {
    border: 2px dashed #ddd;
    padding: 40px;
    text-align: center;
    border-radius: 8px;
    transition: border-color 0.3s ease;
    margin-bottom: 20px;
}

.upload-area:hover,
.upload-area.dragover {
    border-color: #007bff;
    background-color: #f8f9ff;
}

.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.stats-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #ddd;
    text-align: center;
}

.stats-number {
    font-size: 24px;
    font-weight: bold;
    color: #007bff;
}

.modal-body .media-grid {
    max-height: 400px;
    overflow-y: auto;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <h1>Media Library</h1>
                <div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fa fa-upload"></i> Upload Files
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="create-folder-btn">
                        <i class="fa fa-folder"></i> New Folder
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-cards">
        <div class="stats-card">
            <div class="stats-number">{{ $stats['total_files'] ?? 0 }}</div>
            <div>Total Files</div>
        </div>
        <div class="stats-card">
            <div class="stats-number">{{ number_format(($stats['total_size'] ?? 0) / 1024 / 1024, 1) }} MB</div>
            <div>Storage Used</div>
        </div>
        <div class="stats-card">
            <div class="stats-number">{{ $stats['images'] ?? 0 }}</div>
            <div>Images</div>
        </div>
        <div class="stats-card">
            <div class="stats-number">{{ $stats['documents'] ?? 0 }}</div>
            <div>Documents</div>
        </div>
        <div class="stats-card">
            <div class="stats-number">{{ $stats['recent_uploads'] ?? 0 }}</div>
            <div>Recent (7 days)</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-md-3">
            <select class="form-control" id="type-filter">
                <option value="all">All File Types</option>
                <option value="images" {{ request('type') == 'images' ? 'selected' : '' }}>Images</option>
                <option value="documents" {{ request('type') == 'documents' ? 'selected' : '' }}>Documents</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-control" id="folder-filter">
                <option value="all">All Folders</option>
                @if(isset($folders))
                    @foreach($folders as $key => $folder)
                        @if($key !== 'all')
                            <option value="{{ $key }}" {{ request('folder') == $key ? 'selected' : '' }}>{{ $folder }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" id="search-input" placeholder="Search files..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-outline-primary w-100" id="search-btn">
                <i class="fa fa-search"></i> Search
            </button>
        </div>
    </div>

    <!-- Media Grid -->
    <div class="card">
        <div class="card-body">
            @if(isset($media) && $media->count() > 0)
                <div class="media-grid" id="media-grid">
                    @foreach($media as $item)
                        <div class="media-item" data-id="{{ $item->id }}" data-type="{{ $item->file_type }}">
                            <div class="media-thumbnail">
                                @if($item->is_image)
                                    <img src="{{ $item->thumbnail_url }}" alt="{{ $item->alt_text }}" loading="lazy">
                                @else
                                    <div class="file-icon">
                                        <i class="fa fa-file-o"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="media-info">
                                <div class="media-title" title="{{ $item->original_name }}">{{ $item->original_name }}</div>
                                <div class="media-meta">
                                    {{ $item->file_size }} • {{ $item->created_at->format('M d, Y') }}
                                </div>
                                @if($item->usage_count > 0)
                                    <div class="text-success">
                                        <i class="fa fa-link"></i> Used {{ $item->usage_count }} time(s)
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $media->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa fa-file-o fa-4x text-muted mb-3"></i>
                    <h4>No files found</h4>
                    <p class="text-muted">Upload your first files to get started.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        <i class="fa fa-upload"></i> Upload Files
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Files</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="upload-form" enctype="multipart/form-data">
                    @csrf
                    <div class="upload-area" id="upload-area">
                        <i class="fa fa-cloud-upload fa-3x text-muted mb-3"></i>
                        <p><strong>Click to upload</strong> or drag and drop files here</p>
                        <p class="text-muted">Maximum file size: 10MB</p>
                        <input type="file" id="file-input" name="files[]" multiple accept="image/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" style="display: none;">
                    </div>
                    
                    <div class="mt-3">
                        <label for="upload-folder" class="form-label">Folder (optional)</label>
                        <input type="text" class="form-control" id="upload-folder" name="folder" placeholder="e.g., images/gallery">
                    </div>
                    
                    <div class="progress mt-3" id="upload-progress" style="display: none;">
                        <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    
                    <div id="upload-results" class="mt-3"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="upload-btn">Upload Files</button>
            </div>
        </div>
    </div>
</div>

<!-- File Details Modal -->
<div class="modal fade" id="fileModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">File Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="file-details">
                <!-- File details loaded via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="delete-file-btn">Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-file-btn">Save Changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let selectedFiles = [];
    let currentFileId = null;

    // Upload area interactions
    $('#upload-area, #file-input').on('click', function(e) {
        e.preventDefault();
        $('#file-input').click();
    });

    $('#file-input').on('change', function() {
        const files = this.files;
        if (files.length > 0) {
            displaySelectedFiles(files);
        }
    });

    // Drag and drop
    $('#upload-area').on('dragover', function(e) {
        e.preventDefault();
        $(this).addClass('dragover');
    });

    $('#upload-area').on('dragleave', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
    });

    $('#upload-area').on('drop', function(e) {
        e.preventDefault();
        $(this).removeClass('dragover');
        const files = e.originalEvent.dataTransfer.files;
        $('#file-input')[0].files = files;
        displaySelectedFiles(files);
    });

    function displaySelectedFiles(files) {
        let html = '<h6>Selected Files:</h6><ul>';
        for (let i = 0; i < files.length; i++) {
            html += `<li>${files[i].name} (${formatFileSize(files[i].size)})</li>`;
        }
        html += '</ul>';
        $('#upload-results').html(html);
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Upload files
    $('#upload-btn').on('click', function() {
        const formData = new FormData();
        const files = $('#file-input')[0].files;
        const folder = $('#upload-folder').val();

        if (files.length === 0) {
            alert('Please select files to upload.');
            return;
        }

        // Add files to form data
        for (let i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }
        
        if (folder) {
            formData.append('folder', folder);
        }

        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        // Show progress
        $('#upload-progress').show();
        $(this).prop('disabled', true);

        $.ajax({
            url: '{{ route("admin.media.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function() {
                const xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(evt) {
                    if (evt.lengthComputable) {
                        const percentComplete = (evt.loaded / evt.total) * 100;
                        $('#upload-progress .progress-bar').css('width', percentComplete + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if (response.success) {
                    $('#upload-results').html('<div class="alert alert-success">' + response.message + '</div>');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            },
            error: function() {
                $('#upload-results').html('<div class="alert alert-danger">Upload failed. Please try again.</div>');
            },
            complete: function() {
                $('#upload-btn').prop('disabled', false);
                $('#upload-progress').hide();
            }
        });
    });

    // Media item selection
    $('.media-item').on('click', function() {
        const fileId = $(this).data('id');
        currentFileId = fileId;
        
        // Toggle selection
        $(this).toggleClass('selected');
        
        if ($(this).hasClass('selected')) {
            selectedFiles.push(fileId);
        } else {
            selectedFiles = selectedFiles.filter(id => id !== fileId);
        }
        
        // Show file details
        loadFileDetails(fileId);
    });

    function loadFileDetails(fileId) {
        $.get('{{ url("admin/media") }}/' + fileId, function(response) {
            // This would load file details - implement based on your needs
            $('#fileModal').modal('show');
        });
    }

    // Filtering
    $('#type-filter, #folder-filter').on('change', function() {
        applyFilters();
    });

    $('#search-btn').on('click', function() {
        applyFilters();
    });

    $('#search-input').on('keypress', function(e) {
        if (e.which === 13) {
            applyFilters();
        }
    });

    function applyFilters() {
        const type = $('#type-filter').val();
        const folder = $('#folder-filter').val();
        const search = $('#search-input').val();
        
        const params = new URLSearchParams();
        if (type && type !== 'all') params.append('type', type);
        if (folder && folder !== 'all') params.append('folder', folder);
        if (search) params.append('search', search);
        
        const url = '{{ route("admin.media.index") }}' + (params.toString() ? '?' + params.toString() : '');
        window.location.href = url;
    }
});
</script>
@endpush
