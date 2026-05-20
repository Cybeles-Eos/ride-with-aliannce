@extends('admin.layouts.base')

@section('content')
    <ul class="breadcrumb breadcrumb-top">
        <li><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li><span href="javascript:void(0)">Edit User</span></li>
    </ul>
    <div class="row">
        {{  Form::open([
            'method' => 'PUT',
            'id' => 'edit-user',
            'route' => ['admin.users.update', $user->id],
            'class' => 'form-horizontal '
            ])
        }}
        <div class="col-md-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Edit User "{{$user->first_name.' '.$user->last_name}}"</strong></h2>
                </div>
                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="first_name">Firstname</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="first_name" name="first_name"
                               value="{{  Request::old('first_name') ? : $user->first_name }}"
                               placeholder="Enter firstname..">
                        @if($errors->has('first_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="last_name">Lastname</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="last_name" name="last_name"
                               value="{{  Request::old('last_name') ? : $user->last_name }}"
                               placeholder="Enter lastname..">
                        @if($errors->has('last_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="user_name">Username</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="user_name" name="user_name"
                               value="{{  Request::old('user_name') ? : $user->user_name }}"
                               placeholder="Enter username..">
                        @if($errors->has('user_name'))
                            <span class="help-block animation-slideDown">{{ $errors->first('user_name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="email">Email</label>

                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email" name="email"
                               value="{{  Request::old('email') ? : $user->email }}"
                               placeholder="Enter email..">
                        @if($errors->has('email'))
                            <span class="help-block animation-slideDown">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Is Active?</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="is_active" name="is_active" value="1" {{ Request::old('is_active') ? : ($user->is_active ? 'checked' : '') }}>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="form-group change-pass-checkbox-container">
                    <label class="col-md-3 control-label">Change Password</label>

                    <div class="col-md-9">
                        <label class="switch switch-primary">
                            <input type="checkbox" id="change_password" name="change_password" value="1" {{ $errors->has('password') ? 'checked' : ''}}>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="change-pass-container" style="{{ $errors->has('password') ? '' : 'display:none;'}}">
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label" for="password">New Password</label>

                        <div class="col-md-9">
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Enter new password..">
                            @if($errors->has('password'))
                                <span class="help-block animation-slideDown">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <label class="col-md-3 control-label" for="password_confirmation">Verify New Password</label>

                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password_confirmation"
                                   placeholder="Verify new password..">
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
                    <label class="col-md-3 control-label" for="roles">Assign Roles</label>
                    <div class="col-md-9">
                        @if(!$roles->isEmpty())
                            <h4></h4>
                            @foreach ($roles as $role)
                                {{ Form::radio('roles[]', $role->id, ($user->roles->contains('id', $role->id))) }}
                                {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                            @endforeach
                        @endif
                        @if($errors->has('roles'))
                            <span class="help-block animation-slideDown">{{ $errors->first('roles') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group form-actions">
                    <div class="col-md-9 col-md-offset-3">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-warning">Cancel</a>
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
    <script type="text/javascript" src="{{ asset('public/js/libraries/users.js') }}"></script>
@endpush