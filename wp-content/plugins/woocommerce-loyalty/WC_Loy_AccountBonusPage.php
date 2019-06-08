<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2019
 * Time: 18:27
 */

//Step 1. Add Link to My Account menu
add_filter ( 'woocommerce_account_menu_items', array('WC_Loy_AccountBonusPage', 'add_more_link_to_account') );

//Step 2. Register Permalink Endpoint
add_action( 'init', array('WC_Loy_AccountBonusPage', 'add_more_hook_endpoint') );

//Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
add_action( 'woocommerce_account_rewards_endpoint', array('WC_Loy_AccountBonusPage', 'my_account_rewards_endpoint_content') );

//


class WC_Loy_AccountBonusPage
{


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Добавляем новый пункт меню
    /*
     * Step 1. Add Link to My Account menu
     */
    static function add_more_link_to_account( $menu_links ){
        // we will hook "rewards" later
        $new = array( 'rewards' => 'Бонусы' );

        // or in case you need 2 links
        // $new = array( 'link1' => 'Link 1', 'link2' => 'Link 2' );

        // array_slice() is good when you want to add an element between the other ones
        $menu_links = array_slice( $menu_links, 0, 1, true )
            + $new
            + array_slice( $menu_links, 1, NULL, true );

        return $menu_links;
    }

    /*
     * Step 2. Register Permalink Endpoint
     */
    /*add_filter( 'woocommerce_get_endpoint_url', 'add_more_hook_endpoints', 10, 4 );
    function add_more_hook_endpoints( $url, $endpoint, $value, $permalink ){

        if( $endpoint === 'rewards' ) {

            // ok, here is the place for your custom URL, it could be external
            $url = get_permalink( get_option('woocommerce_myaccount_page_id') ) . 'rewards/';

        }
        return $url;
    }*/
    static function add_more_hook_endpoint() {
        // WP_Rewrite is my Achilles' heel, so please do not ask me for detailed explanation
        add_rewrite_endpoint( 'rewards', EP_PAGES );
    }

    /*
     * Step 3. Content for the new page in My Account, woocommerce_account_{ENDPOINT NAME}_endpoint
     */
    static function my_account_rewards_endpoint_content() {
        // of course you can print dynamic content here, one of the most useful functions here is get_current_user_id()
        //Содержимое страницы бонусов
        echo self::getContent();
    }

