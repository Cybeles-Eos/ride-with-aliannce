/* Scroll to top functionality */
var topLink = $('#to-top');

$(window).scroll(function() { if ($(this).scrollTop() > 150) { topLink.fadeIn(100); } else { topLink.fadeOut(100); } });
topLink.click(function() { $('html, body').animate({ scrollTop: 0 }, 200); return false; });





// for header class sticky
jQuery(window).scroll(function() {
    var scroll = jQuery(window).scrollTop();
    if (scroll >= 100) {
        jQuery("header").addClass("scrolling");
    } else {
        jQuery("header").removeClass("scrolling");
    }

});


// for contact us
$("ul.form-box .form-group input").focus(function() {
    $(this).parent().addClass('active');

}).blur(function() {
    $(this).parent().removeClass('active');
})

$("ul.form-box .form-group textarea").focus(function() {
    $(this).parent().addClass('active');

}).blur(function() {
    $(this).parent().removeClass('active');
})



// for footer class
jQuery(window).scroll(function() {
    var scroll = jQuery(window).scrollTop();

    if (scroll >= 300) {
        jQuery(".btn--backbutton").addClass("scrolling");
    } else {
        jQuery(".btn--backbutton").removeClass("scrolling");
    }

});


// smooth scroll
$(document).on('click', 'a[href^="#"]', function(event) {
    event.preventDefault();

    $('html, body').animate({
        scrollTop: $($.attr(this, 'href')).offset().top
    }, 500);
});


// activate search box
$(".search-now").click(function() {
    $(".search-box").toggleClass('search-visible');
    setTimeout(function() {
        var sValue = $('[name="keyword"]').val();
        $('[name="keyword"]').focus().val('').val(sValue);
    }, 100);
});

$(".search-box__button").click(function() {
    $(".search-box").toggleClass('search-visible');
});


// basic toggle
// $(".mobile__menu--btn").click(function(){
//     $(".extended-navigation").toggleClass('extended-navigation--show');
// });

// var addclass = 'social-sets--show';
// var $cols = $('.social-sets').click(function(e) {
//     $cols.removeClass(addclass);
//     $(this).addClass(addclass);
// });


/***************************************** */
// for mobile elements
/***************************************** */


// for sidebar
$(".siderbar-toggle-btn").click(function() {
    $(".sidebar").toggleClass('sidebar--toggle');
});


//  Configure/customize these variables.
var showChar = 220; // How many characters are shown by default
var ellipsestext = "...";
var moretext = "Read more";
var lesstext = "Readmore less";

$('.more').each(function() {
    var content = $(this).html();

    if (content.length > showChar) {

        var c = content.substr(0, showChar);
        var h = content.substr(showChar, content.length - showChar);

        var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span><a href="" class="morelink">' + moretext + '</a></span>';

        $(this).html(html);
    }

});

$(".morelink").click(function() {
    if ($(this).hasClass("less")) {
        $(this).removeClass("less");
        $(this).html(moretext);
    } else {
        $(this).addClass("less");
        $(this).html(lesstext);
    }
    $(this).parent().prev().toggle();
    $(this).prev().toggle();
    return false;
});