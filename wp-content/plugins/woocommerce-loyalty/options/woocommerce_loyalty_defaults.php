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
        "sumOfPointsUnfreeze" => array(
            "type" => "number",
            "default" => "500",
            "title" => "Сумма, на которую клиент должен сделать заказов, чтобы разморозить свои бонусы"
        ),
        "percentOfPointReturning" => array(
            "type" => "number",
            "default" => "15",
            "title" => "Процент от суммы заказа, который будет возвращаться бонусами"
        ),
        "pointsForRegistration" => array(
            "type" => "number",
            "default" => "200",
            "title" => "Бонусы за регистрацию"
        ),
        "pointsForReview" => array(
            "type" => "number",
            "default" => "30",
            "title" => "Бонусы за отзыв о товаре (можно получить только если ты купил этот товар и для каждого товара только однажды)"
        ),
    );




    // Перечень скидочных купонов и их стоимости в бонусах
    public static $coupons_numinals_defaults = array(
        'fixed_10' => array(
            "coupon_rub" => "10",  //Купоны в рублях
            "coupun_price_in_points" => "0", //Соответственные цены в бонусах
        ),
        'fixed_50' => array(
            "coupon_rub" => "50",
            "coupun_price_in_points" => "250",
        ),
        'fixed_100' => array(
            "coupon_rub" => "100",
            "coupun_price_in_points" => "450",
        ),
        'fixed_200' => array(
            "coupon_rub" => "200",
            "coupun_price_in_points" => "800",
        ),
        'fixed_500' => array(
            "coupon_rub" => "500",
            "coupun_price_in_points" => "1750",
        ),
        'fixed_1000' => array(
            "coupon_rub" => "1000",
            "coupun_price_in_points" => "3000",
        ),
        'fixed_2000' => array(
            "coupon_rub" => "2000",
            "coupun_price_in_points" => "5000",
        ),
    );




}