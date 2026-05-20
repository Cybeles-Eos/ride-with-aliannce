<div class="form-group">
    <label for="{{ $fieldId }}" class="form-label">
        {{ $field->label ?: $field->name }}
        @if($field->is_required)
            <span class="text-danger">*</span>
        @endif
    </label>
    
    <input 
        type="{{ $attributes['type'] ?? 'text' }}"
        id="{{ $fieldId }}"
        name="{{ $fieldName }}"
        value="{{ old($fieldName, $value) }}"
        class="{{ $attributes['class'] ?? 'form-control' }}"
        @if(isset($attributes['placeholder']))
            placeholder="{{ $attributes['placeholder'] }}"
        @endif
        @if(isset($attributes['maxlength']))
            maxlength="{{ $attributes['maxlength'] }}"
        @endif
        @if(isset($attributes['pattern']))
            pattern="{{ $attributes['pattern'] }}"
        @endif
        @if($field->is_required)
            required
        @endif
    />
    
    @if($field->help_text)
        <small class="form-text text-muted">{{ $field->help_text }}</small>
    @endif
    
    @error($fieldName)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
