(function($) {

    $(window).scroll(function () {
        if ($(this).scrollTop() > 167) {
            $('.top-menu').addClass("fix-nav");
        } else {
            $('.top-menu').removeClass("fix-nav");
        }
    });
    $(function dropDown()
    {
        elClick = 'button.dropdown-toggle';
        elSlide =  '.dropdown-site-menu';
        activitedClass = 'active';

        $(elClick).on('click', function(e){
            e.stopPropagation();
            var subUl = $(this).next(elSlide);
            if(subUl.is(':hidden'))
            {
                subUl.slideDown();
                $(this).addClass(activitedClass);
            }
            else
            {
                subUl.slideUp();
                $(this).removeClass(activitedClass);
            }
            $(elClick).not(this).next(elSlide).slideUp();
            $(elClick).not(this).removeClass(activitedClass);
            e.preventDefault();
        });

        $(elSlide).on('click', function(e){
            e.stopPropagation();
        });

        $(document).on('click', function(e){
            e.stopPropagation();
            var elementHide = $(elClick).next(elSlide);
            $(elementHide).slideUp();
            $(elClick).removeClass('active');
        });
    });


})(jQuery);