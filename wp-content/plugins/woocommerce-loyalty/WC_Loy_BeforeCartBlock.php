<?php


add_action( 'woocommerce_before_cart', array( 'WC_Loy_BeforeCartBlock', 'wc_loy_before_cart_block'), 20 );

class WC_Loy_BeforeCartBlock
{
    static function wc_loy_before_cart_block()
    {
        do_shortcode('[WC_Loy_My_Coupons title="Вы можете использовать свои купоны чтобы получить скидку к заказу" link_to_exchange="/my-account/rewards/"]');
    }
}