<?php

/**
 *
 * это должно быть в functions.php
 *
 *
// правильный способ подключить стили и скрипты
//add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
add_action('wp_print_styles', 'true_include_styles'); // можно использовать этот хук он более поздний
function true_include_styles() {
    wp_enqueue_style( 'style-ocslideshow', get_stylesheet_directory_uri() . '/homepage/nivoslider/css/ocslideshow.css' );
    wp_enqueue_style( 'style-animate', get_stylesheet_directory_uri() . '/homepage/nivoslider/css/animate.css' );
}
add_action( 'wp_enqueue_scripts', 'true_include_scripts' );
function true_include_scripts() {
    wp_enqueue_script( 'script-nivo-slider', get_stylesheet_directory_uri() . '/homepage/nivoslider/js/jquery.nivo.slider.js' );
}
 * */

?>
<div class="banner7">
    <div class= "oc-banner7-container">
        <div class="flexslider oc-nivoslider">
            <div class="oc-loading"></div>
            <div id="oc-inivoslider1" class="nivoSlider">

                <img src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>bg1-slidershow-870x410.png" alt="" title="#banner7-caption2"  />
                <img src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>bg2-slidershow-870x410.png" alt="" title="#banner7-caption3"  />
                <img src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>bg-slidershow-870x410.png" alt="" title="#banner7-caption4"  />

            </div>





            <div id="banner7-caption2" class="banner7-caption nivo-html-caption nivo-caption move-slides-effect" data-class="slide-movetype1">
                <div class="timeloading"></div>
                <div class="banner7-content slider-1">
                    <div class="text-content">
                        <h1 class="title1"> Exclusive Offer -40% Off This Week </h1>

                        <h2 class="sub-title"> Samsung S7/S7 edge 2018 </h2>

                        <div class="banner7-des">
                            Starting at  <span>$602.99</span>
                        </div>
                        <div class="banner7-readmore">
                            <a class="btn" href="  # " title="Shop Now!">Shop Now!</a>
                        </div>
                    </div>
                </div>
            </div>




            <div id="banner7-caption3" class="banner7-caption nivo-html-caption nivo-caption move-slides-effect" data-class="slide-movetype1">
                <div class="timeloading"></div>
                <div class="banner7-content slider-1">
                    <div class="text-content">
                        <h1 class="title1"> Exclusive Offer -30% Off This Week </h1>

                        <h2 class="sub-title"> Google Home  New Product 2018 </h2>

                        <div class="banner7-des">
                            Starting at  <span>$426.99</span>
                        </div>
                        <div class="banner7-readmore">
                            <a class="btn" href="  # " title="Shop Now!">Shop Now!</a>
                        </div>
                    </div>
                </div>
            </div>




            <div id="banner7-caption4" class="banner7-caption nivo-html-caption nivo-caption move-slides-effect" data-class="slide-movetype1">
                <div class="timeloading"></div>
                <div class="banner7-content slider-1">
                    <div class="text-content">
                        <h1 class="title1"> Exclusive Offer -20% Off This Week </h1>

                        <h2 class="sub-title"> Samsung Gear Vr Sale 70% Off </h2>

                        <div class="banner7-des">
                            Starting at  <span>$560.99</span>
                        </div>
                        <div class="banner7-readmore">
                            <a class="btn" href="  # " title="Shop Now!">Shop Now!</a>
                        </div>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(window).ready(function() {
                    jQuery('#oc-inivoslider1').nivoSlider({
                        effect:    "random"  ,
                        slices: 15,
                        boxCols: 8,
                        boxRows: 4,
                        manualAdvance:  false  ,
                        animSpeed: 500,
                        pauseTime:   5000  ,
                        startSlide: 0,
                        controlNav:   true  ,
                        directionNav:     false   ,
                        controlNavThumbs: false,
                        pauseOnHover:     false   ,
                        prevText: '<i class="ion-chevron-left"></i>',
                        nextText: '<i class="ion-chevron-right"></i>',
                        afterLoad: function(){
                            jQuery('.oc-loading').css("display","none");
                            jQuery('.timeloading').css('animation-duration'," 5000ms ");
                        },
                    });
                });
            </script>
        </div>
    </div>
</div>

