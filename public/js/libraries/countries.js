(function () {
    "use strict";
    /* declare global variables within the class */
    var uiCountrySelect,
        uiStateSelect,
        filler;

    /*
     * This js file will only contain country events
     *
     * */
    CPlatform.prototype.country = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiCountrySelect = $('.country-select');
            uiStateSelect = $('.state-select');

            /* state select */
            uiStateSelect.select2({width: '100%'}).on('change', function () {
                var uiThis = $(this);
                var iStateId = uiThis.val();
                if (uiThis.val() != '') {
                    uiThis.closest('.form-group').find('.select2-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();
                }
            });

            /* country select */
            uiCountrySelect.select2({width: '100%'}).on('change', function () {
                var uiThis = $(this);
                var iCountryId = uiThis.find('option:selected').attr('data-country-id');
                if (platform.var_check(iCountryId)) {
                    uiThis.closest('.form-group').find('.select2-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();

                    uiStateSelect.html('<option value=""></option>');
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
                        uiStateSelect.append(uiNewOption);
                    }

                    uiStateSelect.trigger('change');
                    uiStateSelect.data('select2').destroy();
                    uiStateSelect.select2({width: '100%'});
                    // if (!uiStateSelect.hasClass('loaded')) {
                    uiStateSelect.val(uiStateSelect.attr('data-old-value'));
                    uiStateSelect.trigger('change');
                    // uiStateSelect.addClass('loaded');
                    // }
                }
            });

            if (!uiCountrySelect.find('option[selected]').length) {
                uiCountrySelect.val(uiCountrySelect.find('option[data-is-default="1"]').text());
            }
            uiCountrySelect.trigger('change');
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.country.initialize();
});