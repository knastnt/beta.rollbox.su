<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/quantity-input.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

if ( $max_value && $min_value === $max_value ) {
	?>
	<div class="quantity hidden">
		<input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" class="qty" name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $min_value ); ?>" />
	</div>
	<?php
} else {
	/* translators: %s: Quantity. */
	$labelledby = ! empty( $args['product_name'] ) ? sprintf( __( '%s quantity', 'woocommerce' ), strip_tags( $args['product_name'] ) ) : '';
	?>
			
			
			<div data-2f0be108="true">
				<button class="_4qhIn2-ESi _2sJs248D-A _18c2gUxCdP _24vNl4GJCb" type="button" data-71e1c78d="true">
					<span class="_2w0qPDYwej">
						<span class="jE8-ezGMzW _2KOZaXwtzH">–</span>
					</span>
				</button>
				<div class="_2ovZ10xVbg">
					<span class="control textinput textinput_type_phone textinput_theme_normal textinput_view_classic">
						<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Quantity', 'woocommerce' ); ?></label>
						<input
							type="number"
							id="<?php echo esc_attr( $input_id ); ?>"
							class="input-text qty text"
							step="<?php echo esc_attr( $step ); ?>"
							min="<?php echo esc_attr( $min_value ); ?>"
							max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>"
							name="<?php echo esc_attr( $input_name ); ?>"
							value="<?php echo esc_attr( $input_value ); ?>"
							title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'woocommerce' ); ?>"
							size="4"
							pattern="<?php echo esc_attr( $pattern ); ?>"
							inputmode="<?php echo esc_attr( $inputmode ); ?>"
							aria-labelledby="<?php echo esc_attr( $labelledby ); ?>" />
					
					</span>
				</div>
				<button class="_4qhIn2-ESi _2sJs248D-A _18c2gUxCdP _3hWhO4rvmA" type="button" data-71e1c78d="true">
					<span class="_2w0qPDYwej">
						<span class="jE8-ezGMzW">+</span>
					</span>
				</button>
			</div>
			
			
	</div>
	<?php
}
