<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 02.06.2019
 * Time: 17:51
 */

class WC_Loy_UserMeta
{
    //Имя метаполя
    const META_NAME = '_woocommerce_loyalty_plugin_protected_meta';


    //Данные защищенного метаполя у пользователей
    const PROTECTED_USER_META = array(
        "points" => "0",  //Баллы
        "points_history" => array( //История изменений баллов
            "time" => "",
            "change" => "",
            "description" => "",
        ),
    );


    /**
     * WC_Loy_UserMeta constructor.
     */
    public function __construct($user_id)
    {

        $test = get_user_meta($user_id, self::META_NAME);
        if (!$test) {
            // Нет таких метаданных, нужно создать
            update_user_meta($user_id, self::META_NAME, self::PROTECTED_USER_META);
            $test = get_user_meta($user_id, self::META_NAME);
        }
        var_dump($test);
        delete_user_meta($user_id, self::META_NAME);
    }
}