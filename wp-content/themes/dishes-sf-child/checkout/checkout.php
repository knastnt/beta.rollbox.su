<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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


    //Убираем поле Адрес, если самовывоз
    $chosen_methods = WC()->session->get( 'chosen_shipping_methods' );
    if (preg_match('/^local_pickup:\d+$/', $chosen_methods[0])) {
        unset($fields['billing']['billing_address_1']);
    }


    return $fields;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Переименовываем (изменяем, подменяем) некоторый текст
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
    if ($text == 'Billing address' && $domain == 'woocommerce') {
        $translation = 'Контакты клиента';
    }
    if ($text == 'Subtotal' && $domain == 'woocommerce') {
        $translation = 'Сумма в корзине';
    }
    return $translation;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Не показываем некоторые сообщения
function remove_some_notices($content){

    // Удаляем следующие сообщения
    if ($content == 'Корзина обновлена.') return '';
    if ($content == "У вас есть купон? <a href=\"#\" class=\"showcoupon\">Нажмите здесь для введения кода</a>") return ''; //пришлось редактировать шаблон notices\notice.php

    return $content;
}
add_filter( 'woocommerce_add_message', 'remove_some_notices' );
add_filter( 'woocommerce_add_notice', 'remove_some_notices' ); //пришлось редактировать шаблон notices\notice.php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////







////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Редирект в cart если checkout вызван не со страницы cart
add_action( 'woocommerce_before_checkout_form', 'checkout_redirect_to_cart' );
function checkout_redirect_to_cart(){
    if (!isset($_SERVER['HTTP_REFERER'])) return; //Если referer не передан, то и ничего не делаем
    $ref = $_SERVER['HTTP_REFERER'];
    if ($ref == '' || $ref == null) return; //Если referer не передан, то и ничего не делаем
    $ref_path = parse_url($ref, PHP_URL_PATH);
    $cart_url = wc_get_cart_url();
    $cart_url_path = parse_url($cart_url, PHP_URL_PATH);

    if (strcasecmp($ref_path, $cart_url_path) == 0) {
        // равны при сравнении без учета регистра
    }else{
        //Не равны. Значит переход не из cart. Значит делаем редирект в cart
        wp_redirect( $cart_url );
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Добавляем кнопочку Назад перед Подтвердить заказ
add_action( 'woocommerce_review_order_before_submit', 'add_checkout_back_btn' );
function add_checkout_back_btn(){
    //echo '<button type="submit" name="woocommerce_checkout_place_order" id="place_order" value="Назад" data-value="Назад" class="button">Назад</button>';
    echo '<a href="' . wc_get_cart_url() . '" class="button">Назад</a>';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

