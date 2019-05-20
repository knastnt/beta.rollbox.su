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

    $labels = []; //Декларирую массив. Чтобы не глючил implode

    //Узнаем сколько дней товар считается новым
    $new_product_duration = isset(get_option( 'rollbox_options_array' ) ['new_product_duration']) ? get_option( 'rollbox_options_array' ) ['new_product_duration'] : 14;

    //Определяем новый ли товар
    $created = $product->get_date_created();
    $now = new DateTime("now");
    $diff_days = date_diff($now, $created)->days;
    if ($diff_days < $new_product_duration) {
        $labels[] = '<div class="new onsale">Новинка!</div>';
    }

    //Определяем есть ли скидка у товара
    if ( $product->is_on_sale() ){
        $labels[] = '<div class="onsale">Распродажа!</div>';
    }

    //Оборачиваем в блок div
    $result = '<div class="labels">' . implode("<br>", $labels) . '</div>';

    echo $result;
}