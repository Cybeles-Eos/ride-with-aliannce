/**
 *    Class that will connection detection
 *    This tool will be used to detect if the client has lost connection to the server by any of the following circumstances:
 *
 *
 */
(function () {
    "use strict";

    var iAJAXtimeout = 0;

    window.CPlatform.prototype.CentralAjax = {

        /**
         * @param : { oAJAXConfig(object)
         * @description : The method that will be used as a wrapper method of the jQuery AJAX.
         * @dependency : ajaxq.js
         * */

        'ajax': function (oAJAXConfig) {
            if (typeof(oAJAXConfig.url) == 'string' && typeof(oAJAXConfig.success) == 'function' 
                && ( oAJAXConfig.data instanceof FormData || Object.getOwnPropertyNames(oAJAXConfig.data).length !== 0 ) ) {


                var oSettings = {
                    type   : oAJAXConfig.type,
                    url    : oAJAXConfig.url,
                    data   : oAJAXConfig.data,
                    datatype : 'jsonp',
                    success: function(sData) {
                        var oData

                        try {
                            oData = JSON.parse(sData);
                        } catch (e) {
                            oData = sData
                        }

                        oAJAXConfig.success(oData)
                    },
                    headers : oAJAXConfig.headers,
                    error  : function (error, errormsg) {
                        if(typeof(oAJAXConfig.error) == 'function')
                        {
                            oAJAXConfig.error(error, errormsg);
                        }
                    },
                    complete : function(xhr) {
                        if(typeof(oAJAXConfig.complete) == 'function')
                        {
                            oAJAXConfig.complete(xhr);
                        }
                    },
                    beforeSend : function() {
                        if(typeof(oAJAXConfig.beforeSend) == 'function')
                        {
                            oAJAXConfig.beforeSend();
                        }
                    },
                    timeout : function() {
                        alert('Request Timeout');
                        if(typeof(oAJAXConfig.timeout) == 'function')
                        {
                            oAJAXConfig.timeout();
                        }
                    }
                }

                if(oAJAXConfig.hasOwnProperty("processData")){
                   oSettings["processData"] = oAJAXConfig.processData;
                }

                if(oAJAXConfig.hasOwnProperty("contentType")){
                   oSettings["contentType"] = oAJAXConfig.contentType;
                }

                if(oAJAXConfig.hasOwnProperty("token")){
                    oSettings.data._token = oAJAXConfig.token;
                }

                // return $.ajaxq('queued_requests', oSettings); //ajaxq to process queueing
                return $.ajax(oSettings);

            }
            else {
                alert('params error');
            }
        }
    }
}());
