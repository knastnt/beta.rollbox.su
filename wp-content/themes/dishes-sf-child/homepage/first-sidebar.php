<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 22.05.2019
 * Time: 16:05
 */



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

    if (strlen($result) > 50){

        ?>
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

            <?php echo $result; ?>

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
        <?php
    }

?>




<div class="insta-sidebar">
    <div class="title">
        <h4>
            <?php
                //Узнаем что отображать в заголовке
                $title = isset(get_option( 'rollbox_options_array' ) ['sidebar_instagram_title']) ? get_option( 'rollbox_options_array' ) ['sidebar_instagram_title'] : 'Instagram';
                echo $title;
            ?>
        </h4>
        <img src="<?php echo get_stylesheet_directory_uri() . '/img/insta_logo_32x32.png'; ?>">
        <div style="clear: both"></div>
    </div>
    <div class="wrapper">
        <?php
            //Узнаем какой ID шорткода вставлять
            $shortcode_id = isset(get_option( 'rollbox_options_array' ) ['sidebar_instagram_shortcode_id']) ? get_option( 'rollbox_options_array' ) ['sidebar_instagram_shortcode_id'] : 0;
            if ($shortcode_id < 1) {
                echo 'Неверно указан ID шорткода галереи';
            }else {
                echo do_shortcode('[insta-gallery id="'. $shortcode_id . '"]');
            }
        ?>
    </div>
</div>





<?php
// Блок Недавно просмотренные

/////////////////////////////////////////////////////
/// скопировано отсюда: wp-content/plugins/woocommerce/includes/widgets/class-wc-widget-recently-viewed.php

$viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', wp_unslash( $_COOKIE['woocommerce_recently_viewed'] ) ) : array(); // @codingStandardsIgnoreLine
$viewed_products = array_reverse( array_filter( array_map( 'absint', $viewed_products ) ) );

if ( empty( $viewed_products ) ) {
    return;
}



$query_args = array(
    'posts_per_page' => 12,
    'no_found_rows'  => 1,
    'post_status'    => 'publish',
    'post_type'      => 'product',
    'post__in'       => $viewed_products,
    'orderby'        => 'post__in',
);

if ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'outofstock',
            'operator' => 'NOT IN',
        ),
    ); // WPCS: slow query ok.
}

$loop = new WP_Query( apply_filters( 'woocommerce_recently_viewed_products_widget_query_args', $query_args ) );

/// /////////////////////////////////////////////////

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

if (strlen($result) > 50){

    ?>
    <div class="products-slick-slider num3">
        <div class="title">
            <h4>
                Просмотренные
            </h4>
            <div class="nav">
                <div class="nav-prev">
                    <i class="arrow-back"></i>
                </div><div class="nav-break"></div><div class="nav-next">
                    <i class="arrow-forward"></i>
                </div>
            </div>
        </div>

        <?php echo $result; ?>

        <script type="text/javascript">
            (function() {
                jQuery('.center-section .first .sidebar .num3 .products').slick({
                    rows: 2,
                    swipeToSlide: true,
                    infinite: false,
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
    <?php
}

?>