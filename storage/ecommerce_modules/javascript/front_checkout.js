(function () {
    "use strict";
    /* declare global variables within the class */
    var uiBillingContainer,
        uiShippingContainer,
        uiDifferentShippingCheckbox,
        uiCheckoutForm,
        uiBillingCountrySelect,
        uiShippingCountrySelect,
        uiBillingStateSelect,
        uiShippingStateSelect,
        uiInputSubtotalTotal,
        uiInputShippingTotal,
        uiInputTaxTotal,
        uiInputTaxPercentage,
        uiInputDiscountTotal,
        uiInputTotal,
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
     * This js file will only contain front_checkout events
     *
     * */
    CPlatform.prototype.front_checkout = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiCheckoutForm = $('#checkout-form');
            uiBillingContainer = $('.billing-container');
            uiShippingContainer = $('.shipping-container');
            uiDifferentShippingCheckbox = $('[name="is_different_shipping_address"]');
            uiBillingCountrySelect = $('.billing-country-select');
            uiShippingCountrySelect = $('.shipping-country-select');
            uiBillingStateSelect = $('.billing-state-select');
            uiShippingStateSelect = $('.shipping-state-select');
            uiInputSubtotalTotal = $('[name="subtotal_total"]');
            uiInputShippingTotal = $('[name="shipping_total"]');
            uiInputTaxTotal = $('[name="tax_total"]');
            uiInputTaxPercentage = $('[name="tax_percentage"]');
            uiInputDiscountTotal = $('[name="discount_total"]');
            uiInputTotal = $('[name="total"]');

            platform.front_checkout.billing_detail_events();
            platform.front_checkout.shipping_detail_events();

            uiDifferentShippingCheckbox.on('change', function () {
                var uiThis = $(this);
                if (!uiThis.is(':checked')) {
                    uiShippingContainer.find('.form-group').removeClass('has-success has-error').find('.help-block').remove();
                    uiShippingContainer.slideUp();
                } else {
                    uiShippingContainer.slideDown();
                }
                // platform.front_checkout.is_different_shipping_address();
            });

            uiBillingContainer.find('input').on('change', function () {
                // platform.front_checkout.is_different_shipping_address();
            });

            uiCheckoutForm.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
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
                    platform.front_checkout.is_different_shipping_address();
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'billing_first_name': {
                        required: true
                    },
                    'billing_last_name': {
                        required: true
                    },
                    'billing_email': {
                        required: true,
                        email: true
                    },
                    'billing_company': {
                        required: true
                    },
                    'billing_phone': {
                        required: true
                    },
                    'billing_address': {
                        required: true
                    },
                    'billing_city': {
                        required: true
                    },
                    'billing_state': {
                        required: true
                    },
                    'billing_zip': {
                        required: true
                    },
                    'billing_country': {
                        required: true
                    },
                    'shipping_first_name': {
                        'required': function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'shipping_last_name': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'shipping_email': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        },
                        email: true
                    },
                    'shipping_company': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'shipping_phone': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        },
                    },
                    'shipping_address': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'shipping_city': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'shipping_state': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'shipping_zip': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'shipping_country': {
                        required: function (element) {
                            return uiDifferentShippingCheckbox.is(':checked');
                        }
                    },
                    'card_number': {
                        required: true
                    },
                    'card_expiration_month': {
                        required: true
                    },
                    'card_expiration_year': {
                        required: true
                    },
                    'card_name': {
                        required: true
                    },
                    'card_cvc': {
                        required: true
                    },
                },
                messages: {
                    'billing_first_name': {
                        required: 'First Name is required.'
                    },
                    'billing_last_name': {
                        required: 'Last Name is required.'
                    },
                    'billing_email': {
                        required: 'Email is required.',
                        email: 'Please enter a valid email address.'
                    },
                    'billing_company': {
                        required: 'Company is required.'
                    },
                    'billing_phone': {
                        required: 'Phone is required.',
                    },
                    'billing_address': {
                        required: 'Address is required.'
                    },
                    'billing_city': {
                        required: 'City is required.'
                    },
                    'billing_state': {
                        required: 'State is required.'
                    },
                    'billing_zip': {
                        required: 'Zip is required.'
                    },
                    'billing_country': {
                        required: 'Country is required.'
                    },
                    'shipping_first_name': {
                        required: 'First Name is required.'
                    },
                    'shipping_last_name': {
                        required: 'Last Name is required.'
                    },
                    'shipping_email': {
                        required: 'Email is required.',
                        email: 'Please enter a valid email address.'
                    },
                    'shipping_company': {
                        required: 'Company is required.'
                    },
                    'shipping_phone': {
                        required: 'Phone is required.',
                    },
                    'shipping_address': {
                        required: 'Address is required.'
                    },
                    'shipping_city': {
                        required: 'City is required.'
                    },
                    'shipping_state': {
                        required: 'State is required.'
                    },
                    'shipping_zip': {
                        required: 'Zip is required.'
                    },
                    'shipping_country': {
                        required: 'Country is required.'
                    },
                    'card_number': {
                        required: 'Card number is required.',
                    },
                    'card_expiration_month': {
                        required: 'Card expiration month is required.',
                    },
                    'card_expiration_year': {
                        required: 'Card expiration year is required.',
                    },
                    'card_name': {
                        required: 'Card name is required.',
                    },
                    'card_cvc': {
                        required: 'Card CVC is required.',
                    },
                }
            });
        },

        billing_detail_events: function () {
            /* state select */
            uiBillingStateSelect.select2({width: '98.5%'}).on('change', function () {
                var uiThis = $(this);
                var iStateId = uiThis.val();
                if (uiThis.val() != '') {
                    uiThis.closest('.form-group').find('.select2-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();
                }
                // platform.front_checkout.is_different_shipping_address();
                platform.front_checkout.compute_tax();
            });

            /* checkout select */
            uiBillingCountrySelect.select2({width: '98.5%'}).on('change', function () {
                var uiThis = $(this);
                var iCountryId = uiThis.find('option:selected').attr('data-country-id');
                if (platform.var_check(iCountryId)) {
                    // platform.front_checkout.is_different_shipping_address();
                    // platform.front_checkout.shipping_method();
                    uiThis.closest('.form-group').find('.select2-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();

                    uiBillingStateSelect.html('<option value=""></option>');
                    var sStates = uiThis.find('option[data-country-id="' + iCountryId + '"]').attr('data-states');
                    var oStates = platform.parse_json(sStates);
                    for (var x in oStates) {
                        var state = oStates[x];

                        var data = {
                            id: state.id,
                            code: state.code,
                            text: state.name,
                            tax: state.tax
                        };

                        var uiNewOption = '<option value="' + data.text + '" ' +
                            'data-state-name="' + data.text + '" ' +
                            'data-state-id="' + data.id + '" ' +
                            'data-state-tax="' + data.tax + '" ' +
                            'data-country-id="' + iCountryId + '" ' +
                            '>' + data.text + '</option>';
                        uiBillingStateSelect.append(uiNewOption);
                    }

                    uiBillingStateSelect.trigger('change');
                    uiBillingStateSelect.data('select2').destroy();
                    uiBillingStateSelect.select2({width: '98.5%'});
                    // if (!uiBillingStateSelect.hasClass('loaded')) {
                        uiBillingStateSelect.val(uiBillingStateSelect.attr('data-old-value'));
                        uiBillingStateSelect.trigger('change');
                        // uiBillingStateSelect.addClass('loaded');
                    // }
                }
            });

            if (!uiBillingCountrySelect.find('option[selected]').length) {
                uiBillingCountrySelect.val(uiBillingCountrySelect.find('option[data-is-default="1"]').text());
            }
            uiBillingCountrySelect.trigger('change');
        },

        shipping_detail_events: function () {
            /* state select */
            uiShippingStateSelect.select2({width: '98.5%'}).on('change', function () {
                var uiThis = $(this);
                var iStateId = uiThis.val();
                if (uiThis.val() != '') {
                    uiThis.closest('.form-group').find('.select2-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();
                }
                platform.front_checkout.compute_tax();
            });

            /* checkout select */
            uiShippingCountrySelect.select2({width: '98.5%'}).on('change', function () {
                var uiThis = $(this);
                var iCountryId = uiThis.find('option:selected').attr('data-country-id');
                if (platform.var_check(iCountryId)) {
                    // platform.front_checkout.shipping_method();
                    uiThis.closest('.form-group').find('.select2-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();

                    uiShippingStateSelect.html('<option value=""></option>');
                    var sStates = uiThis.find('option[data-country-id="' + iCountryId + '"]').attr('data-states');
                    var oStates = platform.parse_json(sStates);
                    for (var x in oStates) {
                        var state = oStates[x];

                        var data = {
                            id: state.id,
                            code: state.code,
                            text: state.name,
                            tax: state.tax
                        };

                        var uiNewOption = '<option value="' + data.text + '" ' +
                            'data-state-name="' + data.text + '" ' +
                            'data-state-id="' + data.id + '" ' +
                            'data-state-tax="' + data.tax + '" ' +
                            'data-country-id="' + iCountryId + '" ' +
                            '>' + data.text + '</option>';
                        uiShippingStateSelect.append(uiNewOption);
                    }

                    uiShippingStateSelect.trigger('change');
                    uiShippingStateSelect.data('select2').destroy();
                    uiShippingStateSelect.select2({width: '98.5%'});
                    // if (!uiShippingStateSelect.hasClass('loaded')) {
                        uiShippingStateSelect.val(uiShippingStateSelect.attr('data-old-value'));
                        uiShippingStateSelect.trigger('change');
                        // uiShippingStateSelect.addClass('loaded');
                    // }
                }
            });

            if (!uiShippingCountrySelect.find('option[selected]').length) {
                uiShippingCountrySelect.val(uiShippingCountrySelect.find('option[data-is-default="1"]').text());
            }
            uiShippingCountrySelect.trigger('change');
        },

        is_different_shipping_address: function (fnCallback) {
            if (!uiCheckoutForm.find('[name="is_different_shipping_address"]').is(':checked')) {
                var sBillingFirstName = uiBillingContainer.find('[name="billing_first_name"]').val();
                var sBillingLastName = uiBillingContainer.find('[name="billing_last_name"]').val();
                var sBillingEmail = uiBillingContainer.find('[name="billing_email"]').val();
                var sBillingCompany = uiBillingContainer.find('[name="billing_company"]').val();
                var sBillingPhone = uiBillingContainer.find('[name="billing_phone"]').val();
                var sBillingExt = uiBillingContainer.find('[name="billing_ext"]').val();
                var sBillingAddress = uiBillingContainer.find('[name="billing_address"]').val();
                var sBillingAddress2 = uiBillingContainer.find('[name="billing_address_2"]').val();
                var sBillingCity = uiBillingContainer.find('[name="billing_city"]').val();
                var sBillingState = uiBillingContainer.find('[name="billing_state"]').val();
                var sBillingZip = uiBillingContainer.find('[name="billing_zip"]').val();
                var sBillingCountry = uiBillingContainer.find('[name="billing_country"]').val();
                uiShippingContainer.find('[name="shipping_first_name"]').val(sBillingFirstName);
                uiShippingContainer.find('[name="shipping_last_name"]').val(sBillingLastName);
                uiShippingContainer.find('[name="shipping_email"]').val(sBillingEmail);
                uiShippingContainer.find('[name="shipping_company"]').val(sBillingCompany);
                uiShippingContainer.find('[name="shipping_phone"]').val(sBillingPhone);
                uiShippingContainer.find('[name="shipping_ext"]').val(sBillingExt);
                uiShippingContainer.find('[name="shipping_address"]').val(sBillingAddress);
                uiShippingContainer.find('[name="shipping_address_2"]').val(sBillingAddress2);
                uiShippingContainer.find('[name="shipping_city"]').val(sBillingCity);
                uiShippingContainer.find('[name="shipping_zip"]').val(sBillingZip);
                uiShippingContainer.find('[name="shipping_country"]').val(sBillingCountry);
                uiShippingCountrySelect.trigger('change');
                uiShippingContainer.find('[name="shipping_state"]').val(sBillingState);
                uiShippingStateSelect.trigger('change');
            }

            if (typeof(fnCallback) == 'function') {
                fnCallback();
            }
        },

        compute_shipping: function (fnCallback) {
            var iShippingTotal = 0;

            uiInputShippingTotal.val(iShippingTotal);

            platform.front_checkout.compute_total();

            if (typeof(fnCallback) == 'function') {
                fnCallback();
            }
        },

        compute_tax: function (fnCallback) {
            var uiAddress = !uiCheckoutForm.find('[name="is_different_shipping_address"]').is(':checked') ? uiBillingStateSelect : uiShippingStateSelect;
            var iTax = uiAddress.find('option:selected').attr('data-state-tax');
            var iSubtotal = platform.remove_commas($('.subtotal_total').text());
            var iTaxTotal = 0.00;

            if (platform.var_check(iTax)) {
                iTaxTotal = parseFloat(iSubtotal) * parseFloat(iTax);
            }
            $('.tax_total').text(platform.number_format(iTaxTotal.toFixed(2), 2, '.', ','));

            uiInputTaxTotal.val(iTaxTotal);
            uiInputTaxPercentage.val(iTax);

            platform.front_checkout.compute_total();

            if (typeof(fnCallback) == 'function') {
                fnCallback();
            }
        },

        compute_total: function (fnCallback) {
            var iSubtotal = platform.remove_commas($('.subtotal_total').text());
            var iDiscountTotal = platform.remove_commas($('.discount_total').text());
            var iTaxTotal = platform.remove_commas($('.tax_total').text());
            var iShippingTotal = platform.remove_commas($('.shipping_total').text());
            var iTotal = (parseFloat(iSubtotal) + parseFloat(iTaxTotal) + parseFloat(iShippingTotal)) - (parseFloat(iDiscountTotal));

            if (platform.var_check(iTotal)) {
                $('.total').text(platform.number_format(iTotal.toFixed(2), 2, '.', ','));
            }

            uiInputTotal.val(iTotal);

            if (typeof(fnCallback) == 'function') {
                fnCallback();
            }
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.front_checkout.initialize();
});