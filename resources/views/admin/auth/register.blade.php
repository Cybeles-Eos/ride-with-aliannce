@extends('admin.layouts.auth')

@section('content')
    <!-- Register Form -->
    {{  Form::open([
        'method' => 'POST',
        'id' => 'form-register',
        'route' => ['admin.register.post'],
        'class' => 'form-horizontal form-bordered form-control-borderless'
        ])
    }}
        <div class="form-group{{ $errors->has('first_name') || $errors->has('last_name') ? ' has-error' : '' }}">
            <div class="col-xs-6">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                    <input type="text" id="first_name" name="first_name" class="form-control input-lg"
                           placeholder="Firstname"
                           value="{{ old('first_name') }}" autofocus>
                </div>
                @if ($errors->has('first_name'))
                    <span id="first_name-error" class="help-block animation-slideDown">
                    {{ $errors->first('first_name') }}
                </span>
                @endif
            </div>
            <div class="col-xs-6">
                <input type="text" id="last_name" name="last_name" class="form-control input-lg"
                       placeholder="Lastname"
                       value="{{ old('last_name') }}">
                @if ($errors->has('last_name'))
                    <span id="last_name-error" class="help-block animation-slideDown">
                    {{ $errors->first('last_name') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('user_name') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                    <input type="text" id="user_name" name="user_name" class="form-control input-lg"
                           placeholder="Username"
                           value="{{ old('user_name') }}">
                </div>
                @if ($errors->has('user_name'))
                    <span id="user_name-error" class="help-block animation-slideDown">
                    {{ $errors->first('user_name') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                    <input type="text" id="email" name="email" class="form-control input-lg" placeholder="Email"
                           value="{{ old('email') }}">
                </div>
                @if ($errors->has('email'))
                    <span id="email-error" class="help-block animation-slideDown">
                    {{ $errors->first('email') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                    <input type="password" id="password" name="password" class="form-control input-lg"
                           placeholder="Password">
                </div>
                @if ($errors->has('password'))
                    <span id="password-error" class="help-block animation-slideDown">
                    {{ $errors->first('password') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-asterisk"></i></span>
                    <input type="password" id="password_confirmation" name="password_confirmation"
                           class="form-control input-lg" placeholder="Verify Password">
                </div>
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-6">
                {{--<a href="#modal-terms" data-toggle="modal" class="terms">Terms</a>--}}
                {{--<label class="switch switch-primary" data-toggle="tooltip" title="Agree to the terms">--}}
                {{--<input type="checkbox" id="terms" name="terms">--}}
                {{--<span></span>--}}
                {{--</label>--}}
            </div>
            <div class="col-xs-6 text-right">
                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Register Account
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 text-center">
                <small>Do you have an account?</small>
                <a href="{{url('/admin/login')}}"{{-- id="link-register"--}}>
                    <small>Login</small>
                </a>
            </div>
        </div>
    {{ Form::close() }}
    <!-- END Register Form -->
@endsection
