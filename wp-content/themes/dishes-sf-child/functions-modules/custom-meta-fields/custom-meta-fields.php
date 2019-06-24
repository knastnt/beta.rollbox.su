<?php

// https://catapultthemes.com/add-custom-fields-woocommerce-product/
// https://wpruse.ru/woocommerce/custom-fields-in-products/


 
/**
 * Display the custom text fields
 * @since 1.0.0
 */
function create_custom_fields() {
	global $post;
	 
	echo '<div class="custom_options_group">';// Группировка полей
	
	// Из каких товаров состоит этот сет
	 $args = array(
	 'id' => 'set_contains_product_ids',
	 'label' => __( 'Из каких товаров состоит этот сет', 'set_contains' ),
	 'class' => 'set_contains-custom-field',
	 'desc_tip' => true,
	 'description' => __( 'Вводятся ID товаров через запятую', 'set_contains' ),
	 );
	 woocommerce_wp_text_input( $args );
 
	echo '</div>';
}
add_action( 'woocommerce_product_options_general_product_data', 'create_custom_fields' );




/**
 * Save the custom fields
 * @since 1.0.0
 */
function save_custom_field( $post_id ) {
	 $product = wc_get_product( $post_id );

     $set_contains_product_ids = isset( $_POST['set_contains_product_ids'] ) ? $_POST['set_contains_product_ids'] : '';
	 
	 $product->update_meta_data( 'set_contains_product_ids', sanitize_text_field( $set_contains_product_ids ) );

	 $product->save();
}
add_action( 'woocommerce_process_product_meta', 'save_custom_field' );


