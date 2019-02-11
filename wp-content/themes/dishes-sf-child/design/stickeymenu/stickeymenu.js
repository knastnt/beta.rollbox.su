(function($) {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 167) {
            $('#stickey_menu_wrapper').addClass("fix-nav");
            $('.container').css("transform", "none");
        } else {
            $('#stickey_menu_wrapper').removeClass("fix-nav");
            $('.container').css("transform", "");
        }
    });


})(jQuery);