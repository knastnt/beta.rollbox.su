<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.06.2019
 * Time: 16:27
 */

class woocommerce_loyalty_defaults
{

    //Основные константы по-умолчанию
    public static $main_defaults = array(
        array(
            "name" => "sumOfPointsUnfreeze",
            "type" => "number",
            "default" => "500",
            "title" => "Сумма, на которую клиент должен набрать товаров, чтобы разморозить свои баллы"
        ),
        array(
            "name" => "percentOfPointReturning",
            "type" => "number",
            "default" => "15",
            "title" => "Процент от суммы заказа, который будет возвращаться баллами"
        ),
        array(
            "name" => "pointsForRegistration",
            "type" => "number",
            "default" => "200",
            "title" => "Баллы за регистрацию"
        ),
        array(
            "name" => "pointsForReview",
            "type" => "number",
            "default" => "30",
            "title" => "Баллы за отзыв о товаре (можно получить только если ты купил этот товар и для каждого товара только однажды)"
        ),
    );




    // Перечень скидочных купонов и их стоимости в баллах
    public static $coupons_numinals_defaults = array(
        array(
            "coupon_rub" => "10",  //Купоны в рублях
            "coupun_price_in_points" => "0", //Соответственные цены в баллах
        ),
        array(
            "coupon_rub" => "50",
            "coupun_price_in_points" => "250",
        ),
        array(
            "coupon_rub" => "100",
            "coupun_price_in_points" => "450",
        ),
        array(
            "coupon_rub" => "200",
            "coupun_price_in_points" => "800",
        ),
        array(
            "coupon_rub" => "500",
            "coupun_price_in_points" => "1750",
        ),
        array(
            "coupon_rub" => "1000",
            "coupun_price_in_points" => "3000",
        ),
        array(
            "coupon_rub" => "2000",
            "coupun_price_in_points" => "5000",
        ),
    );




}