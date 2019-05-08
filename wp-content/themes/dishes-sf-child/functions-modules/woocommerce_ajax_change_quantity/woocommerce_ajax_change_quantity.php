<?php
/*
к этому функционалу относится файл
ПАПКА_ТЕМЫ\woocommerce\global\quantity-input.php

в нем задается создание кнопок +/-
*/

//подмена core js в woocommerce для ajax автообновления корзины при изменении количества товаров
add_action( 'wp_enqueue_scripts', 'load_theme_scripts' );

    function load_theme_scripts() {
        global $wp_scripts; 
        $wp_scripts->registered[ 'wc-cart' ]->src = get_stylesheet_directory_uri() . '/functions-modules/woocommerce_ajax_change_quantity/js/cart.js';
    }


//подключаем скрипт для работы кнопок изменения количества товара
//для отображения кнопок нужно подменить файл yourtheme/woocommerce/global/quantity-input.php в своей теме
add_action( 'wp_enqueue_scripts', 'true_include_myscript' );
function true_include_myscript() {
 	wp_enqueue_script( 'dishes-sf-child-func', get_stylesheet_directory_uri() . '/functions-modules/woocommerce_ajax_change_quantity/js/dishes-sf-child-func.js' );
}


 ?>