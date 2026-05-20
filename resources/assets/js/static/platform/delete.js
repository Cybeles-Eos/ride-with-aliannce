(function () {
    "use strict";
    var filler;

    /*
     * This js file will only contain delete ajax events
     *
     * */
    CPlatform.prototype.delete = {

        initialize: function () {

        },

        /* delete function ajax */
        delete: function (oParams, fnCallback, uiBtn) {
            if (platform.var_check(oParams) && platform.var_check(oParams.url)) {
                var oAjaxConfig = {
                    "type": "DELETE",
                    "data": oParams,
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
    }

}());

$(window).load(function () {
    platform.delete.initialize();
});