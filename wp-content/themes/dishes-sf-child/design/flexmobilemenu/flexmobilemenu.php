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
        <div class="container">
            <div class="wrapper"><!-- wrapper needed for scroll -->
                <p style="position: fixed;top: 0;left: 0;z-index: 10000000;width: 15px;height: 15px;overflow: hidden;"><button id="showMenu">Show Menu</button></p>

                <?php
}
function close_menu_wrapper() {
                ?>


            </div><!-- wrapper -->
        </div><!-- /container -->


        <!--nav id="flexmobilemainmenu" data-id="flexmobile-mainmenu" class="outer-nav left vertical">
        </nav>
        <nav id="flexmobile-mainmenu" data-parent="" style="display: none;">
            <a class="flexmobile icon-home" link_on="flexmobile-submenu-1" href="#">Home</a></li>
            <a class="flexmobile icon-news" href="#">News</a>
            <a class="flexmobile icon-image" href="#">Images</a>
            <a class="flexmobile icon-upload" href="#">Uploads</a>
            <a class="flexmobile icon-star" href="#">Favorites</a>
            <a class="flexmobile icon-mail" href="#">Messages</a>
            <a class="flexmobile icon-lock" href="#">Security</a>
        </nav>
        <!-- Submenu 1 ->
        <nav id="flexmobile-submenu-1" data-parent="flexmobile-mainmenu" style="display: none;">
            <a class="flexmobile icon-home" link_on="flexmobile-submenu-1-1" href="#">Home2</a>
            <a class="flexmobile icon-news" href="#">News2</a>
            <a class="flexmobile icon-image" href="#">Images2</a>
            <a class="flexmobile icon-upload" href="#">Uploads2</a>
        </nav>
        <!-- Submenu 1-1 ->
        <nav-- id="flexmobile-submenu-1-1" data-parent="flexmobile-submenu-1" style="display: none;">
            <a class="flexmobile icon-home" href="#">Home3</a>
            <a class="flexmobile icon-news" href="#">News3</a>
            <a class="flexmobile icon-image" href="#">Images3</a>
            <a class="flexmobile icon-upload" href="#">Uploads3</a>
            <a class="flexmobile icon-lock" href="#">Security3</a>
        </nav-->



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
                                if(NO_LINKS_ON_ITEMS_WITH_CHILDS) $item->link = "#";
                                echo "<a class=\"flexmobile havechilds icon-" . $item->ID . "\" href=\"" . $item->link . "\" link_on=\"" . $item->childs_nav_link . "\">" . $item->title . "</a>";
                            }else{
                                echo "<a class=\"flexmobile icon-" . $item->ID . "\" href=\"" . $item->link . "\">" . $item->title . "</a>";
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






        <!--ul id="menu-moe-menju-1" class="menu outer-nav left vertical">
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-37 current_page_item menu-item-has-children menu-item-64">
                <a href="https://beta.ot-dv.ru/">СОУТ</a>
                <button aria-expanded="false" class="dropdown-toggle">
                    <span class="screen-reader-text">Развернутое вложенное меню</span>
                </button>
                <ul class="sub-menu">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-75">
                        <a href="https://beta.ot-dv.ru/sout/zakazat-sout/">Заказать СОУТ</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-74">
                        <a href="https://beta.ot-dv.ru/sout/shtrafy-i-otvetstvennost/">Штрафы и ответственность</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-67">
                        <a href="https://beta.ot-dv.ru/sout/jekonomicheskij-jeffekt/">Экономический эффект</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-68">
                <a href="https://beta.ot-dv.ru/akademija-jelektronnogo-obrazovanija/">Академия Электронного Образования</a>
                <button aria-expanded="false" class="dropdown-toggle">
                    <span class="screen-reader-text">Развернутое вложенное меню</span>
                </button>
                <ul class="sub-menu">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-72">
                        <a href="https://beta.ot-dv.ru/akademija-jelektronnogo-obrazovanija/uchenikam/">Ученикам</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-73">
                        <a href="https://beta.ot-dv.ru/akademija-jelektronnogo-obrazovanija/prepodavateljam/">Преподавателям</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-69">
                        <a href="https://beta.ot-dv.ru/akademija-jelektronnogo-obrazovanija/ob-uchebnom-centre/">Об учебном центре</a>
                        <button aria-expanded="false" class="dropdown-toggle">
                            <span class="screen-reader-text">Развернутое вложенное меню</span>
                        </button>
                        <ul class="sub-menu">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-71">
                                <a href="https://beta.ot-dv.ru/akademija-jelektronnogo-obrazovanija/ob-uchebnom-centre/licenzija-i-dokumenty-cjeodv/">Лицензия и документы (ЦЭОДВ)</a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-70">
                                <a href="https://beta.ot-dv.ru/akademija-jelektronnogo-obrazovanija/ob-uchebnom-centre/dokumenty-ajeo/">Документы АЭО</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-60">
                <a href="https://beta.ot-dv.ru/obuchenie-u-partnerov/">Обучение у партнеров</a>
                <button aria-expanded="false" class="dropdown-toggle">
                    <span class="screen-reader-text">Развернутое вложенное меню</span>
                </button>
                <ul class="sub-menu">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-81">
                        <a href="https://beta.ot-dv.ru/obuchenie-u-partnerov/predattestacionnaja-podgotovka/">Предаттестационная подготовка</a>
                        <button aria-expanded="false" class="dropdown-toggle">
                            <span class="screen-reader-text">Развернутое вложенное меню</span>
                        </button>
                        <ul class="sub-menu">
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-83">
                                <a href="https://beta.ot-dv.ru/obuchenie-u-partnerov/predattestacionnaja-podgotovka/nostroj/">«НОСТРОЙ»</a>
                            </li>
                            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-82">
                                <a href="https://beta.ot-dv.ru/obuchenie-u-partnerov/predattestacionnaja-podgotovka/po-jelektrobezopasnosti-i-rostehnadz/">По электробезопасности и Ростехнадзору</a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-62">
                        <a href="https://beta.ot-dv.ru/obuchenie-u-partnerov/povyshenie-kvalifikacii/">Повышение квалификации</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-61">
                        <a href="https://beta.ot-dv.ru/obuchenie-u-partnerov/perepodgotovka-kadrov/">Переподготовка кадров</a>
                    </li>
                </ul>
            </li>
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-935">
                <a href="https://beta.ot-dv.ru/o-nas/">О нас</a>
                <button aria-expanded="false" class="dropdown-toggle">
                    <span class="screen-reader-text">Развернутое вложенное меню</span>
                </button>
                <ul class="sub-menu">
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-59">
                        <a href="https://beta.ot-dv.ru/o-nas/kontakty/">Контакты</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1033">
                        <a href="https://beta.ot-dv.ru/o-nas/voprosy-i-otvety/">Вопросы и ответы</a>
                    </li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-66">
                        <a href="https://beta.ot-dv.ru/o-nas/dostizhenija-i-nagrady/">Достижения и награды</a>
                    </li>
                </ul>
            </li>
        </ul-->





    </div><!-- /perspective -->


    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/classie.js"></script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/menu.js"></script>

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/mytestscript.js"></script>








    <?php
}
?>