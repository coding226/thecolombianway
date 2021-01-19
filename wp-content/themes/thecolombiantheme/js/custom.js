// Author: Andrei Popa 
// Website: http://andrei123.ro

jQuery(document).ready(function($) {

    function setHeroFeatured() {
        var headerHeight = $('.fusion-header').height();
        var viewportHeight = $(window).height();
        var viewportWidth = $(window).width();
        if (viewportWidth <= 550) {
            var heroHeight = viewportHeight - headerHeight;
        } else {
            var heroHeight = viewportHeight;
        }
        $('.heroFeatured').height(heroHeight);
    };

    $('.tcw-menu > li.menu-item-has-children').on("touchstart click", "> a", function(e) {
        if (e.handled === false) return
        e.stopPropagation();
        e.preventDefault();
        e.handled = true;
        var displayType = $(e.currentTarget).siblings('.sub-menu-custom').css("display");
        if (displayType === "block") {
            $(e.currentTarget).siblings('.sub-menu-custom').hide(700);
        } else {
            $(e.currentTarget).siblings('.sub-menu-custom').show(700);
        }
        $(e.currentTarget).toggleClass('minus-icon');
    });
    $('a.downIndicator').click(function() {
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 98
        }, 1000);
        return false;
    });
    setHeroFeatured();
    $('.heroFeatured').show();
    $('#loaderContainer').hide();

    $(window).on('resize', function(e) {
        setHeroFeatured();
    });

});