<?php


//// превью заказа при нажатии на глаз
//https://wp-kama.ru/function/WC_Admin_List_Table_Orders::order_preview_template
//////////////////////////////////



/*
Суть такая: чтобы поправить содержание окошка просмотра ордера (при нажатии на глаз), делаем такой костыль.
вывод этого окошка описан в функции order_preview_template() файла \wp-content\plugins\woocommerce\includes\admin\list-tables\class-wc-admin-list-table-orders.php
сначала выполняются экшены привязанные к хуку woocommerce_admin_order_preview_start,
затем выводится html-подобный код с вставленными в него именами переменных,
затем выполняются экшены привязанные к хуку woocommerce_admin_order_preview_end.

так как функция order_preview_template не переопределяется, я не нашел ничего лучшего чем перехватить и стереть вывод
с между двумя этими хуками помощью ob_start(); ob_get_contents(); ob_clean ();
а нужный html-подобный код вставил в акшен второго хука.


*/


add_action( 'woocommerce_admin_order_preview_start', 'action_function_name_7949', 10000, 0 ); //Приоритет 10000 - большой чтобы этат экшн выполнялся последним из возможно в будущем прикрепленных к этому хуку
function action_function_name_7949(){
	//ob_clean();
	ob_start();
}

/*
Из примера использования общей переменной
// Add custom order meta data to make it accessible in Order preview template
add_filter( 'woocommerce_admin_order_preview_get_order_details', 'admin_order_preview_add_custom_meta_data', 10, 2 );
function admin_order_preview_add_custom_meta_data( $data, $order ) {
	/*$data = print_r($data, 1) . PHP_EOL;
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/dump.txt', $data, FILE_APPEND); /
	
    // Replace '_custom_meta_key' by the correct postmeta key
    if( $custom_value = $order->get_meta('_custom_meta_key') )
        $data['custom_key'] = $custom_value; // <= Store the value in the data array.
       
	$data['formatted_billing_address'] = 1111111; // <= Store the value in the data array.

    return $data;
*/

// Display custom values in Order preview
add_action( 'woocommerce_admin_order_preview_end', 'custom_display_order_data_in_admin', 1, 0 ); //Приоритет 1 - наименьший чтобы этат экшн выполнялся первым из возможно в будущем прикрепленных к этому хуку
function custom_display_order_data_in_admin(){
	/*
	Из примера использования общей переменной
    // Call the stored value and display it
    echo '<div>Value: {{data.custom_key}}</div><br>';
	*/
	
	
	$t=ob_get_contents();

	//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/dump0.txt', $t, FILE_APPEND);
	/* содержимое $t = ...

	!!!!!!!!!!
								<div class="wc-order-preview-addresses">
									<div class="wc-order-preview-address">
										<h2>Детали оплаты</h2>
										{{{ data.formatted_billing_address }}}

										<# if ( data.data.billing.email ) { #>
											<strong>Email</strong>
											<a href="mailto:{{ data.data.billing.email }}">{{ data.data.billing.email }}</a>
										<# } #>

										<# if ( data.data.billing.phone ) { #>
											<strong>Телефон</strong>
											<a href="tel:{{ data.data.billing.phone }}">{{ data.data.billing.phone }}</a>
										<# } #>

										<# if ( data.payment_via ) { #>
											<strong>Платёж через</strong>
											{{{ data.payment_via }}}
										<# } #>
									</div>
									<# if ( data.needs_shipping ) { #>
										<div class="wc-order-preview-address">
											<h2>Детали доставки</h2>
											<# if ( data.ship_to_billing ) { #>
												{{{ data.formatted_billing_address }}}
											<# } else { #>
												<a href="{{ data.shipping_address_map_url }}" target="_blank">{{{ data.formatted_shipping_address }}}</a>
											<# } #>

											<# if ( data.shipping_via ) { #>
												<strong>Метод доставки</strong>
												{{ data.shipping_via }}
											<# } #>
										</div>
									<# } #>

									<# if ( data.data.customer_note ) { #>
										<div class="wc-order-preview-note">
											<strong>Заметка</strong>
											{{ data.data.customer_note }}
										</div>
									<# } #>
								</div>

								{{{ data.item_html }}}

								????????

	*/

	//Стираем буфер вывода нафиг
	ob_clean ();

	//сдесь пишем свой код вывода, который будет вместо стертого
	print_overrided_code($t);

}

function print_overrided_code($t){
	//echo $t; //Вывести оригинальное содержание	
	?>
	
	<div class="wc-order-preview-addresses">
		<div class="wc-order-preview-address">
			<h2><?php esc_html_e( 'Billing details', 'woocommerce' ); ?></h2>
			{{{ data.formatted_billing_address }}}

			<# if ( data.data.billing.email ) { #>
				<strong><?php esc_html_e( 'Email', 'woocommerce' ); ?></strong>
				<a href="mailto:{{ data.data.billing.email }}">{{ data.data.billing.email }}</a>
			<# } #>

			<# if ( data.data.billing.phone ) { #>
				<strong><?php esc_html_e( 'Phone', 'woocommerce' ); ?></strong>
				<a href="tel:{{ data.data.billing.phone }}">{{ data.data.billing.phone }}</a>
			<# } #>

			<# if ( data.payment_via ) { #>
				<strong><?php esc_html_e( 'Payment via', 'woocommerce' ); ?></strong>
				{{{ data.payment_via }}}
			<# } #>
		</div>
		<# if ( data.needs_shipping ) { #>
			<div class="wc-order-preview-address">
				<h2><?php esc_html_e( 'Shipping details', 'woocommerce' ); ?></h2>
				<# if ( data.ship_to_billing ) { #>
					{{{ data.formatted_billing_address }}}
				<# } else { #>
					<a href="{{ data.shipping_address_map_url }}" target="_blank">{{{ data.formatted_shipping_address }}}</a>
				<# } #>

				<# if ( data.shipping_via ) { #>
					<strong><?php esc_html_e( 'Shipping method', 'woocommerce' ); ?></strong>
					{{ data.shipping_via }}
				<# } #>
			</div>
		<# } #>

		<# if ( data.data.customer_note ) { #>
			<div class="wc-order-preview-note">
				<strong><?php esc_html_e( 'Note', 'woocommerce' ); ?></strong>
				{{ data.data.customer_note }}
			</div>
		<# } #>
	</div>

	{{{ data.item_html }}}
	
	<?php
}