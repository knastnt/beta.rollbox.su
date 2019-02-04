(function($) {

    $('a.flexmobile').live('click', function(){
        //alert(1);

        //container = document.querySelector( '#flexmobilemainmenu' ),
        //container.style.top = '100px';

        //$("#flexmobilemainmenu").fadeOut(30000);

        /*$("#flexmobilemainmenu").animate({
            left: '10%',
            //opacity: '0.3',
          });*/

        //$('#flexmobilemainmenu').empty();

        //
        //var $id_of_showed_nav = $(this).parent().attr('data-id');
        var $link_on_child_id = $(this).attr('link_on');
        var $link_on_parent_nav_id = $("#" + $link_on_child_id).attr('data-parent');
        //console.log("$id_of_showed_nav = " + $id_of_showed_nav);
        //console.log("$link_on_child_id = " + $link_on_child_id);
        //console.log("$link_on_parent_nav_id = " + $link_on_parent_nav_id);

        if($link_on_child_id != null){
            //есть дочерние пункты
            //console.log("есть дочерние пункты");

            $("#flexmobilemainmenu").animate({
                left: '10%',
            });


            $("#flexmobilemainmenu a").css({opacity: 0.01});
            //$("#flexmobilemainmenu").offset({left:40%});
            /*$("#flexmobilemainmenu").animate({
               left: '25%',
               //opacity: '1',
             });	*/

            //$('#flexmobilemainmenu').empty();

            setTimeout(function () {

                //$('#flexmobilemainmenu').html("<a class=\"flexmobile icon-home\" link_on=\"submenu-1-1\" href=\"#\">Home2</a><a class=\"flexmobile icon-news\" href=\"#\">News2</a><a class=\"flexmobile icon-image\" href=\"#\">Images2</a><a class=\"flexmobile icon-upload\" href=\"#\">Uploads2</a>");
                //$('#flexmobilemainmenu').html($('#flexmobile-submenu-1').html);


                //console.log($link_on_child_id);

                var $child_content = $('#' + $link_on_child_id).html();

                if($link_on_parent_nav_id != ""){
                    $back = "<a class=\"flexmobile icon-home\" link_on=\"" + $link_on_parent_nav_id + "\" href=\"#\">Назад</a>";
                }else{
                    $back = "";
                }
                $('#flexmobilemainmenu').html($back + $child_content);
                $('#flexmobilemainmenu').attr('data-id', $link_on_child_id);

                $("#flexmobilemainmenu a").css({opacity: 0.99});
                $('#flexmobilemainmenu').css({ left: '26%'});
                $("#flexmobilemainmenu").animate({
                    left: '25%',
                });

            }, 500); // время в мс



        }


    });



    /*$('#showMenu').on('click', function() {
            //ev.stopPropagation();
            //ev.preventDefault();
            /*$("#flexmobilemainmenu").animate({
                left: '25%',
                opacity: '1',
              });*
            $('#flexmobilemainmenu').html($('#flexmobile-mainmenu').html());
            $("#flexmobilemainmenu a").css({opacity: '1'});
    });*/


    function hexc(colorval) {
        var parts = colorval.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
        delete(parts[0]);
        for (var i = 1; i <= 3; ++i) {
            parts[i] = parseInt(parts[i]).toString(16);
            if (parts[i].length == 1) parts[i] = '0' + parts[i];
        }
        color = '#' + parts.join('');
    }

})(jQuery);