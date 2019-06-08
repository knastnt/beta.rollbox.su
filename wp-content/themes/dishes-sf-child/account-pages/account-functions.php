<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Убираем лишние пункты меню в личном кабинете
add_filter ( 'woocommerce_account_menu_items', 'misha_remove_my_account_links' );
function misha_remove_my_account_links( $menu_links ){

    unset( $menu_links['edit-address'] ); // Addresses
    //unset( $menu_links['dashboard'] ); // Dashboard
    //unset( $menu_links['payment-methods'] ); // Payment Methods
    //unset( $menu_links['orders'] ); // Orders
    unset( $menu_links['downloads'] ); // Downloads
    //unset( $menu_links['edit-account'] ); // Account details
    //unset( $menu_links['customer-logout'] ); // Logout

    return $menu_links;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Изменим имена пунктов меню в личном кабинете
function my_woocommerce_account_menu_items($items) {
    $items['dashboard'] = "Начальная страница";
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'my_woocommerce_account_menu_items', 10 );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Фамилия в Деталях учетной записи будет не обязательна
// переменная $required_fields в файле wp-content/plugins/woocommerce/includes/class-wc-form-handler.php
function last_name_not_requered($items) {
    unset($items['account_last_name']);
    unset($items['account_display_name']);
    return $items;
}
add_filter( 'woocommerce_save_account_details_required_fields', 'last_name_not_requered' );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Обрабатываем сохранение добавленного в Детали учетной записи телефон
//wp-content/themes/dishes-sf-child/woocommerce/myaccount/form-edit-account.php

//Для начала сделаем поле телефон - обязательным. Тут эе выполним проверку правильности ввода, т.к. если будет создан error, то сохранения не будет
function billing_phone_requered($items) {
    $items['billing_phone'] = 'Телефон';

    //Проверка правильности ввода телефона
    //Не проверяем если пусто, т.к. на пустоту проверка будет выполнена после этого экшена
    //Получаем телефон из $_POST
    $billing_phone   = ! empty( $_POST['billing_phone'] ) ? wc_clean( wp_unslash( $_POST['billing_phone'] ) ) : '';
    if ($billing_phone != '') {
        //Проверка. Просто нужно выполнить
        // wc_add_notice( __( 'Номер телефона введен неверно', 'woocommerce' ), 'error' );
        //в случае неудачи.

        /*if ( !true ) {
            wc_add_notice( __( 'Номер телефона введен неверно', 'woocommerce' ), 'error' );
        }*/
        //Лучше сделаем это хуком, чтобы из validate_billing_phone_number.php могло работать
        do_action( 'edit_account_validate_billing_phone' );
    }
    return $items;
}
add_filter( 'woocommerce_save_account_details_required_fields', 'billing_phone_requered' );

//Логика сохранения из взята файла
//wp-content/plugins/woocommerce/includes/class-wc-form-handler.php
function saving_billing_phone( $user_id ) {
    //wp_update_user( $user ); //х.з. что это

    // Update customer object to keep data in sync.
    $customer = new WC_Customer( $user_id );
    $billing_phone   = ! empty( $_POST['billing_phone'] ) ? wc_clean( wp_unslash( $_POST['billing_phone'] ) ) : '';
    if ( $customer ) {
        // Keep billing data in sync if data changed.
        if ( $billing_phone !== $customer->get_billing_phone() ) {
            $customer->set_billing_phone($billing_phone);
        }
        $customer->save();
    }
}
add_action( 'woocommerce_save_account_details', 'saving_billing_phone' );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////