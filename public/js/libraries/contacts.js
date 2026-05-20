(function () {
    "use strict";
    /* declare global variables within the class */
    var uiContactsTable,
        uiCreateContactForm,
        uiContactsDatatable,
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

    /* private fileselect function that will check/validate files input */
    function _fileselect(element, numFiles, label, ext) {
        var input = $(element).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
        var uiImgContainer = $(element).parents('.form-group:first').find('.img-responsive');

        if (element.val() == '') {
            uiImgContainer.attr('src', uiImgContainer.attr('alt'));
            uiImgContainer.parents('.zoom:first').attr('href', uiImgContainer.attr('alt'));
            _fileselect_error(element, input, 'File is required.');
        } else {
            if (ext == 'jpeg' || ext == 'jpg' || ext == 'png') {
                element.closest('.form-group').find('.help-block').remove();
                element.closest('.form-group').removeClass('has-success has-error');

                if (input.length) {
                    input.val(log);
                    platform.readURL($(element).get(0).files[0], uiImgContainer, []);
                } else {
                    if (log) {
                        console.log(log);
                    }
                }
            }
            else {
                uiImgContainer.attr('src', uiImgContainer.attr('alt'));
                uiImgContainer.parents('.zoom:first').attr('href', uiImgContainer.attr('alt'));
                _fileselect_error(element, input, 'The upload file must be a file of type: jpeg, jpg, png.');
            }
        }
    }

    /* private fileselect_error function that will append/display error messages of file input */
    function _fileselect_error(element, input, msg) {
        element.closest('.form-group').find('.help-block').remove();
        element.closest('.form-group').removeClass('has-success has-error').addClass('has-error');
        element.parents('.form-group > div').append('<span id="file-error" class="help-block animation-slideDown">' + msg + '</span>');
        element.val('');
        input.val('');
    }

    /*
     * This js file will only contain contact events
     *
     * */
    CPlatform.prototype.contact = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiContactsTable = $('#contacts-table');
            uiCreateContactForm = $('#create-contact');
            uiContactsDatatable = null;

            if (uiContactsTable.length) {
                uiContactsDatatable = platform.contact.initialize_datatable();
            }

            /* create contact validation */
            uiCreateContactForm.validate({
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
                    'name': {
                        required: true
                    },
                    'email': {
                        required: true,
                        email: true
                    },
                    // 'phone': {
                    //     required: true
                    // },
                    'subject': {
                        required: true
                    },
                    'message': {
                        required: true
                    },
                },
                messages: {
                    'name': {
                        required: 'Name is required.'
                    },
                    'email': {
                        required: 'Email is required.',
                        email: 'Please enter a valid email address.',
                    },
                    // 'phone': {
                    //     required: 'Phone is required.'
                    // },
                    'message': {
                        required: 'Message is required.'
                    },
                    'subject': {
                        required: 'Subject is required.'
                    },
                }
            });
        },

        initialize_datatable: function () {
            if (platform.var_check(uiContactsDatatable)) {
                uiContactsDatatable.destroy();
            }

            /* contacts table initialize datatable */
            uiContactsDatatable = uiContactsTable.DataTable({
                "order": [[0, "asc"]],
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'All']],
                "ordering": true,
                "info": true,
                "searching": true,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [4]
                }]
            });

            return uiContactsDatatable;
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.contact.initialize();
});