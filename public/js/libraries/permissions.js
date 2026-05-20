(function () {
    "use strict";
    /* declare global variables within the class */
    var uiPermissionsTable,
        uiCreatePermissionForm,
        uiEditPermissionForm,
        uiPermissionGroupSelect,
        uiPermissionsDatatable,
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
     * This js file will only contain permission events
     *
     * */
    CPlatform.prototype.permission = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiPermissionsTable = $('#permissions-table');
            uiCreatePermissionForm = $('#create-permission');
            uiEditPermissionForm = $('#edit-permission');
            uiPermissionGroupSelect = $('.permission-group-select');
            uiPermissionsDatatable = null;

            uiPermissionsDatatable = platform.permission.initialize_datatable();

            /* create permission validation */
            uiCreatePermissionForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiCreatePermissionForm.validate({
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
                    'name': {
                        required: true
                    },
                    'permission_group_id': {
                        required: true
                    }
                },
                messages: {
                    'name': {
                        required: 'Name is required.'
                    },
                    'permission_group_id': {
                        required: 'Permission Group is required.'
                    }
                }
            });

            /* edit permission validation */
            uiEditPermissionForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiEditPermissionForm.validate({
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
                    'name': {
                        required: true
                    },
                    'permission_group_id': {
                        required: true
                    }
                },
                messages: {
                    'name': {
                        required: 'Name is required.'
                    },
                    'permission_group_id': {
                        required: 'Permission Group is required.'
                    }
                }
            });

            /* delete permission button ajax */
            $('body').on('click', '.delete-permission-btn', function (e) {
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
                            'data': {'id': self.attr('data-permission-id')},
                            'url': self.attr('data-permission-route')
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
                                                /* remove permission container */
                                                // $('[data-permission-template-id="' + oData.data.id + '"]').remove();
                                                if (platform.var_check(uiPermissionsDatatable)) {
                                                    uiPermissionsDatatable.row(self.parents('tr:first')).remove();
                                                }

                                                uiPermissionsDatatable = platform.permission.initialize_datatable();

                                                /* check if there are other permissions to hide the table header and show the no permissions found */
                                                if ($('tr[data-permission-template-id]').length == 0) {
                                                    $('.permission-empty').removeClass('johnCena');
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

            /* permissions group select */
            uiPermissionGroupSelect.select2({width: "100%"}).on('change', function () {
                var uiThis = $(this);
                if (uiThis.val() != '') {
                    uiThis.closest('.form-group').find('.select2-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();
                }
            });
        },

        initialize_datatable: function () {
            if (platform.var_check(uiPermissionsDatatable)) {
                uiPermissionsDatatable.destroy();
            }

            /* permissions table initialize datatable */
            uiPermissionsDatatable = uiPermissionsTable.DataTable({
                "order": [[0, "asc"]],
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'All']],
                "ordering": true,
                "info": true,
                "searching": true,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [3]
                }],
                "initComplete": function () {
                    /* create a container for additional filers */
                    $('.dataTables_filter').parents().first().after('<div class="filter-container width-100percent"></div>');
                    /*role filter*/
                    this.api().columns(1).every(function () {
                        var column = this;

                        /* create a select/input text/input range */
                        var sPermissionGroupFilter = 'custom_permission_group_filter';
                        var uiPermissionGroupSelectIndex = '<div class="col-sm-6"> ' +
                            '<div class="dataTables_custom_permission_group_filter"> ' +
                            '<label><select ' +
                            'name="'+sPermissionGroupFilter+'" ' +
                            'aria-controls="'+sPermissionGroupFilter+'" class="form-control">' +
                            '<option value="">All</option> ';

                        column.data().unique().sort().each(function (d, j) {
                            if (d != '') {
                                uiPermissionGroupSelectIndex += '<option value="' + d + '">' + d + '</option>';
                            }
                        });

                        uiPermissionGroupSelectIndex += '</select></label></div></div>';

                        /* append to created container */
                        $('.filter-container').append(uiPermissionGroupSelectIndex);

                        /* create an on change event for the filter */
                        $('[name="'+sPermissionGroupFilter+'"]').on('change', function () {
                            var val = $(this).val();
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    });
                    /*role filter end*/
                }
            });

            return uiPermissionsDatatable;
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.permission.initialize();
});