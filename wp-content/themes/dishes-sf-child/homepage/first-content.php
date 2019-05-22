<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 22.05.2019
 * Time: 16:04
 */
?>

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
            jQuery('.center-section .first .content .num1 .woocommerce .products').slick({
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

    <div class="products-slick-slider num4">
        <div class="title">
            <h4>
                Основное меню
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
        /*$result = do_shortcode( '[product_categories orderby="slug"]' );
        $result = str_replace('<ul', '<div', $result);
        $result = str_replace('</ul', '</div', $result);
        $result = str_replace('<li', '<div', $result);
        $result = str_replace('</li', '</div', $result);
        echo $result;*/



        //Вывести список категорий товаров woocommerce
        $args = array(
            'orderby'    => 'slug',
            'hide_empty' => true,
            'exclude'       => array(43), //Скрываем родительскую категорию "роллы"
        );

        $product_categories = get_terms( 'product_cat', $args );

        $count = count($product_categories);
        if ( $count > 0 ){
            echo '<div class="products">';
            foreach ( $product_categories as $product_category ) {
                //echo '<li><a href="' . get_term_link( $product_category ) . '">' . $product_category->name . '</li>';

                //Получаем ссылку на изображение
                $thumbnail_id = get_term_meta( $product_category->term_id, 'thumbnail_id', true );
                if ($thumbnail_id == 0) {
                    $image_url = wc_placeholder_img_src();
                }else{
                    $image_url = wp_get_attachment_url( $thumbnail_id );
                }


                echo '<div class="product-category product">';
                //echo '<a href="' . get_term_link( $product_category ) . '">';
                echo '<a href="/shop/?swoof=1&product_cat=' . $product_category->slug . '">';
                echo '<img src="' . $image_url . '" alt="' . $product_category->name . '" width="324" height="">';
                echo '<h4 class="woocommerce-loop-category__title">' . $product_category->name . '</h4>';
                echo '</a>';
                echo '</div>';

            }
            echo '</div>';
        }

        ?>

        <script type="text/javascript">
            (function() {
                jQuery('.center-section .first .content .num4 .products').slick({
                    rows: 2,
                    swipeToSlide: true,
                    infinite: false,
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
                    nextArrow: jQuery('.products-slick-slider.num4 .nav-next'),
                    prevArrow: jQuery('.products-slick-slider.num4 .nav-prev')
                });
            })()
        </script>
    </div>

</div>
