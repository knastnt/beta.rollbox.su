<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 04.02.2019
 * Time: 17:36
 */

// переместить корзину рядом с поиском
add_action('storefront_header', 'storefront_header_cart', 40);
add_action( 'storefront_header', 'replace_cart', 41 );
function replace_cart()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_header_cart', 60);
}


if ( ! function_exists( 'storefront_cart_link' ) ) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since  1.0.0
     */
    function storefront_cart_link()
    {
        ?>
        <!--a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'storefront'); ?>">
            <?php /* translators: %d: number of items in cart */ ?>
            <?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?> <span class="count"><?php echo wp_kses_data(sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'storefront'), WC()->cart->get_cart_contents_count())); ?></span>
        </a-->

        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/header-cart/header-cart.css" />

        <button type="button" data-toggle="dropdown" data-loading-text="Loading..."
                class="btn dropdown-toggle dropdown-cart">
            <i class="ion-android-cart"></i>
            <span id="cart-total"><span class="number-cart">0</span>$0.00<i class="ion-chevron-down"></i></span>
        </button>
        <?php
    }

}