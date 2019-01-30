<?php


//Нужно подвинуть этот экшн перед ним storefront_header_container с нулевым приоритетом. это оказалось просто: приоритет -1
add_action( 'storefront_header', 'header_top', -1 );
function header_top() {
    ?>

    <div class="header-top">
        <div class="col-full">

            <div class="top-order">
                <p class="order1"><?php get_order1_text(); ?></p>
                <p class="order2">Телефон: <?php get_phone(); ?></p>
            </div>

        </div>
    </div>

    <?php
}


function get_order1_text() {
    if (is_today_sanitary_day()) {
        echo "Сегодня санитарный день. <a href=\"#raspisanie\">Посмотреть Расписание. ^</a>";
    }else{
        $os = array(5, 6, 7); //Пятница, Суббота и Воскресенье
        if (in_array(date("N"), $os)) {
            echo "Сегодня принимаем заказы с <a href=\"#raspisanie\">11:00 до 23:30 ^</a>";
        }else{
            echo "Сегодня принимаем заказы с <a href=\"#raspisanie\">11:00 до 22:30 ^</a>";
        }


    }
}

function get_phone() {
    //echo '<a href="tel:+79241005522">8 (924) 100-5522</a>';
    ?>
        <span id="header-phone">8 (924) 100-5522</span>
        <script>
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                document.getElementById("header-phone").innerHTML = '<a href="tel:+79241005522">8 (924) 100-5522</a>';
            }
        </script>
    <?php
}

function is_today_sanitary_day() {
    return false;
}