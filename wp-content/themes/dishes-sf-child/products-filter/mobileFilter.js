(function($) {

    //Отслеживаем scroll и resize
    //Scrolling
    jQuery(document).scroll(function () {
        ScrollAndResizeFnc();
    });
    //Resizing
    jQuery(window).resize(function () {
        ScrollAndResizeFnc();
    });
    //Ready
    jQuery(window).ready(function () {
        ScrollAndResizeFnc();
    });
    function ScrollAndResizeFnc () {

        var andermenuY = 0;
        var filterY = 0;

        var m = $("#masthead");
        var stm = $("#stickey_menu_wrapper");
        var ffb = $("#fixedFilterBlock"); //Плавающая строка Фильтровать товары
        var wwf = $("#woof_widget-3");

        //Если фильтр на странице отсутствует, то ретюрним
        if (!wwf.length) {
            try {
                ffb.hide();
            }catch (e) {

            }
            //console.log ("ret");
            return;
        }

        //Смотрим если на экране нет кнопки фильтра, то в любом случае делаем фильтр видимым
        if (ffb.css('display') == 'none') {
            //wwf.css('display', 'block');
            wwf.show();
        }


        if (m.css('position') == 'fixed')
        {
            //Меню на маленьких экранах - фиксированно. stm - отключено. andermenuY - под m.height
            ffb.css('position', 'fixed');
            andermenuY = m.innerHeight();
            filterY = andermenuY + ffb.outerHeight();
        }else{
            //Меню на больших экранах - обычное, привязанное к контенту. stm может быть видимо или нет
            if (stm.hasClass("fix-nav") && (m.innerHeight() - $(window).scrollTop()) < stm.innerHeight()) {
                // если stm - есть и оно ниже, чем m
                ffb.css('position', 'fixed');
                andermenuY = stm.innerHeight();
                filterY = andermenuY + ffb.outerHeight();
            }else{
                // если stm - нет. ffb должно быть absolute
                ffb.css('position', 'absolute');
                andermenuY = m.innerHeight();
                filterY = m.innerHeight() - $(window).scrollTop() + ffb.outerHeight();
            }
        }

        //console.log(andermenuY);

        ffb.css("top", andermenuY + "px");
        wwf.css("top", filterY + "px");

    };






    jQuery("#fixedFilterBlock").live('click', function(e) {
        if ($("#woof_widget-3").css('display') == 'none') {
            $("#woof_widget-3").css('display', 'block');
        }else{
            $("#woof_widget-3").css('display', 'none');
        }
    });




})(jQuery);