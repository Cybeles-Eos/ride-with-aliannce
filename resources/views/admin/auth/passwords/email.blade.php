@extends('admin.layouts.auth')

@section('content')
    <!-- Reminder Form -->
    {{  Form::open([
        'method' => 'POST',
        'id' => 'form-email',
        'route' => ['admin.password.email.post'],
        'class' => 'form-horizontal form-bordered form-control-borderless'
        ])
    }}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <div class="col-xs-12">
                <div class="input-group">
                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                    <input type="text" id="email" name="email" class="form-control input-lg" placeholder="Email"
                           value="{{ old('email') }}" autofocus>
                </div>
            </div>
        </div>
        <div class="form-group form-actions">
            <div class="col-xs-12 text-right">
                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Reset
                    Password
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 text-center">
                <small>Did you remember your password?</small>
                <a href="{{ url('/login') }}"{{-- id="link-reminder"--}}>
                    <small>Login</small>
                </a>
            </div>
        </div>
    {{ Form::close() }}
    <!-- END Reminder Form -->
@endsection