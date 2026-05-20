@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.pages.index') }}">Pages</a></li>
        <li><span href="javascript:void(0)">Add New Page</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'POST',
            'id' => 'create-page',
            'route' => ['admin.pages.store'],
            'class' => 'form-horizontal ',
            'files' => TRUE,
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Add new Page</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="pages_name">Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="pages_name" name="name"
                               placeholder="Enter page name.." value="{{ old('name') }}">
                        @if($errors->has('name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="pages_slug">Slug</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="pages_slug" name="slug"
                               placeholder="Enter page slug.." value="{{ old('slug') }}">
                        @if($errors->has('slug'))
                            <span class="help-block animation-slideDown">{{ $errors->first('slug') }}</span>
                        @endif
                    </div>
                </div>


                <div class="form-group{{ $errors->has('banner_image') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="file">Banner Image</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <label class="input-group-btn">
                        <span class="btn btn-primary">
                            Choose File <input type="file" class="form-control" name="banner_image" style="display: none;">
                            <input type="hidden" class="fld" name="banner_image" value="">
                        </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                        </div>
                        @if($errors->has('banner_image'))
                            <span class="help-block animation-slideDown">{{ $errors->first('banner_image') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('page_type') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="page_type_id">Type</label>

                    <div class="col-md-9">
                        <select name="page_type_id" id="page_type_id"
                                class="page-type-select"
                                data-placeholder="Choose page type..">
                            <option value=""></option>
                            @foreach($page_types as $page_type)
                                <option value="{{ $page_type->id }}" {{ old('page_type_id') ? old('page_type_id') == $page_type->id ? 'selected' : '' : '' }}>{{ $page_type->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('page_type'))
                            <span class="help-block animation-slideDown">{{ $errors->first('page_type') }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="page_content">Content</label>

                    <div class="col-md-9">
                            <textarea id="page_content" name="content" rows="9"
                                      class="form-control ckeditor"
                                      placeholder="Enter page content..">{{ old('content') }}</textarea>
                        @if($errors->has('content'))
                            <span class="help-block animation-slideDown">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active" name="is_active"
                                   value="1" checked>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-warning">Cancel</a>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            @include('admin.pages.page.meta_fields')
        </div>
        {{ Form::close() }}
    </div>
@endsection

@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/libraries/pages.js') }}"></script>
@endpush