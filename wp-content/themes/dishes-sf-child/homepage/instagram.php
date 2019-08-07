<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 07.08.2019
 * Time: 15:44
 */

//Регистрируем шорткод
add_shortcode( 'my-insta-gallery', 'my_insta_gallery' );
function my_insta_gallery($atts)
{
    // белый список параметров и значения по умолчанию
    $atts = shortcode_atts( array(
        'id' => '0',
        'title' => '',
    ), $atts );

    ?>

    <div class="insta-sidebar">
        <div class="title">
            <h4>
                <?php
                    echo $atts['title'];
                ?>
            </h4>
            <img src="<?php echo get_stylesheet_directory_uri() . '/img/insta_logo_32x32.png'; ?>">
            <div style="clear: both"></div>
        </div>
        <div class="wrapper">
            <?php
                echo do_shortcode('[insta-gallery id="' . $atts['id'] . '"]');
            ?>
        </div>
    </div>

    <?php

}