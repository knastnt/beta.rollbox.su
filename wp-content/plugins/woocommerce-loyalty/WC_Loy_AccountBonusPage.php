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

add_action( 'init', array('WC_Loy_AccountBonusPage', 'process_post') );


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




    static function process_post() {


        // Form submission
        if ( isset( $_POST['points_to_coupons'] ) && wp_verify_nonce( $_POST['points_to_coupons']['token'], 'points-to-woo-coupon' ) ) {

            $user_id = get_current_user_id();
            if ($user_id == 0) return;

            $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

            $balance = $wc_loy_usermeta->getPoints();



            /*$neededAmount = 0;
            if (isset( $_POST['coupon'])) {
                $neededAmount = intval($_POST['coupon']);
            }*/
            $neededCoupon = isset($_POST['coupon']) ? $_POST['coupon'] : '';


            $error = self::checkAbility($neededCoupon, $balance, $wc_loy_usermeta);


            // If no errors
            if ($error === false) {

                //Получаем логин пользователя
                $current_user = wp_get_current_user();
                if ( ($current_user instanceof WP_User) ){
                    $current_user_login = $current_user->user_login;
                    $current_user_email = $current_user->user_email;
                }else{
                    $current_user_login = '';
                    $current_user_email = '';
                }

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
                $price = woocommerceLoyalty_Options::instance()->getPriceOfCoupon($neededCoupon);
                $amount = woocommerce_loyalty_defaults::$coupons_numinals_defaults[$neededCoupon]['coupon_rub'];
                $result = $wc_loy_usermeta->removePoints($price, 'Покупка купона на сумму ' . $amount . ' руб.');

                if ($result) {
                    // Update Coupon details
                    update_post_meta($new_coupon_id, 'discount_type', 'fixed_cart');
                    update_post_meta($new_coupon_id, 'coupon_amount', $amount);
                    /*update_post_meta($new_coupon_id, 'individual_use', 'no');
                    update_post_meta($new_coupon_id, 'product_ids', '');
                    update_post_meta($new_coupon_id, 'exclude_product_ids', '');*/

                    // Make sure you set usage_limit to 1 to prevent duplicate usage!!!
                    update_post_meta($new_coupon_id, 'usage_limit', 1);
                    update_post_meta($new_coupon_id, 'usage_limit_per_user', 1);
                    /*update_post_meta($new_coupon_id, 'limit_usage_to_x_items', '');
                    update_post_meta($new_coupon_id, 'usage_count', '');
                    update_post_meta($new_coupon_id, 'expiry_date', '');
                    update_post_meta($new_coupon_id, 'apply_before_tax', (in_array($before_tax, array('no', 'yes')) ? $before_tax : 'yes'));
                    update_post_meta($new_coupon_id, 'free_shipping', (in_array($free_shipping, array('no', 'yes')) ? $free_shipping : 'no'));
                    update_post_meta($new_coupon_id, 'product_categories', array());
                    update_post_meta($new_coupon_id, 'exclude_product_categories', array());
                    update_post_meta($new_coupon_id, 'exclude_sale_items', 'no');
                    update_post_meta($new_coupon_id, 'minimum_amount', '');
                    update_post_meta($new_coupon_id, 'customer_email', array($current_user_email));*/

                    update_post_meta($new_coupon_id, 'only_for_user_id', $user_id);
                }

                //Перезагружаем страницу
                //header("Refresh:0");
            }else{
                wc_add_notice( $error, 'error' );
            }

        }
    }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function getContent() {
        $output = 'Last time you logged in: yesterday from Terrano...';

        $user_id = get_current_user_id();
        if ($user_id == 0) return;

        $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

        $balance = $wc_loy_usermeta->getPoints();




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
	<input type="hidden" name="points_to_coupons[balance]" value="' . $balance . '" />
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


        $coupons_numinals_defaults = woocommerce_loyalty_defaults::$coupons_numinals_defaults;
        foreach ( $coupons_numinals_defaults as $key => $entry) {
            $htmlName = 'coupon[' . $key . ']';
            $coupon = $key;
            $amount = $entry['coupon_rub'];
            $price = woocommerceLoyalty_Options::instance()->getPriceOfCoupon($key);
            if ($price > 0) {
                $output .= '<input type="radio" id="' . $htmlName . '" name="coupon" value="' . $coupon . '"><label for="' . $htmlName . '">Купон на ' . $amount . ' руб. = ' . $price . ' бонусов</label>';
            }
        }

        $output .= '</div>

	<input type="submit" name="submit" value="Обменять" />
</form>';



            return $output;

        }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function checkAbility($neededCoupon, $balance, $wc_loy_usermeta) {

            $coupons_numinals_defaults = woocommerce_loyalty_defaults::$coupons_numinals_defaults;


            // Убеждаемся что это не повторная отравка POST при обновлении страницы
            if ($balance != $_POST['points_to_coupons']['balance'])
                return 'Эта операция уже выполнена ранее';

            // Убеждаемся что купон выбран
            if ($neededCoupon == '')
                return 'Неверный номинал купона';

            // Убеждаемся что такой купон существует
            if (!isset($coupons_numinals_defaults[$neededCoupon]))
                return 'Такой купон не существует';


            //Убеждаемся что бонусы не заморожены
            if (!$wc_loy_usermeta->isPointsUnfreeze())
                return 'Ваши бонусы ещё не разморожены';

            //Убеждаемся что на балансе достаточно бонусов
            //$price = $coupons_numinals_defaults['fixed-' . $neededAmount]['coupun_price_in_points'];
            $price = woocommerceLoyalty_Options::instance()->getPriceOfCoupon($neededCoupon);
            if ($balance < $price)
                return 'Не хватает баллов для приобретения этого купона';


            return false;

        }


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}