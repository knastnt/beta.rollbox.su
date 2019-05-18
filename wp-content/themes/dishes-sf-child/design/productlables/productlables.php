<?php
/**
 * кастомные надписи к продуктам.
 *
 */
/*// в списке товаров
add_action( 'woocommerce_before_shop_loop_item_title', 'productlables_show_product_loop_lables', 11 );
// на странице товара
add_action( 'woocommerce_before_single_product_summary', 'productlables_show_product_lables', 11 );


if ( ! function_exists( 'productlables_show_product_loop_lables' ) ) {

    /**
     * Get the flash for the loop.
     *
    function productlables_show_product_loop_lables() {
        template();
    }
}


if ( ! function_exists( 'productlables_show_product_lables' ) ) {

    /**
     * Output the product flash.
     *
    function productlables_show_product_lables() {
        template();
    }
}


function template()  {

    global $post, $product;

    $created = $product->get_date_created();
    $now = new DateTime("now");
    $diff_days = date_diff($now, $created)->days;
    if ($diff_days < 14) {

        echo apply_filters( 'woocommerce_sale_flash', '<span class="new">Новинка!</span>', $post, $product );

    }

}*/

add_filter( 'woocommerce_sale_flash', 'custom_labels', 10, 3 );

function custom_labels( $result, $post, $product ) {

    //У нас уже готов лэйбл распродажи. Если существует. Сохраним его в переменную
    $onsale = $result;

    //Определяем новый ли товар
    $isnew = '';
    $created = $product->get_date_created();
    $now = new DateTime("now");
    $diff_days = date_diff($now, $created)->days;
    if ($diff_days < 14) {
        $isnew = '<span class="new onsale">Новинка!</span>';
    }

    //Оборачиваем в блок div
    $result = '<div class="labels">' . $isnew . $onsale . '</div>';

    return $result;
}