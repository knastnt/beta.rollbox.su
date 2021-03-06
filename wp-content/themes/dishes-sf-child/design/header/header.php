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
add_action('storefront_header', 'storefront_primary_navigation', 43);
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
                <div class="info3"><span class="town">г.Комсомольск-на-Амуре, </span>проспект Мира 29</div>

                <div class="right-info-wrapper">
                <?php if(is_user_logged_in()) { ?>
                    <div class="rating">
                        <a href="#">Ваш рейтинг: <?php echo do_shortcode('[WC_Loy_Get_Current_User_Rating]'); ?></a>
                    </div>
                    <div class="info4"><?php get_account_menu(); ?></div>
                <?php } else { ?>
                    <div class="info5"><a href="/wp-login.php?action=register">Регистрация</a></div>
                    <div class="info6"><a href="/wp-login.php">Войти</a></div>
                <?php } ?>
                </div>
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
        $buttonText = "Режим работы";
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
                    <td rowspan="2" style="vertical-align: middle;">с 11:00 до 02:00</td>
                </tr>
                <tr>
                    <td>Суббота</td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #dbdbdb;"></td><td style="border-bottom: 1px solid #dbdbdb;"></td>
                </tr>
                <tr>
                    <td>Воскресенье</td>
                    <td>с 11:00 до 00:30</td>
                </tr>
            </table>
        </li>
    </ul>
    <?php
}




function get_account_menu() {
    global $current_user;
    $username = $current_user->user_nicename;
    $account_link = get_permalink( wc_get_page_id( 'myaccount' ) );
    $cart_link = get_permalink( wc_get_page_id( 'cart' ) );
    $logout_link = wp_logout_url();
    /*<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>">Личный кабинет</a>*/
    ?>

    <button class="btn-link dropdown-toggle">
        <i class="ion-image"></i>
        <span class="name"><?php echo strtoupper ($username); ?></span>
        <i class="ion-chevron-down"></i>
    </button>
    <ul class="dropdown-site-menu account-menu" style="">
        <?php if(is_user_logged_in()) { ?>
            <li>
                <a href="<?php echo $account_link; ?>">Личный кабинет</a>
            </li>
            <li class="line"></li>
            <li>
                <a href="<?php echo $account_link . "rewards/"; ?>">Бонусы</a>
            </li>
            <li class="line"></li>
            <li>
                <a href="<?php echo $account_link . "orders/"; ?>">Мои заказы</a>
            </li>
            <li class="line"></li>
            <li>
                <a href="<?php echo $cart_link; ?>">Корзина</a>
            </li>
            <li class="line"></li>
            <li>
                <a href="<?php echo $logout_link; ?>">Выйти</a>
            </li>
        <?php } else { ?>
            <li>
                <a href="/wp-login.php">Войти</a>
            </li>
            <li>
                <a href="/wp-login.php?action=register">Регистрация</a>
            </li>
        <?php } ?>

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


// Значек баллов около корзины
add_action('storefront_header', 'points_after_header_cart', 42);
function points_after_header_cart() {
?>
    <div class="user-points">
        <button class="btn-link dropdown-toggle" title="Ваши бонусы">
            <i class="ion-user-points"></i>
            <span id="points-total"><?php echo do_shortcode('[WC_Loy_Get_Current_User_Points]'); ?></span>
            <i class="ion-chevron-down"></i>
        </button>

        <ul class="dropdown-site-menu user-points-menu" style="">
            <?php
                if(is_user_logged_in()) {
                    $history_output = do_shortcode('[WC_Loy_Get_Current_User_Points_History limit=6]');

                    if ($history_output != '') {
                        ?>
                            <div class="header" style="font-size: 20px;font-weight: 300;margin: 5px;">
                                Ваш бонусный счет: <b><?php echo do_shortcode('[WC_Loy_Get_Current_User_Points]'); ?></b>
                            </div>
                            <div class="header-buttons" style="border-bottom: 1px solid #dbdbdb;padding-bottom: 10px;">
                                <div class="header-button-wrapper" style="">
                                    <a class="button" href="/bonusnaya-sistema">О бонусной системе</a>
                                </div>
                                <!--div class="header-button-wrapper">
                                    <a class="button" href="#">На что потратить</a>
                                </div-->
                                <div style="clear: both;">

                                </div>
                            </div>
                        <?php
                        echo $history_output;
                        ?>
                            <div class="footer">
                                <a class="button button-gray" href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>rewards#wc-loy-history">Показать полностью</a>
                            </div>
                        <?php
                    }else {
                        echo '<li class="info">У вас ещё нет бонусов</li>';
                    }
                }else{
                    echo '<li class="info">Для того чтобы копить бонусы и получать скидки, необходимо <a href="/wp-login.php?action=register">зарегистрироваться</a></li>';
                }


            ?>
        </ul>
    </div>
<?php
}


// Значек аккаунта около баллов
add_action('storefront_header', 'account_after_points', 42);
function account_after_points() {
?>
    <div class="user-account-toggle-button">
        <?php get_account_menu(); ?>
    </div>
<?php
}