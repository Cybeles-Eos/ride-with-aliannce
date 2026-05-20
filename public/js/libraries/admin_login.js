(function () {
    "use strict";
    /* declare global variables within the class */
    var uiAdminLogin,
        uiAdminRegister,
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
     * This js file will only contain admin login events
     *
     * */
    CPlatform.prototype.admin_login = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiAdminLogin = $('#form-login');
            uiAdminRegister = $('#form-register');
            filler = $('.element');

            platform.admin_login.admin_login();
            platform.admin_login.admin_register();
        },

        /* admin login */
        admin_login: function () {
            /* admin login validation */
            uiAdminLogin.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                onkeyup:false,
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

        /* admin register */
        admin_register: function () {
            /* admin register validation */
            uiAdminRegister.validate({
                errorClass: 'help-block animation-slideDown', // You can change the animation class for a different entrance animation - check animations page
                errorElement: 'span',
                onkeyup:false,
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
                        maxlength: 25
                    },
                    'last_name': {
                        required: true,
                        maxlength: 25
                    },
                    'user_name': {
                        required: true,
                        maxlength: 45
                    },
                    'email': {
                        required: true,
                        email: true,
                        maxlength: 45
                    },
                    'password': {
                        required: true,
                        minlength: 8
                    },
                    'password_confirmation': {
                        equalTo: uiAdminRegister.find('#password')
                    },
                },
                messages: {
                    'first_name': {
                        required: 'Firstname is required.',
                        maxlength: 'Please enter no more than 25 characters.',
                    },
                    'last_name': {
                        required: 'Lastname is required.',
                        maxlength: 'Please enter no more than 25 characters.',
                    },
                    'user_name': {
                        required: 'Username is required.',
                        maxlength: 'Please enter no more than 45 characters.',
                    },
                    'email': {
                        required: 'Email is required.',
                        email: 'Please enter a valid email address.',
                        maxlength: 'Please enter no more than 45 characters.',
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
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.admin_login.initialize();
});