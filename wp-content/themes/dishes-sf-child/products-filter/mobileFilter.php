<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 16.08.2019
 * Time: 14:44
 */


//////////////////////////////////////////////////////////////////////////
// правильный способ подключить скрипты
add_action( 'wp_enqueue_scripts', 'true_include_mobileFilter_script' );
function true_include_mobileFilter_script() {
    wp_enqueue_script( 'script-mobileFilter', get_stylesheet_directory_uri() . '/products-filter/mobileFilter.js' );
}
//////////////////////////////////////////////////////////////////////////


add_action( 'storefront_sidebar', 'addMobileFilterButton', 20 );

function addMobileFilterButton() {

    ?>
    <div id="fixedFilterBlock"><span>Фильтры и сортировка</span></div>
    <?php

}