@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.permissions.index') }}">Permissions</a></li>
        <li><span href="javascript:void(0)">Add New Permission</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'POST',
            'id' => 'create-permission',
            'route' => ['admin.permissions.store'],
            'class' => 'form-horizontal '
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Add new Permission</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="name">Name</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
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
                                <option value="{{ $permission_group->id }}" {{ old('permission_group_id') ? old('permission_group_id') == $permission_group->id ? 'selected' : '' : '' }}>{{ $permission_group->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('permission_group_id'))
                            <span class="help-block animation-slideDown">{{ $errors->first('permission_group_id') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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