    /*
     * Step 4
     */
    // Go to Settings > Permalinks and just push "Save Changes" button.
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function getContent() {
        $output = 'Last time you logged in: yesterday from Terrano...';

        $user_id = get_current_user_id();
        if ($user_id == 0) return;

        $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

        $balance = $wc_loy_usermeta->getPoints();

        $coupons_numinals_defaults = woocommerce_loyalty_defaults::$coupons_numinals_defaults;


        // Form submission
        if ( isset( $_POST['points_to_coupons'] ) && wp_verify_nonce( $_POST['points_to_coupons']['token'], 'points-to-woo-coupon' ) ) {

            // Make sure amounts are always positive
            if (isset( $_POST['coupon-fixed'])) {
                $neededAmount = intval($_POST['coupon-fixed']);
                if (isset($coupons_numinals_defaults['fixed-' . $neededAmount])){
                    //Запрошенный размер купона существует
                    $price = $coupons_numinals_defaults['fixed-' . $neededAmount]['coupun_price_in_points'];
                    
                }
            }
            $amount = abs($_POST['points_to_coupons']['amount']);

            // Exchange rate
            $value = wc_format_decimal(($amount * $exchange), '');

            // Make sure amount is not zero
            if ($amount == $mycred->zero())
                $error = 'Amount can not be zero';

            // If we are enforcing a minimum
            if ($minimum > 0 && $amount < $minimum)
                $error = sprintf('Amount must be minimum %s', $mycred->format_creds($minimum));

            // If we are enforcing a maximum
            elseif ($maximum > 0 && $amount > $maximum)
                $error = sprintf('Amount can not be higher than %s', $mycred->format_creds($maximum));

            // Make sure user has enough points
            if ($amount > $balance)
                $error = 'Insufficient Funds. Please try a lower amount';

            // Убеждаемся что это не повторная отравка POST при обновлении страницы
            if ($balance != $_POST['points_to_coupons']['balance'])
                $error = 'Эта операция уже выполнена ранее';


            // If no errors
            if ($error === false) {


                // Создаем Woo-купон
                $code = strtolower(wp_generate_password(12, false, false));
                $new_coupon_id = wp_insert_post(array(
                    'post_title' => $code,
                    'post_content' => '',
                    'post_excerpt' => 'Generated by ' . $current_user_login,
                    'post_status' => 'publish',
                    'post_author' => $user_id,
                    'post_type' => 'shop_coupon'
                ));

                // Вычитаем баллы у пользователя
                $mycred->add_creds(
                    'points_to_coupon',
                    $user_id,
                    0 - $amount,
                    '%plural% conversion into store coupon: %post_title%',
                    $new_coupon_id,
                    array('ref_type' => 'post', 'code' => $code),
                    $type
                );

                $balance = $balance - $amount;
                $balance = $mycred->number($balance);

                // Update Coupon details
                update_post_meta($new_coupon_id, 'discount_type', 'fixed_cart');
                update_post_meta($new_coupon_id, 'coupon_amount', $value);
                update_post_meta($new_coupon_id, 'individual_use', 'no');
                update_post_meta($new_coupon_id, 'product_ids', '');
                update_post_meta($new_coupon_id, 'exclude_product_ids', '');

                // Make sure you set usage_limit to 1 to prevent duplicate usage!!!
                update_post_meta($new_coupon_id, 'usage_limit', 1);
                update_post_meta($new_coupon_id, 'usage_limit_per_user', 1);
                update_post_meta($new_coupon_id, 'limit_usage_to_x_items', '');
                update_post_meta($new_coupon_id, 'usage_count', '');
                update_post_meta($new_coupon_id, 'expiry_date', '');
                update_post_meta($new_coupon_id, 'apply_before_tax', (in_array($before_tax, array('no', 'yes')) ? $before_tax : 'yes'));
                update_post_meta($new_coupon_id, 'free_shipping', (in_array($free_shipping, array('no', 'yes')) ? $free_shipping : 'no'));
                update_post_meta($new_coupon_id, 'product_categories', array());
                update_post_meta($new_coupon_id, 'exclude_product_categories', array());
                update_post_meta($new_coupon_id, 'exclude_sale_items', 'no');
                update_post_meta($new_coupon_id, 'minimum_amount', '');
                update_post_meta($new_coupon_id, 'customer_email', array($current_user_email));
            }
        }




            // Show users current balance
            $output .= '
<p>Your current balance is: ' . $balance . '</p>';

            /*/ Error
            if ( $error !== false )
                $output .= '<p style="color:red;">' . $error . '</p>';

            // Success
            elseif ( $code !== false )
                $output .= '<p>Your coupon code is: <strong>' . $code . '</strong></p>';*/

                $output .= '
<form action="" method="post">
	<input type="hidden" name="points_to_coupons[token]" value="' . wp_create_nonce( 'points-to-woo-coupon' ) . '" />
	<!--label>Amount</label>
	<input type="text" size="5" name="points_to_coupons[amount]" value="" /-->
	<div>';

        /*<input type="radio" id="contactChoice1"
         name="contact" value="email">
        <label for="contactChoice1">Email</label>
    
        <input type="radio" id="contactChoice2"
         name="contact" value="phone">
        <label for="contactChoice2">Phone</label>
    
        <input type="radio" id="contactChoice3"
         name="contact" value="mail">
        <label for="contactChoice3">Mail</label>*/


        foreach ( $coupons_numinals_defaults as $entry) {
            if ($entry['coupun_price_in_points'] > 0) {
                $name = 'coupon-fixed[' . $entry['coupon_rub'] . ']';
                $output .= '<input type="radio" id="' . $name . '" name="coupon-fixed" value="' . $entry['coupon_rub'] . '"><label for="' . $name . '">Купон на ' . $entry['coupon_rub'] . ' руб. = ' . $entry['coupun_price_in_points'] . ' бонусов</label>';
            }
        }

        $output .= '</div>

	<input type="submit" name="submit" value="Обменять" />
</form>';



            return $output;

        }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}