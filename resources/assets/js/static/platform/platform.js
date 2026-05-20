/*
 * platform.js - handles low level platform functions
 *
 * JSLint Valid (http://www.jslint.com/)
 *
 */
/*jslint plusplus: true, evil: true */
/*global jQuery:true */

var oLocalData = {};

function CPlatform() {
    "use strict";

    var config = {};
    // Assign Config
    // This function performs the adding new config data into the system
    function assign_config(keys, value) {
        var x = 0,
            y,
            path = '',
            configuration = config,
            test = {};
        if (keys && keys.length > 0) {
            // Traverse through each segment and determine if that segment already exists in config
            for (x = 0; x < keys.length; x++) {
                path += '["' + keys[x] + '"]';
                eval('test = config' + path);
                // Otherwise add it as a blank object
                if (typeof(test) == 'undefined') {
                    eval('config' + path + ' = {};');
                }
            }
            eval('config' + path + ' = "' + value + '";');
            return true;
        }
        return false;
    }

    /*
     CONFIG
     Performs config traversal and assignment.
     */
    function configuration(sKey, sValue) {
        var oKeywords = {};
        // Check if the provided key is actually an object
        if (typeof(sKey) === 'object') {
            // It's an object, which could only mean that it's a multiple-assignment
            oKeywords = sKey;
            $.each(oKeywords, function (sKey, sValue) {
                // Explode the key to get the config tree
                var arKey = sKey.split('.'),
                    x = 0,
                    y = 0,
                    configuration,
                    keys = [];
                // Check if the array of keys isn't empty
                if (arKey.length > 0) {
                    for (x = 0; x < arKey.length; x++) {
                        if (arKey[x] && arKey[x].length > 0) {
                            if (y > 0) {
                                if (configuration[arKey[x]]) {
                                    configuration = configuration[arKey[x]];
                                    y++;
                                } else {
                                    configuration = '';
                                }
                            } else {
                                if (config[arKey[x]]) {
                                    configuration = config[arKey[x]];
                                    y++;
                                } else {
                                    configuration = '';
                                }
                            }
                        }
                        keys.push(arKey[x]);
                    }
                } else {
                    // If it is empty, just copy it over
                    configuration = arKey[0];
                }
                // Let's just make sure a value is provided, this means that there's an
                // intention of updating the stored value.
                if (sValue && sValue !== 'undefined' && sValue.length >= 0) {
                    assign_config(keys, sValue);
                }
            });
            // It's not an object, so it's likely a string
        } else {
            if (sKey && sKey.length > 0) {
                // Explode the key to get the config tree
                var arKey = sKey.split('.'),
                    x = 0,
                    y = 0,
                    configuration,
                    keys = [];
                // Check if the array of keys isn't empty
                if (arKey.length > 0) {
                    for (x = 0; x < arKey.length; x++) {
                        if (arKey[x] && arKey[x].length > 0) {
                            if (y > 0) {
                                if (configuration[arKey[x]]) {
                                    configuration = configuration[arKey[x]];
                                    y++;
                                } else {
                                    configuration = '';
                                }
                            } else {
                                if (config[arKey[x]]) {
                                    configuration = config[arKey[x]];
                                    y++;
                                } else {
                                    configuration = '';
                                }
                            }
                        }
                        keys.push(arKey[x]);
                    }
                } else {
                    // If it is empty, just copy it over
                    configuration = arKey[0];
                }
                // Check if a value parameter is provided and not empty
                if (sValue && sValue !== 'undefined' && sValue.length >= 0) {
                    // Then assign it to the specified key
                    assign_config(keys, sValue);
                    // This allows us to pass the node's assigned value as the return value of the function
                    configuration = sValue;
                }
                return configuration;
            }
        }
        return config;
    }

    // System.config allows you to retrieve or set the value of a
    // custom config variable.
    // Usage:
    //    System.config(name) = returns value of "name" config
    //    System.config(name,value) = sets the value of "name" config to "value"

    this.config = function (sKey, sValue) {
        return configuration(sKey, sValue);
    };

    /**
     * @param : { variable }
     * @description : Function to validate variable
     * @author : Richard Guevara
     * @return : boolean
     * */

    this.var_check = function (variable, iLength) {
        var bValidity = false;
        var aDataTypes = ['string', 'array', 'object', 'number', 'boolean', 'function'];
        if (typeof(variable) != 'undefined' && typeof(variable) !== undefined) {
            if (aDataTypes.indexOf(typeof(variable)) > -1 && variable != null) {
                bValidity = true;
            }
        }

        if (typeof(iLength) != 'undefined') {
            bValidity = (variable.length > iLength - 1) ? true : false;
        }

        return bValidity;
    }

    /**
     * @param : { sStingJson (string) }
     * @description : Function to SAFELY validate and parse a valid json string and avoid scripts freezing
     * @author : Richard Guevara
     * @return : boolean
     * */

    this.parse_json = function (sStringJson) {
        var oJsonObject = {};
        if (my_platform.var_check(sStringJson)) {
            if (sStringJson.length > 0) {
                try {
                    oJsonObject = $.parseJSON(sStringJson);
                }
                catch (e) {
                    console.log('failed to parse json string');
                    console.log(e);
                }
            }
        }
        return oJsonObject;
    }

    /**
     * @param : { sStingJson (string) }
     * @description : global configuration of console logs, to be false in live during deployment
     * @author : Richard Guevara
     * @return : boolean
     * */
    this.log = function (variable) {
        var bDebugMode = true;
        if (my_platform.var_check(variable) && bDebugMode == true) {
            console.trace();
            console.log(variable);
        }
    },


        this.generate_random_keys = function (length) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for (var i = 0; i < ( my_platform.var_check(length) ? length : 0 ); i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            return text;
        }

    /**
     * check_duplicate
     * @description Check duplicate data in an array. Returns status 1 if no duplicate and 0 if has duplicate with corresponding error message.
     * @param {array} array
     * @returns {object}
     * @author : Richard Guevara
     */
    this.check_duplicate = function (array) {
        var response = {
            'status': 0,
            'data': [],
            'message': '',
        };
        if (my_platform.var_check(array) && Object.keys(array).length > 0) {
            var unique = [];
            for (var i = 0; i < Object.keys(array).length; i++) {
                var current = array[i];
                if (unique.indexOf(current) < 0) {
                    response.status = 1;
                    unique.push(current);
                }
                else {
                    response.status = 0;
                    response.message = 'Duplicate value ' + current + ' in array.';
                    response.value_error = current;
                    break;
                }
            }
            response.data = unique;
        }
        else {
            response.message = 'No array given.';
        }

        return response;
    }

    /**
     * capitalize
     * @description Capitalize the string given
     * @param {string} string
     * @returns {string}
     * @author : Richard Guevara
     */
    this.capitalize = function (string) {
        var i, words, w, result = '';

        words = string.split(' ');

        for (i = 0; i < words.length; i += 1) {
            w = words[i];
            result += w.substr(0, 1).toUpperCase() + w.substr(1).toLowerCase();
            if (i < words.length - 1) {
                result += ' ';
            }
        }
        return result;
    }

    this.focus_element = function ($element, $container, iOffset) {
        if (my_platform.var_check($container) && my_platform.var_check(iOffset)) {
            $container.animate({
                scrollTop: (parseInt($element.offset().top) - iOffset) + 'px'
            }, 'fast');
        }

        $('html, body').animate({
            scrollTop: (parseInt($element.offset().top) - 20) + 'px'
        }, 'fast');


        return this; // for chaining...
    }

    /**
     * show_spinner
     * @description This function will add/remove the loading spinner.
     * @dependencies N/A
     * @param {jQuery} $uiElem
     * @param {boolean} bShow
     * @response N/A
     * @criticality CRITICAL
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.show_spinner = function ($uiElem, bShow) {
        if (bShow == true) {
            if ($uiElem.find('i.fa-spinner').length > 0) {
                $uiElem.find('i.fa-spinner').removeClass('hidden');
            }
            else {
                $uiElem.append(' <i class="fa fa-spinner fa-pulse"></i>');
            }

            $uiElem.prop('disabled', true);
            $uiElem.attr('disabled', 'disabled');
            $uiElem.css('pointer-events', 'none');
        }
        else {
            if ($uiElem.find('i.fa-spinner').length > 0) {
                $uiElem.find('i.fa-spinner').addClass('hidden');
                $uiElem.find('i.fa-spinner').remove();
            }
            $uiElem.prop('disabled', false);
            $uiElem.removeAttr('disabled');
            $uiElem.css('pointer-events', 'auto');
        }
    },

        this.css2json = function (css) {
            var s = {};
            if (!css) return s;
            if (css instanceof CSSStyleDeclaration) {
                for (var i in css) {
                    if ((css[i]).toLowerCase) {
                        s[(css[i]).toLowerCase()] = (css[css[i]]);
                    }
                }
            } else if (typeof css == "string") {
                css = css.split("; ");
                for (var i in css) {
                    var l = css[i].split(": ");
                    s[l[0].toLowerCase()] = (l[1]);
                }
            }
            return s;
        }

    this.css = function (a) {
        var sheets = document.styleSheets, o = {};
        for (var i in sheets) {
            var rules = sheets[i].rules || sheets[i].cssRules;
            for (var r in rules) {
                if (a.is(rules[r].selectorText)) {
                    o = $.extend(o, my_platform.css2json(rules[r].style), my_platform.css2json(a.attr('style')));
                }
            }
        }
        return o;
    }

    /**
     * input_numeric
     * @description This function is for allowing only numeric keys on keydown, and also other keys such as backspace, delete, tab etc.
     * @dependencies
     * @param {jQuery} uiElement
     * @param {bool} bRemoveDot
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.input_numeric = function (uiElement, bRemoveDot) {
        if (my_platform.var_check(uiElement)) {
            uiElement.off('keydown.input_numeric').on('keydown.input_numeric', function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                var arrValid = [46, 8, 9, 27, 13, 110, 190];
                if (my_platform.var_check(bRemoveDot) && bRemoveDot) {
                    arrValid = [46, 8, 9, 27, 13, 110];
                }
                if ($.inArray(e.keyCode, arrValid) !== -1 ||
                    // Allow: Ctrl+A
                    (e.keyCode == 65 && e.ctrlKey === true) ||
                    // Allow: Ctrl+C
                    (e.keyCode == 67 && e.ctrlKey === true) ||
                    // Allow: Ctrl+X
                    (e.keyCode == 88 && e.ctrlKey === true) ||
                    // Allow: Ctrl+R
                    (e.keyCode == 82 && e.ctrlKey === true) ||
                    // Allow: Ctrl+V
                    (e.keyCode == 86 && e.ctrlKey === true) ||
                    // Allow: home, end, left, right
                    (e.keyCode >= 35 && e.keyCode <= 39)) {
                    // let it happen, don't do anything
                    return;
                }
                // Ensure that it is a number and stop the keypress
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        }
    }

    /**
     * remove_commas
     * @description This function is for removing all commas in a string given
     * @dependencies
     * @param {string} string
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.remove_commas = function (string) {
        if (my_platform.var_check(string) && string.length > 0) {
            while (string.search(",") >= 0) {
                string = (string + "").replace(',', '');
            }
            return string;
        }
        return '';
    }

    /**
     * clear_sorting_classes
     * @description This function is for clearing sort classes
     * @dependencies
     * @param {jQuery} uiSortField
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.clear_sorting_classes = function (uiSortField) {
        uiSortField.each(function () {
            $(this).css({"color": "black"});
            $(this).removeClass("active red-color");
            $(this).find("i.fa").removeClass("fa-chevron-up");
            $(this).find("i.fa").removeClass("fa-chevron-down");
        });
    }

    /**
     * ui_sorting
     * @description This function is for sorting passed template
     * @dependencies
     * @param {jQuery} uiSortField - the element containing the data-sort-value
     * @param {jQuery} sOrderby - the data attribute needed to sort the templates
     * @param {int} iTemplateCount - if template count is not greater than 1 or equal to 1, it wont sort
     * @param {jQuery} uiTemplateForSort - the elements or templates to be sorted
     * @param {jQuery} uiTemplateContainer - the container where the sorted data will append
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.ui_sorting = function (uiSortField, sOrderby, iTemplateCount, uiTemplateForSort, uiTemplateContainer) {
        if (my_platform.var_check(uiSortField) && my_platform.var_check(sOrderby) && my_platform.var_check(iTemplateCount) && my_platform.var_check(uiTemplateForSort) && my_platform.var_check(uiTemplateContainer)) {
            /*validate if order count needs sorting*/
            if (iTemplateCount > 1) {
                my_platform.show_spinner(uiSortField, true);

                var iSortDirectionAsc;
                var iSortDirectionDesc;

                uiSortField.addClass("active red-color");
                if (uiSortField.attr("data-sort-value") == "asc") {
                    iSortDirectionAsc = -1;
                    iSortDirectionDesc = 1;
                    uiSortField.attr("data-sort-value", "desc");
                    uiSortField.find("i.fa").removeClass("fa-chevron-up");
                    uiSortField.find("i.fa").addClass("fa-chevron-down");
                }
                else {
                    iSortDirectionAsc = 1;
                    iSortDirectionDesc = -1;
                    uiSortField.attr("data-sort-value", "asc");
                    uiSortField.find("i.fa").addClass("fa-chevron-up");
                    uiSortField.find("i.fa").removeClass("fa-chevron-down");
                }

                var returnZeroCtr = 0;
                var returnAscCtr = 0;
                var returnDescCtr = 0;

                /*sort visible template*/
                uiTemplateForSort.sort(function (a, b) {
                    var akey = $(a).attr(sOrderby);
                    var bkey = $(b).attr(sOrderby);
                    if (my_platform.var_check(akey) && my_platform.var_check(bkey) && akey.length > 0 && bkey.length > 0) {
                        akey = akey.toLowerCase();
                        bkey = bkey.toLowerCase();
                        if (akey == bkey) {
                            returnZeroCtr++;
                            return 0;
                        }
                        if (akey < bkey) {
                            returnAscCtr++;
                            return iSortDirectionAsc;
                        }
                        if (akey > bkey) {
                            returnDescCtr++;
                            return iSortDirectionDesc;
                        }
                    }
                    else {
                        return 0;
                    }
                });

                /*included validation if the field sorted has no change*/
                if (returnDescCtr > 0 || returnAscCtr > 0 || (uiTemplateForSort.length - 1) > returnZeroCtr) {
                    // console.log('not same');
                    if (uiTemplateContainer.find('.last-content').length > 0) {
                        uiTemplateForSort.detach().insertBefore(uiTemplateContainer.find('.last-content'));
                    }
                    else {
                        uiTemplateForSort.detach().appendTo(uiTemplateContainer);
                    }
                }

                my_platform.show_spinner(uiSortField, false);
            }
        }
    }

    /**
     * print_element
     * @description This function is for printing a specific element
     * @dependencies
     * @param {jQuery} element - the element that should be printed
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.print_element = function (element) {
        if (my_platform.var_check(element)) {
            var elementHTML = element.html();
            //Get the HTML of whole page
            var oldPage = $('body').html();

            //Reset the page's HTML with div's HTML only
            $('body').html(elementHTML);

            //Print Page
            window.print();

            //Restore orignal HTML
            $('body').html(oldPage);
        }
        return true;
    }

    /**
     * readURL
     * @description This function is for previewing a file
     * @dependencies
     * @param {jQuery} input - the input type file
     * @param {jQuery} imgcontainer - the container where the image will be previewed
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.readURL = function (file, imgcontainer, filearray) {
        if (my_platform.var_check(file) && my_platform.var_check(imgcontainer) && my_platform.var_check(filearray)) {

            var reader = new FileReader();

            reader.onload = function (e) {
                imgcontainer
                    .attr('src', e.target.result)
                    // .addClass('img-thumbnail')
                    // .width(100)
                    // .height(100)
                    .show();

                imgcontainer.parents('.zoom:first').attr('href', e.target.result);
            };
            reader.readAsDataURL(file);
            filearray.push(reader);
        }
    }

    /**
     * number_format
     * @description This function is php like number_format
     * @dependencies
     * @param {jQuery} number - string||int
     * @param {jQuery} decimals - count of decimal places
     * @param {jQuery} dec_point - decimal point string
     * @param {jQuery} thousands_sep - separator for thousands string
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.number_format = function (number, decimals, dec_point, thousands_sep) {
        // Strip all characters but numerical ones.
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }

    /**
     * indent_textarea
     * @description This function makes a textarea have indention
     * @dependencies
     * @param {jQuery} uiElem - textarea
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.indent_textarea = function (uiElem) {
        $(uiElem).on('keydown', function (e) {
            if (e.keyCode == 9 || e.which == 9) {
                e.preventDefault();
                var s = this.selectionStart;
                this.value = this.value.substring(0, this.selectionStart) + "\t" + this.value.substring(this.selectionEnd);
                this.selectionEnd = s + 1;
            }
        });
    }

    /**
     * inline_css_to_json
     * @description This function will get inline styles of an element and convert it to json
     * @dependencies
     * @param {jQuery} uiElem
     * @response N/A
     * @criticality N/A
     * @software_architect N/A
     * @author : Richard Guevara
     */
    this.inline_css_to_json = function (uiElem) {
        var styles = $(uiElem).attr('style').split(';'),
            i= styles.length,
            json = {style: {}},
            style, k, v;
        while (i--)
        {
            style = styles[i].split(':');
            k = $.trim(style[0]);
            v = $.trim(style[1]);
            if (k.length > 0 && v.length > 0)
            {
                json.style[k] = v;
            }
        }
        return json.style;
    }


}
window.CPlatform = CPlatform;
window.my_platform = new CPlatform(),
window.platform = window.my_platform;
