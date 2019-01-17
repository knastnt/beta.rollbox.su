<?php

/**
 * убираются лишние способы доставки в зависимости от цены
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 * 
 * на основе https://docs.woocommerce.com/document/hide-other-shipping-methods-when-free-shipping-is-available/
 */
function clear_shipping_methods($available_methods) {
	$returned_methods = array();
	$free_delivery = 0; //0 - no free, 1 - in town, 2 - for all
	foreach ( $available_methods as $method ){
		if($method->get_label() == 'Бесплатная доставка по городу') $free_delivery++;
		if($method->get_label() == 'Бесплатная доставка') $free_delivery++;
	}
	foreach ( $available_methods as $method ){
		switch ($method->get_label()) {
			case 'Самовывоз':
				$returned_methods[] = $method;
				break;
			case 'Бесплатная доставка по городу':
				if($free_delivery == 1){
					$returned_methods[] = $method;
				}
				break;
			case 'Бесплатная доставка':
				if($free_delivery == 2){
					$returned_methods[] = $method;
				}
				break;
			case 'Центральный округ':
				if($free_delivery == 0){
					$returned_methods[] = $method;
				}
				break;
			case 'Ленинский округ':
				if($free_delivery == 0){
					$returned_methods[] = $method;
				}
				break;
			case 'За город':
				if($free_delivery < 2){
					$returned_methods[] = $method;
				}
				break;
		}
	}
	return $returned_methods;
}
add_filter( 'woocommerce_package_rates', 'clear_shipping_methods', 100 );

 ?>