<?php
/**
 * кастомные надписи к продуктам.
 *
 */


//// Убираем стандартный лэйбл (т.к. его нужно обернуть в общий div, а так не получается).
add_filter( 'woocommerce_sale_flash', 'remove_default_onsale', 10, 1 );
function remove_default_onsale( $result ) {
    return '';
}

///// Добавляем кастомные лэйблы. В том числе и стандартный лэйбл Распродажа
// в списке товаров
add_action( 'woocommerce_before_shop_loop_item_title', 'add_custom_labels', 11 );
// на странице товара
add_action( 'woocommerce_before_single_product_summary', 'add_custom_labels', 11 );
function add_custom_labels() {

    global $post, $product;

    //Определяем есть ли скидка у товара
    $onsale = '';
    if ( $product->is_on_sale() ){
        $onsale = '<div class="onsale">Распродажа!</div>';
    }

    //Определяем новый ли товар
    $isnew = '';
    $created = $product->get_date_created();
    $now = new DateTime("now");
    $diff_days = date_diff($now, $created)->days;
    if ($diff_days < 14) {
        $isnew = '<div class="new onsale">Новинка!</div>';
    }

    //Оборачиваем в блок div
    $result = '<div class="labels">' . $isnew . $onsale . '</div>';

    echo $result;
}