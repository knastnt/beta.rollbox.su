<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2019
 * Time: 15:18
 */

//Поле в свойствах купона
add_action( 'woocommerce_coupon_options', array('Coupons', 'only_for_user_id_input'), 10, 0 );
//Сохранение значения поля в свойствах купона
add_action( 'woocommerce_coupon_options_save', array('Coupons', 'save_conly_for_user_id_input'));
//Проверка значения поня при применении купона
add_action( 'woocommerce_coupon_is_valid', array('Coupons', 'check_user_id_when_coupon_apply'), 10, 3);

//Начисление бонусов при выполнении заказа
add_action( 'woocommerce_order_status_completed', array( 'Coupons', 'add_bonus_when_order_complete' ) );
//Начисление бонусов за регистрацию
add_action( 'user_register', array( 'Coupons', 'add_bonus_when_user_registred') );

class Coupons
{

    static function only_for_user_id_input() {
        woocommerce_wp_text_input( array(
            'id' => 'only_for_user_id',
            'type' => 'number',
            'label' => 'Только для пользователя с ID =',
            'description' => 'Укажите ID пользователя. Только он сможет использовать этот купон. 0 - ограничений нет'
        ) );
    }

    static function save_conly_for_user_id_input( $post_id ) {
        $only_for_user_id = isset( $_POST['only_for_user_id'] ) ? intval( $_POST['only_for_user_id'] ) : 0;
        update_post_meta( $post_id, 'only_for_user_id', $only_for_user_id );
    }

    static function check_user_id_when_coupon_apply( $true_p, $coupon_p, $this_p ) {
        $user_id = get_post_meta( $coupon_p->get_id(), 'only_for_user_id' );
        $user_id = isset( $user_id[0] ) ? intval($user_id[0]) : 0;

        if ($user_id > 0) {
            if ($user_id != get_current_user_id()) {
                throw new Exception( sprintf( 'Купон "%s" Вам не доступен!',  $coupon_p->get_code() ), 105 );
            }
        }

        return $true_p;
    }

    //Начисление бонусов при выполнении заказа
    static function add_bonus_when_order_complete( $order_ID ) {

        //Получаем ID пользователя
        $user_id = get_current_user_id();
        // Если юзер не залогинен, то ничего не делаем
        if ($user_id == 0) return;

        //Получаем значение процента возврата от суммы ордера
        $percentOfPointReturning = woocommerceLoyalty_Options::instance()->getPercentOfPointReturning();
        //Если 0, то ничего не делаем
        if ($percentOfPointReturning == 0) return;

        //Получаем ордер
        $order = wc_get_order( $order_ID );
        //Если такого ордера нет, то ничего не делаем
        if (!$order) return;

        //Получаем количество бонусов для возврата
        $pointsToReturn = intval($order->get_total() * $percentOfPointReturning * 0.01);
        //Если 0, то ничего не делаем
        if ($pointsToReturn == 0) return;


        //Получаем метаданные пользователя, относящиеся к плагину
        $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

        //Проверка, начислялись ли бонусы за этот заказ
        $origincode = 'fromOrder_' . $order_ID; //Генерируем значение источника и проверяем нет ли такого у пользователя
        $isOriginCodeExistInHistory = $wc_loy_usermeta->isOriginCodeExistInHistory($origincode);
        //Если бонусы за это уже начислялись - то ничего не делаем
        if ($isOriginCodeExistInHistory == true) return;



        //Если все тесты пройдены - начисляем бонусы
        $wc_loy_usermeta->addPoints($pointsToReturn, "Начисление за заказ №$order_ID", $origincode);
    }

    //Начисление бонусов за регистрацию
    static function add_bonus_when_user_registred( $user_id ) {

        //Получаем количество бонусов для зачисления при регистрации
        $pointsForRegistration = woocommerceLoyalty_Options::instance()->getPointsForRegistration();
        //Если 0, то ничего не делаем
        if ($pointsForRegistration == 0) return;


        //Получаем метаданные пользователя, относящиеся к плагину
        $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

        //Проверка, начислялись ли бонусы за этот заказ
        $origincode = 'fromRegistration'; //Генерируем значение источника и проверяем нет ли такого у пользователя
        $isOriginCodeExistInHistory = $wc_loy_usermeta->isOriginCodeExistInHistory($origincode);
        //Если бонусы за это уже начислялись - то ничего не делаем
        if ($isOriginCodeExistInHistory == true) return;



        //Если все тесты пройдены - начисляем бонусы
        $wc_loy_usermeta->addPoints($pointsForRegistration, "Начисление за регистрацию", $origincode);
    }
}