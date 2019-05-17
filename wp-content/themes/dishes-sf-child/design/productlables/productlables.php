<?php
/**
 * кастомные надписи к продуктам.
 *
 */
// в списке товаров
add_action( 'woocommerce_before_shop_loop_item_title', 'productlables_show_product_loop_lables', 11 );
// на странице товара
add_action( 'woocommerce_before_single_product_summary', 'productlables_show_product_lables', 11 );


if ( ! function_exists( 'productlables_show_product_loop_lables' ) ) {

    /**
     * Get the flash for the loop.
     */
    function productlables_show_product_loop_lables() {
        template();
    }
}


if ( ! function_exists( 'productlables_show_product_lables' ) ) {

    /**
     * Output the product flash.
     */
    function productlables_show_product_lables() {
        template();
    }
}


function template()  {

    global $post, $product;


    if ( $product->is_on_sale() ) {

        echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product );

    }

}