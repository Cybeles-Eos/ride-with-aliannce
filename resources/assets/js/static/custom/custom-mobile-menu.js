// for mobile
// "/* MOBILE HEADER */
$('.mob-burger-menu').click(function() {
    $(this).toggleClass('change');
    $('.mob-nav-menu').toggleClass('open-menu');
    $('.sub-elem').removeClass('show-sub');
});

$('.drop-menu-elem').click(function(e) {
    e.preventDefault();
    $('.sub-elem').toggleClass('show-sub');
});

$('.back-btn').click(function() {
    $('.mob-sub-menu').removeClass('show-sub');
});

$('.btn--close-menu').click(function() {
    $('.mob-nav-menu').removeClass('open-menu');
    $('.mob-burger-menu').removeClass('change');
    $('.mob-sub-menu').removeClass('show-sub');
});

$(document).click(function(e) {
    if (!$(e.target).closest('.mobile-header__wrapper').length) {
        $('.mob-nav-menu').removeClass('open-menu');
        $('.mob-burger-menu').removeClass('change');
        $('.mob-sub-menu').removeClass('show-sub');
    }
});



// MObile menu sub
$(".icon-button__open").click(function() {
    $('.icon-button-active').removeClass('icon-button-active');
    $(this).parent().addClass('icon-button-active');
});

$(".icon-button__close").click(function() {
    $('.icon-button-active').removeClass('icon-button-active');
});