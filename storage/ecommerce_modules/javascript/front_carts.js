(function () {
    "use strict";
    /* declare global variables within the class */
    var uiAddProductToCart,
        uiAddCustomDesignToCart,
        uiEditProductFromCart,
        uiQuantityInput,
        uiPriceInput,
        uiAddToCartAndDesignAnotherLabelBtn,
        uiValidateCouponCode,
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
     * This js file will only contain front_cart events
     *
     * */
    CPlatform.prototype.front_cart = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiAddProductToCart = $('#add-product-to-cart');
            uiAddCustomDesignToCart = $('#add-custom-design-to-cart');
            uiEditProductFromCart = $('.edit-product-from-cart');
            uiQuantityInput = $('[name="quantity"]');
            uiPriceInput = $('[name="price"]');
            uiAddToCartAndDesignAnotherLabelBtn = $('.add-to-cart-and-design-another-label-btn');
            uiValidateCouponCode = $('#validate-coupon-code');

            platform.front_cart.product_page_events();
            platform.front_cart.cart_page_events();
        },

        product_page_events: function () {
            uiQuantityInput.on('change', function () {
                var uiThis = $(this);
                if (uiThis.val() != '') {
                    uiPriceInput.val(uiThis.parents('.form-group:first').find('[data-price]').attr('data-price'));
                } else {
                    uiPriceInput.val(0);
                }
            });

            uiAddProductToCart.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                errorPlacement: function (error, e) {
                    e.parents('.form-group').append(error);
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
                    'quantity_id': {
                        required: true
                    },
                },
                messages: {
                    'quantity_id': {
                        required: 'Quantity is required.'
                    },
                }
            });
        },

        cart_page_events: function () {
            uiEditProductFromCart.each(function () {
                var uiThis = $(this);
                uiThis.validate({
                    errorClass: 'help-block animation-slideDown',
                    errorElement: 'span',
                    errorPlacement: function (error, e) {
                        e.parents('.form-group').append(error);
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
                        $(form).find('[type="submit"]').find('i').addClass('fa-spin');
                        $(form).find('[type="submit"]').prop('disabled', true);
                        $(form).find('[type="submit"]').attr('disabled', 'disabled');
                        $(form).find('[type="submit"]').css('pointer-events', 'none');
                        // platform.show_spinner($(form).find('[type="submit"]'), true);
                        form.submit();
                    },
                    rules: {
                        'quantity_id': {
                            required: true
                        },
                    },
                    messages: {
                        'quantity_id': {
                            required: 'Quantity is required.'
                        },
                    }
                });
            });

            $('body').on('click', '.delete-cart-btn', function (e) {
                e.preventDefault();
                var self = $(this);
                /* open confirmation modal */
                swal({
                    title: "Are you sure?",
                    text: "Are you sure you want to delete this record?",
                    type: "warning",
                    showCancelButton: true,
                    //confirmButtonColor: "#27ae60",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true,
                    allowOutsideClick: true
                }, function (isConfirm) {
                    /* if confirmed, send request ajax */
                    if (isConfirm) {
                        var oParams = {
                            'data': {'id': self.attr('data-cart-id')},
                            'url': self.attr('data-cart-route')
                        };
                        platform.delete.delete(oParams, function (oData) {
                            /* check return of ajax */
                            if (platform.var_check(oData)) {
                                /* check status if success */
                                if (oData.status > 0) {
                                    /* if status is true, render success messages */
                                    if (platform.var_check(oData.message)) {
                                        for (var x in oData.message) {
                                            var message = oData.message[x];
                                            swal({
                                                'title': "Deleted!",
                                                'text': message,
                                                'type': "success",
                                                'showCancelButton': false,
                                                'showConfirmButton': true,
                                                'allowOutsideClick': false
                                                //'confirmButtonColor': "#DD6B55",
                                            }, function () {
                                                /* remove cart container */
                                            });
                                            swal.disableButtons();
                                            location.reload();
                                        }
                                    }
                                }
                                else {
                                    /* if status is false, render error messages */
                                    if (platform.var_check(oData.message)) {
                                        for (var x in oData.message) {
                                            var message = oData.message[x];
                                            swal({
                                                'title': "Error!",
                                                'text': message,
                                                'type': "error"
                                                //'confirmButtonColor': "#DD6B55",
                                            }, function () {

                                            });
                                        }
                                    }
                                }
                            }
                        }, self);
                    }
                });
            });

            uiValidateCouponCode.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                errorPlacement: function (error, e) {
                    e.parents('.form-group').append(error);
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
                    'coupon_code': {
                        required: true
                    },
                },
                messages: {
                    'coupon_code': {
                        required: 'Coupon Code is required.'
                    },
                }
            });
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.front_cart.initialize();
});