<?php


add_action( 'woocommerce_before_cart', 'wc_loy_before_cart_block', 20 );

function wc_loy_before_cart_block() {

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
            </div>

        </div>
    <?php

}