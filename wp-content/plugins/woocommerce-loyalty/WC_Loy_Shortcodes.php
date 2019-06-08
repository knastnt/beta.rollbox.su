<?php


add_shortcode( 'WC_Loy_Get_Current_User_Points', array( 'WC_Loy_Shortcodes', 'WC_Loy_User_Points' ) );
add_shortcode( 'WC_Loy_Get_Current_User_Points_History', array( 'WC_Loy_Shortcodes', 'WC_Loy_User_Points_History' ) );
add_shortcode( 'WC_Loy_Get_Current_User_Rating', array( 'WC_Loy_Shortcodes', 'WC_Loy_User_Rating' ) );
add_shortcode( 'WC_Loy_Bonus_to_Coupons_Exchange', array( 'WC_Loy_Shortcodes', 'WC_Loy_Bonus_to_Coupons_Exchange' ) );


class WC_Loy_Shortcodes
{
    static function WC_Loy_User_Points() {
        $cur_user_id = get_current_user_id();
        if ($cur_user_id == 0) { return ""; }

        $WCLoyUserMeta = new WC_Loy_UserMeta($cur_user_id);

        return $WCLoyUserMeta->getPoints();
    }
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

    static function WC_Loy_User_Rating() {
        $cur_user_id = get_current_user_id();
        if ($cur_user_id == 0) { return ""; }

        $WCLoyUserMeta = new WC_Loy_UserMeta($cur_user_id);

        return $WCLoyUserMeta->getRating();
    }

    static function WC_Loy_Bonus_to_Coupons_Exchange() {
        echo 'exchange';
    }
}