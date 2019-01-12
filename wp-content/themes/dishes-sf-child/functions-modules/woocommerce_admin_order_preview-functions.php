<?php


//// превью заказа при нажатии на глаз
//https://wp-kama.ru/function/WC_Admin_List_Table_Orders::order_preview_template
//////////////////////////////////






add_action( 'woocommerce_admin_order_preview_start', 'action_function_name_7949' );
function action_function_name_7949(){
	echo "!!!!!!!!!!";
}


// Add custom order meta data to make it accessible in Order preview template
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_custom_meta_data', 10, 2 );
function admin_order_preview_add_custom_meta_data( $data, $order ) {
	/*$data = print_r($data, 1) . PHP_EOL;
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/dump.txt', $data, FILE_APPEND);*/
	
    // Replace '_custom_meta_key' by the correct postmeta key
    if( $custom_value = $order->get_meta('_custom_meta_key') )
        $data['custom_key'] = $custom_value; // <= Store the value in the data array.
       
	$data['formatted_billing_address'] = 1111111; // <= Store the value in the data array.

    return $data;
}

// Display custom values in Order preview
add_action( 'woocommerce_admin_order_preview_end', 'custom_display_order_data_in_admin' );
function custom_display_order_data_in_admin(){
    // Call the stored value and display it
    echo '<div>Value: {{data.custom_key}}</div><br>';
}

