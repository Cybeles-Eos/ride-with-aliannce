$('.banner__slick').slick({
    dots: false,
    infinite: true,
    speed: 800,
    slidesToShow: 1,
    autoplay: false,
    autoplaySpeed: 2000,
    fade: true,
    cssEase: 'linear',
    arrows: true,
});



$('.why-us__slick').slick({
    dots: false,
    arrows: true,
    infinite: true,
    speed: 500,
    slidesToShow: 1,
    autoplay: false,
    autoplaySpeed: 1000,
    // fade: true,
    cssEase: 'linear'
});





$('.global-featured-slider__top--slick').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '.global-featured-slider__bottom--slick'
});


$('.global-featured-slider__bottom--slick').slick({
    lazyLoad: 'ondemand',
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.global-featured-slider__top--slick',
    dots: false,
    centerMode: true,
    arrows: true,
    nextArrow: "<div class=\"nextIcon\" style=\"z-index: 9999999;\"><i class=\"featured-properties__icon--next\"></i></div>",
    prevArrow: "<div class=\"prevIcon\" style=\"z-index: 9999999;\"><i class=\"featured-properties__icon--prev\"></i></div>",
    // fade: true,
    focusOnSelect: true
});