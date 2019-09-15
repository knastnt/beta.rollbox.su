<?php


// страница настроек rollbox
require_once( plugin_dir_path(__FILE__ ) . '/options/options-page.php' );

// изменение дизайна
require_once( get_stylesheet_directory() . '/design/design.php' );

// логика для санитарного дня
require_once( get_stylesheet_directory() . '/functions-modules/sanitary_day_notices.php' );

// превью заказа при нажатии на глаз
require_once( get_stylesheet_directory() . '/functions-modules/woocommerce_admin_order_preview-functions.php' );

// убираются лишние способы доставки в зависимости от цены
require_once( get_stylesheet_directory() . '/functions-modules/woocommerce_clear_shipping_methods-functions.php' );

// добавление +/- для количества товаров в корзине и автообновление
require_once( get_stylesheet_directory() . '/functions-modules/woocommerce_ajax_change_quantity/woocommerce_ajax_change_quantity.php' );

// добавление произвольного поля к товарам
require_once( get_stylesheet_directory() . '/functions-modules/custom-meta-fields/custom-meta-fields.php' );


//кастомные надписи к продуктам.
require_once( get_stylesheet_directory() . '/design/productlables/productlables.php' );

//настройки личного кабинета
require_once( get_stylesheet_directory() . '/account-pages/account-functions.php' );


// Проверка ввода телефона
require_once( get_stylesheet_directory() . '/functions-modules/validate_billing_phone_number/validate_billing_phone_number.php' );

// Настройки оформления заказа
require_once( get_stylesheet_directory() . '/checkout/checkout.php' );

//Шорткод карты
require_once( get_stylesheet_directory() . '/functions-modules/map/map2gis.php' );

//Переработанный шорткод инстаграма
require_once( get_stylesheet_directory() . '/homepage/instagram.php' );

//Меняем url у хлебных крошек
require_once( get_stylesheet_directory() . '/products-filter/changeBreadcrumbs.php' );

//Меняем url у ингридиентов из состава
require_once( get_stylesheet_directory() . '/products-filter/changePaConsist.php' );

//Добавляем плавающую кнопку применить фильтр
require_once( get_stylesheet_directory() . '/products-filter/floatApplyButton.php' );

//Фильтр товаров для мобильных устройств
require_once( get_stylesheet_directory() . '/products-filter/mobileFilter.php' );

//Максимальное количество автоматически создаваемых вариаций woocommerce
//Если сервер не будет пропускать, то, возможно, решение тут: https://toster.ru/q/165355
define( 'WC_MAX_LINKED_VARIATIONS', 1000 );


/*24 товара на странице*/
add_filter( 'loop_shop_per_page', function ( $cols ) {
    // $cols contains the current number of products per page based on the value stored on Options -> Reading
    // Return the number of products you wanna show per page.
    return 24;
}, 20 );


/*похожих товаров 4 штуки*/
add_filter( 'woocommerce_output_related_products_args', 'set_ralated_products_count', 20 );
function set_ralated_products_count( $args ) {
    $args['posts_per_page'] = 5; // количество "Похожих товаров"
    $args['columns'] = 5; // количество колонок
    return $args;
};


/*Регистрируем панель для виджетов на главной странице справа*/
register_sidebar(array( 'name' => 'Сайдбар справа на главной странице', 'id' => 'homepage-right-sidebar', 'before_widget' => '<div class="homepage-r-sdbar-widget widget">', 'after_widget' => '</div>', 'before_title' => '<span class="homepage-r-sdbar-widget widget-title">', 'after_title' => '</span>', ));


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
  Функция для исправления бага об ограничении применения купона.
  При обмене баллов на купон я сделал привязку к email пользователя, чтобы только он мог использовать этот купон. И несмотря на это, купон могли использовать все.
  Это свежий баг

  WooCommerce email restriction for coupons does not work. This fix corrects it.
  Include this code snippet in your theme or plugin.

  https://gist.github.com/riotxoa/f4f1a895052c195394ba4841085a0e83
