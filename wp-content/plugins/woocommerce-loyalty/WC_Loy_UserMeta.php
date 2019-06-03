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

    //ID пользователя
    private $user_id;

    //Данные защищенного метаполя у пользователей
    private $protected_user_meta = array(
        "points" => 0,  //Баллы
        "points_history" => array(), //История изменений баллов
        "rating" => 0, //Рейтинг пользователя
    );


    /**
     * WC_Loy_UserMeta constructor.
     */
    public function __construct($user_id)
    {

        $test = get_user_meta($user_id, self::META_NAME);
        if (!$test) {
            // Нет таких метаданных, нужно создать
            update_user_meta($user_id, self::META_NAME, $this->protected_user_meta);
            $test = get_user_meta($user_id, self::META_NAME);
        }
        $this->user_id = $user_id;
        $this->protected_user_meta = $test[0];
        unset($test);

        /*$res = $this->addPoints(15, "Вознаграждение за регистрацию, например");
        $res = $this->addPoints(-10, "тест");
        $res = $this->removePoints(-10, "тест");
        $res = $this->removePoints(600, "тест");
        $res = $this->removePoints(5, "Обмен баллов на купон со скидкой");

        var_dump($res);
        delete_user_meta($user_id, self::META_NAME);*/
    }


    public function addPoints ( $count, $description ) {
        $count = intval($count);
        if ($count <= 0) { return false; }

        return $this->changePoints($count, $description);
    }

    public function removePoints ( $count, $description ) {
        $count = intval($count);
        if ($count <= 0) { return false; }

        if ( $count > $this->protected_user_meta["points"] ) { return false; }

        return $this->changePoints(-$count, $description);
    }

    public function getPoints() {
        return $this->protected_user_meta["points"];
    }
    public function getPointsHistory() {
        return $this->protected_user_meta["points_history"];
    }

    private function changePoints ( $count, $description ) {
        $count = intval($count);
        if ($count == 0) { return false; }

        $temp = (new ArrayObject($this->protected_user_meta))->getArrayCopy();

        // Если в результате вычитания результат будет отрицательным, то вычитаем меньше. Чтобы результат был = 0
        if ( $count < 0 && $temp["points"] + $count < 0 ) { $count = -$temp["points"]; }

        $temp["points"] = $temp["points"] + $count;
        $temp["points_history"][] = array ( "time" => (int) current_time('timestamp'), "change" => $count, "description" => $description);

        //Если $count > 0, то и рейтинг увеличиваем
        if ($count>0) {
            $temp["rating"] = $temp["rating"] + $count;
        }

        $result = update_user_meta($this->user_id, self::META_NAME, $temp);
        if ($result) {
            $this->protected_user_meta = $temp;
        }
        return $result;
    }



    public function addRating ( $count ) {
        $count = intval($count);
        if ($count <= 0) { return false; }

        $temp = (new ArrayObject($this->protected_user_meta))->getArrayCopy();

        $temp["rating"] = $temp["rating"] + $count;

        $result = update_user_meta($this->user_id, self::META_NAME, $temp);
        if ($result) {
            $this->protected_user_meta = $temp;
        }
        return $result;
    }

    public function getRating() {
        return $this->protected_user_meta["rating"];
    }
}