<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 04.02.2019
 * Time: 17:36
 */

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//отодвинем закрывающий тэг

add_action('storefront_header', 'storefront_header_container_close', 45);
add_action( 'storefront_header', 'replace_close_tag', 10 );
function replace_close_tag()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_header_container_close', 41);
}

// переместить корзину рядом с поиском
add_action('storefront_header', 'storefront_header_cart', 41);
add_action( 'storefront_header', 'replace_cart', 10 );
function replace_cart()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_header_cart', 60);
}

// переместить навигацию под поиск
add_action('storefront_header', 'storefront_primary_navigation', 42);
add_action( 'storefront_header', 'replace_nav', 10 );
function replace_nav()
{
    /*if( $priority = has_action('storefront_header', 'storefront_header_cart') ){
        echo "У хука init есть функция storefront_header_cart с приоритетом ". $priority;
    }else{
        echo 'нету';
    }*/
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper', 42);
    remove_action('storefront_header', 'storefront_primary_navigation', 50);
    remove_action('storefront_header', 'storefront_primary_navigation_wrapper_close', 68);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

            <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/header-cart/header-cart.css" />

            <div id="site-header-cart-head-wrapper">
                <ul id="site-header-cart" class="site-header-cart menu">
                    <li class="<?php echo esc_attr( $class ); ?>">
                        <?php storefront_cart_link(); ?>
                    </li>
                    <li>
                        <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                    </li>
                </ul>
                <div style="clear: both"></div>
            </div>

            <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/header-cart/header-cart.js"></script>

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