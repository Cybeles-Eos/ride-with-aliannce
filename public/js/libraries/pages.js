(function () {
    "use strict";
    /* declare global variables within the class */
    var uiPagesTable,
        uiCreatePageForm,
        uiEditPageForm,
        uiPageTypeSelect,
        uiPagesDatatable,
        uiInputBannerImage,
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

        if (element.val() == '') {
            _fileselect_error(element, input, 'File is required.');
        } else {
            if (ext == 'jpeg' || ext == 'jpg' || ext == 'png') {
                element.closest('.form-group').find('.help-block').remove();
                element.closest('.form-group').removeClass('has-success has-error');

                if (input.length) {
                    input.val(log);
                } else {
                    if (log) {
                        console.log(log);
                    }
                }
            }
            else {
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
     * This js file will only contain page events
     *
     * */
    CPlatform.prototype.page = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiPagesTable = $('#pages-table');
            uiCreatePageForm = $('#create-page');
            uiEditPageForm = $('#edit-page');
            uiPageTypeSelect = $('.page-type-select');
            uiPagesDatatable = null;
            uiInputBannerImage = $('input[type="file"]');

            uiPagesDatatable = platform.page.initialize_datatable();

            /* create page validation */
            uiCreatePageForm.validate({
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
                    'title': {
                        required: true
                    },
                    'slug': {
                        required: true
                    },
                    'content': {
                        required: true
                    },
                    // 'page_type_id': {
                    //     required: true
                    // },
                },
                messages: {
                    'title': {
                        required: 'Title is required.'
                    },
                    'slug': {
                        required: 'Slug is required.'
                    },
                    'content': {
                        required: 'Content is required.'
                    },
                    // 'page_type_id': {
                    //     required: 'Page Type is required.'
                    // },
                }
            });

            /* edit page validation */
            uiEditPageForm.validate({
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
                    'title': {
                        required: true
                    },
                    'slug': {
                        required: true
                    },
                    'content': {
                        required: true
                    },
                    'page_type_id': {
                        required: true
                    },
                },
                messages: {
                    'title': {
                        required: 'Title is required.'
                    },
                    'slug': {
                        required: 'Slug is required.'
                    },
                    'content': {
                        required: 'Content is required.'
                    },
                    'page_type_id': {
                        required: 'Page Type is required.'
                    },
                }
            });

            /* delete page button ajax */
            $('body').on('click', '.delete-page-btn', function (e) {
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
                            'data': {'id': self.attr('data-page-id')},
                            'url': self.attr('data-page-route')
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
                                                /* remove page container */
                                                // $('[data-page-template-id="' + oData.data.id + '"]').remove();

                                                if (platform.var_check(uiPagesDatatable)) {
                                                    uiPagesDatatable.row(self.parents('tr:first')).remove();
                                                }

                                                uiPagesDatatable = platform.page.initialize_datatable();

                                                /* check if there are other pages to hide the table header and show the no pages found */
                                                if ($('tr[data-page-template-id]').length == 0) {
                                                    $('.page-empty').removeClass('johnCena');
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

            /* page type select */
            uiPageTypeSelect.chosen({width: "100%", search_contains: true}).on('change', function () {
                var uiThis = $(this);
                if (uiThis.val() != '') {
                    uiThis.closest('.form-group').find('.chosen-container').removeClass('has-success has-error');
                    uiThis.closest('.form-group').removeClass('has-success has-error');
                    uiThis.closest('.form-group').find('.help-block').remove();
                }
            });

            /* input file event */
            uiInputBannerImage.on('change', function () {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, ''),
                    sValue = $(this).val(),
                    ext = sValue.substring(sValue.lastIndexOf('.') + 1).toLowerCase();
                _fileselect($(this), numFiles, label, ext);
            });

            if (platform.var_check(oPageSections)) {
                for (var x in oPageSections) {
                    var oPageSection = oPageSections[x];
                    console.log( $('[name="page_sections[' + oPageSection.id + ']"]'))
                    $('[name="page_sections[' + oPageSection.id + ']"]').on('change', function () {
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
            if (platform.var_check(uiPagesDatatable)) {
                uiPagesDatatable.destroy();
            }

            /* pages table initialize datatable */
            uiPagesDatatable = uiPagesTable.DataTable({
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
                // "initComplete": function () {
                //     /* create a container for additional filers */
                //     $('.dataTables_filter').parents().first().after('<div class="filter-container width-100percent"></div>');
                //     /*role filter*/
                //     this.api().columns(3).every(function () {
                //         var column = this;
                //
                //         /* create a select/input text/input range */
                //         var sPageTypeFilter = 'custom_page_type_filter';
                //         var uiPageTypeSelectIndex = '<div class="col-sm-6"> ' +
                //             '<div class="dataTables_custom_page_type_filter"> ' +
                //             '<label><select ' +
                //             'name="'+sPageTypeFilter+'" ' +
                //             'aria-controls="'+sPageTypeFilter+'" class="form-control">' +
                //             '<option value="">All</option> ';
                //
                //         column.data().unique().sort().each(function (d, j) {
                //             if (d != '') {
                //                 uiPageTypeSelectIndex += '<option value="' + d + '">' + d + '</option>';
                //             }
                //         });
                //
                //         uiPageTypeSelectIndex += '</select></label></div></div>';
                //
                //         /* append to created container */
                //         $('.filter-container').append(uiPageTypeSelectIndex);
                //
                //         /* create an on change event for the filter */
                //         $('[name="'+sPageTypeFilter+'"]').on('change', function () {
                //             var val = $(this).val();
                //             column.search(val ? '^' + val + '$' : '', true, false).draw();
                //         });
                //     });
                //     /*role filter end*/
                // }
            });

            return uiPagesDatatable;
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.page.initialize();
});