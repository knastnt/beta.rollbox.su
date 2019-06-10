<?php


add_shortcode( 'WC_Loy_Get_Current_User_Points', array( 'WC_Loy_Shortcodes', 'WC_Loy_User_Points' ) );
add_shortcode( 'WC_Loy_Get_Current_User_Points_History', array( 'WC_Loy_Shortcodes', 'WC_Loy_User_Points_History' ) );
add_shortcode( 'WC_Loy_Get_Current_User_Rating', array( 'WC_Loy_Shortcodes', 'WC_Loy_User_Rating' ) );
add_shortcode( 'WC_Loy_Bonus_to_Coupons_Exchange', array( 'WC_Loy_Shortcodes', 'WC_Loy_Bonus_to_Coupons_Exchange' ) );
add_shortcode( 'WC_Loy_My_Coupons', array( 'WC_Loy_Shortcodes', 'WC_Loy_My_Coupons' ) );


class WC_Loy_Shortcodes
{
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function WC_Loy_User_Points() {
        $cur_user_id = get_current_user_id();
        if ($cur_user_id == 0) { return ""; }

        $WCLoyUserMeta = new WC_Loy_UserMeta($cur_user_id);

        return $WCLoyUserMeta->getPoints();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function WC_Loy_User_Points_History( $atts ) {
        // белый список параметров и значения по умолчанию
        $atts = shortcode_atts( array(
            //'class' => '',
            'limit' => '',
        ), $atts );

        $cur_user_id = get_current_user_id();
        if ($cur_user_id == 0) { return ""; }

        $WCLoyUserMeta = new WC_Loy_UserMeta($cur_user_id);

        $history = $WCLoyUserMeta->getPointsHistory();

        $toReturn = '';
        //echo '<ul class="' . $atts['class'] . '">';
        $displayed = 0;
        foreach ($history as $entry) {
            $displayed++;
            if ($atts['limit']) {
                if ($displayed > $atts['limit']) break;
            }

            $timestamp = $entry["time"];
            $time = date("d.m.Y h:i",$timestamp);
            $change = $entry["change"];
            $changeClass = $change > 0 ? 'plus' : 'minus';
            $descr = $entry["description"];

            $toReturn = $toReturn . '<li><div class="time">' . $time . '</div><div class="change ' . $changeClass . '">' . $change . '</div><div class="descr">' . $descr . '</div><div style="clear: both"></div> </li>';
        }
        //echo '</ul>';

        return $toReturn;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function WC_Loy_User_Rating() {
        $cur_user_id = get_current_user_id();
        if ($cur_user_id == 0) { return ""; }

        $WCLoyUserMeta = new WC_Loy_UserMeta($cur_user_id);

        return $WCLoyUserMeta->getRating();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function WC_Loy_Bonus_to_Coupons_Exchange() {
        $output = '';

        $user_id = get_current_user_id();
        if ($user_id == 0) return;

        $wc_loy_usermeta = new WC_Loy_UserMeta($user_id);

        $balance = $wc_loy_usermeta->getPoints();


        // Show users current balance
        $output .= '
<p>Ваш бонусный счёт: ' . $balance . '</p>';


        $output .= '
<form action="" method="post">
	<input type="hidden" name="points_to_coupons[token]" value="' . wp_create_nonce( 'points-to-woo-coupon' ) . '" />
	<input type="hidden" name="points_to_coupons[balance]" value="' . $balance . '" />
	<div>';

        $coupons_numinals_defaults = woocommerce_loyalty_defaults::$coupons_numinals_defaults;
        foreach ( $coupons_numinals_defaults as $key => $entry) {
            $htmlName = 'coupon[' . $key . ']';
            $coupon = $key;
            $amount = $entry['coupon_rub'];
            $price = woocommerceLoyalty_Options::instance()->getPriceOfCoupon($key);
            if ($price > 0) {
                $output .= '<input type="radio" id="' . $htmlName . '" name="coupon" value="' . $coupon . '"><label for="' . $htmlName . '">Купон на ' . $amount . ' руб. = ' . $price . ' бонусов</label>';
            }
        }

        $output .= '</div>
	<input type="submit" name="submit" value="Обменять" />
</form>';

        echo $output;
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function WC_Loy_My_Coupons($atts) {

        // User must be logged in
        if ( ! is_user_logged_in() ){
            return;
        }

        $user_id = get_current_user_id();
        $wc_loy_UserMeta = new WC_Loy_UserMeta($user_id);
        $is_freeze = !$wc_loy_UserMeta->isPointsUnfreeze();

        //Извлекаем параметры, переданные в шорткоде
        extract( shortcode_atts( array(
            'title' => '',
            'link_to_exchange' => '',
        ), $atts ) );


        //показываем только купоны у которых only_for_user_id == user_ID
        $args = array(
            'posts_per_page' => -1,
            'orderby'          => 'date',
            'post_type'        => 'shop_coupon',
            //'author'	   => $user_id,
            'post_status'      => 'publish',

            //'meta_key'    => 'only_for_user_id',
            //'meta_value'  => $user_id,

            'meta_query' => array(
                // meta query takes an array of arrays, watch out for this!
                array(
                    'key'     => 'only_for_user_id',
                    'value'   => $user_id,
                    //'value'   => array('anOption', 'anotherOption', 'thirdOption'),
                    //'compare' => 'IN'
                )
            )

        );

        $posts_array = get_posts( $args );

        ?>
        <div class="wc-loy-myCoupons">
        <h3><?php echo isset($atts['title']) ? $atts['title'] : 'Ваши купоны' ?></h3>
        <div class="coupons-wrapper">
        <?php

        foreach ( $posts_array as $coupon ) {

            // Get the name for each coupon post
            //$coupon_name = $coupon->post_title;
            $coupon_obj = new WC_Coupon( $coupon->ID);
            //https://docs.woocommerce.com/wc-apidocs/class-WC_Coupon.html
            if($coupon_obj->get_usage_count() > 0) continue;

            //echo $coupon_obj->get_code() . '  (скидка ' . $coupon_obj->get_amount() . ' руб.)<br>';
            ?>

            <div class="coupon-wrapper">
                <div class="coupon">
                    <div class="code"><?php echo $coupon_obj->get_code(); ?></div>
                    <div class="title">Скидка <?php echo $coupon_obj->get_amount(); ?> рублей</div>
                    <div class="description"><?php echo $coupon_obj->get_description(); ?></div>
                    <div class="time">Действует до: <?php echo $coupon_obj->get_date_expires()->date("d.m.Y"); ?></div>
                </div>
            </div>

            <?php

        }


        ?>


            <?php if ( isset($atts['link_to_exchange']) && $atts['link_to_exchange'] != '' ) { ?>
                    <div class="coupon-wrapper buy-coupon <?php if ($is_freeze) { echo 'disable'; } ?>">
                        <a href="<?php echo $atts['link_to_exchange']; ?>">
                        <div class="coupon">
                            <div class="code"></div>
                            <div class="title">Обмен бонусов на купоны</div>
                            <div class="description">
                                <?php if ($is_freeze) { ?>
                                    Вы можете обменять бонусы на купоны только после выполнения заказов на сумму <?php echo woocommerceLoyalty_Options::instance()->getSumOfPointsUnfreeze(); ?> рублей
                                <?php } else { ?>
                                    Ваш бонусный счёт: <?php echo $wc_loy_UserMeta->getPoints(); ?> б.
                                <?php } ?>
                            </div>
                            <div class="time"></div>
                        </div>
                        </a>
                    </div>
            <?php } ?>
        </div>
        </div>
        <?php
    }
}