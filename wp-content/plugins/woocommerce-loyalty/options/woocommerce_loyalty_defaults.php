<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.06.2019
 * Time: 16:27
 */

class woocommerce_loyalty_defaults
{

    // Перечень скидочных купонов и их стоимости в баллах
    public static $coupons_numinals =                array (10, 50,  100, 200, 500,  1000, 1500, 2000); //Купоны в ркблях
    public static $coupons_numinals_default_points = array (0,  250, 450, 800, 1750, 3000, 0,    5000); //Соответственные цены в баллах

}