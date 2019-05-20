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
//add_action( 'wp_enqueue_scripts', 'theme_name_scripts' );
add_action('wp_print_styles', 'true_include_styles'); // можно использовать этот хук он более поздний
function true_include_styles() {
    wp_enqueue_style( 'style-homepage', get_stylesheet_directory_uri() . '/homepage/homepage.css' );
    wp_enqueue_style( 'style-ocslideshow', get_stylesheet_directory_uri() . '/homepage/nivoslider/css/ocslideshow.css' );
    wp_enqueue_style( 'style-animate', get_stylesheet_directory_uri() . '/homepage/nivoslider/css/animate.css' );
}
add_action( 'wp_enqueue_scripts', 'true_include_scripts' );
function true_include_scripts() {
    wp_enqueue_script( 'script-nivo-slider', get_stylesheet_directory_uri() . '/homepage/nivoslider/js/jquery.nivo.slider.js' );
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
                <div class="top">
                    <div class="slider-wrapper">
                        <?php
                            // слайдер
                            require_once( get_stylesheet_directory() . '/homepage/nivoslider/nivoslider.php' );
                        ?>
                    </div>
                    <div class="banner-wrapper">
                        <div class="banner1">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>block-home1_315x405.jpg" alt="" />
                        </div>
                        <div class="banner2">
                            <img src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>block1-home1_315x138.png" alt="" />
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
            </div>
            <div class="center-section">
                <div class="first">
                    <div class="content">

                        <script src="<?php echo get_stylesheet_directory_uri(); ?>/design/slick/slick.min.js"></script>
                        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/slick/slick.css"/>
                        <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/design/slick/slick-theme.css"/>

                        <div class="products-slick-slider num1">
                            <div class="title">
                                <h4>
                                    Самые популярные
                                </h4>
                                <div class="nav">
                                    <div class="nav-prev">
                                        <i class="arrow-back"></i>
                                    </div><div class="nav-break"></div><div class="nav-next">
                                        <i class="arrow-forward"></i>
                                    </div>
                                </div>
                            </div>
                            <?php
                                $result = do_shortcode( '[best_selling_products per_page="12"]' );
                                $result = str_replace('<ul', '<div', $result);
                                $result = str_replace('</ul', '</div', $result);
                                $result = str_replace('<li', '<div', $result);
                                $result = str_replace('</li', '</div', $result);
                                echo $result;
                            ?>

                            <script type="text/javascript">
                                (function() {
                                    jQuery('.center-section .first .content .woocommerce .products').slick({
                                        swipeToSlide: true,
                                        infinite: true,
                                        dots: false,
                                        slidesToShow: 4,
                                        slidesToScroll: 1,
                                        responsive: [
                                            {
                                                breakpoint: 1064,
                                                settings: {
                                                    slidesToShow: 3
                                                }
                                            },
                                            {
                                                breakpoint: 767,
                                                settings: {
                                                    slidesToShow: 1
                                                }
                                            }
                                        ],
                                        arrows: true,
                                        nextArrow: jQuery('.products-slick-slider.num1 .nav-next'),
                                        prevArrow: jQuery('.products-slick-slider.num1 .nav-prev')
                                    });
                                })()
                            </script>
                        </div>

                        <div class="module-image">
                            <img src="http://demo.towerthemes.com/tt_boxstore/image/cache/catalog/category/img-category-870x125.jpg" alt="">
                        </div>

                        <div class="main-categiries">



                        </div>


                    </div>
                    <div class="sidebar">
                        <div class="products-slick-slider num2">
                            <div class="title">
                                <h4>
                                    Новинки
                                </h4>
                                <div class="nav">
                                    <div class="nav-prev">
                                        <i class="arrow-back"></i>
                                    </div><div class="nav-break"></div><div class="nav-next">
                                        <i class="arrow-forward"></i>
                                    </div>
                                </div>
                            </div>
                            <?php


                                // Выводим новинки
                            //////////////////////////////////////////////////////////////

                                //Узнаем сколько дней товар считается новым
                                $new_product_duration = isset(get_option( 'rollbox_options_array' ) ['new_product_duration']) ? get_option( 'rollbox_options_array' ) ['new_product_duration'] : 14;

                                $args = array(
                                    'post_type' => 'product', // тип товара
                                    'date_query' => array(
                                        array(
                                            'after'  => $new_product_duration . ' day ago',
                                        )
                                    )
                                );

                                $loop = new WP_Query( $args );

                                ob_start();

                                woocommerce_product_loop_start();

                                while ( $loop->have_posts() ) {
                                    $loop->the_post();
                                    wc_get_template_part( 'content', 'product' );
                                }

                                woocommerce_product_loop_end();

                                $result = ob_get_clean();
                            //////////////////////////////////////////////////////////////

                            //////////////////////////////////////////////////////////////
                                //$result = do_shortcode( '[recent_products per_page="12"]' );
                            //////////////////////////////////////////////////////////////

                                $result = str_replace('<ul', '<div', $result);
                                $result = str_replace('</ul', '</div', $result);
                                $result = str_replace('<li', '<div', $result);
                                $result = str_replace('</li', '</div', $result);
                                echo $result;

                            ?>

                            <script type="text/javascript">
                                (function() {
                                    jQuery('.center-section .first .sidebar .num2 .products').slick({
                                        swipeToSlide: true,
                                        infinite: true,
                                        dots: false,
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        responsive: [
                                            {
                                                breakpoint: 1064,
                                                settings: {
                                                    slidesToShow: 1
                                                }
                                            },
                                            {
                                                breakpoint: 767,
                                                settings: {
                                                    slidesToShow: 1
                                                }
                                            }
                                        ],
                                        arrows: true,
                                        nextArrow: jQuery('.products-slick-slider.num2 .nav-next'),
                                        prevArrow: jQuery('.products-slick-slider.num2 .nav-prev')
                                    });
                                })()
                            </script>
                        </div>
                        <div class="products-slick-slider num3">
                            <div class="title">
                                <h4>
                                    Товары со скидкой
                                </h4>
                                <div class="nav">
                                    <div class="nav-prev">
                                        <i class="arrow-back"></i>
                                    </div><div class="nav-break"></div><div class="nav-next">
                                        <i class="arrow-forward"></i>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $result = do_shortcode( '[sale_products per_page="12"]' );
                            $result = str_replace('<ul', '<div', $result);
                            $result = str_replace('</ul', '</div', $result);
                            $result = str_replace('<li', '<div', $result);
                            $result = str_replace('</li', '</div', $result);
                            echo $result;
                            ?>

                            <script type="text/javascript">
                                (function() {
                                    jQuery('.center-section .first .sidebar .num3 .woocommerce .products').slick({
                                        swipeToSlide: true,
                                        infinite: true,
                                        dots: false,
                                        slidesToShow: 1,
                                        slidesToScroll: 1,
                                        responsive: [
                                            {
                                                breakpoint: 1064,
                                                settings: {
                                                    slidesToShow: 1
                                                }
                                            },
                                            {
                                                breakpoint: 767,
                                                settings: {
                                                    slidesToShow: 1
                                                }
                                            }
                                        ],
                                        arrows: true,
                                        nextArrow: jQuery('.products-slick-slider.num3 .nav-next'),
                                        prevArrow: jQuery('.products-slick-slider.num3 .nav-prev')
                                    });
                                })()
                            </script>
                        </div>
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
