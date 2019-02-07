jQuery( function( $ ) {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 167) {
            $('.top-menu').addClass("fix-nav");
        } else {
            $('.top-menu').removeClass("fix-nav");
        }
    });
    $(function dropDown()
    {
        elementClick = '#site-header-cart a.cart-contents';
        elementSlide = '#site-header-cart .widget_shopping_cart_content';
        activeClass = 'active';

        $(elementClick).live('click', function(e){
            e.stopPropagation();
            var subUl = $(elementSlide);
            if(subUl.is(':hidden'))
            {
                subUl.slideDown();
                $(elementClick).addClass(activeClass);
            }
            else
            {
                subUl.slideUp();
                $(elementClick).removeClass(activeClass);
            }
            /*$(elementClick).not(this).next(elementSlide).slideUp();
            $(elementClick).not(this).removeClass(activeClass);*/
            e.preventDefault();
        });

        $(elementSlide).live('click', function(e){
            e.stopPropagation();
        });

        $(document).on('click', function(e){
            e.stopPropagation();
            var elementHide = $(elementSlide);
            $(elementHide).slideUp();
            $(elementClick).removeClass('active');
        });
    });
});