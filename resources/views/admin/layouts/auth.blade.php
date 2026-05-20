<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
    <meta charset="utf-8">

    <title>{!! $seo_meta['title'] !!}</title>

    <meta name="description" content="{!! $seo_meta['description'] !!}">
    <meta name="author" content="{!! $seo_meta['author'] !!}">
    <meta name="robots" content="{!! $seo_meta['robots'] !!}">
    <meta name="keywords" content="{!! $seo_meta['keywords'] !!}">
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta property="og:locale" content="en_US">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{!! $seo_meta['title'] !!}">
    <meta property="og:description" content="{!! $seo_meta['description'] !!}">
    <meta property="og:url" content="{!! url('/') !!}">
    <meta property="og:site_name" content="{!! $seo_meta['name'] !!}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    {{--Icons--}}
    <link rel="shortcut icon" href="{{ asset('public/images/icons/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon57.png') }}" sizes="57x57">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon72.png') }}" sizes="72x72">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon76.png') }}" sizes="76x76">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon114.png') }}" sizes="114x114">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon120.png') }}" sizes="120x120">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon144.png') }}" sizes="144x144">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon152.png') }}" sizes="152x152">
    <link rel="apple-touch-icon" href="{{ asset('public/images/icons/icon180.png') }}" sizes="180x180">

    {{--Stylesheets--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" class="themes" href="{{ asset('public/css/admin.css') }}">

    @if($admin_template['theme'])
        <link id="theme-link" rel="stylesheet" href="{{ asset('public/css/themes/'.$admin_template['theme'].'.css') }}">
    @endif

    @stack('extrastylesheets')
    <script src="{{asset('public/js/modernizr.min.js')}}"></script>


      
    {{-- for admin control overwrite --}}
    <link rel="stylesheet" class="themes" href="{{ asset('public/css/admin-control.css') }}"> 
</head>
<body>
<img src="{{ asset('public/images/placeholders/backgrounds/mc_full_bg.png') }}" alt="Login Full Background" class="full-bg {{--animation-pulseSlow--}}">
{{-- <div id="login-container" class="animation-fadeIn">
    <div class="login-title text-center">
        <h1>
            <i class="gi gi-flash"></i>&nbsp;&nbsp;
            <strong>{!! $admin_template['name'] !!}</strong><br>
            <small>Please <strong>Login</strong> or <strong>Register</strong></small>
        </h1>
    </div>
    <div class="block push-bit">
        @yield('content')
    </div>
</div>
<div id="modal-terms" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Terms &amp; Conditions</h4>
            </div>
            <div class="modal-body">
                <h4>Title</h4>
                <p>
                    Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                    lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula
                    elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla
                    hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem
                    ipsum dolor sit amet, consectetur adipiscing elit.
                </p>
            </div>
        </div>
    </div>
</div> --}}

<div class="login-wrapper" style="background:url('{{ asset('public/images/placeholders/backgrounds/background-set.jpg') }}')">

    <div class="container">
        <div class="col-md-12">

                {{-- login  --}}
                <div id="login-container" class="animation-fadeIn">
                        <div class="login-title text-center">
                            <h1>
                                {{-- <i class="gi gi-flash"></i>&nbsp;&nbsp; --}}
                                <strong>{!! $admin_template['name'] !!}</strong><br>
                                <small>Please <strong>Login</strong> or <strong>Register</strong></small>
                            </h1>
                        </div>
                        <div class="block push-bit">
                            @yield('content')

                            <div class="copyright">
                                <a href="http://montecarlowebgraphics.com/" target="_blank">Developed by: Monte Carlo Web Graphics Studio</a>
                            </div>
                        </div>
                    </div>
                    <div id="modal-terms" class="modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title">Terms &amp; Conditions</h4>
                                </div>
                                <div class="modal-body">
                                    <h4>Title</h4>
                                    <p>
                                        Donec lacinia venenatis metus at bibendum? In hac habitasse platea dictumst. Proin ac nibh rutrum
                                        lectus rhoncus eleifend. Sed porttitor pretium venenatis. Suspendisse potenti. Aliquam quis ligula
                                        elit. Aliquam at orci ac neque semper dictum. Sed tincidunt scelerisque ligula, et facilisis nulla
                                        hendrerit non. Suspendisse potenti. Pellentesque non accumsan orci. Praesent at lacinia dolor. Lorem
                                        ipsum dolor sit amet, consectetur adipiscing elit.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            {{-- login  --}}

        </div>
    </div>



<script type="text/javascript" src="{{ asset('public/js/admin.js') }}"></script>
<script type="text/javascript" src="{{ asset('public/js/libraries/admin_login.js') }}"></script>
@stack('extrascripts')
</body>
</html>