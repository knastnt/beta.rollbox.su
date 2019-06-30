(function($) {

    $(window).scroll(function () {
        /*console.log($('#site-navigation').offset().top);
        if ($(this).scrollTop() > 167) {*/
        if ($(this).scrollTop() > $('#site-navigation').offset().top - 45) {
            $('#stickey_menu_wrapper').addClass("fix-nav");

            if($('#wpadminbar').length == 1){
                $('#stickey_menu_wrapper').css({
                    top: $('#wpadminbar').height() + 'px',
                });
            }

            /*не переносим меню*
            $("#storefront-primary-navigation").height(77);
            $("#site-navigation").appendTo("#menu-stickey-wrapper");*/
            /*переносим корзину*/
            $("#site-header-cart").appendTo("#site-header-cart-stickey-wrapper");
        } else {
            $('#stickey_menu_wrapper').removeClass("fix-nav");

            /*не возвращаем меню*
            $("#site-navigation").appendTo(".storefront-primary-navigation .col-full");*/
            /*возвращаем корзину*/
            $("#site-header-cart").appendTo("#site-header-cart-head-wrapper");
        }
    });

})(jQuery);