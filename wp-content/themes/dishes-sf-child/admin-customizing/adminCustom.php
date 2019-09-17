<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 17.09.2019
 * Time: 9:39
 */


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
Разрешаем редактирование заказа в следующих статусах
https://ittricks.ru/programmirovanie/cms/wordpress/woocommerce/1292/razreshit-redaktirovanie-zakaza-pri
*/
add_filter('wc_order_is_editable', 'my_wc_order_is_editable', 10, 2);
function my_wc_order_is_editable($res, $order) {
    if(in_array($order->get_status(), array('processing', 'cooking'))) {
        return true;
    }
    return $res;
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////






////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
меняю ссылку у продукта в заказе в админке
*/
add_filter('woocommerce_before_order_item_line_item_html', 'urlChangeProdAdm', 20, 3);
function urlChangeProdAdm($item_id, $item, $order) {
    $url_edit = '';
    $url = '';
    try{
        $url_edit = admin_url( 'post.php?post=' . $item->get_product_id() . '&action=edit' );
        $url = $item->get_product()->get_permalink();
    }catch (Exception $e){

    }
    //echo '<p class="hidden_url_product"><a class="search" href="' . $url_edit . '">search</a><a class="replace" href="' . $url . '">replace</a></p>';
    ?>
    <script>
        jQuery(document).ready(function() {
            //jQuery('#login .pw-checkbox').prop('checked', true);
            //jQuery('table.woocommerce_order_items a.wc-order-item-name[href=\"' . $url_edit . '\"]').attr('href',\"" . $url . "\");
            var s = jQuery('table.woocommerce_order_items a.wc-order-item-name[href="<?php echo $url_edit; ?>"]');
            s.attr('href',"<?php echo $url; ?>");
            s.attr('target',"_blank");
        });
    </script>
    <?php
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
создаю ссылку у продукта в превью заказа в админке
*/
add_filter('woocommerce_admin_html_order_preview_item_class', 'urlAddProdPrevAdm', 20, 3);
function urlAddProdPrevAdm($emptyVar, $item, $order) {
    $product = $item->get_product();
    if ($product==false || $product == null) return '';
    $slug = $product->get_slug();
    if ($slug==false || $slug == '') return '';

    return 'slug--' . $product->get_slug();
}

add_action('admin_enqueue_scripts', 'urlAddProdPrevAdmJScript');
function urlAddProdPrevAdmJScript($hook){
    if ( 'edit.php' != $hook ) {return;}
    if (!isset($_GET['post_type']) || $_GET['post_type'] != 'shop_order') {return;}
    wp_enqueue_script( 'productPreviewLinkCreator', get_stylesheet_directory_uri() . '/admin-customizing/productPreviewLinkCreator.js' );
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


