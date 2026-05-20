(function () {
    "use strict";
    /* declare global variables within the class */
    var uiOrdersTable,
        filler;

    /* private ajax function that will send quote to backend */
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

    function format(d) {
        return d[5];
    }

    /*
     * This js file will only contain quote events
     *
     * */
    CPlatform.prototype.front_order = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            uiOrdersTable = $('#orders-table');

            /* orders table initialize datatable */
            var uiOrdersDatatable = uiOrdersTable.DataTable({
                "order": [[1, "desc"]],
                "paging": false,
                "pageLength": 10,
                "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, 'All']],
                "ordering": false,
                "info": false,
                "searching": false,
                "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [4]
                },
                {
                    'bVisible': false,
                    'aTargets': [5]
                }],
                "initComplete": function () {
                    $(this).siblings('.row').hide();
                }
            });

            uiOrdersTable.on('click', '.details-control', function () {
                var tr = $(this).closest('tr');
                var row = uiOrdersDatatable.row(tr);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        },
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.front_order.initialize();
});