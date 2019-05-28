<?php

// мобильное меню
require_once( get_stylesheet_directory() . '/design/flexmobilemenu/flexmobilemenu.php' );

// шапка
require_once( get_stylesheet_directory() . '/design/header/header.php' );

// корзина в шапке
require_once( get_stylesheet_directory() . '/design/header-cart/header-cart.php' );

// Прилипающее меню
require_once( get_stylesheet_directory() . '/design/stickeymenu/stickeymenu.php' );



//подключаем js с общими функциями
add_action( 'wp_enqueue_scripts', 'true_include_commonscript' );
function true_include_commonscript() {
    wp_enqueue_script( 'commonscript', get_stylesheet_directory_uri() . '/design/common.js', array('jquery'), null, true );
}