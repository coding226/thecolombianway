jQuery(document).ready(function($) {
    var mobile = false;
    $(window).resize(function() {

        if ($(window).width() <= 414) {
            mobile = true;
        }
    });
    setTimeout(function() {
        var diff = 70;
        if (mobile) {
            diff = 0;
        }
        var jumpPos = $('#main').offset().top - diff;
        if ($(document).scrollTop() <= jumpPos) $('html, body').animate({ scrollTop: jumpPos }, 1000);
    }, 5000);
});