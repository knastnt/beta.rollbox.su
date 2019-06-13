<?php

//Переопределяем функцию купил ли пользователь этот товар или нет. Проблема была в том, что пользователь мог
// отправить отзыв и получить баллы даже при невыполненном заказе
add_action( 'woocommerce_pre_customer_bought_product', array('WC_Loy_Functions', 'rewrite_wc_customer_bought_product'), 10, 4 );


class WC_Loy_Functions
{

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function rewrite_wc_customer_bought_product( $null, $customer_email, $user_id, $product_id ) {
        //Заменяем логику метода wc_customer_bought_product в файле wp-content/plugins/woocommerce/includes/wc-user-functions.php
        //только потому что поле $statuses      = array_map( 'esc_sql', wc_get_is_paid_statuses() ); должно возвращать только статус COMPLETED.
        // я не стал переопределять wc_get_is_paid_statuses, т.к. он много где используется.
        // Иных способов вроде как нет.
        //придется переберать все ордера со статусом completed и искать в них этот товар.

        // User must be logged in
        if ( $user_id == 0 ){
            return false;
        }

        //не делал - Если у этого товара есть хоть один комментарий от этого пользователя, то return true;

        //Нужно получить все ордера со статусом completed у пользователя $user_id
        //Если ни в одном из них нет продукта с ID = $product_id, то return false
        //В противном случае return true

        $orders = wc_get_orders( array(
            'customer_id' => $user_id,
            'status' => 'completed',
        ) );

        //Если совсем нет завершенных заказов
        if ( count($orders) == 0 ) {
            return false;
        }

        //Перебераем все товары в каждом найденном ордере
        foreach ($orders as $order) {
            $order_item = $order->get_items();
            foreach ($order_item as $product) {
                if ($product_id == $product->get_product_id()) return true;
            }
        }


        return false;
        //return $null;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



}