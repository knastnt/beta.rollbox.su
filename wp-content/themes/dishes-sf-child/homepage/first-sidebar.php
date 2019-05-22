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
<div class="insta-sidebar">
    <div class="title">
        <h4>
            Instagram
        </h4>
    </div>
    <div class="wrapper">
        <?php echo do_shortcode('[insta-gallery id="2"]'); ?>
    </div>
</div>
