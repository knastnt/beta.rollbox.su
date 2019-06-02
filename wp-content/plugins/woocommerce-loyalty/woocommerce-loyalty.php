<?php
/*
 * Plugin Name: Woocommerce Loyalty. Программа лояльности
 * Description: Позволяет гибко настраивать программу лояльности и вознаграждения
 * Version:     0.1
 */





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

        // страница настроек плагина
        require_once( plugin_dir_path(__FILE__ ) . '/options/options-page.php' );

        woocommerceLoyalty_Options::instance();

    }



}