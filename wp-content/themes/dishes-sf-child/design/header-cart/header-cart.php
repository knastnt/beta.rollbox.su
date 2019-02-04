<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 04.02.2019
 * Time: 17:36
 */

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
            <ul id="site-header-cart" class="site-header-cart menu">
                <li class="<?php echo esc_attr( $class ); ?>"-->
                    <?php storefront_cart_link(); ?>
                </li>
                <!--li>
                    <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                </li-->
            </ul>
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
        <!--a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php esc_attr_e('View your shopping cart', 'storefront'); ?>">
            <?php /* translators: %d: number of items in cart */ ?>
            <?php echo wp_kses_post(WC()->cart->get_cart_subtotal()); ?> <span class="count"><?php echo wp_kses_data(sprintf(_n('%d item', '%d items', WC()->cart->get_cart_contents_count(), 'storefront'), WC()->cart->get_cart_contents_count())); ?></span>
        </a-->

        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/header-cart/header-cart.css" />



        <div id="cart" class="btn-group btn-block">

            <button type="button" data-toggle="dropdown" data-loading-text="Loading..."
                    class="btn dropdown-toggle dropdown-cart">
                <i class="ion-android-cart"></i>
                <span id="cart-total"><span class="number-cart">0</span><span class="woocommerce-Price-currencySymbol">₽</span>0.00<i class="ion-chevron-down"></i></span>
            </button>

            <ul class="dropdown-menu pull-right"><li class="has-scroll">
                    <table class="table">
                        <tbody><tr>
                            <td class="text-center cart-image"> <a href="http://demo.towerthemes.com/tt_boxstore/index.php?route=product/product&amp;product_id=30"><img class="cart-image" src="http://demo.towerthemes.com/tt_boxstore/image/cache/catalog/product1/2-100x100.jpg" alt="Aliquam Consequat Eget Non Arc..." title="Aliquam Consequat Eget Non Arc..."></a> </td>
                            <td class="text-left info-item"><a href="http://demo.towerthemes.com/tt_boxstore/index.php?route=product/product&amp;product_id=30">Aliquam Consequat Eget Non Arc...</a>              <br>
                                - <small>Select Blue</small>                         			<p class="cart-quantity">Qty:2</p>
                                <p class="cart-price">$240.00</p>
                            </td>
                            <td class="text-center cart-close"><button type="button" onclick="cart.remove('0');" title="Remove" class="btn btn-danger btn-xs"><i class="ion-close-round"></i></button></td>
                        </tr>
                        </tbody></table>
                </li><li>
                    <table class="table cart-totals">
                        <tbody><tr>
                            <td class="text-left">Sub-Total :</td>
                            <td class="text-right">$240.00</td>
                        </tr>
                        <tr>
                            <td class="text-left">Total :</td>
                            <td class="text-right">$240.00</td>
                        </tr>
                        </tbody></table>
                    <p class="text-center cart-button">
                        <a class="view-cart" href="http://demo.towerthemes.com/tt_boxstore/index.php?route=checkout/cart">View Cart</a>
                        <a class="checkout-cart" href="http://demo.towerthemes.com/tt_boxstore/index.php?route=checkout/checkout">Checkout</a>
                    </p>
                </li></ul>
        </div>


        <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/header-cart/header-cart.js"></script>
        <?php
    }

}