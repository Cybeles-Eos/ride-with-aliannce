<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="form-group{{ $errors->has($field) ? ' has-error' : '' }}">
            <label class="col-md-2 control-label" for="career_{{ $field }}">{{ $label }}</label>

            <div class="col-md-10">
                <textarea
                  @if(empty($async) || $async == false)
                  id="career_{{ $field }}"
                  name="{{ $field }}"
                  @else
                  id="{{ str_random(12) }}"
                  data-name="{{ $field }}"
                  @endif
                  rows="9"
                  class="form-control ckeditor fld"
                  placeholder="Enter {{ $field }}...">{{ old($field) ?: (empty($value) ? '' : $value) }}</textarea>
                @if($errors->has($field))
                    <span class="help-block animation-slideDown">{{ $errors->first($field) }}</span>
                @endif
            </div>
        </div>
    </div>
</div>