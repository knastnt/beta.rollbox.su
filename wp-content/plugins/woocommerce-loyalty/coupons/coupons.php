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
}