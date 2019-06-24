<?php

// https://catapultthemes.com/add-custom-fields-woocommerce-product/
// https://wpruse.ru/woocommerce/custom-fields-in-products/

// wp-content/plugins/woocommerce/includes/admin/meta-boxes/views/html-product-data-linked-products.php
 
/**
 * Display the custom text fields
 * @since 1.0.0
 */
function create_custom_fields() {
	?>

    <div class="options_group">
        <p class="form-field hide_if_grouped hide_if_external">
            <label for="set_contains_product_ids">Состав сета</label>
            <select class="wc-product-search" multiple="multiple" style="width: 50%;" id="set_contains_product_ids" name="set_contains_product_ids[]" data-placeholder="<?php esc_attr_e( 'Search for a product&hellip;', 'woocommerce' ); ?>" data-action="woocommerce_json_search_products_and_variations" data-exclude="<?php echo intval( $post->ID ); ?>">
                <?php

                global $product_object;

                $product_ids = $product_object->get_meta('set_contains_product_ids');

                if ($product_ids != '') {
                    foreach ( $product_ids as $product_id ) {
                        $product = wc_get_product( $product_id );
                        if ( is_object( $product ) ) {
                            echo '<option value="' . esc_attr( $product_id ) . '"' . selected( true, true, false ) . '>' . wp_kses_post( $product->get_formatted_name() ) . '</option>';
                        }
                    }
                }

                ?>
            </select>
        </p>
    </div>

	<?php
}
add_action( 'woocommerce_product_options_general_product_data', 'create_custom_fields' );




/**
 * Save the custom fields
 * @since 1.0.0
 */
function save_custom_field( $post_id ) {
	 $product = wc_get_product( $post_id );

     $set_contains_product_ids = isset( $_POST['set_contains_product_ids'] ) ? $_POST['set_contains_product_ids'] : '';
	 
	 $product->update_meta_data( 'set_contains_product_ids', array_filter( (array) $set_contains_product_ids ) );

	 foreach ($set_contains_product_ids as $contain_product_id) {

         $getted_attributes = wc_get_product( $contain_product_id )->get_attributes();
         if (isset($getted_attributes['pa_consist'])) {
             $pa_consist = $getted_attributes['pa_consist'];

             //$product->set_attributes($pa_consist);

             $text = '';
         }

    }



	 //$product->set_attributes($getted_attributes);

	 $product->save();
}
add_action( 'woocommerce_process_product_meta', 'save_custom_field' );


