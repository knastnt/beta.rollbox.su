<?php


add_action( 'woocommerce_before_cart', array( 'WC_Loy_BeforeCartBlock', 'wc_loy_before_cart_block'), 20 );

class WC_Loy_BeforeCartBlock
{
    static function wc_loy_before_cart_block()
    {
        wp_register_script('wc_loy_script', plugins_url('/js/wc_loy_script.js', __FILE__), array('jquery'), '1.4.1', true);
        wp_enqueue_script('wc_loy_script');

        do_shortcode('[WC_Loy_My_Coupons title="Вы можете использовать свои купоны чтобы получить скидку к заказу" link_to_exchange="/my-account/rewards/" make_disabled_applied_in_cart_coupons=true]');
    }
}