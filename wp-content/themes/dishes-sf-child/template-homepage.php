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

//////////////////////////////////////////////////////////////////////////
/// от слайдера
///
// правильный способ подключить стили и скрипты
add_action( 'wp_enqueue_scripts', 'true_include_styles' );
//add_action('wp_print_styles', 'true_include_styles'); // можно использовать этот хук он более поздний
function true_include_styles() {
    wp_enqueue_style( 'style-homepage', get_stylesheet_directory_uri() . '/homepage/homepage.css' );
    wp_enqueue_style( 'flickity-style', get_stylesheet_directory_uri() . '/design/flickity/flickity.css' );
    wp_enqueue_style( 'style-ocslideshow', get_stylesheet_directory_uri() . '/homepage/nivoslider/css/ocslideshow.css' );
    wp_enqueue_style( 'style-animate', get_stylesheet_directory_uri() . '/homepage/nivoslider/css/animate.css' );
}
add_action( 'wp_enqueue_scripts', 'true_include_scripts' );
function true_include_scripts() {
    wp_enqueue_script( 'script-nivo-slider', get_stylesheet_directory_uri() . '/homepage/nivoslider/js/jquery.nivo.slider.js' );
    wp_enqueue_script( 'flickity-script', get_stylesheet_directory_uri() . '/design/flickity/flickity.pkgd.min.js' );
}
//////////////////////////////////////////////////////////////////////////


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
                <?php require_once( get_stylesheet_directory() . '/homepage/top-section.php' ); ?>
            </div>
            <div class="center-section">
                <div class="white-wrapper">
                    <div class="first">
                        <div class="content">
                            <?php require_once( get_stylesheet_directory() . '/homepage/first-content.php' ); ?>
                        </div>
                        <div class="sidebar">
                            <?php require_once( get_stylesheet_directory() . '/homepage/first-sidebar.php' ); ?>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                    <div class="second">

                    </div>
                    <div class="third">

                    </div>
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
