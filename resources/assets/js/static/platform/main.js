(function () {
    "use strict";
    /* declare global variables within the class */
    var filler;

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
     * This js file will only contain main events
     *
     * */
    CPlatform.prototype.main = {

        initialize: function () {
            /* assign a value to the global variable within this class */
            filler = $('.element');

            App.pageLoading();
            App.datatables();

            platform.main.show_post_loader();
        },

        /* show post-loader on beforeunload */
        show_post_loader: function () {
            $(window).on('beforeunload', function () {
                NProgress.start();
                setInterval(function () {
                    NProgress.inc();
                }, 2000);
            });
            $(window).on('unload', function () {
                NProgress.done();
            });
        }
    }

}());

/* run initialize function on load of window */
$(window).on('load', function () {
    platform.main.initialize();
});