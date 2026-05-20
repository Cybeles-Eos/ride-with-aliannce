(function () {
    "use strict";
    /* declare global variables within the class */
    var uiFrontLogin,
        uiFrontRegister,
        uiFrontEmail,
        uiFrontReset,
        filler;

    /* private ajax function that will send request to backend */
    function _ajax(oParams, fnCallback, uiBtn) {
        if (platform.var_check(oParams)) {
            var oAjaxConfig = {
                "type": oParams.type,
                "data": oParams.data,
                "url": oParams.url,
                "token": platform.config('csrf.token'),
                "beforeSend": function () {
                    /* check if there is a button to add spinner */
                    if (platform.var_check(uiBtn)) {
                        platform.show_spinner(uiBtn, true);
                    }
                },
                "success": function (oData) {
                    console.log(oData);
                    if (typeof(fnCallback) == 'function') {
                        fnCallback(oData);
                    }
                },
                "complete": function () {
                    /* check if there is a button to remove spinner */
                    if (platform.var_check(uiBtn)) {
                        platform.show_spinner(uiBtn, false);
                    }
                }
            };

            platform.CentralAjax.ajax(oAjaxConfig);
        }
    }

    /*
     * This js file will only contain front login events
     *
     * */
    CPlatform.prototype.front_login = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiFrontLogin = $('#form-login');
            uiFrontRegister = $('#form-register');
            uiFrontEmail = $('#form-email');
            uiFrontReset = $('#form-reset');
            filler = $('.element');

            platform.front_login.front_login();
            platform.front_login.front_register();
            platform.front_login.front_email();
            platform.front_login.front_reset();
        },

        /* front login */
        front_login: function () {
            /* front login validation */
            uiFrontLogin.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                onkeyup:false,
                errorPlacement: function (error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.form-group').find('.help-block').remove();
                },
                success: function (e) {
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
                        minlength: 8
                    }
                },
                messages: {
                    'email': 'Please enter your account\'s email',
                    'password': {
                        required: 'Please provide your password',
                        minlength: 'Your password must be at least 8 characters long'
                    }
                }
            });
        },

        /* front register */
        front_register: function () {
            /* front register validation */
            uiFrontRegister.validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'span',
                onkeyup:false,
                errorPlacement: function (error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.help-block').remove();
                },
                success: function (e) {
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
                        required: true
                    },
                    'last_name': {
                        required: true
                    },
                    'user_name': {
                        required: true
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    'password': {
                        required: true,
                        minlength: 8
                    },
                    'password_confirmation': {
                        equalTo: uiFrontRegister.find('#password')
                    },
                },
                messages: {
                    'first_name': {
                        required: 'Firstname is required.'
                    },
                    'last_name': {
                        required: 'Lastname is required.'
                    },
                    'user_name': {
                        required: 'Username is required.'
                    },
                    'email': {
                        required: 'Email is required.',
                        email: 'Please enter a valid email address.'
                    },
                    'password': {
                        required: 'Password is required.',
                        minlength: 'Your password must be at least 8 characters long.'
                    },
                    'password_confirmation': {
                        equalTo: 'Please enter the same password as above.'
                    }
                }
            });
        },

        /* front email */
        front_email: function () {
            /* front email validation */
            uiFrontEmail.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                onkeyup:false,
                errorPlacement: function (error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.form-group').find('.help-block').remove();
                },
                success: function (e) {
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
                        email: true
                    }
                },
                messages: {
                    'email': 'Please enter your account\'s email'
                }
            });
        },

        /* front reset */
        front_reset: function () {
            /* front reset validation */
            uiFrontReset.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                onkeyup:false,
                errorPlacement: function (error, e) {
                    e.parents('.form-group > div').append(error);
                },
                highlight: function (e) {
                    $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                    $(e).closest('.form-group').find('.help-block').remove();
                },
                success: function (e) {
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
                        email: true
                    },
                    'password': {
                        required: true,
                        minlength: 8
                    },
                    'password_confirmation': {
                        equalTo: uiFrontReset.find('#password')
                    },
                },
                messages: {
                    'email': 'Please enter your account\'s email',
                    'password': {
                        required: 'Please provide a password',
                        minlength: 'Your password must be at least 8 characters long'
                    },
                    'password_confirmation': {
                        equalTo: 'Please enter the same password as above'
                    },
                }
            });
        },

    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.front_login.initialize();
});