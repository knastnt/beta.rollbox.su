<?php
/*
 * Plugin Name: MyCred Loyalty Addon. Программа лояльности
 * Description: Дополнение к MyCred, позволяющее гибко настраивать программу лояльности и вознаграждения
 * Version:     0.1
 */





mycred_loyalty_addon_core();

function mycred_loyalty_addon_core() {
    return mycredLoyaltyAddon_Core::instance();
}


final class mycredLoyaltyAddon_Core
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

        mycredLoyaltyAddon_Options::load();

    }



}