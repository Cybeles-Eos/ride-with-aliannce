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

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="canonical" href="{!! $seo_meta['canonical'] !!}">

    {{--Icons--}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/images/icons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/icons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/icons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('public/images/icons/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('public/images/icons/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">



    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">

    @stack('extrastylesheets')

    <script src="{{asset('public/js/modernizr.min.js')}}"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
@yield('content')
<script>
    var sBaseURI = '{{ url('/') }}';
</script>
<script src="{{ asset('public/js/app.js') }}"></script>
@stack('extrascripts')

@if (session()->has('flash_message'))
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            swal({
                title: "{!! session('flash_message.title') !!}",
                text: "{!! session('flash_message.message') !!}",
                type: "{!! session('flash_message.type') !!}",
                html: true,
                allowEscapeKey: true,
                allowOutsideClick: true,
            }, function () {
            });
        });
    </script>
@endif
</body>
</html>