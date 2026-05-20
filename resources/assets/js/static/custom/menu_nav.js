$(window).on('load', function () {
    $('nav.navbar-bar li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').show()/*.stop(true, true).delay(200).fadeIn(500)*/;
    }, function() {
        $(this).find('.dropdown-menu').hide()/*.stop(true, true).delay(200).fadeOut(500)*/;
    });
});