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
<p>Выш текущий бонусный счёт: ' . $balance . '</p>';


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
    static function WC_Loy_My_Coupons() {

        $wc_loy_UserMeta = new WC_Loy_UserMeta(get_current_user_id());
        $is_freeze = !$wc_loy_UserMeta->isPointsUnfreeze();
        ?>

        <div class="coupons-wrapper">
            <div class="coupon-wrapper">
                <div class="coupon">
                    <div class="code">bwe8o7rewt</div>
                    <div class="title">Скидка 50 рублей</div>
                    <div class="description">Получите скидку на только вот это</div>
                    <div class="time">Действует до: 01.07.2019</div>
                </div>
            </div>
            <div class="coupon-wrapper buy-coupon <?php if ($is_freeze) {
                echo 'disable';
            } ?>">
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
            </div>
        </div>
        <?php
    }
}