(function($) {

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

                /*Сворачиваем корзину*/
                $('#site-header-cart .widget_shopping_cart_content').slideUp();
                $('#site-header-cart a.cart-contents').removeClass(activeClass);


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


    /* Функция для выбора чекбоксов фильтра товаров */
    /**
     * Если установили родителя, то устанавливаются все чайлды.
     * Если снимается родитель, то все чайлды снимаются тоже
     *
     * При изменении какого-то чайлда смотреть, если кто-то из них не выбран - снимается родитель
     */

    // Совершенно необходимо в файле wp-content/plugins/woocommerce-products-filter/js/html_types/checkbox.js убрать это:
    /*//this script should be, because another way wrong way of working if to click on the label
    jQuery('.woof_checkbox_label').unbind();
    jQuery('label.woof_checkbox_label').click(function () {
        if(jQuery(this).prev().find('.woof_checkbox_term').is(':disabled')){
            return false;
        }
        if (jQuery(this).prev().find('.woof_checkbox_term').is(':checked')) {
            jQuery(this).prev().find('.woof_checkbox_term').trigger('ifUnchecked');
            jQuery(this).prev().removeClass('checked');
        } else {
            jQuery(this).prev().find('.woof_checkbox_term').trigger('ifChecked');
            jQuery(this).prev().addClass('checked');
        }
    });
    */
    //Иначе при клике на Label около чекбокса, событие не отловится. Х.З. зачем вообще сделали эту хрень



    /*$("input[name='400_noodles']").change(function() {
        alert ("fff");
        /*if ($("input[value='kn1']").prop("checked")) {
            $('.block').css("display", "block");  // Этот код сработает
        } else {
            $('.block').css("display", "none");  // И этот тоже
        }*-/
    });*/



    //Работает на лэйбле
    //$('.woof_list_checkbox li.woof_childs_list_li').live('click', function(event){

    // http://icheck.fronteed.com

    //На работает на лэйбле
    //Точное выделение только элементов с чайлдами. Чтобы не срабатывали события по нескольку раз
    //$('.woof_childs_list_li > div > input.woof_checkbox_term').live('ifChanged', function(event){
    $('.woof_childs_list_li > div > input.woof_checkbox_term').live('ifClicked', function(event){
        //alert(event.type + ' callback');
        //console.log (event.type + ' callback');

        parentChecked = !jQuery(this).is(':checked');

        //Находим ul у этого чекбокса
        //childs = jQuery(this).parent().siblings("ul");
        childs = jQuery(this).parent().siblings("ul").find('input.woof_checkbox_term');

        //console.log (childs.length);
        if (childs.length > 0) {
            // есть чайлды

            //childs.css("background-color","red");

            // Перебор всех чайлдов
            childs.each(function(i,elem) {
                //jQuery(elem).css("background-color","red");

                if (parentChecked) {
                    //Устанавливаем в положение Выбрано
                    jQuery(elem).iCheck('check');
                }else{
                    //Устанавливаем в положение Снято
                    jQuery(elem).iCheck('uncheck');
                }



                /*if ($(this).hasClass("stop")) {
                    alert("Остановлено на " + i + "-м пункте списка.");
                    return false;
                } else {
                    alert(i + ': ' + $(elem).text());
                }*/
            });
        }

        /*alert(jQuery(this).prev().className);
        alert(jQuery(this).prev().find('.woof_checkbox_term').className);
        alert(jQuery(this).prev().find('.woof_checkbox_term').is(':disabled'));
        if(jQuery(this).prev().find('.woof_checkbox_term').is(':disabled')){
            alert (2);
        }else{
            alert (3);
        }*/
    });


    // Теперь отслеживаем нажатия чайлдов
    $('.woof_childs_list > li > div > input.woof_checkbox_term').live('ifChanged', function(event){
    //$('.woof_childs_list > li > div > input.woof_checkbox_term').live('ifClicked', function(event){
        //alert(event.type + ' callback');

        //isThisChecked = !jQuery(this).is(':checked');
        //console.log (isThisChecked);

        //Находим ближайший родительский ul
        parent_ul = jQuery(this).closest("ul");
        //jQuery(parent_ul).css("background-color","green");

        //А теперь все его чайлды первого уровня
        //childs = jQuery(parent_ul).children("li > div > input.woof_checkbox_term");
        childs = jQuery(parent_ul).find('> li > div > input.woof_checkbox_term');
        //jQuery(childs).css("background-color","black");


        //Находим родительский input
        parent_input = jQuery(parent_ul).closest(".woof_childs_list_li").find('> div > input.woof_checkbox_term');
        //jQuery(parent_input).css("background-color","blue");


        //console.log (childs.length);

        isAllSelected = true;
        childs.each(function(i,elem) {
            isAllSelected = isAllSelected && jQuery(elem).is(':checked');
        });
        //console.log (jQuery(parent_input).is(':checked'));


        if (jQuery(parent_input).is(':checked') && !isAllSelected) {
            //снимаем родителя
            //console.log ('снимаем родителя');
            jQuery(parent_input).iCheck('uncheck');
        }
        if (!jQuery(parent_input).is(':checked') && isAllSelected) {
            //ставим родителя
            //console.log ('ставим родителя');
            jQuery(parent_input).iCheck('check');
        }

        /*if (childs.length > 0) {
            // есть чайлды

            //childs.css("background-color","red");

            // Перебор всех чайлдов
            childs.each(function(i,elem) {
                //jQuery(elem).css("background-color","red");

                if (parentChecked) {
                    //Устанавливаем в положение Выбрано
                    jQuery(elem).iCheck('check');
                }else{
                    //Устанавливаем в положение Снято
                    jQuery(elem).iCheck('uncheck');
                }



                /*if ($(this).hasClass("stop")) {
                    alert("Остановлено на " + i + "-м пункте списка.");
                    return false;
                } else {
                    alert(i + ': ' + $(elem).text());
                }*-/
            });
        }*/

        /*alert(jQuery(this).prev().className);
        alert(jQuery(this).prev().find('.woof_checkbox_term').className);
        alert(jQuery(this).prev().find('.woof_checkbox_term').is(':disabled'));
        if(jQuery(this).prev().find('.woof_checkbox_term').is(':disabled')){
            alert (2);
        }else{
            alert (3);
        }*/
    });


    /*$(function filterClickCheckboxes()
    {

        parent = '.woof_list_checkbox li.woof_childs_list_li';

        //$('#input-1, #input-3').iCheck('check');

        childs =  '.woof_list_checkbox li.woof_childs_list_li > ul >li1';


        $(parent).live('click', function(e){
            alert (this);
            /*e.stopPropagation();
            var subUl = $(this).next(elSlide);
            if(subUl.is(':hidden'))
            {

                /-*Сворачиваем корзину*-/
                $('#site-header-cart .widget_shopping_cart_content').slideUp();
                $('#site-header-cart a.cart-contents').removeClass(activeClass);


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
            e.preventDefault();*-/
        });

        $(childs).on('click', function(e){
            /*e.stopPropagation();*-/
            alert (this);
        });

        /*$(document).on('click', function(e){
            e.stopPropagation();
            var elementHide = $(elClick).next(elSlide);
            $(elementHide).slideUp();
            $(elClick).removeClass('active');
        });*-/
    });*/


    //Отслеживаем нажатия на заголовках фильтра
    jQuery('.woof_redraw_zone .woof_container .woof_container_inner h4').click(function (e) {
        if (e.target.nodeName == 'H4') {
            toggle = jQuery(this).children('a');
            if (toggle.length == 1) {
                jQuery(toggle).trigger('click');
            }
        }
    });

})(jQuery);