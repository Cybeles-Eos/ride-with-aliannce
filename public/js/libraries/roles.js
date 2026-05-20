(function () {
    "use strict";
    /* declare global variables within the class */
    var uiRolesTable,
        uiCreateRoleForm,
        uiEditRoleForm,
        uiRolesDatatable,
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
     * This js file will only contain role events
     *
     * */
    CPlatform.prototype.role = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiRolesTable = $('#roles-table');
            uiCreateRoleForm = $('#create-role');
            uiEditRoleForm = $('#edit-role');
            uiRolesDatatable = null;

            uiRolesDatatable = platform.role.initialize_datatable();

            /* create role validation */
            uiCreateRoleForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiCreateRoleForm.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                errorPlacement: function (error, e) {
                    if (e.parents('.permissions_container:first').length) {
                        e.parents('.permissions_container:first').find('.permission-error-container').show().find('div').append(error);
                    } else {
                        e.parents('.form-group > div').append(error);
                    }
                },
                highlight: function (e) {
                    if ($(e).hasClass('permissions')) {

                    } else {
                        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.form-group').find('.help-block').remove();
                    }
                },
                success: function (e) {
                    if (e.parents('.permissions_container:first').length) {
                        e.parents('.permissions_container:first').find('.permission-error-container').hide().find('div').find('.help-block').remove();
                    } else {
                        e.closest('.form-group').removeClass('has-success has-error');
                        e.closest('.form-group').find('.help-block').remove();
                    }
                },
                submitHandler: function (form) {
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'name': {
                        required: true
                    },
                    'permissions[]': {
                        required: true
                    }
                },
                messages: {
                    'name': {
                        required: 'Name is required.'
                    },
                    'permissions[]': {
                        required: 'Permission is required.'
                    }
                }
            });

            /* edit role validation */
            uiEditRoleForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiEditRoleForm.validate({
                errorClass: 'help-block animation-slideDown',
                errorElement: 'span',
                errorPlacement: function (error, e) {
                    if (e.parents('.permissions_container:first').length) {
                        e.parents('.permissions_container:first').find('.permission-error-container').show().find('div').append(error);
                    } else {
                        e.parents('.form-group > div').append(error);
                    }
                },
                highlight: function (e) {
                    if ($(e).hasClass('permissions')) {

                    } else {
                        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
                        $(e).closest('.form-group').find('.help-block').remove();
                    }
                },
                success: function (e) {
                    if (e.parents('.permissions_container:first').length) {
                        e.parents('.permissions_container:first').find('.permission-error-container').hide().find('div').find('.help-block').remove();
                    } else {
                        e.closest('.form-group').removeClass('has-success has-error');
                        e.closest('.form-group').find('.help-block').remove();
                    }
                },
                submitHandler: function (form) {
                    platform.show_spinner($(form).find('[type="submit"]'), true);
                    form.submit();
                },
                rules: {
                    'name': {
                        required: true,
                    },
                    'permissions[]': {
                        required: true
                    }
                },
                messages: {
                    'name': {
                        required: 'Name is required.'
                    },
                    'permissions[]': {
                        required: 'Permission is required.'
                    }
                }
            });

            /* delete role button ajax */
            $('body').on('click', '.delete-role-btn', function (e) {
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
                            'data': {'id': self.attr('data-role-id')},
                            'url': self.attr('data-role-route')
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
                                                /* remove role container */
                                                // $('[data-role-template-id="' + oData.data.id + '"]').remove();
                                                if (platform.var_check(uiRolesDatatable)) {
                                                    uiRolesDatatable.row(self.parents('tr:first')).remove();
                                                }

                                                uiRolesDatatable = platform.role.initialize_datatable();

                                                /* check if there are other roles to hide the table header and show the no roles found */
                                                if ($('tr[data-role-template-id]').length == 0) {
                                                    $('.role-empty').removeClass('johnCena');
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
        },

        initialize_datatable: function () {
            if (platform.var_check(uiRolesDatatable)) {
                uiRolesDatatable.destroy();
            }

            /* roles table initialize datatable */
            uiRolesDatatable = uiRolesTable.DataTable({
                "order": [[0, "asc"]],
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'All']],
                "ordering": true,
                "info": true,
                "searching": true,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [2]
                }]
            });

            return uiRolesDatatable;
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.role.initialize();
});