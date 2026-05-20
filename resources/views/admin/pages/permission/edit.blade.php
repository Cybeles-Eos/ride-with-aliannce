@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ url('admin/permissions') }}">Permissions</a></li>
        <li><span href="javascript:void(0)">Edit Permission</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-permission',
            'route' => ['admin.permissions.update', $permission->id],
            'class' => 'form-horizontal '
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit Permission "{{$permission->name}}"</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="name">Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="name" name="name"
                               value="{{  Request::old('name') ? : $permission->name }}"
                               placeholder="Enter permission name..">
                        @if($errors->has('name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('permission_group_id') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="permission_group_id">Permission Group</label>

                    <div class="col-md-9">
                        <select name="permission_group_id" id="permission_group_id"
                                class="permission-group-select"
                                data-placeholder="Choose permission group..">
                            <option value=""></option>
                            @foreach($permission_groups as $permission_group)
                                <option value="{{ $permission_group->id }}" {{ old('permission_group_id') ? : $permission->permission_group_id == $permission_group->id ? 'selected' : '' }}>{{ $permission_group->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('permission_group_id'))
                            <span class="help-block animation-slideDown">{{ $errors->first('permission_group_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ url('admin/permissions') }}" class="btn btn-sm btn-warning">Cancel</a>
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
<script type="text/javascript" src="{{ asset('public/js/libraries/permissions.js') }}"></script>
@endpush