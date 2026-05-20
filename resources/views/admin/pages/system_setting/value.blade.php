@if ($system_setting->type == 'textarea')
    <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label" for="system_settings_value">Value</label>

        <div class="col-md-9">
                <textarea id="system_settings_value"
                          name="value" rows="9"
                          class="form-control" style="resize: vertical; min-height: 150px;"
                          placeholder="Enter system setting value..">{!! $system_setting->value !!}</textarea>
        </div>
    </div>
@elseif ($system_setting->type == 'ckeditor')
    <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label" for="system_settings_value">Value</label>

        <div class="col-md-9">
                <textarea id="system_settings_value"
                          name="value" rows="9"
                          class="form-control ckeditor" style="resize: vertical; min-height: 150px;"
                          placeholder="Enter system setting value..">{!! $system_setting->value !!}</textarea>
        </div>
    </div>
@elseif ($system_setting->type == 'file')
    <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label"
               for="value">Value</label>
        <div class="col-md-9">
            <div class="input-group">
                <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Choose File <input type="file" name="value" style="display: none;">
                        </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-offset-3 col-md-9">
            <a href="{{ asset($system_setting->value) }}" class="zoom img-thumbnail"
               style="cursor: default !important;" data-toggle="lightbox-image">
                <img src="{{ asset($system_setting->value) }}" alt="{{ $system_setting->value}}"
                     class="img-responsive center-block" style="max-width: 100px;">
            </a>
        </div>
    </div>
@else
    <div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label" for="system_settings_value">Value</label>

        <div class="col-md-9">
            <input type="text" class="form-control" id="system_settings_value" name="value"
                   value="{{  Request::old('value') ? : $system_setting->value }}"
                   placeholder="Enter system setting value..">
        </div>
    </div>
@endif
@if($errors->has('value'))
    <span class="help-block animation-slideDown">{{ $errors->first('value') }}</span>
@endif
