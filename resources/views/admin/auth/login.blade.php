@extends('admin.layouts.auth')

@section('content')
    {{--Login Form--}}
    {{ Form::open([
        'method' => 'POST',
        'id' => 'form-login',
        'route' => ['admin.login.post'],
        'class' => 'form-horizontal form-bordered form-control-borderless'
        ]) }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                    <input type="text" id="email" name="email" class="form-control input-lg" placeholder="Email/Username" value="{{ old('email') }}" autofocus>
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
                    <input type="password" id="password" name="password" class="form-control input-lg" placeholder="Password">
                </div>
                @if ($errors->has('password'))
                    <span id="password-error" class="help-block animation-slideDown">
                    {{ $errors->first('password') }}
                </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
            <div class="col-xs-12 text-center">
                {!! NoCaptcha::display() !!}
                @if ($errors->has('g-recaptcha-response'))
                    <span id="g-recaptcha-response-error" class="help-block animation-slideDown">
                        {{ $errors->first('g-recaptcha-response') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-4">
                <label class="switch switch-primary" data-toggle="tooltip" title="Remember Me?">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : ''}}>
                    <span></span>
                </label>
            </div>
            <div class="col-xs-8 text-right">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Login to
                    Dashboard
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 text-center">
                {{--<a href="{{ url('/password/reset') }}"--}}{{-- id="link-reminder-login"--}}{{-->
                    <small>Forgot password?</small>
                </a> ---}}
                {{--<a href="{{ url('/admin/register') }}"--}}{{-- id="link-register-login"--}}{{-->--}}
                    {{--<small>Create a new account</small>--}}
                {{--</a>--}}
            </div>
        </div>
    {{ Form::close() }}
    {{--END Login Form--}}
@endsection

@push('extrascripts')
{!! NoCaptcha::renderJs() !!}
@endpush
