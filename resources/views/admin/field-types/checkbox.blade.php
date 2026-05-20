<div class="form-group">
    <div class="form-check">
        <input 
            type="checkbox"
            id="{{ $fieldId }}"
            name="{{ $fieldName }}"
            value="{{ $attributes['value'] ?? '1' }}"
            class="{{ $attributes['class'] ?? 'form-check-input' }}"
            @if($isChecked)
                checked
            @endif
        />
        
        <label for="{{ $fieldId }}" class="form-check-label">
            {{ $settings['label_text'] ?: $field->label ?: $field->name }}
            @if($field->is_required)
                <span class="text-danger">*</span>
            @endif
        </label>
    </div>
    
    @if($field->help_text)
        <small class="form-text text-muted">{{ $field->help_text }}</small>
    @endif
    
    @error($fieldName)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
