<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 28.05.2019
 * Time: 8:47
 */



// Регистрируем меню для футера
register_nav_menus(
    array(
        'footer_menu' => 'Меню в футере'
    )
);





class FooterMenuItem {
    public $ID;
    public $parent_ID;
    public $title;
    public $link;

    public $childs = array();

    public $childs_nav_link;

    public function __construct($ID)
    {
        $this->ID = $ID;
    }
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
add_shortcode( 'WC_Loy_Get_Footer_Menu', 'WC_Loy_Footer_Menu' );

function WC_Loy_Footer_Menu() {
    if (has_nav_menu('footer_menu')) {

        $menu_name = 'footer_menu';
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations[$menu_name]);
        $menuitems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC'));

        //те элементы у кого menu_item_parent = 0 - корневые
        $count = 0;
        foreach ($menuitems as $item) {
            if ($item->to_array()['menu_item_parent'] == 0) {
                //Корневой элемент
                $count++;
                if ($count > 3) break;
                $parent = $item->ID;
                ?>
                <div class="column column<?php echo $count; ?>">
                    <h3><?php echo $item->post_title; ?></h3>
                    <ul>
                        <?php
                            foreach ($menuitems as $item) {
                                if ($item->to_array()['menu_item_parent'] == $parent) {
                                    echo '<li><a href="' . $item->to_array()['url'] . '">' . $item->post_title . '</a></li>';
                                }
                            }
                        ?>
                    </ul>
                </div>
                <?php
            }

        }
    }
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////