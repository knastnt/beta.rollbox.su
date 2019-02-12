(function($) {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 167) {
            $('#stickey_menu_wrapper').addClass("fix-nav");
            if($('#wpadminbar').length == 1){
                $('#stickey_menu_wrapper').css({
                    top: $('#wpadminbar').height() + 'px',
                });
            }
            $('.container').css("transform", "none");
            $("#site-header-cart").appendTo("#site-header-cart-stickey-wrapper");
        } else {
            $('#stickey_menu_wrapper').removeClass("fix-nav");
            $('.container').css("transform", "");
            $("#site-header-cart").appendTo("#site-header-cart-head-wrapper");
        }
    });


})(jQuery);