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
        elementClick = '#cart button.dropdown-cart';
        elementSlide =  '.dropdown-menu';
        activeClass = 'active';

        $(elementClick).on('click', function(e){
            e.stopPropagation();
            var subUl = $(this).next(elementSlide);
            if(subUl.is(':hidden'))
            {
                subUl.slideDown();
                $(this).addClass(activeClass);
            }
            else
            {
                subUl.slideUp();
                $(this).removeClass(activeClass);
            }
            $(elementClick).not(this).next(elementSlide).slideUp();
            $(elementClick).not(this).removeClass(activeClass);
            e.preventDefault();
        });

        $(elementSlide).on('click', function(e){
            e.stopPropagation();
        });

        $(document).on('click', function(e){
            e.stopPropagation();
            var elementHide = $(elementClick).next(elementSlide);
            $(elementHide).slideUp();
            $(elementClick).removeClass('active');
        });
    });
});