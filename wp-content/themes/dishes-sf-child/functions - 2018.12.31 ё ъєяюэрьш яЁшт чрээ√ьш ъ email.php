<?php

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

		// If no errors
		if ( $error === false ) {
			
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
			$code = strtolower( wp_generate_password( 12, false, false ) );
			$new_coupon_id = wp_insert_post( array(
				'post_title'   => $code,
				'post_content' => '',
				'post_status'  => 'publish',
				'post_author'  => 1,
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
	<label>Amount</label>
	<input type="text" size="5" name="mycred_to_woo[amount]" value="" />
	<input type="submit" name="submit" value="' . $button_label . '" />
</form>';

	// Not enough points
	else
		$output .= '<p>Not enough points to create coupons.</p>';

	return $output;

}



/*
  Функция для исправления бага об ограничении применения купона.
  При обмене баллов на купон я сделал привязку к email пользователя, чтобы только он мог использовать этот купон. И несмотря на это, купон могли использовать все.
  Это свежий баг

  WooCommerce email restriction for coupons does not work. This fix corrects it. 
  Include this code snippet in your theme or plugin.
  
  https://gist.github.com/riotxoa/f4f1a895052c195394ba4841085a0e83
*/

add_filter( 'woocommerce_coupon_is_valid', 'wc_riotxoa_coupon_is_valid', 10, 2 );

if ( ! function_exists( 'wc_riotxoa_coupon_is_valid' ) ) {

	function wc_riotxoa_coupon_is_valid( $result, $coupon ) {
		$user = wp_get_current_user();

		$restricted_emails = $coupon->get_email_restrictions();

		return ( in_array( $user->user_email, $restricted_emails ) ? $result : false );
	}
}