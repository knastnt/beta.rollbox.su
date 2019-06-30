<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 04.02.2019
 * Time: 17:36
 */



//////////////////////////////////////////////////////////////////////////
/// подключение стилей
///
// правильный способ подключить стили и скрипты
add_action( 'wp_enqueue_scripts', 'header_cart_include_styles', 30 );
//add_action('wp_print_styles', 'true_include_styles'); // можно использовать этот хук он более поздний
function header_cart_include_styles() {
    wp_enqueue_style( 'header-cart-style', get_stylesheet_directory_uri() . '/design/header-cart/header-cart.css' );
}
add_action( 'wp_enqueue_scripts', 'header_cart_include_scripts' );
function header_cart_include_scripts() {
    wp_enqueue_script( 'header-cart-script', get_stylesheet_directory_uri() . '/design/header-cart/header-cart.js' );
}
//////////////////////////////////////////////////////////////////////////


if ( ! function_exists( 'storefront_header_cart' ) ) {
    /**
     * Display Header Cart
     *
     * @since  1.0.0
     * @uses  storefront_is_woocommerce_activated() check if WooCommerce is activated
     * @return void
     */
    function storefront_header_cart() {
        wp_deregister_script( 'storefront-header-cart' );
        if ( storefront_is_woocommerce_activated() ) {
            if ( is_cart() ) {
                $class = 'current-menu-item';
            } else {
                $class = '';
            }
            ?>


            <div id="site-header-cart-head-wrapper">
                <ul id="site-header-cart" class="site-header-cart menu">
                    <li class="<?php echo esc_attr( $class ); ?>">
                        <?php storefront_cart_link(); ?>
                    </li>
                    <li>
                        <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                    </li>
                </ul>
            </div>


            <?php
        }
    }
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'storefront'); ?>">
            <i class="ion-android-cart"></i>
            <span id="cart-total"><span class="number-cart"><?php echo WC()->cart->get_cart_contents_count(); ?></span><?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?><i class="ion-chevron-down"></i></span>
        </a>
        <?php
    }

}