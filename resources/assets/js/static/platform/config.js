/*
 * config.js - all configuration variables are initialized here
 *
 * JSLint Valid (http://www.jslint.com/)
 *
 */
/*jslint plusplus: true, evil: true */
/*global jQuery:true */
my_platform.config({
    /*
     URL - Server Module
     The server module url list is a collection of urls related to the application itself.
     */
    'url.server.base'       : 'http://localhost/laravel-template/',
    'pusher.app.id'         : '313427',
    'pusher.app.key'        : 'a6ebd79e60efcda5975c',
    'pusher.app.secret'     : '5aa1b2195cd3a03d340f',
    'pusher.auth.uri'       : 'http://localhost/laravel-template/auth_pusher',
    'csrf.token'            : $('meta[name="_token"]').attr('content')
});