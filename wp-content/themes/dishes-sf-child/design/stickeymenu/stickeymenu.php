<?php

//подключаем js с функцией прилипания
add_action( 'wp_enqueue_scripts', function (){
    wp_enqueue_script( 'stickeyscript', get_stylesheet_directory_uri() . '/design/stickeymenu/stickeymenu.js');
});

add_action('storefront_header', 'stickey_menu_wrapper');

function stickey_menu_wrapper()
{
    ?>

    <div id="stickey_menu_wrapper" style="height: 50px;background-color: red;width: 100%;position: fixed;top: 0;z-index: 10;left: 0;">
        <div id="site-header-cart-stickey-wrapper">

        </div>
    </div>
    <?php
}
