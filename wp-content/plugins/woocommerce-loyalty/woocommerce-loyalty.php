<?php
/*
 * Plugin Name: Woocommerce Loyalty. Программа лояльности
 * Description: Позволяет гибко настраивать программу лояльности и вознаграждения
 * Version:     0.1
 */


//add_action( 'plugins_loaded', 'woocommerce_loyalty_core' );

woocommerce_loyalty_core();

function woocommerce_loyalty_core() {
    return woocommerceLoyalty_Core::instance();
}


final class woocommerceLoyalty_Core
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
        // правильный способ подключить стили и скрипты
        add_action('wp_print_styles', array( $this, 'true_include_styles')); // можно использовать этот хук он более поздний


        // значения по умолчанию
        require_once( plugin_dir_path(__FILE__ ) . '/options/woocommerce_loyalty_defaults.php' );


        // страница настроек плагина
        require_once( plugin_dir_path(__FILE__ ) . '/options/woocommerce_loyalty_options.php' );
        woocommerceLoyalty_Options::instance();

        //Класс метаданных пользователя
        require_once( plugin_dir_path(__FILE__ ) . '/WC_Loy_UserMeta.php' );

        //Класс шорткодов
        require_once( plugin_dir_path(__FILE__ ) . '/WC_Loy_Shortcodes.php' );

        //Блок над корзиной
        require_once( plugin_dir_path(__FILE__ ) . '/beforeCartBlock.php' );

        //new WC_Loy_UserMeta(1);
    }


    public function true_include_styles() {
        wp_enqueue_style( 'wc-loy-style', plugins_url('/wc_loy_style.css', __FILE__) );
    }

}