<?php


function is_today_sanitary_day() {
    // Достаем санитарный день из настроек
    $sanitaryDay = explode(".", get_option( 'rollbox_options_array' ) ['sanitary_day']);
    $nowDay = explode(".", current_time('Y.m.d'));


    foreach ($nowDay as $key => $value){
        if((int)$value != (int)$sanitaryDay[$key]) return false;
    }
    return true;
}

/* Не давать оформить заказ в санитарный день */
add_action( 'woocommerce_checkout_process', 'custom_checkout_question_field_validate' );
function custom_checkout_question_field_validate() {
    if ( is_today_sanitary_day() ) {
        wc_add_notice('К сожалению мы не можем принять этот заказ. <b>Сегодня санитарный день.</b>', 'error');
    }
}
