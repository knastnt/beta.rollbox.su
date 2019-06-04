<?php


/*
Убираем ненужные поля при оформлении заказа
https://shopiweb.ru/internet-magazin-wordpress/kak-uprostit-formu-oformleniya-tovarov-woocommerce/
*/
add_filter( 'woocommerce_checkout_fields' , 'custom_override_checkout_fields' );

function custom_override_checkout_fields( $fields ) {
    //unset($fields['billing']['billing_first_name']); //первое имя
    unset($fields['billing']['billing_last_name']); //второе имя
    unset($fields['billing']['billing_company']); //название компании
    //unset($fields['billing']['billing_address_1']); //адрес 1
    unset($fields['billing']['billing_address_2']); //адрес 2
    unset($fields['billing']['billing_city']); //улица
    unset($fields['billing']['billing_postcode']); //индекс
    //unset($fields['billing']['billing_country']); //страна нельзя убирать, т.к. будет требовать адрес
    unset($fields['billing']['billing_state']); //штат
    //unset($fields['billing']['billing_phone']); //телефон
    //unset($fields['order']['order_comments']); //добавить комментарий
    //unset($fields['billing']['billing_email']); //email
    //unset($fields['account']['account_username']); //логин
    //unset($fields[‘account’][‘account_password’]); //пароль
    //unset($fields['account']['account_password-2']); //подтверждение пароля

    //Не обязателен E-mail если человек не залогинен
    $fields['billing']['billing_email']['required'] = false;

    //Если залогинен, скрываем поле ввода  E-mail
    if ( is_user_logged_in() )
        unset($fields['billing']['billing_email']);

    return $fields;
}



//Переименовываем некоторый текст
add_filter( 'gettext' , 'rename_some_fields', 10, 3 );
function rename_some_fields( $translation, $text, $domain ) {
    if ($text == 'House number and street name' && $domain == 'woocommerce') {
        $translation = 'Улица, Номер дома и Квартира';
    }
    if ($text == 'Notes about your order, e.g. special notes for delivery.' && $domain == 'woocommerce') {
        $translation = 'Примечания к вашему заказу, например, особые пожелания.';
    }
    if ($text == 'Billing &amp; Shipping' && $domain == 'woocommerce') {
        $translation = 'Основная информация';
    }
    return $translation;
}