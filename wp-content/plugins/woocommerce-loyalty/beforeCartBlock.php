<?php


add_action( 'woocommerce_before_cart', 'wc_loy_before_cart_block', 20 );

function wc_loy_before_cart_block() {

    $wc_loy_UserMeta = new WC_Loy_UserMeta(get_current_user_id());
    $is_freeze = !$wc_loy_UserMeta->isPointsUnfreeze();

    ?>
        <div class="wc-loy-beforeCart">
            <h3>Вы можете использовать свои купоны чтобы получить скидку к заказу</h3>
            <div class="coupons-wrapper">
                <div class="coupon-wrapper">
                    <div class="coupon">
                        <div class="code">bwe8o7rewt</div>
                        <div class="title">Скидка 50 рублей</div>
                        <div class="description">Получите скидку на только вот это</div>
                        <div class="time">Действует до: 01.07.2019</div>
                    </div>
                </div>
                <div class="coupon-wrapper buy-coupon <?php if($is_freeze) { echo 'disable'; } ?>">
                    <div class="coupon">
                        <div class="code"></div>
                        <div class="title">Обмен бонусов на купоны</div>
                        <div class="description">
                            <?php if($is_freeze) {  ?>
                            Вы можете обменять бонусы на купоны только после выполнения заказов на сумму <?php echo woocommerceLoyalty_Options::instance()->getSumOfPointsUnfreeze(); ?> рублей
                            <?php } else {  ?>
                            Ваш бонусный счёт: <?php echo $wc_loy_UserMeta->getPoints(); ?> б.
                            <?php } ?>
                        </div>
                        <div class="time"></div>
                    </div>
                </div>
            </div>

        </div>
    <?php

}