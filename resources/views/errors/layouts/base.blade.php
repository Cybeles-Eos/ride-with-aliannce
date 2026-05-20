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
    <meta property="og:url" content="{!! url('') !!}">
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

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('public/css/admin.css') }}">

    <script src="{{ asset('public/js/modernizr.min.js') }}"></script>
</head>
<body>
<div id="error-container">
    <div class="error-options">
        <h3><i class="fa fa-chevron-circle-left text-muted"></i> <a href="{{ (url()->current() == url()->previous()) ? url('') : url()->previous() }}">Go Back</a></h3>
    </div>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 text-center">
            <h1 class="animation-fadeIn"><i class="fa fa-times-circle-o text-muted"></i> @yield('code')</h1>

            <h2 class="h3">@yield('message')</h2>
        </div>
    </div>
</div>
</body>
</html>