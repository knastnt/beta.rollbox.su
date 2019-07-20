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
            <?php echo wc_help_tip('Если существует атрибут Состав (slug = consist), то в него (к уже имеющимся ингридиентам) будет добавляться состав этих роллов.'); ?>
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

     $product->save();

}
add_action( 'woocommerce_process_product_meta', 'save_custom_field' );




/**
 * Подтягиваем состав дочерник роллов в сет
 */
function set_prepare_attributes( $attribute, $data, $i ) {

    $attribute_slug = 'consist';       // Слаг заранее созданного атрибута. В нем будем работать. В моём случае это состав.
    $taxonomy = 'pa_' . $attribute_slug; // The taxonomy

    //Эта херня запускается на каждом атрибуте, который есть у товара. Если атрибута нет, то и не запускается

    //Поэтому проверяем, тот ли атрибут сейчас обрабатывается, и если нет, то ретюрним
    if ($attribute->get_name() != $taxonomy) {
        return $attribute;
    }

    //Получаем ID продукта
    $product_id = get_the_ID();
    if ($product_id == false) {
        $product_id = absint(wp_unslash($_POST['post_id'])); //Если запрос через ajax
    }

    // Получаем продукт
    $product_object = wc_get_product( $product_id );

    //Получаем массив ID роллов входящих в состав этого сета
    $set_contains_product_ids = $product_object->get_meta('set_contains_product_ids');

    //Если $set_contains_product_ids пуст, то ретюрним
    if (count($set_contains_product_ids) == 0) {
        return $attribute;
    }

    // ------------------------------------------------------------------------------- //
    // Переносим состав роллов в наш сет

    // Получаем массив состава из всех входящих роллов
    $znacheniya_to_add = array ();
    foreach ($set_contains_product_ids as $contain_product_id) {
        $attributes = wc_get_product( $contain_product_id )->get_attributes();
        if( array_key_exists( $taxonomy, $attributes ) ) {  // Если наш атрибут имеется у этого товара
            $options = (array) $attributes[$taxonomy]->get_options();  // Получаем массив из ID значений этого атрибута
            foreach ($options as $o_key => $o_id){
                if (! in_array($o_id, $znacheniya_to_add)){
                    $znacheniya_to_add[] = $o_id;
                }
            }
            //$product->set_attributes($pa_consist);
        }
    }


    $options = (array) $attribute->get_options();  // Получаем массив из ID значений этого атрибута

    //$options[] = $term_id;   //Вот здесь мы и зададим массив всех значений
    foreach ($znacheniya_to_add as $o_key => $o_id){
        if (! in_array($o_id, $options)){
            $options[] = $o_id;
        }
    }

    //Добавляем недостающие значения атрибута (можно указывать сверх того что заполнится автоматом, но автоматом не удаляются при удалении дочернего ролла)
    $attribute->set_options($options); //Применяем новый набор значений к этому атрибуту

    //Заменяем все значения на вычесленные автоматом
    //$attribute->set_options($znacheniya_to_add); //Применяем новый набор значений к этому атрибуту

    return $attribute;

    /*// ---------------------------------------------------------------------------------------------------- //
    // Массив атрибутов товара (массив из WC_Product_Attribute)
    $attributes = (array) $product->get_attributes();

    // 1. If the product attribute is set for the product
    if( array_key_exists( $taxonomy, $attributes ) ) {  // Если наш атрибут имеется у этого товара
        foreach( $attributes as $key => $attribute ){ //Перебираем все имеющиеся атрибуты

            // $key - таксономия атрибута (с приставкой pa_)
            // $attribute - объект WC_Product_Attribute

            if( $key == $taxonomy ){ //Если это наш атрибут

                $options = (array) $attribute->get_options();  // Получаем массив из ID значений этого атрибута

                //$options[] = $term_id;   //Вот здесь мы и зададим массив всех значений
                foreach ($znacheniya_to_add as $o_key => $o_id){
                    if (! in_array($o_id, $options)){
                        $options[] = $o_id;
                    }
                }

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
        $attribute->set_options( $znacheniya_to_add );  //Вот здесь мы и зададим массив всех значений
        $attribute->set_position( sizeof( $attributes) + 1 );
        $attribute->set_visible( true );
        $attribute->set_variation( false );

        $attributes[] = $attribute;  // Добавляем к массиву атрибутов - наш

        $product->set_attributes( $attributes ); //Применяем к товару подкорректированный массив атрибутов
    }
    // ---------------------------------------------------------------------------------------------------- //



    $product->save();*/

    /*// Append the new term in the product
    //х.з. что это
    if( ! has_term( $term_name, $taxonomy, $post_id ))
        wp_set_object_terms($post_id, $term_slug, $taxonomy, true );*/

}
add_filter( 'woocommerce_admin_meta_boxes_prepare_attribute', 'set_prepare_attributes', 10, 3 );


