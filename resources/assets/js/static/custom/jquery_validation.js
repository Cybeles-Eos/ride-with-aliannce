$(window).on('load', function () {
    $.validator.setDefaults({
        normalizer: function (value) {
            return $.trim(value);
        }
    });
});