@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.system_settings.index') }}">System Settings</a></li>
        <li><span href="javascript:void(0)">Edit System Setting</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-system-setting',
            'route' => ['admin.system_settings.update', $system_setting->id],
            'class' => 'form-horizontal ',
            'files' => TRUE
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit System Setting "{{$system_setting->name}}"</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="system_settings_code">Code</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="system_settings_code" name="code"
                               placeholder="Enter system setting code.."
                               value="{{  Request::old('code') ? : $system_setting->code }}"
                               readonly>
                        @if($errors->has('code'))
                            <span class="help-block animation-slideDown">{{ $errors->first('code') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="system_settings_name">Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="system_settings_name" name="name"
                               value="{{  Request::old('name') ? : $system_setting->name }}"
                               placeholder="Enter system setting name..">
                        @if($errors->has('name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                @include('admin.pages.system_setting.value')
                {{--<div class="form-group{{ $errors->has('value') ? ' has-error' : '' }}">--}}
                    {{--<label class="col-md-3 control-label" for="system_settings_value">Value</label>--}}

                    {{--<div class="col-md-9">--}}
                        {{--<input type="text" class="form-control" id="system_settings_value" name="value"--}}
                               {{--value="{{  Request::old('value') ? : $system_setting->value }}"--}}
                               {{--placeholder="Enter system setting value..">--}}
                        {{--@if($errors->has('value'))--}}
                            {{--<span class="help-block animation-slideDown">{{ $errors->first('value') }}</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.system_settings.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
@if ($system_setting->type == 'file')
    <script>
        sSettingType = 'file';
    </script>
@endif
<script type="text/javascript" src="{{ asset('public/js/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/libraries/system_settings.js') }}"></script>
@endpush