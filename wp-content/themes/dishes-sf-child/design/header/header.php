<?php

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
        <li><button class="btn btn-link btn-block language-select item-selected" type="button" name="en-gb"><img src="catalog/language/en-gb/en-gb.png" alt="English" title="English">English</button></li>
        <li><button class="btn btn-link btn-block language-select" type="button" name="fr-gb"><img src="catalog/language/fr-gb/fr-gb.png" alt="French" title="French">French</button></li>
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
    return false;
}
