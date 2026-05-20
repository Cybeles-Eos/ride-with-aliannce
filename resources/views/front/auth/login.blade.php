@extends('front.layouts.base')

@section('content')
    @if (!empty($page))
        @php
            $item = $page;
        @endphp
    @else
        @php
            $item = (object) ['name' => 'login'];
        @endphp
    @endif
    @include('front.layouts.sections.header')
    @include('front.pages.custom-page.sections.banner')

    <!-- Log In -->
    <section class="site-content site-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4 site-block">
                    <!-- Log In Form -->
                    {{  Form::open([
                        'method' => 'POST',
                        'id' => 'form-login',
                        'route' => ['customer.login.post'],
                        'class' => 'form-horizontal'
                        ])
                    }}
                        @if (session()->has('status'))
                            <div class="alert alert-success">
                                {{ session()->get('status') }}
                            </div>
                        @endif
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-envelope"></i></span>
                                    <input type="text" id="email" name="email"
                                           class="form-control input-lg" placeholder="Email"
                                           value="{{ old('email') }}" autofocus>
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
                                    <input type="password" id="password" name="password"
                                           class="form-control input-lg" placeholder="Password">
                                </div>
                                @if ($errors->has('password'))
                                    <span id="password-error" class="help-block animation-slideDown">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group form-actions">
                            <div class="col-xs-6">
                                <label class="switch switch-primary">
                                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : ''}}>
                                    <span></span>
                                </label>
                                <small>Remember me</small>
                            </div>
                            <div class="col-xs-6 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-arrow-right"></i>
                                    Log In
                                </button>
                            </div>
                        </div>
                        <div class="form-group">

                        </div>
                    {{ Form::close() }}
                    <div class="text-center">
                        <a href="{{ url('customer/password/email') }}">
                            <small>Forgot password?</small>
                        </a>
                    </div>
                    <!-- END Log In Form -->
                </div>
            </div>
            <hr>
        </div>
    </section>
    <!-- END Log In -->
    @include('front.layouts.sections.footer')
@endsection

@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/libraries/front_login.js') }}"></script>
@endpush
