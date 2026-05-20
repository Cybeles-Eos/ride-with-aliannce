(function () {
    "use strict";
    /* declare global variables within the class */
    var uiChangePasswordRadio,
        uiChangePasswordContainer,
        uiUsersTable,
        uiCreateUserForm,
        uiEditUserForm,
        uiUsersDatatable,
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
     * This js file will only contain user events
     *
     * */
    CPlatform.prototype.user = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiChangePasswordRadio = $('#change_password');
            uiChangePasswordContainer = $('.change-pass-container');
            uiUsersTable = $('#users-table');
            uiCreateUserForm = $('#create-user');
            uiEditUserForm = $('#edit-user');
            uiUsersDatatable = null;

            uiUsersDatatable = platform.user.initialize_datatable();

            /*user change password*/
            uiChangePasswordRadio.on('change', function (e) {
                if ($(this).is(':checked')) {
                    uiChangePasswordContainer.slideDown();
                    uiChangePasswordContainer.find('input').removeAttr('disabled').removeClass('johnCena');
                } else {
                    uiChangePasswordContainer.slideUp();
                    uiChangePasswordContainer.find('input').attr('disabled', 'disabled').addClass('johnCena');
                }
            });

            /* create user validation */
            uiCreateUserForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiCreateUserForm.validate({
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
                        equalTo: uiCreateUserForm.find('#password')
                    }
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

            /* edit user validation */
            uiEditUserForm.find('[type="submit"]').on('click', function () {
                if (platform.var_check(CKEDITOR) && platform.var_check(CKEDITOR.instances)) {
                    for (var instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].updateElement();
                    }
                }
            });
            uiEditUserForm.validate({
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
                        required: {
                            depends: function () {
                                return uiChangePasswordRadio.is(':checked');
                            }
                        },
                        minlength: {
                            param: 8,
                            depends: function () {
                                return uiChangePasswordRadio.is(':checked');
                            }
                        }
                    },
                    'password_confirmation': {
                        equalTo: {
                            param: uiEditUserForm.find('#password'),
                            depends: function () {
                                return uiChangePasswordRadio.is(':checked');
                            }
                        },
                    }
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

            /* delete user button ajax */
            $('body').on('click', '.delete-user-btn', function (e) {
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
                            'data': {'id': self.attr('data-user-id')},
                            'url': self.attr('data-user-route')
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
                                                /* remove user container */
                                                // $('[data-user-template-id="' + oData.data.id + '"]').remove();
                                                if (platform.var_check(uiUsersDatatable)) {
                                                    uiUsersDatatable.row(self.parents('tr:first')).remove();
                                                }

                                                uiUsersDatatable = platform.user.initialize_datatable();

                                                /* check if there are other users to hide the table header and show the no users found */
                                                if ($('tr[data-user-template-id]').length == 0) {
                                                    $('.user-empty').removeClass('johnCena');
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
            if (platform.var_check(uiUsersDatatable)) {
                uiUsersDatatable.destroy();
            }

            uiUsersDatatable = uiUsersTable.DataTable({
                "searchDelay": 1000,
                "processing": true,
                "serverSide": true,
                "lengthChange": true,
                "ajax": {
                    "url": sAdminBaseURI + '/users/draw',
                    "dataType": "json",
                    "type": "GET",
                    "error": function(jqXHR, textStatus, errorThrown)
                    {
                        if (jqXHR.status != 0)
                        {
                            var message = 'Please try again.';
                            swal({
                                'title': "Error!",
                                'text': message,
                                'type': "error"
                            }, function () {

                            });
                        }
                    },
                    "complete": function () {
                        $('[data-toggle="tooltip"], .enable-tooltip').tooltip({
                            container: 'body',
                            animation: false,
                            trigger: 'hover'
                        });
                    }
                },
                "columns": [
                    {
                        "data": "full_name",
                        "className": "text-left"
                    },
                    {
                        "data": "user_name",
                        "className": "text-left"
                    },
                    {
                        "data": "email",
                        "className": "text-left"
                    },
                    {
                        "data": "user_roles",
                        "className": "text-left"
                    },
                    {
                        "data": "action",
                        "className": "text-center"
                    }
                ],
                "order": [[0, "asc"]],
                "paging": true,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'All']],
                "ordering": true,
                "info": true,
                "searching": true,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [3, 4]
                }],
                "initComplete": function () {
                    /* create a container for additional filers */
                    $('.dataTables_filter').parents().first().after('<div class="filter-container width-100percent"></div>');
                    /*role filter*/
                    this.api().columns(3).every(function () {
                        var column = this;

                        /* create a select/input text/input range */
                        var sRoleFilter = 'custom_role_filter';
                        var uiRoleSelect = '<div class="col-sm-6"> ' +
                            '<div class="dataTables_custom_role_filter"> ' +
                            '<label><select ' +
                            'name="'+sRoleFilter+'" ' +
                            'aria-controls="'+sRoleFilter+'" class="form-control">' +
                            '<option value="">All</option> ';

                        column.data().unique().sort().each(function (d, j) {
                            if (d != '') {
                                uiRoleSelect += '<option value="' + d + '">' + d + '</option>';
                            }
                        });

                        uiRoleSelect += '</select></label></div></div>';

                        /* append to created container */
                        $('.filter-container').append(uiRoleSelect);

                        /* create an on change event for the filter */
                        $('[name="'+sRoleFilter+'"]').off('change').on('change', function () {
                            var val = $(this).val();
                            // column.search(val ? '^' + val + '$' : '', true, false).draw();
                            uiUsersDatatable.columns(3).search(val).draw();
                        });
                    });
                    /*role filter end*/
                },
                'createdRow': function( row, data, dataIndex ) {
                    $(row).attr('data-user-template-id', data.id);
                },
            });


            /* users table initialize datatable */
            /*uiUsersDatatable = uiUsersTable.DataTable({
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
                }],
                "initComplete": function () {
                    /!* create a container for additional filers *!/
                    $('.dataTables_filter').parents().first().after('<div class="filter-container width-100percent"></div>');
                    /!*role filter*!/
                    this.api().columns(3).every(function () {
                        var column = this;

                        /!* create a select/input text/input range *!/
                        var sRoleFilter = 'custom_role_filter';
                        var uiRoleSelect = '<div class="col-sm-6"> ' +
                            '<div class="dataTables_custom_role_filter"> ' +
                            '<label><select ' +
                            'name="'+sRoleFilter+'" ' +
                            'aria-controls="'+sRoleFilter+'" class="form-control">' +
                            '<option value="">All</option> ';

                        column.data().unique().sort().each(function (d, j) {
                            if (d != '') {
                                uiRoleSelect += '<option value="' + d + '">' + d + '</option>';
                            }
                        });

                        uiRoleSelect += '</select></label></div></div>';

                        /!* append to created container *!/
                        $('.filter-container').append(uiRoleSelect);

                        /!* create an on change event for the filter *!/
                        $('[name="'+sRoleFilter+'"]').on('change', function () {
                            var val = $(this).val();
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });
                    });
                    /!*role filter end*!/
                }
            });*/

            return uiUsersDatatable;
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.user.initialize();
});