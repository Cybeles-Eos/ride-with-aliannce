/*
 *  Document   : login.js
 *  Author     : pixelcave
 *  Description: Custom javascript code used in Login page
 */

var Login = function() {

    // Function for switching form views (login, reminder and register forms)
    var switchView = function(viewHide, viewShow, viewHash){
        viewHide.slideUp(250);
        viewShow.slideDown(250, function(){
            $('input').placeholder();
        });

        if ( viewHash ) {
            window.location = '#' + viewHash;
        } else {
            window.location = '#';
        }
    };

    return {
        init: function() {
            /* Switch Login, Reminder and Register form views */
            var formLogin       = $('#form-login'),
                formReminder    = $('#form-reminder'),
                formRegister    = $('#form-register');
            /*
            $('#link-register-login').click(function(){
                switchView(formLogin, formRegister, 'register');
            });

            $('#link-register').click(function(){
                switchView(formRegister, formLogin, '');
            });

            $('#link-reminder-login').click(function(){
                switchView(formLogin, formReminder, 'reminder');
            });

            $('#link-reminder').click(function(){
                switchView(formReminder, formLogin, '');
            });
            */

            // If the link includes the hashtag 'register', show the register form instead of login
            /*
            if (window.location.hash === '#register') {
                formLogin.hide();
                formRegister.show();
            }
            */

            // If the link includes the hashtag 'reminder', show the reminder form instead of login
            /*
             if (window.location.hash === '#reminder') {
                formLogin.hide();
                formReminder.show();
            }
             */

            /*
             *  Jquery Validation, Check out more examples and documentation at https://github.com/jzaefferer/jquery-validation
             */

            /* Login form - Initialize Validation */
            $('#form-login').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'span',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.form-group').find('.help-block').remove();
                },
                success: function(e) {
                    e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.form-group').find('.help-block').remove();
                },
                submitHandler: function (form) {
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'email': {
                        required: true,
                        // email: true
                    },
                    'password': {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    'email': 'Please enter your account\'s email',
                    'password': {
                        required: 'Please provide your password',
                        minlength: 'Your password must be at least 6 characters long'
                    }
                }
            });

            /* Reminder form - Initialize Validation */
            $('#form-reminder').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'span',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    e.closest('.form-group').removeClass('has-success has-error');
                    e.closest('.help-block').remove();
                },
                submitHandler: function (form) {
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'email': {
                        required: true,
                        email: true
                    }
                },
                messages: {
                    'email': 'Please enter your account\'s email'
                }
            });

            /* Register form - Initialize Validation */
            $('#form-register').validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'span',
                errorPlacement: function(error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function(e) {
                    if (e.closest('.form-group').find('.help-block').length === 2) {
                        e.closest('.help-block').remove();
                    } else {
                        e.closest('.form-group').removeClass('has-success has-error');
                        e.closest('.help-block').remove();
                    }
                },
                submitHandler: function (form) {
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'first_name': {
                        required: true,
                        minlength: 2
                    },
                    'last_name': {
                        required: true,
                        minlength: 2
                    },
                    'user_name': {
                        required: true,
                        minlength: 2
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'password': {
                        required: true,
                        minlength: 6
                    },
                    'password_confirmation': {
                        equalTo: $('#form-register').find('#password')
                    },
                    /*'terms': {
                        required: true
                    }*/
                },
                messages: {
                    'first_name': {
                        required: 'Please enter your firstname',
                        minlength: 'Please enter your firstname'
                    },
                    'last_name': {
                        required: 'Please enter your lastname',
                        minlength: 'Please enter your lastname'
                    },
                    'user_name': {
                        required: 'Please enter your username',
                        minlength: 'Please enter your username'
                    },
                    'email': 'Please enter a valid email address',
                    'password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 6 characters long'
                    },
                    'password_confirmation': {
                        equalTo: 'Please enter the same password as above'
                    },
                    /*'terms': {
                        required: 'Please accept the terms!'
                    }*/
                }
            });
        }
    };
}();