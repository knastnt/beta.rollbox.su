<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2019
 * Time: 15:18
 */


add_action( 'woocommerce_coupon_options', array('Coupons', 'only_for_user_id_input'), 10, 0 );
add_action( 'woocommerce_coupon_options_save', array('Coupons', 'save_conly_for_user_id_input'));

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
}