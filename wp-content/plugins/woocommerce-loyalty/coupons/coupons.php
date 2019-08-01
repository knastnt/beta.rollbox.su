<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08.06.2019
 * Time: 15:18
 */

//Поле в свойствах купона
add_action( 'woocommerce_coupon_options', array('Coupons', 'only_for_user_id_input'), 10, 0 );
//Сохранение значения поля в свойствах купона
add_action( 'woocommerce_coupon_options_save', array('Coupons', 'save_conly_for_user_id_input'));
//Проверка значения поня при применении купона
add_action( 'woocommerce_coupon_is_valid', array('Coupons', 'check_user_id_when_coupon_apply'), 10, 3);

//Начисление бонусов при выполнении заказа
add_action( 'woocommerce_order_status_completed', array( 'Coupons', 'add_bonus_when_order_complete' ) );
//Начисление бонусов за регистрацию
add_action( 'user_register', array( 'Coupons', 'add_bonus_when_user_registred') );

//Начисление бонусов за оставление комментариев
add_action('comment_post', array( 'Coupons', 'post_comment'), 10, 2);
add_action('transition_comment_status', array( 'Coupons', 'change_comment_status'), 10, 3);

class Coupons
{

    static function only_for_user_id_input() {
        woocommerce_wp_text_input( array(
            'id' => 'only_for_user_id',
            'type' => 'number',
            'label' => 'Только для пользователя с ID =',
            'description' => 'Укажите ID пользователя. Только он сможет использовать этот купон. 0 - ограничений нет'
        ) );
    }

    static function save_conly_for_user_id_input( $post_id ) {
        $only_for_user_id = isset( $_POST['only_for_user_id'] ) ? intval( $_POST['only_for_user_id'] ) : 0;
        update_post_meta( $post_id, 'only_for_user_id', $only_for_user_id );
    }

    static function check_user_id_when_coupon_apply( $true_p, $coupon_p, $this_p ) {
        $user_id = get_post_meta( $coupon_p->get_id(), 'only_for_user_id' );
        $user_id = isset( $user_id[0] ) ? intval($user_id[0]) : 0;

        if ($user_id > 0) {
            if ($user_id != get_current_user_id()) {
                throw new Exception( sprintf( 'Купон "%s" Вам не доступен!',  $coupon_p->get_code() ), 105 );
            }
        }

        return $true_p;
    }

    //Начисление бонусов при выполнении заказа
    static function add_bonus_when_order_complete( $order_ID ) {

        //Получаем ордер
        $order = wc_get_order( $order_ID );
        //Если такого ордера нет, то ничего не делаем
        if (!$order) return;

        //Получаем ID покупателя
        $user = $order->get_user();
        // Если юзер не возвращён (т.е. гость), то ничего не делаем
        if ($user == false) return;
        $user_id = $user->ID;

        //Получаем значение процента возврата от суммы ордера
        $percentOfPointReturning = woocommerceLoyalty_Options::instance()->getPercentOfPointReturning();
        //Если 0, то ничего не делаем
        if ($percentOfPointReturning == 0) return;

        //Получаем количество бонусов для возврата
        $pointsToReturn = intval($order->get_total() * $percentOfPointReturning * 0.01);
        //Если 0, то ничего не делаем
        if ($pointsToReturn == 0) return;


        //Получаем метаданные пользователя, относящиеся к плагину
        $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

        //Проверка, начислялись ли бонусы за этот заказ
        $origincode = 'fromOrder_' . $order_ID; //Генерируем значение источника и проверяем нет ли такого у пользователя
        $isOriginCodeExistInHistory = $wc_loy_usermeta->isOriginCodeExistInHistory($origincode);
        //Если бонусы за это уже начислялись - то ничего не делаем
        if ($isOriginCodeExistInHistory == true) return;



        //Если все тесты пройдены - начисляем бонусы
        $wc_loy_usermeta->addPoints($pointsToReturn, 'Начисление за заказ <a href="' . $order->get_view_order_url() . '">№' . $order_ID . '</a>', $origincode);
    }

    //Начисление бонусов за регистрацию
    static function add_bonus_when_user_registred( $user_id ) {

        //Получаем количество бонусов для зачисления при регистрации
        $pointsForRegistration = woocommerceLoyalty_Options::instance()->getPointsForRegistration();
        //Если 0, то ничего не делаем
        if ($pointsForRegistration == 0) return;


        //Получаем метаданные пользователя, относящиеся к плагину
        $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

        //Проверка, начислялись ли бонусы за этот заказ
        $origincode = 'fromRegistration'; //Генерируем значение источника и проверяем нет ли такого у пользователя
        $isOriginCodeExistInHistory = $wc_loy_usermeta->isOriginCodeExistInHistory($origincode);
        //Если бонусы за это уже начислялись - то ничего не делаем
        if ($isOriginCodeExistInHistory == true) return;



        //Если все тесты пройдены - начисляем бонусы
        $wc_loy_usermeta->addPoints($pointsForRegistration, "Начисление за регистрацию", $origincode);
    }


    /**
     * Если комментарий требует одобрения, то он проходит через изменение статуса, если не требует - то через post_comment
     */
    //Начисление бонусов за оставление комментариев при изменении статуса на approved
    static function change_comment_status( $new_status, $old_status, $wp_comment ) {
       if( $new_status == 'approved' ){
           self::add_bonus_for_comment( $wp_comment );
       }
    }
    //Начисление бонусов за оставление комментариев при публикации
    static function post_comment( $comment_ID, $comment_approved ) {
        //Получаем комментарий из его ID
        $wp_comment = get_comment( $comment_ID );
        // Если коммент не существует, то ничего не делаем
        if ($wp_comment == null) return;

        if( 1 === $comment_approved ){
            self::add_bonus_for_comment( $wp_comment );
        }
    }

    //Начисление бонусов за комментарий
    static function add_bonus_for_comment( $wp_comment ) {

        //Получаем ID пользователя, оставившего коммент
        $user_id = $wp_comment->user_id;
        // Если юзер не существует, то ничего не делаем
        if ($user_id == 0) return;


        //ID записи, на которой оставили этот коммент
        $post_ID = $wp_comment->comment_post_ID;
        $post = get_post($post_ID);
        if ($post->post_type == "product") {
            //Если коммент оставлен товару

            //Получаем количество бонусов для зачисления за отзыв
            $pointsForReview = woocommerceLoyalty_Options::instance()->getPointsForReview();
            //Если 0, то ничего не делаем
            if ($pointsForReview == 0) return;

            //Получаем метаданные пользователя, относящиеся к плагину
            $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

            //Проверка, начислялись ли бонусы за комментирование этого товара
            $origincode = 'fromProductComment_' . $post_ID; //Генерируем значение источника и проверяем нет ли такого у пользователя
            $isOriginCodeExistInHistory = $wc_loy_usermeta->isOriginCodeExistInHistory($origincode);
            //Если бонусы за это уже начислялись - то ничего не делаем
            if ($isOriginCodeExistInHistory == true) return;

            //Если все тесты пройдены - начисляем бонусы
            $wc_loy_usermeta->addPoints($pointsForReview, 'Начисление за отзыв. <a href="' . get_permalink( $post_ID ) . '">' . $post->post_title . '</a>', $origincode);
        }

    }
}