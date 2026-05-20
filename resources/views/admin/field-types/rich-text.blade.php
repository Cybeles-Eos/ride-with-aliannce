<div class="form-group">
    <label for="{{ $fieldId }}" class="form-label">
        {{ $field->label ?: $field->name }}
        @if($field->is_required)
            <span class="text-danger">*</span>
        @endif
    </label>
    
    <textarea 
        id="{{ $fieldId }}"
        name="{{ $fieldName }}"
        class="form-control rich-text-editor"
        data-editor="{{ $editor }}"
        data-height="{{ $settings['height'] ?? 300 }}"
        @if($field->is_required)
            required
        @endif
    >{{ old($fieldName, $value) }}</textarea>
    
    @if($field->help_text)
        <small class="form-text text-muted">{{ $field->help_text }}</small>
    @endif
    
    @error($fieldName)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

@push('scripts')
<script>
$(document).ready(function() {
    @if($editor === 'ckeditor')
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('{{ $fieldId }}', {
                height: {{ $settings['height'] ?? 300 }},
                toolbar: '{{ $settings['toolbar'] ?? 'full' }}'
            });
        }
    @endif
});
</script>
@endpush
