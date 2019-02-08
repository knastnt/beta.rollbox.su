jQuery( function( $ ) {
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

                /*Сворачиваем другие меню*/
                $('.dropdown-site-menu').slideUp();
                $('button.dropdown-toggle').removeClass(activeClass);

                subUl.slideDown();
                $(elementClick).addClass(activeClass);
            }
            else
            {
                subUl.slideUp();
                $(elementClick).removeClass(activeClass);
            }
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