*/
add_filter( 'woocommerce_coupon_is_valid', 'wc_riotxoa_coupon_is_valid', 10, 2 );
function wc_riotxoa_coupon_is_valid( $result, $coupon ) {
    $user = wp_get_current_user();

    $restricted_emails = $coupon->get_email_restrictions();

    if (count($restricted_emails)>0) {
        return (in_array($user->user_email, $restricted_emails) ? $result : false);
    }else{
        return $result;
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








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
Отсоединяем знак рубля от суммы пробелом
*/
add_filter('woocommerce_currency_symbol', 'woocommerce_currency_symbol_add_space');
function woocommerce_currency_symbol_add_space($currency_symbol) {
    return $currency_symbol . '&nbsp;';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
меняю ссылку у продукта в заказе в админке
*/
add_filter('woocommerce_before_order_item_line_item_html', 'urlChangeProdAdm', 20, 3);
function urlChangeProdAdm($item_id, $item, $order) {
    $url = '';
    try{
        $url = $item->get_product()->get_permalink();
    }catch (Exception $e){

    }
    echo '<div class="hidden_url_product">' . $url . '</div>';
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////








////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
Изменить требование сложного пароля при регистрации
*/
function worldless_custom_script() {
    ?>
    <script>
        jQuery(document).ready(function() {
            jQuery('#login .pw-checkbox').prop('checked', true);
            jQuery('#login .description').hide();
        });
    </script>
    <?php
}
add_action('login_head','worldless_custom_script');

/*
Изменить требование сложного пароля при восстановлении пароля
*/
function wc_ninja_remove_password_strength() {
    if ( wp_script_is( 'wc-password-strength-meter', 'enqueued' ) ) {
        wp_dequeue_script( 'wc-password-strength-meter' );
    }
}
add_action( 'wp_print_scripts', 'wc_ninja_remove_password_strength', 100 );
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



function setroll_contains($product_attributes, $product) {

    $product_ids = $product->get_meta('set_contains_product_ids');

    $value = '';

    ob_start();
    ?><ul class="product_list_widget setroll_contains"><?php
    if ($product_ids != '') {
        foreach ( $product_ids as $product_id ) {
            $product = wc_get_product( $product_id );
            if ( is_object( $product ) ) {
                //$value .= '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                //wc_get_template( 'content-widget-product.php', null );
                ?>
                <li>


                    <a href="<?php echo esc_url( $product->get_permalink() ); ?>">
                        <?php echo $product->get_image(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        <span class="product-title"><?php echo wp_kses_post( $product->get_name() ); ?></span>

                        <?php echo wc_get_rating_html( $product->get_average_rating()+0.01 ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>

                        <?php echo $product->get_price_html(); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    </a>

                </li>
                <?php
            }
        }
    }
    ?></ul><?php
    $content = ob_get_clean();

    if (strpos($content, '<li') > 0){
        $product_attributes['setroll_contains'] = [
            'label' => 'Входящие в состав:',
            'value' => $content
            ];
    }

    return $product_attributes;
}
add_filter( 'woocommerce_display_product_attributes', 'setroll_contains', 10, 2 );



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
Редактируем письмо, отправляемое пользователю при регистрации

Проблема в том, что он шлет ссылку - текстом, а потом вставляет ссылку входа на сайт. идиот
*/
add_filter('wp_new_user_notification_email', 'edit_wp_new_user_notification_email', 10, 1);
function edit_wp_new_user_notification_email($wp_new_user_notification_email) {

    $message = $wp_new_user_notification_email['message'];

    //Убираем ссылку на вход
    $message = str_replace("\r\n" . wp_login_url() . "\r\n", "\r\n", $message);

    //Оборачиваем в ссылку на смену пароля
    $pattern = "/(\r\n\r\n)<(\\S+)>(\r\n\r\n)/";
    $replacement = '\1\2\3';
    $message = preg_replace($pattern, $replacement, $message);



    $wp_new_user_notification_email['message'] = $message;

    return $wp_new_user_notification_email;

}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


















////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
return;

/*
 * Использовать шорткоды:
 *
 * [mycred_to_woo_coupon]
 *
 * [mycred_display_customer_coupons]
 *
 */



/**
 * Convert myCRED Points into WooCommerce Coupon
 * Requires myCRED 1.4 or higher!
 * @version 1.3.1

 * https://gist.github.com/gabrielmerovingi/8700026
 */
add_shortcode( 'mycred_to_woo_coupon', 'mycred_pro_render_points_to_coupon' );
function mycred_pro_render_points_to_coupon( $atts, $content = NULL ) {

    // Users must be logged in
    if ( ! is_user_logged_in() )
        return 'You must be logged in to generate store coupons.';

    // myCRED must be enabled
    if ( ! function_exists( 'mycred' ) )
        return 'myCRED must be enabled to use this shortcode';

    extract( shortcode_atts( array(
        'exchange'      => 1,
        'minimum'       => 0,
        'maximum'       => 0,
        'type'          => 'mycred_default',
        'button_label'  => 'Create Coupon',
        'before_tax'    => 'yes',
        'free_shipping' => 'no'
    ), $atts ) );

    // Load myCRED
    $mycred = mycred( $type );

    // Prep
    $error   = $code = false;
    $output  = '';
    $user_id = get_current_user_id();

    //Получаем логин пользователя
    $current_user = wp_get_current_user();
    if ( ($current_user instanceof WP_User) ){
        $current_user_login = $current_user->user_login;
        $current_user_email = $current_user->user_email;
    }else{
        $current_user_login = '';
        $current_user_email = '';
    }

    // No need to show this for excluded users
    if ( $mycred->exclude_user( $user_id ) ) return $content;

    $balance = $mycred->get_users_balance( $user_id );

    // Form submission
    if ( isset( $_POST['mycred_to_woo'] ) && wp_verify_nonce( $_POST['mycred_to_woo']['token'], 'points-to-woo-coupon' ) ) {

        // Make sure amounts are always positive
        $amount = abs( $_POST['mycred_to_woo']['amount'] );

        // Exchange rate
        $value  = wc_format_decimal( ( $amount*$exchange ), '' );

        // Make sure amount is not zero
        if ( $amount == $mycred->zero() )
            $error = 'Amount can not be zero';

        // If we are enforcing a minimum
        if ( $minimum > 0 && $amount < $minimum )
            $error = sprintf( 'Amount must be minimum %s', $mycred->format_creds( $minimum ) );

        // If we are enforcing a maximum
        elseif ( $maximum > 0 && $amount > $maximum )
            $error = sprintf( 'Amount can not be higher than %s', $mycred->format_creds( $maximum ) );

        // Make sure user has enough points
        if ( $amount > $balance )
            $error = 'Insufficient Funds. Please try a lower amount';

        // Убеждаемся что это не повторная отравка POST при обновлении страницы
        if ( $balance != $_POST['mycred_to_woo']['balance'] )
            $error = 'Эта операция уже выполнена ранее';


        // If no errors
        if ( $error === false ) {




            // Создаем Woo-купон
            $code = strtolower( wp_generate_password( 12, false, false ) );
            $new_coupon_id = wp_insert_post( array(
                'post_title'   => $code,
                'post_content' => '',
                'post_excerpt' => 'Generated by ' . $current_user_login,
                'post_status'  => 'publish',
                'post_author'  => $user_id,
                'post_type'    => 'shop_coupon'
            ) );

            // Вычитаем баллы у пользователя
            $mycred->add_creds(
                'points_to_coupon',
                $user_id,
                0-$amount,
                '%plural% conversion into store coupon: %post_title%',
                $new_coupon_id,
                array( 'ref_type' => 'post', 'code' => $code ),
                $type
            );

            $balance = $balance-$amount;
            $balance = $mycred->number( $balance );

            // Update Coupon details
            update_post_meta( $new_coupon_id, 'discount_type', 'fixed_cart' );
            update_post_meta( $new_coupon_id, 'coupon_amount', $value );
            update_post_meta( $new_coupon_id, 'individual_use', 'no' );
            update_post_meta( $new_coupon_id, 'product_ids', '' );
            update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );

            // Make sure you set usage_limit to 1 to prevent duplicate usage!!!
            update_post_meta( $new_coupon_id, 'usage_limit', 1 );
            update_post_meta( $new_coupon_id, 'usage_limit_per_user', 1 );
            update_post_meta( $new_coupon_id, 'limit_usage_to_x_items', '' );
            update_post_meta( $new_coupon_id, 'usage_count', '' );
            update_post_meta( $new_coupon_id, 'expiry_date', '' );
            update_post_meta( $new_coupon_id, 'apply_before_tax', ( in_array( $before_tax, array( 'no', 'yes' ) ) ? $before_tax : 'yes' ) );
            update_post_meta( $new_coupon_id, 'free_shipping', ( in_array( $free_shipping, array( 'no', 'yes' ) ) ? $free_shipping : 'no' ) );
            update_post_meta( $new_coupon_id, 'product_categories', array() );
            update_post_meta( $new_coupon_id, 'exclude_product_categories', array() );
            update_post_meta( $new_coupon_id, 'exclude_sale_items', 'no' );
            update_post_meta( $new_coupon_id, 'minimum_amount', '' );
            update_post_meta( $new_coupon_id, 'customer_email', array( $current_user_email ) );
        }

    }

    // Show users current balance
    $output .= '
<p>Your current balance is: ' . $mycred->format_creds( $balance ) . '</p>';

    // Error
    if ( $error !== false )
        $output .= '<p style="color:red;">' . $error . '</p>';

    // Success
    elseif ( $code !== false )
        $output .= '<p>Your coupon code is: <strong>' . $code . '</strong></p>';

    // The form for those who have points
    if ( $balance > $mycred->zero() )
        $output .= '
<form action="" method="post">
	<input type="hidden" name="mycred_to_woo[token]" value="' . wp_create_nonce( 'points-to-woo-coupon' ) . '" />
	<input type="hidden" name="mycred_to_woo[balance]" value="' . $balance . '" />
	<label>Amount</label>
	<input type="text" size="5" name="mycred_to_woo[amount]" value="" />
	<input type="submit" name="submit" value="' . $button_label . '" />
</form>';

    // Not enough points
    else
        $output .= '<p>Not enough points to create coupons.</p>';

    /*///////////////////////////////////////////////////////////////////////////////
    Это я перенёс в отдельный шорткод
    $args = array(
         'posts_per_page' => -1,
        'orderby'          => 'date',
        'post_type'        => 'shop_coupon',
        'author'	   => $user_id,
        'post_status'      => 'publish',
    );
    $posts_array = get_posts( $args );
    //var_dump($posts_array);
    //$output .= $posts_array;

    $coupon_objects = array();

    foreach ( $posts_array as $coupon ) {

        // Get the name for each coupon post
        //$coupon_name = $coupon->post_title;
        $coupon_obj = new WC_Coupon( $coupon->ID);
        if($coupon_obj->get_description() == 'Generated by ' . $current_user_login){
            array_push( $coupon_objects, $coupon_obj );
        }

    }

    //var_dump($coupon_objects );


    foreach ( $coupon_objects as $coupon_obj ) {
        //https://docs.woocommerce.com/wc-apidocs/class-WC_Coupon.html
        if($coupon_obj->get_usage_count() > 0) continue;

        echo $coupon_obj->get_code() . '  (скидка ' . $coupon_obj->get_amount() . ' руб.)<br>';
        echo '<br>';

    }

    ///////////////////////////////////////////////////////////////////////////////*/

    return $output;

}

/**
 * Шорткод для вывода активных обменяных купонов
 */
add_shortcode( 'mycred_display_customer_coupons', 'mycred_display_customer_coupons_function' );
function mycred_display_customer_coupons_function( $atts, $content = NULL ) {

    // Users must be logged in
    if ( ! is_user_logged_in() ){
        if(SHOW_MSG_IF_NOT_LOGGINED){
            return 'You must be logged in to generate store coupons.';
        }else{
            return;
        }

    }
    // myCRED must be enabled
    if ( ! function_exists( 'mycred' ) ){
        if(DEBUG_MODE){
            return 'myCRED must be enabled to use this shortcode';
        }else{
            return;
        }
    }

    extract( shortcode_atts( array(
        'type'          => 'mycred_default'
    ), $atts ) );

    // Load myCRED
    $mycred = mycred( $type );

    // Prep
    $error   = $code = false;
    $output  = '';
    $user_id = get_current_user_id();

    //Получаем логин пользователя
    $current_user = wp_get_current_user();
    if ( ($current_user instanceof WP_User) ){
        $current_user_login = $current_user->user_login;
        $current_user_email = $current_user->user_email;
    }else{
        $current_user_login = '';
        $current_user_email = '';
    }

    // No need to show this for excluded users
    if ( $mycred->exclude_user( $user_id ) ) return $content;



    ////////////////////////////////////////////////////////////////////////////////

    $args = array(
        'posts_per_page' => -1,
        'orderby'          => 'date',
        'post_type'        => 'shop_coupon',
        'author'	   => $user_id,
        'post_status'      => 'publish',
    );
    $posts_array = get_posts( $args );
    //var_dump($posts_array);
    //$output .= $posts_array;

    $coupon_objects = array();

    foreach ( $posts_array as $coupon ) {

        // Get the name for each coupon post
        //$coupon_name = $coupon->post_title;
        $coupon_obj = new WC_Coupon( $coupon->ID);
        if($coupon_obj->get_description() == 'Generated by ' . $current_user_login){
            array_push( $coupon_objects, $coupon_obj );
        }

    }

    //var_dump($coupon_objects );


    foreach ( $coupon_objects as $coupon_obj ) {
        //https://docs.woocommerce.com/wc-apidocs/class-WC_Coupon.html
        if($coupon_obj->get_usage_count() > 0) continue;

        echo $coupon_obj->get_code() . '  (скидка ' . $coupon_obj->get_amount() . ' руб.)<br>';
        echo '<br>';

    }

    ////////////////////////////////////////////////////////////////////////////////

    return $output;

}




/**
 * Эта функция не учитывает настройку получения бонуса у каждого товара. она тупо определяет процент от корзины. Отключена
 * Woo Point Rewards by Order Total
 * Reward store purchases by paying a percentage of the order total
 * as points to the buyer.
 * @version 1.1
 */
/*function mycred_pro_reward_order_percentage( $order_id ) {

	if ( ! function_exists( 'mycred' ) ) return;

	// Get Order
	$order   = wc_get_order( $order_id );
	$cost    = $order->get_subtotal();

	// Do not payout if order was paid using points
	if ( $order->payment_method == 'mycred' ) return;

	// The percentage to payout
	$percent = 25;

	// Load myCRED
	$mycred  = mycred();

	// Make sure user only gets points once per order
	if ( $mycred->has_entry( 'reward', $order_id, $order->user_id ) ) return;

	// Reward example 25% in points.
	$reward  = $cost * ( $percent / 100 );

	// Add reward
	$mycred->add_creds(
		'reward',
		$order->user_id,
		$reward,
		'Reward for store purchase',
		$order_id,
		array( 'ref_type' => 'post' )
	);

}
add_action( 'woocommerce_order_status_completed', 'mycred_pro_reward_order_percentage' );*/

