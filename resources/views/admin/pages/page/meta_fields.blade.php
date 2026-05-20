<div class="block">
    <div class="block-title">
        <h2><i class="fa fa-archive"></i> <strong>Meta Data</strong></h2>
    </div>
    <input type="hidden" name="seo_meta_id" value="{{ (!empty($page) ? $page->seo_meta_id : 0) }}">
    <div class="form-group{{ $errors->has('meta_title') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label" for="meta_title">Meta Title</label>

        <div class="col-md-9">
            <input type="text" class="form-control" id="meta_title" name="meta_title"
                   value="{{ Request::old('meta_title') ? old('meta_title') : (!empty($seo_meta_fields) ? $seo_meta_fields->meta_title : '') }}"
                   placeholder="Enter meta title..">
            @if($errors->has('meta_title'))
                <span class="help-block animation-slideDown">{{ $errors->first('meta_title') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('meta_keywords') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label" for="meta_keywords">Meta Keywords</label>

        <div class="col-md-9">
            <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                   value="{{ Request::old('meta_keywords') ? old('meta_keywords') : (!empty($seo_meta_fields) ? $seo_meta_fields->meta_keywords : '') }}"
                   placeholder="Enter meta keywords..">
            @if($errors->has('meta_keywords'))
                <span class="help-block animation-slideDown">{{ $errors->first('meta_keywords') }}</span>
            @endif
        </div>
    </div>
    <div class="form-group{{ $errors->has('meta_description') ? ' has-error' : '' }}">
        <label class="col-md-3 control-label" for="meta_description">Meta Description</label>

        <div class="col-md-9">
                <textarea class="form-control" id="meta_description" name="meta_description"
                          placeholder="Enter meta description.." style="resize: vertical; min-height: 100px;"
                          rows="5">{{ Request::old('meta_description') ? old('meta_description') : (!empty($seo_meta_fields) ? $seo_meta_fields->meta_description : '') }}</textarea>
            @if($errors->has('meta_description'))
                <span class="help-block animation-slideDown">{{ $errors->first('meta_description') }}</span>
            @endif
        </div>
    </div>
</div>