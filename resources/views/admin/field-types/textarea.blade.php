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
        class="{{ $attributes['class'] ?? 'form-control' }}"
        rows="{{ $attributes['rows'] ?? 4 }}"
        @if(isset($attributes['placeholder']))
            placeholder="{{ $attributes['placeholder'] }}"
        @endif
        @if(isset($attributes['maxlength']))
            maxlength="{{ $attributes['maxlength'] }}"
        @endif
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
