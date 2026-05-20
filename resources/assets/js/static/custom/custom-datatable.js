/* Datatables basic Bootstrap integration (pagination integration included under the Datatables plugin in plugins.js) */
var dtIntegration = function() {
    /* API method to get paging information */
    $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
    {
        return {
            "iStart":         oSettings._iDisplayStart,
            "iEnd":           oSettings.fnDisplayEnd(),
            "iLength":        oSettings._iDisplayLength,
            "iTotal":         oSettings.fnRecordsTotal(),
            "iFilteredTotal": oSettings.fnRecordsDisplay(),
            "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
            "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
        };
    }

    $.extend( $.fn.dataTableExt.oPagination, {
        "bootstrap": {
            "fnInit": function( oSettings, nPaging, fnDraw ) {
                var oLang = oSettings.oLanguage.oPaginate;
                var fnClickHandler = function ( e ) {
                    e.preventDefault();
                    if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
                        fnDraw( oSettings );
                    }
                };

                $(nPaging).addClass('pagination pagination-right').append(
                    '<ul class="pagination">' +
                    '<li class="prev disabled"><a href="#"><i class="fa fa-angle-double-left"></i> ' + oLang.sFirst + '</a></li>' +
                    '<li class="prev disabled"><a href="#"><i class="fa fa-angle-left"></i> '+oLang.sPrevious+'</a></li>'+
                    '<li class="next disabled"><a href="#">' + oLang.sNext + ' <i class="fa fa-angle-right"></i></a></li>' +
                    '<li class="next disabled"><a href="#">' + oLang.sLast + ' <i class="fa fa-angle-double-right"></i></a></li>' +
                    '</ul>'
                );
                var els = $('a', nPaging);
                $(els[0]).bind('click.DT', { action: "first" }, fnClickHandler);
                $(els[1]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
                $(els[2]).bind('click.DT', { action: "next" }, fnClickHandler);
                $(els[3]).bind('click.DT', { action: "last" }, fnClickHandler);
            },

            "fnUpdate": function ( oSettings, fnDraw ) {
                var iListLength = 5;
                var oPaging = oSettings.oInstance.fnPagingInfo();
                var an = oSettings.aanFeatures.p;
                var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

                if ( oPaging.iTotalPages < iListLength) {
                    iStart = 1;
                    iEnd = oPaging.iTotalPages;
                }
                else if ( oPaging.iPage <= iHalf ) {
                    iStart = 1;
                    iEnd = iListLength;
                } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
                    iStart = oPaging.iTotalPages - iListLength + 1;
                    iEnd = oPaging.iTotalPages;
                } else {
                    iStart = oPaging.iPage - iHalf + 1;
                    iEnd = iStart + iListLength - 1;
                }

                for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
                    // Remove the middle elements
                    $('li:gt(1)', an[i]).filter(':not(.next)').remove();

                    // Add the new list items and their event handlers
                    for ( j=iStart ; j<=iEnd ; j++ ) {
                        sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
                        $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                            .insertBefore( $('li.next:first', an[i])[0] )
                            .bind('click', function (e) {
                                e.preventDefault();
                                oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                                fnDraw( oSettings );
                            } );
                    }

                    // Add / remove disabled classes from the static elements
                    if ( oPaging.iPage === 0 ) {
                        $('li.prev', an[i]).addClass('disabled');
                    } else {
                        $('li.prev', an[i]).removeClass('disabled');
                    }

                    if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
                        $('li.next', an[i]).addClass('disabled');
                    } else {
                        $('li.next', an[i]).removeClass('disabled');
                    }
                }
            }
        }
    } );
    $.extend(true, $.fn.dataTable.defaults, {
        "sDom": "<'row'<'col-sm-6 col-xs-5'l><'col-sm-6 col-xs-7'f>r>t<'row'<'col-sm-4 col-xs-4'i><'col-sm-8 col-xs-8 clearfix'p>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sLengthMenu": "_MENU_",
            "sSearch": "<div class=\"input-group\">_INPUT_<span class=\"input-group-addon\"><i class=\"fa fa-search\"></i></span></div>",
            "sInfo": "<strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
            "oPaginate": {
                "sFirst": "",
                "sLast": "",
                "sPrevious": "",
                "sNext": ""
            },
            "sProcessing": "<div class='col-sm-12'><div class='alert alert-info alert-dismissable image-empty'><b><i class='fa fa-spinner fa-pulse'></i> Loading..</b></div></div>"
        }
    });
    $.extend($.fn.dataTableExt.oStdClasses, {
        "sWrapper": "dataTables_wrapper form-inline",
        "sFilterInput": "form-control",
        "sLengthSelect": "form-control"
    });
};
dtIntegration();