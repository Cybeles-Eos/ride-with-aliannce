@extends('front.layouts.base')

@section('content')
    @if (!empty($page))
        @php
            $item = $page;
        @endphp
    @else
        @php
            $item = (object) ['name' => 'register'];
        @endphp
    @endif
    @include('front.layouts.sections.header')
    @include('front.pages.custom-page.sections.banner')

    <!-- Sign Up -->
    <section class="site-content site-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4 site-block">
                    <!-- Sign Up Form -->
                    {{  Form::open([
                        'method' => 'POST',
                        'id' => 'form-register',
                        'route' => ['customer.register.post'],
                        'class' => 'form-horizontal'
                        ])
                    }}
                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    <input type="text" id="first_name" name="first_name" class="form-control input-lg"
                                           placeholder="First name"
                                           value="{{ old('first_name') }}" autofocus>
                                </div>
                                @if ($errors->has('first_name'))
                                    <span id="first_name-error" class="help-block animation-slideDown">
                                    {{ $errors->first('first_name') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="gi gi-user"></i></span>
                                    <input type="text" id="last_name" name="last_name" class="form-control input-lg"
                                           placeholder="Last name"
                                           value="{{ old('last_name') }}">
                                </div>
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
                                    <input type="text" id="email" name="email" class="form-control input-lg"
                                           placeholder="Email"
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
                                    @if ($errors->has('password'))
                                        <span id="password-error" class="help-block animation-slideDown">
                                        {{ $errors->first('password') }}
                                    </span>
                                    @endif
                                </div>
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
                                {{--<label class="switch switch-primary" data-toggle="tooltip" title="Agree to the terms">--}}
                                {{--<input type="checkbox" id="terms" name="terms"><span></span>--}}
                                {{--</label>--}}
                                {{--<a href="#modal-terms" data-toggle="modal" class="terms">--}}
                                {{--<small>View Terms</small>--}}
                                {{--</a>--}}
                            </div>
                            <div class="col-xs-6 text-right">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Sign Up
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <!-- END Sign Up Form -->
                </div>
            </div>
        </div>
    </section>
    <!-- END Sign Up -->

    <!-- Quick Stats -->
    <section class="site-content site-section themed-background">
        <div class="container">
            <!-- Stats Row -->
            <!-- CountTo (initialized in js/app.js), for more examples you can check out https://github.com/mhuggins/jquery-countTo -->
            <div class="row" id="counters">
                <div class="col-sm-6 col-md-3">
                    <div class="counter site-block">
                        <span data-toggle="countTo" data-to="6800" data-after="+"></span>
                        <small>Projects</small>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="counter site-block">
                        <span data-toggle="countTo" data-to="5500" data-after="+"></span>
                        <small>Happy Customers</small>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="counter site-block">
                        <span data-toggle="countTo" data-to="12362"></span>
                        <small>Cups of Coffee</small>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="counter site-block">
                        <span data-toggle="countTo" data-to="2150"></span>
                        <small>Awesome Days</small>
                    </div>
                </div>
            </div>
            <!-- END Stats Row -->
        </div>
    </section>
    <!-- END Quick Stats -->

    <!-- Modal Terms -->
    <div id="modal-terms" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Terms &amp; Conditions</h4>
                </div>
                <div class="modal-body">
                    <h4>Title</h4>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <h4>Title</h4>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <h4>Title</h4>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                    <p>Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis
                        ligula elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et
                        facilisis nulla hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at
                        lacinia dolor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal Terms -->
    @include('front.layouts.sections.footer')
@endsection

@push('extrascripts')
<script type="text/javascript" src="{{ asset('public/js/libraries/front_login.js') }}"></script>
@endpush
