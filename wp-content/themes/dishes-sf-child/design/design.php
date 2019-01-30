<?php


//Нужно подвинуть этот экшн перед ним storefront_header_container с нулевым приоритетом. это оказалось просто: приоритет -1
add_action( 'storefront_header', 'header_top', -1 );
function header_top() {
    ?>

    <div class="header-top">
        <div class="col-full">

            <div class="top-info">
                <p class="info1"><?php get_info1_text(); ?></p>
                <p class="info2"><?php get_phone(); ?></p>
                <p class="info3">г.Комсомольск-на-Амуре, проспект Мира 29</p>

                <?php if(is_user_logged_in()) { ?>
                    <p class="info4"><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Личный кабинет</a></p>
                <?php } else { ?>
                    <p class="info5"><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Регистрация</a></p>
                    <p class="info6"><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Войти</a></p>
                <?php } ?>
            </div>

        </div>
    </div>

    <?php
}


function get_info1_text() {
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






// переместить корзину рядом с поиском
add_action('storefront_header', 'storefront_header_cart', 40);
add_action( 'storefront_header', 'replace_cart', 41 );
function replace_cart()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_header_cart', 60);
}