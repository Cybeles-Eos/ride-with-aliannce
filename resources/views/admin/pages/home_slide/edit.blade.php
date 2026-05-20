@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.home_slides.index') }}">Home Slides</a></li>
        <li><span href="javascript:void(0)">Edit Home Slide</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-home_slide',
            'route' => ['admin.home_slides.update', $home_slide->id],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit Home Slide "{{$home_slide->name}}"</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="home_slide_name">Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="home_slide_name" name="name"
                               value="{{  Request::old('name') ? : $home_slide->name }}"
                               placeholder="Enter Home Slide name..">
                        @if($errors->has('name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('background_image') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="background_image">Background Image</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary">
                                    Choose File <input type="file" name="background_image" style="display: none;">
                                </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        @if($errors->has('background_image'))
                            <span class="help-block animation-slideDown">{{ $errors->first('background_image') }}</span>
                        @endif
                    </div>
                    <div class="col-md-offset-3 col-md-9">
                        <a href="{{ asset($home_slide->background_image) }}" class="zoom img-thumbnail" style="cursor: default !important;" data-toggle="lightbox-image">
                            <img src="{{ $home_slide->background_image != '' ? asset($home_slide->background_image) : '' }}"
                                 alt="{{ $home_slide->background_image != '' ? asset($home_slide->background_image) : '' }}"
                                 class="img-responsive center-block" style="max-width: 100px;">
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="btn btn-xs btn-danger remove-image-btn"
                           style="display: {{ $home_slide->background_image != '' ? '' : 'none' }};"><i class="fa fa-trash"></i> Remove</a>
                        <input type="hidden" name="remove_background_image" class="remove-image" value="0">
                    </div>
                </div>

                <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="home_slide_content">Content</label>

                    <div class="col-md-9">
                    <textarea id="home_slide_content" name="content" rows="9" class="form-control ckeditor"
                              placeholder="Enter Home Slide content..">{!! Request::old('content') ? : $home_slide->content !!}</textarea>
                        @if($errors->has('content'))
                            <span class="help-block animation-slideDown">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('button_label') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="home_slide_button_label">Button Label</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="home_slide_button_label" name="button_label"
                               value="{{  Request::old('button_label') ? : $home_slide->button_label }}"
                               placeholder="Enter Home Slide button label..">
                        @if($errors->has('button_label'))
                            <span class="help-block animation-slideDown">{{ $errors->first('button_label') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('button_link') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="home_slide_button_link">Button Link</label>

                    <div class="col-md-9">
                    <textarea id="home_slide_button_link" name="button_link" rows="9" class="form-control "
                              style="resize: vertical; min-height: 150px;"
                              placeholder="Enter Home Slide button link..">{!! Request::old('button_link') ? : $home_slide->button_link !!}</textarea>
                        @if($errors->has('button_link'))
                            <span class="help-block animation-slideDown">{{ $errors->first('button_link') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active" name="is_active"
                                   value="1" {{ Request::old('is_active') ? : ($home_slide->is_active ? 'checked' : '') }}>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.home_slides.index') }}" class="btn btn-sm btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/libraries/home_slides.js') }}"></script>
@endpush