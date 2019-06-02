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
    public static $coupons_numinals =                array (10, 50,  100, 200, 500,  1000, 1500, 2000); //Купоны в ркблях
    public static $coupons_numinals_default_points = array (0,  250, 450, 800, 1750, 3000, 0,    5000); //Соответственные цены в баллах

}