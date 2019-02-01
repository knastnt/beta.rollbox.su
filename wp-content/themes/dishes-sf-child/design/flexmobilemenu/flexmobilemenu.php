<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 01.02.2019
 * Time: 21:06
 */

add_action('storefront_before_site', 'open_menu_wrapper');
add_action('wp_footer', 'close_menu_wrapper');

function open_menu_wrapper() {
    ?>

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/css/mytestcss.css" />




<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/css/component.css" />
    <!-- csstransforms3d-shiv-cssclasses-prefixed-teststyles-testprop-testallprops-prefixes-domprefixes-load -->
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/flexmobilemenu/js/modernizr.custom.25376.js"></script>

    <div id="perspective" class="perspective effect-airbnb">
        <div class="container">
            <div class="wrapper"><!-- wrapper needed for scroll -->
                <p><button id="showMenu">Show Menu</button></p>

                <?php
}
function close_menu_wrapper() {
    ?>









            </div><!-- wrapper -->
        </div><!-- /container -->
        <!--nav class="outer-nav left vertical">
            <a href="#" class="icon-home">Home</a>
            <a href="#" class="icon-news">News</a>
            <a href="#" class="icon-image">Images</a>
            <a href="#" class="icon-upload">Uploads</a>
            <a href="#" class="icon-star">Favorites</a>
            <a href="#" class="icon-mail">Messages</a>
            <a href="#" class="icon-lock">Security</a>
        </nav-->

        <nav id="flexmobilemainmenu" data-id="flexmobile-mainmenu" class="outer-nav left vertical">
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
        <!-- Submenu 1 -->
        <nav id="flexmobile-submenu-1" data-parent="flexmobile-mainmenu" style="display: none;">
            <a class="flexmobile icon-home" link_on="flexmobile-submenu-1-1" href="#">Home2</a>
            <a class="flexmobile icon-news" href="#">News2</a>
            <a class="flexmobile icon-image" href="#">Images2</a>
            <a class="flexmobile icon-upload" href="#">Uploads2</a>
        </nav>
        <!-- Submenu 1-1 -->
        <nav id="flexmobile-submenu-1-1" data-parent="flexmobile-submenu-1" style="display: none;">
            <a class="flexmobile icon-home" href="#">Home3</a>
            <a class="flexmobile icon-news" href="#">News3</a>
            <a class="flexmobile icon-image" href="#">Images3</a>
            <a class="flexmobile icon-upload" href="#">Uploads3</a>
            <a class="flexmobile icon-lock" href="#">Security3</a>
        </nav>

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