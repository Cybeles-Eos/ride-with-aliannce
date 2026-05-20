(function () {
    "use strict";
    /* declare global variables within the class */
    var uiSystemSettingsTable,
        uiCreateSystemSettingForm,
        uiEditSystemSettingForm,
        uiSystemSettingsDatatable,
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
     * This js file will only contain system setting events
     *
     * */
    CPlatform.prototype.system_setting = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiSystemSettingsTable = $('#system-settings-table');
            uiCreateSystemSettingForm = $('#create-system-setting');
            uiEditSystemSettingForm = $('#edit-system-setting');
            uiSystemSettingsDatatable = null;

            uiSystemSettingsDatatable = platform.system_setting.initialize_datatable();

            /* create system setting validation */
            uiCreateSystemSettingForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiCreateSystemSettingForm.validate({
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
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'code': {
                        required: true
                    },
                    'name': {
                        required: true
                    },
                    'value': {
                        required: true
                    },
                },
                messages: {
                    'code': {
                        required: 'Code is required.'
                    },
                    'name': {
                        required: 'Name is required.'
                    },
                    'value': {
                        required: 'Value is required.'
                    },
                }
            });

            /* edit system setting validation */
            uiEditSystemSettingForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiEditSystemSettingForm.validate({
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
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'code': {
                        required: true
                    },
                    'name': {
                        required: true
                    },
                    'value': {
                        required: true
                    },
                },
                messages: {
                    'code': {
                        required: 'Code is required.'
                    },
                    'name': {
                        required: 'Name is required.'
                    },
                    'value': {
                        required: 'Value is required.'
                    },
                }
            });

            /* delete system setting button ajax */
            $('body').on('click', '.delete-system-setting-btn', function (e) {
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
                            'data': {'id': self.attr('data-system-setting-id')},
                            'url': self.attr('data-system-setting-route')
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
                                                'type': "success"
                                                //'confirmButtonColor': "#DD6B55",
                                            }, function () {
                                                /* remove system-setting container */
                                                // $('[data-system-setting-template-id="' + oData.data.id + '"]').remove();
                                                if (platform.var_check(uiSystemSettingsDatatable)) {
                                                    uiSystemSettingsDatatable.row(self.parents('tr:first')).remove();
                                                }

                                                uiSystemSettingsDatatable = platform.system_setting.initialize_datatable();

                                                /* check if there are other system settings to hide the table header and show the no system settings found */
                                                if ($('tr[data-system-setting-template-id]').length == 0) {
                                                    $('.system-setting-empty').removeClass('johnCena');
                                                    $('.table-responsive').addClass('johnCena');
                                                }
                                            });
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

            if (platform.var_check(sSettingType)) {
                if (sSettingType == 'file') {
                    $('[name="value"]').on('change', function () {
                        var input = $(this),
                            numFiles = input.get(0).files ? input.get(0).files.length : 1,
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
                            sValue = $(this).val(),
                            ext = sValue.substring(sValue.lastIndexOf('.') + 1).toLowerCase();
                        _fileselect($(this), numFiles, label, ext);
                    });
                }
            }
        },

        initialize_datatable: function () {
            if (platform.var_check(uiSystemSettingsDatatable)) {
                uiSystemSettingsDatatable.destroy();
            }

            /* system settings table initialize datatable */
            uiSystemSettingsDatatable = uiSystemSettingsTable.DataTable({
                    "order": [[0, "asc"]],
                    "paging": false,
                    // "pageLength": 10,
                    // "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'All']],
                    "ordering": true,
                    "info": true,
                    "searching": true,
                    "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [3]
                    }]
                });

            return uiSystemSettingsDatatable;
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.system_setting.initialize();
});