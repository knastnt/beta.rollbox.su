<?php

// https://wp-kama.ru/id_3773/api-optsiy-nastroek.html

class mycredLoyaltyAddon_Options
{

    // Instnace
    protected static $_instance = NULL;

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    public function __construct()
    {

        /**
         * Регистрируем страницу настроек плагина
         */
        //add_action('admin_menu', 'add_plugin_page');
        add_action('admin_menu', array( $this, 'add_plugin_page' ));

        /**
         * Регистрируем настройки.
         * Настройки будут храниться в массиве, а не одна настройка = одна опция.
         */
        add_action('admin_init', array( $this, 'plugin_settings'));

    }



    public function add_plugin_page()
    {
        add_options_page('MyCred Loyalty Addon. Настройки.', 'MyCred Loyalty Addon', 'manage_options', 'mycred_loyalty_addon', array ($this, 'mycred_loyalty_addon_options_page_output') );
    }

    public function mycred_loyalty_addon_options_page_output()
    {
        ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

            <form action="options.php" method="POST">
                <?php
                // скрытые защитные поля
                settings_fields('option_group');

                // Секции с настройками (опциями). (section_id_1, ...)
                do_settings_sections('mycred_loyalty_addon_page');

                //Кнопка сохранить
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }


    public function plugin_settings()
    {
        // параметры: $option_group, $kristall_options_array, $sanitize_callback
        register_setting('option_group', 'mycred_loyalty_addon_options_array', array( $this, 'sanitize_callback'));

        // Раздел Программа лояльности
        add_settings_section('section_id_1', 'Программа лояльности', '', 'mycred_loyalty_addon_page');

        add_settings_field('sumOfPointsUnfreeze', 'Сумма, на которую клиент должен набрать товаров, чтобы разморозить свои баллы', array( $this, 'fill_sumOfPointsUnfreeze'), 'mycred_loyalty_addon_page', 'section_id_1');
        add_settings_field('percentOfPointReturning', 'Процент от суммы заказа, который будет возвращаться баллами', array ( $this, 'fill_percentOfPointReturning'), 'mycred_loyalty_addon_page', 'section_id_1' );
        add_settings_field('pointsForRegistration', 'Баллы за регистрацию', array ( $this, 'fill_pointsForRegistration'), 'mycred_loyalty_addon_page', 'section_id_1' );
        add_settings_field('pointsForReview', 'Баллы за отзыв о товаре (можно получить только если ты купил этот товар и для каждого товара только однажды)', array ( $this, 'fill_pointsForReview'), 'mycred_loyalty_addon_page', 'section_id_1' );

        // Раздел Цены скидочных купонов в баллах
        add_settings_section('section_id_2', 'Цены скидочных купонов в баллах. (0 - не использовать такой купон)', '', 'mycred_loyalty_addon_page');

        $numinals =                array (10, 50,  100, 200, 500,  1000, 1500, 2000);
        $numinals_default_points = array (0,  250, 450, 800, 1750, 3000, 0,    5000);
        for($i = 0; $i < count($numinals); $i++){
            add_settings_field("rub_$numinals[$i]", "Скидка $numinals[$i] рублей", array( $this, 'fill_rub_numinals'), 'mycred_loyalty_addon_page', 'section_id_2', array( $numinals[$i], $numinals_default_points[$i] ));
        }


    }



## Заполняем опцию ID магазина
    public function fill_sumOfPointsUnfreeze()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['sumOfPointsUnfreeze']) ? $val['sumOfPointsUnfreeze'] : '500';
        ?>
        <input type="number" name="mycred_loyalty_addon_options_array[sumOfPointsUnfreeze]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }

    ## Заполняем опцию Процент от суммы заказа, который будет возвращаться баллами
    public function fill_percentOfPointReturning()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['percentOfPointReturning']) ? $val['percentOfPointReturning'] : 15;
        ?>
        <input type="number" name="mycred_loyalty_addon_options_array[percentOfPointReturning]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }

## Заполняем опцию Баллы за регистрацию
    public function fill_pointsForRegistration()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['pointsForRegistration']) ? $val['pointsForRegistration'] : 200;
        ?>
        <input type="number" name="mycred_loyalty_addon_options_array[pointsForRegistration]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }

## Заполняем опцию Баллы за отзыв о товаре
    public function fill_pointsForReview()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['pointsForReview']) ? $val['pointsForReview'] : 30;
        ?>
        <input type="number" name="mycred_loyalty_addon_options_array[pointsForReview]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }





## Заполняем опцию Баллы за отзыв о товаре
    public function fill_rub_numinals( $args )
    {
        $numinal = $args[0];
        $default_points = $args[1];
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val["rub_$numinal"]) ? $val["rub_$numinal"] : $default_points;
        ?>
        <input type="number" name="mycred_loyalty_addon_options_array[rub_<?php echo $numinal; ?>]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }



## Очистка данных
    public function sanitize_callback($options)
    {
        // очищаем
        foreach ($options as $name => & $val) {

            if ($name == 'sumOfPointsUnfreeze') {
                $val = intval($val);
            }

            if ($name == 'percentOfPointReturning') {
                $val = intval($val);
            }

            if ($name == 'pointsForRegistration') {
                $val = intval($val);
            }

            if ($name == 'pointsForReview') {
                $val = intval($val);
            }

            if (preg_match("/^rub_\\d+$/", $name)) {
                $val = intval($val);
            }


        }

        return $options;
    }

}