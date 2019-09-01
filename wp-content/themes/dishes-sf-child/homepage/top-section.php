<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 22.05.2019
 * Time: 16:01
 */
?>


<div class="top">
    <div class="slider-wrapper">
        <?php
        // слайдер
        require_once( get_stylesheet_directory() . '/homepage/nivoslider/nivoslider.php' );
        ?>
    </div>
    <div class="banner-wrapper">
        <div class="banner1">
            <img src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>banner_kalyan_ps_315_405.jpg" alt="" />
        </div>
        <div class="banner2">
            <img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>banner_mini_orderrolls_315_138.jpg" alt="" />
            <img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>banner_mini_orderrolls_315_405.jpg" alt="" />
        </div>
    </div>
    <div style="clear: both"></div>
</div>
<div class="bottom">
    <?php
    // иконки с текстом под слайдером
    require_once( get_stylesheet_directory() . '/homepage/units/units.php' );
    ?>
</div>