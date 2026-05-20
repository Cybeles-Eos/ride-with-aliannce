const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.setPublicPath('public');
mix.setResourceRoot('../');

mix.js('resources/assets/js/app.js', 'public/js')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/fonts')
    .copy('node_modules/slick-carousel/slick/ajax-loader.gif', 'public/fonts')
    .copy('node_modules/slick-carousel/slick/fonts', 'public/fonts')
    .sass('resources/assets/scss/app.scss', 'public/css')
    .sass('resources/assets/scss/admin-control.scss', 'public/css')
    .styles([
        'public/css/app.css',
        'resources/assets/css/sweetalert.css'
    ], 'public/css/app.css')
    .styles([
        'resources/assets/css/bootstrap.min.css',
        'resources/assets/css/pro-ui/plugins.css',
        'resources/assets/css/pro-ui/main.css',
        'resources/assets/css/pro-ui/themes.css',
        'resources/assets/css/custom_style.css',
        'resources/assets/css/sweetalert.css'
    ], 'public/css/admin.css')
    .scripts([
        'resources/assets/js/static/vendors/jquery.min.js',
        'resources/assets/js/static/vendors/bootstrap.min.js',
        'resources/assets/js/static/vendors/plugins.js',
        'resources/assets/js/static/vendors/app.js',
        'resources/assets/js/static/platform/platform.js',
        'resources/assets/js/static/platform/ajaxq.js',
        'resources/assets/js/static/platform/centralajax.js',
        'resources/assets/js/static/platform/config.js',
        'resources/assets/js/static/platform/main.js',
        'resources/assets/js/static/platform/delete.js',
        'resources/assets/js/static/vendors/sweetalert.min.js',
        'resources/assets/js/static/vendors/moment.js'
    ], 'public/js/admin.js').options({ processCssUrls: false });