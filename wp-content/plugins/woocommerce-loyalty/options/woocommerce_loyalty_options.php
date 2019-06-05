<?php

// https://wp-kama.ru/id_3773/api-optsiy-nastroek.html

class woocommerceLoyalty_Options
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

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


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
        add_options_page('Woocommerce Loyalty. Настройки.', 'Woocommerce Loyalty', 'manage_options', 'woocommerce_loyalty', array ($this, 'woocommerce_loyalty_options_page_output') );
    }

    public function woocommerce_loyalty_options_page_output()
    {
        ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

            <form action="options.php" method="POST">
                <?php
                // скрытые защитные поля
                settings_fields('woocommerce_loyalty_option_group');

                // Секции с настройками (опциями). (section_id_1, ...)
                do_settings_sections('woocommerce_loyalty_page');

                //Кнопка сохранить
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }


    public function plugin_settings()
    {
        // параметры: $woocommerce_loyalty_option_group, $kristall_options_array, $sanitize_callback
        register_setting('woocommerce_loyalty_option_group', 'woocommerce_loyalty_options_array', array( $this, 'sanitize_callback'));

        // Раздел Основные параметры программы лояльности
        add_settings_section('section_id_1', 'Основные параметры программы лояльности', '', 'woocommerce_loyalty_page');

        $main_defaults = woocommerce_loyalty_defaults::$main_defaults;
        foreach ( $main_defaults as $key => $param) {
            $param['name'] = $key;
            add_settings_field($param['name'], $param['title'], array( $this, 'fill_main_defaults'), 'woocommerce_loyalty_page', 'section_id_1', $param);
        }


        // Раздел Цены скидочных купонов в баллах
        add_settings_section('section_id_2', 'Цены скидочных купонов в баллах. (0 - не использовать такой купон)', '', 'woocommerce_loyalty_page');

        $coupons_numinals_defaults = woocommerce_loyalty_defaults::$coupons_numinals_defaults;
        foreach ( $coupons_numinals_defaults as $entry) {
            add_settings_field("rub_$entry[coupon_rub]", "Скидка $entry[coupon_rub] рублей", array( $this, 'fill_rub_numinals'), 'woocommerce_loyalty_page', 'section_id_2', $entry);
        }


    }



    ## Заполняем основные опции
    public function fill_main_defaults( $args )
    {
        $val = get_option('woocommerce_loyalty_options_array');
        $val = isset($val[$args['name']]) ? $val[$args['name']] : $args['default'];
        ?>
        <input type="<?php echo $args['type']; ?>" name="woocommerce_loyalty_options_array[<?php echo $args['name']; ?>]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }






    ## Заполняем опции скидочных купонов
    public function fill_rub_numinals( $args )
    {
        $numinal = $args['coupon_rub'];
        $default_points = $args['coupun_price_in_points'];
        $val = get_option('woocommerce_loyalty_options_array');
        $val = isset($val["rub_$numinal"]) ? $val["rub_$numinal"] : $default_points;
        ?>
        <input type="number" name="woocommerce_loyalty_options_array[rub_<?php echo $numinal; ?>]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }



## Очистка данных
    public function sanitize_callback($options)
    {
        // очищаем
        foreach ($options as $name => & $val) {

            // Числа из основных параметров
            if ( in_array($name, array ('sumOfPointsUnfreeze', 'percentOfPointReturning', 'pointsForRegistration', 'pointsForReview')) ) {
                $val = intval($val);
            }

           // Скидочные купоны
            if (preg_match("/^rub_\\d+$/", $name)) {
                $val = intval($val);
            }


        }

        return $options;
    }



    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Геттеры опций
    public function getSumOfPointsUnfreeze()
    {
        $optionsArray = get_option('woocommerce_loyalty_options_array');
        $defaultValue = woocommerce_loyalty_defaults::$main_defaults['sumOfPointsUnfreeze']['default'];

        // Из настроек. Сумма, на которую нужно набрать заказов, чтобы разморозить баллы
        $sumOfPointsUnfreeze = isset($optionsArray['sumOfPointsUnfreeze']) ? $optionsArray['sumOfPointsUnfreeze'] : $defaultValue;

        return $sumOfPointsUnfreeze;
    }

}