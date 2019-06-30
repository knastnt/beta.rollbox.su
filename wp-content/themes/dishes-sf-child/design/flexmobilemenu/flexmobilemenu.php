<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 01.02.2019
 * Time: 21:06
 */

//Не делать ссылки у пунктов меню с дочерними элементами
define('NO_LINKS_ON_ITEMS_WITH_CHILDS', true);


register_nav_menus(
    array(
        'flex_mobile_menu' => 'Мобильное меню flex'
    )
);


add_action('storefront_before_site', 'open_menu_wrapper');
add_action('wp_footer', 'close_menu_wrapper');


class FlexMenuItem {
    public $ID;
    public $parent_ID;
    public $title;
    public $link;

    public $childs = array();

    //public $parent_nav_id;
    public $childs_nav_link;

    /**
     * FlexMenuItem constructor.
     * @param $ID
     */
    public function __construct($ID)
    {
        $this->ID = $ID;
    }


}


function open_menu_wrapper() {
    ?>

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/css/mytestcss.css" />




<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/css/component.css" />
    <!-- csstransforms3d-shiv-cssclasses-prefixed-teststyles-testprop-testallprops-prefixes-domprefixes-load -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/modernizr.custom.25376.js"></script>

    <div id="perspective" class="perspective effect-airbnb">
        <button id="showMenu" class="toggle-mnu hidden-lg"><span></span></button>
        <div class="container">
            <div class="wrapper"><!-- wrapper needed for scroll -->

                <?php
}
function close_menu_wrapper() {
                ?>


            </div><!-- wrapper -->
        </div><!-- /container -->






        <?php
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        if (has_nav_menu('flex_mobile_menu')) {
            ?>
                <nav id="flexmobilemainmenu" data-id="flexmobile-mainmenu" class="outer-nav left vertical">
                </nav>
            <?php



            $menu_name = 'flex_mobile_menu';
            $locations = get_nav_menu_locations();
            $menu = wp_get_nav_menu_object($locations[$menu_name]);
            $menuitems = wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC'));

            $menu_array = array();
            $parents_array = array();


            foreach ($menuitems as $item) {
                $flexMenuItem = new FlexMenuItem($item->ID);

                $menu_array[$item->ID] = $flexMenuItem;

                $flexMenuItem->link = $item->url;

                $flexMenuItem->title = $item->title;

                $flexMenuItem->parent_ID = $item->menu_item_parent;

                if ($flexMenuItem->parent_ID) {
                    $menu_array[$flexMenuItem->parent_ID]->childs[] = $flexMenuItem->ID;
                }

                $parents_array[$flexMenuItem->parent_ID] = $flexMenuItem->parent_ID;

            }

            foreach ($menu_array as $item) {
                //На каждый пункт по линку на чилдренов
                $link_on = "";
                if( $item->childs){
                    $link_on = $item->ID . "-link-" . implode('-', $item->childs);
                }
                $item->childs_nav_link = $link_on;
            }



            foreach ($parents_array as $parent) {

                if($parent == 0) {
                    ?>
                        <nav id="flexmobile-mainmenu" data-parent="" style="display: none;">
                    <?php
                }else{
                    $id = $menu_array[$parent]->childs_nav_link;
                    $dataParent = $menu_array[$parent]->parent_ID;
                    if($dataParent == 0){
                        $dataParent = "flexmobile-mainmenu";
                    }else{
                        $dataParent = $menu_array[$dataParent]->childs_nav_link;
                    }
                    ?>
                        <nav id="<?php echo $id; ?>" data-parent="<?php echo $dataParent; ?>" style="display: none;">
                    <?php
                }
                    /*<a class="flexmobile icon-home" link_on="flexmobile-submenu-1" href="#">Home</a></li>
                    <a class="flexmobile icon-news" href="#">News</a>
                    <a class="flexmobile icon-image" href="#">Images</a>
                    <a class="flexmobile icon-upload" href="#">Uploads</a>
                    <a class="flexmobile icon-star" href="#">Favorites</a>
                    <a class="flexmobile icon-mail" href="#">Messages</a>
                    <a class="flexmobile icon-lock" href="#">Security</a>*/

                    foreach ($menu_array as $item) {

                        if($item->parent_ID == $parent) {
                            if($item->childs_nav_link){
                                //if(NO_LINKS_ON_ITEMS_WITH_CHILDS) $item->link = "#";
                                echo "<div class=\"havechilds\">";
                                echo "<a class=\"flexmobile icon-" . $item->ID . "\" href=\"" . $item->link . "\">" . $item->title . "</a>";
                                echo "<a class=\"flexmobile arrow2childs icon-" . $item->ID . "\" href=\"" . $item->link . "\" link_on=\"" . $item->childs_nav_link . "\"></a>";
                                echo "<div style='clear: both;'></div></div>";
                            }else{
                                echo "<a class=\"flexmobile icon-" . $item->ID . "\" href=\"" . $item->link . "\">" . $item->title . "</a>";
                                echo "<div style='clear: both;'></div>";
                            }
                        }

                    }
                ?>
                    </nav>
                <?php

            }



        }
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ?>











    </div><!-- /perspective -->


    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/classie.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/menu.js"></script>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/mytestscript.js"></script>








    <?php
}
?>