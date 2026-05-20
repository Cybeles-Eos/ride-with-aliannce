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
{{--Page Wrapper--}}
{{--In the PHP version you can set the following options from inc/config file--}}
{{--Available classes:--}}

{{--'page-loading'      enables page preloader--}}
<div id="page-wrapper"{!! ($admin_template['page_preloader']) ? ' class="page-loading"' : '' !!}>
    {{--Preloader--}}
    {{--Preloader functionality (initialized in js/app.js) - pageLoading()--}}
    {{--Used only if page preloader is enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version)--}}
    <div class="preloader themed-background">
        <h1 class="push-top-bottom text-light text-center"><strong>{!! $admin_template['name'] !!}</strong></h1>
        <div class="inner">
            <h3 class="text-light visible-lt-ie10"><strong>Loading..</strong></h3>
            <div class="preloader-spinner hidden-lt-ie10"></div>
        </div>
    </div>

    {{--Page Container--}}
    {{--In the PHP version you can set the following options from inc/config file--}}
    {{--Available #page-container classes:--}}

    {{--'' (None)                                       for a full main and alternative sidebar hidden by default (> 991px)--}}

    {{--'sidebar-visible-lg'                            for a full main sidebar visible by default (> 991px)--}}
    {{--'sidebar-partial'                               for a partial main sidebar which opens on mouse hover, hidden by default (> 991px)--}}
    {{--'sidebar-partial sidebar-visible-lg'            for a partial main sidebar which opens on mouse hover, visible by default (> 991px)--}}
    {{--'sidebar-mini sidebar-visible-lg-mini'          for a mini main sidebar with a flyout menu, enabled by default (> 991px + Best with static layout)--}}
    {{--'sidebar-mini sidebar-visible-lg'               for a mini main sidebar with a flyout menu, disabled by default (> 991px + Best with static layout)--}}

    {{--'sidebar-alt-visible-lg'                        for a full alternative sidebar visible by default (> 991px)--}}
    {{--'sidebar-alt-partial'                           for a partial alternative sidebar which opens on mouse hover, hidden by default (> 991px)--}}
    {{--'sidebar-alt-partial sidebar-alt-visible-lg'    for a partial alternative sidebar which opens on mouse hover, visible by default (> 991px)--}}

    {{--'sidebar-partial sidebar-alt-partial'           for both sidebars partial which open on mouse hover, hidden by default (> 991px)--}}

    {{--'sidebar-no-animations'                         add this as extra for disabling sidebar animations on large screens (> 991px) - Better performance with heavy pages!--}}

    {{--'style-alt'                                     for an alternative main style (without it: the default style)--}}
    {{--'footer-fixed'                                  for a fixed footer (without it: a static footer)--}}

    {{--'disable-menu-autoscroll'                       add this to disable the main menu auto scrolling when opening a submenu--}}

    {{--'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar--}}
    {{--'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar--}}

    {{--'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links--}}
    <?php
    $page_classes = '';

    if ($admin_template['header'] == 'navbar-fixed-top') :
        $page_classes = 'header-fixed-top';
    elseif ($admin_template['header'] == 'navbar-fixed-bottom') :
        $page_classes = 'header-fixed-bottom';
    endif;

    if ($admin_template['sidebar']) :
        $page_classes .= (($page_classes == '') ? '' : ' ') . $admin_template['sidebar'];
    endif;

    if ($admin_template['main_style'] == 'style-alt') :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'style-alt';
    endif;

    if ($admin_template['footer'] == 'footer-fixed') :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'footer-fixed';
    endif;

    if (!$admin_template['menu_scroll']) :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'disable-menu-autoscroll';
    endif;

    if ($admin_template['cookies'] === 'enable-cookies') :
        $page_classes .= (($page_classes == '') ? '' : ' ') . 'enable-cookies';
    endif;
    ?>
    <div id="page-container"{!! ($page_classes)? ' class="' . $page_classes . '"' : '' !!}>
        @include('admin.layouts.sections.sidebar')
        <div id="main-container">
            {{--In the PHP version you can set the following options from inc/config file--}}

            {{--Available header.navbar classes:--}}
            {{--'navbar-default'            for the default light header--}}
            {{--'navbar-inverse'            for an alternative dark header--}}
            {{--'navbar-fixed-top'          for a top fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())--}}
            {{--'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added--}}
            {{--'navbar-fixed-bottom'       for a bottom fixed header (fixed sidebars with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))--}}
            {{--'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added--}}
            @include('admin.layouts.sections.header')
            <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <div class="page-content" id="page-content">
                @yield('content')
            </div>
            @include('admin.layouts.sections.footer')
        </div>
    </div>
</div>
<a href="#" id="to-top"><i class="fa fa-angle-double-up"></i></a>
@include('admin.layouts.sections.modals')
<script>
    var sBaseURI = '{{ url('/') }}';
    var sAdminBaseURI = '{{ url('admin') }}';
    var oPageSections = null;
    var sSettingType = null;
</script>
<script type="text/javascript" src="{{ asset('public/js/admin.js') }}"></script>
@stack('extrascripts')
@if (session()->has('flash_message'))
    <script>
        swal({
            title: "{!! session('flash_message.title') !!}",
            text: "{!! session('flash_message.message') !!}",
            type: "{!! session('flash_message.type') !!}",
            html: true,
            allowEscapeKey: true,
            allowOutsideClick: true,
//            confirmButtonColor: "#DD6B55",
        }, function () {

        });
    </script>
@endif
</body>
</html>