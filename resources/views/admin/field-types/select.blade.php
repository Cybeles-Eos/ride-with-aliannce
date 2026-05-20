<div class="form-group">
    <label for="{{ $fieldId }}" class="form-label">
        {{ $field->label ?: $field->name }}
        @if($field->is_required)
            <span class="text-danger">*</span>
        @endif
    </label>
    
    <select 
        id="{{ $fieldId }}"
        name="{{ $fieldName }}{{ isset($attributes['multiple']) ? '[]' : '' }}"
        class="{{ $attributes['class'] ?? 'form-control' }}"
        @if(isset($attributes['multiple']) && $attributes['multiple'])
            multiple
        @endif
        @if($field->is_required)
            required
        @endif
    >
        @if(!isset($attributes['multiple']) || !$attributes['multiple'])
            <option value="">{{ $settings['default_option'] ?? 'Choose an option...' }}</option>
        @endif
        
        @foreach($options as $optionValue => $optionLabel)
            <option 
                value="{{ $optionValue }}"
                @if(is_array($value) && in_array($optionValue, $value))
                    selected
                @elseif($optionValue == old($fieldName, $value))
                    selected
                @endif
            >
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
    
    @if($field->help_text)
        <small class="form-text text-muted">{{ $field->help_text }}</small>
    @endif
    
    @error($fieldName)
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>
