<?php

// https://wp-kama.ru/id_3773/api-optsiy-nastroek.html

class mycredLoyaltyAddon_Options
{


    public function load()
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
        //add_action('admin_init', 'plugin_settings');

    }



    private function add_plugin_page()
    {
        add_options_page('MyCred Loyalty Addon. Настройки.', 'MyCred Loyalty Addon', 'manage_options', 'mycred_loyalty_addon', 'mycred_loyalty_addon_options_page_output');
    }

    private function mycred_loyalty_addon_options_page_output()
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


    private function plugin_settings()
    {
        // параметры: $option_group, $kristall_options_array, $sanitize_callback
        register_setting('option_group', 'mycred_loyalty_addon_options_array', 'sanitize_callback');

        /*// параметры: $id, $title, $callback, $page
        add_settings_section( 'section_id_1', 'Основные настройки', '', 'mycred_loyalty_addon_page' );

        // параметры: $id, $title, $callback, $page, $section, $args
        add_settings_field('primer_field1', 'Название опции', 'fill_primer_field1', 'mycred_loyalty_addon_page', 'section_id_1' );
        add_settings_field('primer_field2', 'Другая опция', 'fill_primer_field2', 'mycred_loyalty_addon_page', 'section_id_1' );*/


        // Раздел ID магазина
        add_settings_section('section_id_1', 'Идентификатор магазина', '', 'mycred_loyalty_addon_page');
        // ID магазина
        add_settings_field('shopId', 'Идентификатор магазина', 'fill_shopId', 'mycred_loyalty_addon_page', 'section_id_1');


        // Раздел
        add_settings_section('section_id_2', 'Отправка новых заказов в кристалл', '', 'mycred_loyalty_addon_page');

        // Чекбокс отправлять корзину
        add_settings_field('send_new_orders_to_kristall', 'Отправлять новые заказы в кристалл', 'fill_send_new_orders_to_kristall', 'mycred_loyalty_addon_page', 'section_id_2');

        // URL для отправки POST
        add_settings_field('send_new_orders_to_kristall_url', 'Адрес для отправки POST', 'fill_send_new_orders_to_kristall_url', 'mycred_loyalty_addon_page', 'section_id_2');


        // Раздел Настройка checkuot
        add_settings_section('section_id_3', 'Настройка checkuot', '', 'mycred_loyalty_addon_page');

        // Чекбокс скрыть div class=woocommerce-additional-fields в checkuot
        add_settings_field('hide_woocommerce_additional_fields_in_checkout', 'Скрыть контейнер Детали (woocommerce-additional-fields) и скрытие выбора способа оплаты (#payment.woocommerce-checkout-payment ul)', 'fill_hide_woocommerce_additional_fields_in_checkout', 'mycred_loyalty_addon_page', 'section_id_3');

        // URL для отправки GET и перенаправления пользователя в кристалл
        add_settings_field('redirect_user_to_kristall_url', 'Адрес для отправки GET и перенаправления пользователя (%ID% - номер заказа; %ShopID% - Идентификатор магазина)', 'fill_redirect_user_to_kristall_url', 'mycred_loyalty_addon_page', 'section_id_3');

    }

    /*## Заполняем опцию 1
    private function fill_primer_field1(){
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['input']) ? $val['input'] : null;
        ?>
        <input type="text" name="mycred_loyalty_addon_options_array[input]" value="<?php echo esc_attr( $val ) ?>" />
        <?php
    }

    ## Заполняем опцию 2
    private function fill_primer_field2(){
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['checkbox']) ? $val['checkbox'] : null;
        ?>
        <label><input type="checkbox" name="mycred_loyalty_addon_options_array[checkbox]" value="1" <?php checked( 1, $val ) ?> /> отметить</label>
        <?php
    }*/

## Заполняем опцию ID магазина
    private function fill_shopId()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['shopId']) ? $val['shopId'] : '0';
        ?>
        <input type="text" name="mycred_loyalty_addon_options_array[shopId]" value="<?php echo esc_attr($val) ?>"
               style="width: 30%;"/>
        <?php
    }


## Заполняем опцию Отправлять новые заказы в кристалл
    private function fill_send_new_orders_to_kristall()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['send_new_orders_to_kristall']) ? $val['send_new_orders_to_kristall'] : 0;
        ?>
        <label><input type="checkbox" name="mycred_loyalty_addon_options_array[send_new_orders_to_kristall]"
                      value="1" <?php checked(1, $val) ?> /> отправлять</label>
        <?php
    }

## Заполняем опцию Адрес для отправки POST
    private function fill_send_new_orders_to_kristall_url()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['send_new_orders_to_kristall_url']) ? $val['send_new_orders_to_kristall_url'] : 'http://kristal-online.ru/wordpress-integration.php';
        ?>
        <input type="text" name="mycred_loyalty_addon_options_array[send_new_orders_to_kristall_url]"
               value="<?php echo esc_attr($val) ?>" style="width: 30%;"/>
        <?php
    }


## Заполняем опцию скрыть div class=woocommerce-additional-fields в checkuot
    private function fill_hide_woocommerce_additional_fields_in_checkout()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['hide_woocommerce_additional_fields_in_checkout']) ? $val['hide_woocommerce_additional_fields_in_checkout'] : 0;
        ?>
        <label><input type="checkbox"
                      name="mycred_loyalty_addon_options_array[hide_woocommerce_additional_fields_in_checkout]"
                      value="1" <?php checked(1, $val) ?> /> скрыть</label>
        <?php
    }

## Заполняем опцию Адрес для отправки GET и перенаправления пользователя
    private function fill_redirect_user_to_kristall_url()
    {
        $val = get_option('mycred_loyalty_addon_options_array');
        $val = isset($val['redirect_user_to_kristall_url']) ? $val['redirect_user_to_kristall_url'] : 'http://www.kristal-online.ru/api/api.php?data=aplyOrderWc&order_id=%ID%&shopId=%ShopID%';
        ?>
        <input type="text" name="mycred_loyalty_addon_options_array[redirect_user_to_kristall_url]"
               value="<?php echo esc_attr($val) ?>" style="width: 30%;"/>
        <?php
    }


## Очистка данных
    private function sanitize_callback($options)
    {
        // очищаем
        foreach ($options as $name => & $val) {
            /*if( $name == 'input' )
                $val = strip_tags( $val );

            if( $name == 'checkbox' )
                $val = intval( $val );*/

            if ($name == 'shopId') {
                $val = intval($val);
            }


            if ($name == 'send_new_orders_to_kristall') {
                $val = intval($val);
            }

            if ($name == 'send_new_orders_to_kristall_url') {
                $val = sanitize_text_field($val);
            }

            if ($name == 'fill_redirect_user_to_kristall_url') {
                $val = sanitize_text_field($val);
            }


            if ($name == 'hide_woocommerce_additional_fields_in_checkout') {
                $val = intval($val);
            }
        }

        //die(print_r( $options )); // Array ( [input] => aaaa [checkbox] => 1 )

        return $options;
    }

}