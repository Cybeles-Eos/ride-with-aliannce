/**
 * Created by DNR-PC-08 on 6/6/2019.
 */

(function() {

    jQuery.fn.chainHeight = function(settings) {

        ChainHeight(jQuery(this), settings);
        return jQuery(this);

    }

    function ChainHeight(elem, settings) {

        var target = jQuery(elem);
        settings = jQuery.extend({
            'master': false,
            'breakpoints': [{
                'min': 0,
                'max': 'none'
            }],
            'refreshDelay': 100
        }, settings);

        (function() {

            doResizeEvents();
            jQuery(window).on('resize', function() {
                doResizeEvents()
            });
            jQuery(window).on('load', function() {
                doResizeEvents()
            });


        })();

        function doResizeEvents() {

            setTimeout(function() {
                chainHeights();
            }, settings.refreshDelay);

        }

        function allowedToRun() {

            var winWidth = window.innerWidth || jQuery(window).width();
            var result = false;

            jQuery.each(settings.breakpoints, function(index, elem) {

                /* If window width is within breakpoints */
                if (winWidth >= elem.min && winWidth <= elem.max) {
                    result = true;
                }

                /* If there is no max width */
                else if (winWidth >= elem.min && (elem.max == 'none' || typeof elem.max == "undefined")) {
                    result = true;
                }

                /* Else default */
                else {
                    result = false;
                }

            });

            return result;

        }

        function chainHeights() {

            var height = 0;
            target.css('height', 'auto');

            if (allowedToRun()) {

                if (jQuery(settings.master).length > 0) {
                    height = jQuery(settings.master).outerHeight();
                } else {

                    /* Loop through elements */
                    target.each(function(i, v) {

                        var elemHeight = jQuery(v).outerHeight();

                        /* Compare heights */
                        if (elemHeight > height) {
                            height = elemHeight;
                        }

                    });

                }

            } else {

                /* Reset height */
                height = 'auto';

            }

            /* Loop through elements */
            target.each(function(i, v) {

                /* Check box-sizing */
                if (jQuery(v).css('box-sizing') != 'border-box') {
                    height -= (parseInt(jQuery(v).css('padding-top')) + parseInt(jQuery(v).css('padding-bottom')));
                }

                /* Apply height */
                jQuery(v).css('height', height);

            });

        }

    }

})();
