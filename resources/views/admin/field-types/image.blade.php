<div class="form-group">
    <label for="{{ $fieldId }}" class="form-label">
        {{ $field->label ?: $field->name }}
        @if($field->is_required)
            <span class="text-danger">*</span>
        @endif
    </label>
    
    @if($attachment)
        <div class="current-image mb-3">
            <img src="{{ $attachment->url }}" alt="{{ $attachment->alt_text }}" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
            <div class="mt-2">
                <strong>Current Image:</strong> {{ $attachment->original_name }}
                <br>
                <small class="text-muted">{{ $attachment->file_size }} | {{ $attachment->metadata['width'] ?? 'Unknown' }}x{{ $attachment->metadata['height'] ?? 'Unknown' }}</small>
            </div>
        </div>
    @endif
    
    <input 
        type="{{ $attributes['type'] ?? 'file' }}"
        id="{{ $fieldId }}"
        name="{{ $fieldName }}"
        class="{{ $attributes['class'] ?? 'form-control' }}"
        accept="{{ $attributes['accept'] ?? 'image/*' }}"
        @if(isset($attributes['multiple']) && $attributes['multiple'])
            multiple
        @endif
        @if($field->is_required && !$attachment)
            required
        @endif
    />
    
    <div class="row mt-2">
        <div class="col-md-6">
            <label for="{{ $fieldId }}_alt_text" class="form-label">Alt Text (for SEO)</label>
            <input 
                type="text" 
                id="{{ $fieldId }}_alt_text"
                name="{{ $fieldName }}_alt_text"
                class="form-control" 
                value="{{ old($fieldName . '_alt_text', $attachment->alt_text ?? '') }}" 
                placeholder="Describe the image for accessibility"
            />
        </div>
        <div class="col-md-6">
            <label for="{{ $fieldId }}_title" class="form-label">Title (optional)</label>
            <input 
                type="text" 
                id="{{ $fieldId }}_title"
                name="{{ $fieldName }}_title"
                class="form-control" 
                value="{{ old($fieldName . '_title', $attachment->title ?? '') }}" 
                placeholder="Image title"
            />
        </div>
    </div>
    
    @if($field->help_text)
        <small class="form-text text-muted">{{ $field->help_text }}</small>
    @endif
    
    @if(isset($settings['max_size']))
        <small class="form-text text-muted">Maximum file size: {{ number_format($settings['max_size'] / 1024, 1) }}MB</small>
    @endif
    
    @error($fieldName)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    @error($fieldName . '_alt_text')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
    @error($fieldName . '_title')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#{{ $fieldId }}').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Auto-generate alt text from filename
            const altTextInput = $('#{{ $fieldId }}_alt_text');
            if (!altTextInput.val()) {
                const filename = file.name.replace(/\.[^/.]+$/, ""); // Remove extension
                const altText = filename.replace(/[-_]/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                altTextInput.val(altText);
            }
        }
    });
});
</script>
@endpush
