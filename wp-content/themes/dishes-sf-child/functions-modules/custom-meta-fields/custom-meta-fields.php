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

    //$product->set_attributes()


    /*$term_taxonomy_ids = wp_set_object_terms( get_the_ID(), 'ATTRIBUTE_VALUE', 'pa_ATTRIBUTE', true );
    $thedata = Array(
        'pa_ATTRIBUTE'=>Array(
            'name'=>'pa_ATTRIBUTE',
            'value'=>'ATTRIBUTE_VALUE',
            'is_visible' => '1',
            'is_variation' => '1',
            'is_taxonomy' => '1'
        )
    );
    update_post_meta( get_the_ID(),'_product_attributes',$thedata);*/




    //----------------------------------------------------//

    // https://stackoverflow.com/questions/53705122/add-a-new-term-to-a-product-attribute-and-set-it-in-the-product-in-woocommerce

    $attribute_slug = 'consist';       // Слаг заранее созданного атрибута. В нем будем работать. В моём случае это состав.
    $znacheniename_of_attribute = 'Значение';    // Имя одного из значений этого атрибута

    $taxonomy = 'pa_' . $attribute_slug; // The taxonomy

    $term_name = $znacheniename_of_attribute; // The term "NAME"
    $term_slug = sanitize_title($term_name); // The term "slug"

// Check if the term exist and if not it create it (and get the term ID).
    if( ! term_exists( $term_name, $taxonomy ) ){ //Проверяем, существует ли такой значение в указанном атрибуте
        // Создаём его, если такого ещё нет
        $term_data = wp_insert_term( $term_name, $taxonomy );
        // Получаем ID этого значения
        $term_id   = $term_data['term_id'];
    } else {
        // Получаем ID этого значения
        $term_id   = get_term_by( 'name', $term_name, $taxonomy )->term_id;
    }

// get an instance of the WC_Product Object
    // Получаем отбъект товара
    $product = wc_get_product( $post_id );
    // Массив атрибутов товара (массив из WC_Product_Attribute)
    $attributes = (array) $product->get_attributes();

// 1. If the product attribute is set for the product
    if( array_key_exists( $taxonomy, $attributes ) ) {  // Если наш атрибут имеется у этого товара
        foreach( $attributes as $key => $attribute ){

            // $key - таксономия атрибута (с приставкой pa_)
            // $attribute - объект WC_Product_Attribute

            if( $key == $taxonomy ){ //Если это наш атрибут

                $options = (array) $attribute->get_options();  // Получаем массив из ID значений этого атрибута

                $options[] = $term_id;   // Добавляем туда ещё и наше значение

                $attribute->set_options($options); //Применяем новый набор значений к этому атрибуту

                $attributes[$key] = $attribute; // Теперь заменяем наш атрибут новым в массиве атрибутов
                break;
            }
        }

        $product->set_attributes( $attributes ); //Применяем к товару подкорректированный массив атрибутов
    }
// 2. The product attribute is not set for the product
    else {
        // Если наш атрибут у этого товара отсутствует

        // создаем новы атрибут
        $attribute = new WC_Product_Attribute();
        $attribute->set_id( sizeof( $attributes) + 1 );
        $attribute->set_name( $taxonomy );
        $attribute->set_options( array( $term_id ) );
        $attribute->set_position( sizeof( $attributes) + 1 );
        $attribute->set_visible( true );
        $attribute->set_variation( false );

        $attributes[] = $attribute;  // Добавляем к массиву атрибутов - наш

        $product->set_attributes( $attributes ); //Применяем к товару подкорректированный массив атрибутов
    }

    $product->save();

// Append the new term in the product
    //х.з. что это
    if( ! has_term( $term_name, $taxonomy, $post_id ))
        wp_set_object_terms($post_id, $term_slug, $taxonomy, true );






	 //$product->set_attributes($getted_attributes);

	 $product->save();
}
add_action( 'woocommerce_process_product_meta', 'save_custom_field' );


