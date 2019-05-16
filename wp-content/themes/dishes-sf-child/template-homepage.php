<?php
/**
 * The template for displaying the homepage.
 *
 * This page template will display any functions hooked into the `homepage` action.
 * By default this includes a variety of product displays and the page content itself. To change the order or toggle these components
 * use the Homepage Control plugin.
 * https://wordpress.org/plugins/homepage-control/
 *
 * Template name: Homepage
 *
 * @package storefront
 */

// правильный способ подключить стили и скрипты
//add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
add_action('wp_print_styles', 'true_include_styles'); // можно использовать этот хук он более поздний
function true_include_styles() {
    wp_enqueue_style( 'style-homepage', get_stylesheet_directory_uri() . '/homepage/css/homepage.css' );
    wp_enqueue_style( 'style-ocslideshow', get_stylesheet_directory_uri() . '/homepage/css/ocslideshow.css' );
    wp_enqueue_style( 'style-animate', get_stylesheet_directory_uri() . '/homepage/css/animate.css' );
}
add_action( 'wp_enqueue_scripts', 'true_include_scripts' );
function true_include_scripts() {
    wp_enqueue_script( 'script-nivo-slider', get_stylesheet_directory_uri() . '/homepage/js/jquery.nivo.slider.js' );
}


get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/**
			 * Functions hooked in to homepage action
			 *
			 * @hooked storefront_homepage_content      - 10
			 * @hooked storefront_product_categories    - 20
			 * @hooked storefront_recent_products       - 30
			 * @hooked storefront_featured_products     - 40
			 * @hooked storefront_popular_products      - 50
			 * @hooked storefront_on_sale_products      - 60
			 * @hooked storefront_best_selling_products - 70
			 */
			//do_action( 'homepage' );
			?>


            <div class="top-section">
                <div class="top">
                    <div class="slider-wrapper">
                        <div class="banner7">
                            <div class= "oc-banner7-container">
                                <div class="flexslider oc-nivoslider">
                                    <div class="oc-loading"></div>
                                    <div id="oc-inivoslider1" class="nivoSlider">

                                        <img style="display: none;" src="http://demo.towerthemes.com/tt_boxstore/image/cache/catalog/slideshow/bg1-slidershow-870x505.png" alt="" title="#banner7-caption2"  />
                                        <img style="display: none;" src="http://demo.towerthemes.com/tt_boxstore/image/cache/catalog/slideshow/bg2-slidershow-870x505.png" alt="" title="#banner7-caption3"  />
                                        <img style="display: none;" src="http://demo.towerthemes.com/tt_boxstore/image/cache/catalog/slideshow/bg-slidershow-870x505.png" alt="" title="#banner7-caption4"  />

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
                                        jQuery(window).load(function() {
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
                    </div>
                    <div class="banner-wrapper">
                        <div class="banner1">

                        </div>
                        <div class="banner2">

                        </div>
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="bottom">

                </div>
            </div>
            <div class="center-section">
                <div class="first">
                    <div class="content">

                    </div>
                    <div class="sidebar">

                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="second">

                </div>
                <div class="third">

                </div>
            </div>
            <div class="last-section">
                <div class="product-block">

                </div>
                <div class="product-block">

                </div>
                <div class="product-block">

                </div>
                <div style="clear: both"></div>
            </div>
		</main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
