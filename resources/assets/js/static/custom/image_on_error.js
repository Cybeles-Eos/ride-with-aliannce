$(window).on('load', function () {
    $("img.hidden_image")
        .on("load", function (res) {
            if ($(this).hasClass('hidden_image')) {
                $(this).parents('.hidden_image_container:first').css('background-image', 'url(\'' + $(this).attr('src') + '\')');
            }
        })
        .on("error", function (res) {
            if ($(this).hasClass('hidden_image')) {
                $(this).parents('.hidden_image_container:first').css('background-image', 'url(\'' + $(this).attr('error-src') + '\')');
            }
        }).each(function () {
        if ($(this).hasClass('hidden_image')) {
            if (this.complete && this.naturalWidth > 0) {
                $(this).load();
            } else {
                $(this).error();
            }
        }
    });
});