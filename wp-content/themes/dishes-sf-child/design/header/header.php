<?php

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//отодвинем закрывающий тэг

add_action('storefront_header', 'storefront_header_container_close', 45);
add_action( 'storefront_header', 'replace_close_tag', 10 );
function replace_close_tag()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_header_container_close', 41);
}

// переместить корзину рядом с поиском
add_action('storefront_header', 'storefront_header_cart', 41);
add_action( 'storefront_header', 'replace_cart', 10 );
function replace_cart()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_header_cart', 60);
}

// переместить навигацию под поиск
add_action('storefront_header', 'storefront_primary_navigation', 42);
add_action( 'storefront_header', 'replace_nav', 10 );
function replace_nav()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper', 42);
    remove_action('storefront_header', 'storefront_primary_navigation', 50);
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper_close', 68);

    //удаляем стремный скрипт для навигации, потрящий жизнь
    //wp_enqueue_script( 'storefront-navigation', get_template_directory_uri() . '/assets/js/navigation' . $suffix . '.js', array(), $storefront_version, true );
    wp_deregister_script('storefront-navigation');
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






//Нужно подвинуть этот экшн перед ним storefront_header_container с нулевым приоритетом. это оказалось просто: приоритет -1
add_action( 'storefront_header', 'header_top', -1 );
function header_top() {
    ?>

    <div class="header-top">
        <div class="col-full">

            <div class="top-info">
                <div class="info1"><?php get_info1_text(); ?></div>
                <div class="info2"><?php get_phone(); ?></div>
                <div class="info3">г.Комсомольск-на-Амуре, проспект Мира 29</div>

                <?php if(is_user_logged_in()) { ?>
                    <div class="info4"><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Личный кабинет</a></div>
                <?php } else { ?>
                    <div class="info5"><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Регистрация</a></div>
                    <div class="info6"><a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Войти</a></div>
                <?php } ?>
            </div>

        </div>
    </div>

    <?php
}


function get_info1_text() {
    $beforeButtonText = "Сегодня принимаем заказы";
    $buttonText = "с 11:00 до 22:30";

    if (is_today_sanitary_day()) {
        $beforeButtonText = "Сегодня санитарный день.";
        $buttonText = "Посмотреть Расписание.";
    }else{
        //echo current_time('N');
        $os = array(5, 6, 7); //Пятница, Суббота и Воскресенье
        if (in_array(current_time('N'), $os)) {
            $buttonText = "с 11:00 до 23:30";
        }


    }
    //echo $beforeButtonText . "<a href=\"#raspisanie\">" . $buttonText . " ^</a>";
    echo $beforeButtonText . " ";
    ?>
    <button class="btn-link dropdown-toggle">
        <?php echo $buttonText; ?>
        <i class="ion-chevron-down"></i>
    </button>
    <ul class="dropdown-site-menu" style="">
        <li>
            <table>
                <tr>
                    <td>Понедельник</td>
                    <td rowspan="4" style="vertical-align: middle;">с 11:00 до 22:30</td>
                </tr>
                <tr>
                    <td>Вторник</td>
                </tr>
                <tr>
                    <td>Среда</td>
                </tr>
                <tr>
                    <td>Четверг</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #dbdbdb;"></td><td style="border-bottom: 1px solid #dbdbdb;"></td>
                </tr>
                <tr>
                    <td>Пятница</td>
                    <td rowspan="3" style="vertical-align: middle;">с 11:00 до 23:30</td>
                </tr>
                <tr>
                    <td>Суббота</td>
                </tr>
                <tr>
                    <td>Воскресенье</td>
                </tr>
            </table>
        </li>
    </ul>
    <?php
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
    // Достаем санитарный день из настроек
    $sanitaryDay = explode(".", get_option( 'rollbox_options_array' ) ['sanitary_day']);
    $nowDay = explode(".", current_time('d.m.Y'));


    foreach ($nowDay as $key => $value){
        if((int)$value != (int)$sanitaryDay[$key]) return false;
    }
    return true;
}