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


<?php

    //Популятные товары
    $popular_content = do_shortcode( '[best_selling_products per_page="12"]' );
    $popular_content = str_replace('<ul', '<div', $popular_content);
    $popular_content = str_replace('</ul', '</div', $popular_content);
    $popular_content = str_replace('<li', '<div', $popular_content);
    $popular_content = str_replace('</li', '</div', $popular_content);


    // Блок Товары со скидкой
    $isSalesExist = false;
    $salesContent = '';
    $shortcode = new WC_Shortcode_Products( array(),'sale_products' );
    if ( isset($shortcode->get_query_args()['post__in']) && count($shortcode->get_query_args()['post__in']) > 1 ) {
        $isSalesExist = true;

        $salesContent = $shortcode->get_content();
        $salesContent = str_replace('<ul', '<div', $salesContent);
        $salesContent = str_replace('</ul', '</div', $salesContent);
        $salesContent = str_replace('<li', '<div', $salesContent);
        $salesContent = str_replace('</li', '</div', $salesContent);
    }


    // Новинки
    $isNewExist = false;
    $newContent = '';
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
        $isNewExist = true;
        $newContent = $result;
    }

?>



<div class="products-slick-slider num1">
    <div class="title">
        <!--div class="tab-wrapper">
            <label >Самые популярные</label>
            <label  <?php if(!$isSalesExist) { echo 'style="display: none;"'; }?>>Со скидками</label>
            <label  <?php if(!$isNewExist) { echo 'style="display: none;"'; }?>>Новинки</label>

        </div-->
        <div class="nav">
            <div class="nav-prev">
                <i class="arrow-back"></i>
            </div><div class="nav-break"></div><div class="nav-next">
                <i class="arrow-forward"></i>
            </div>
        </div>
    </div>

    <div class="content-wrapper popular-btn<?php if($isSalesExist) { echo ' sale-btn'; }?><?php if($isNewExist) { echo ' new-btn'; }?>">
        <input type="radio" name="odin" checked="checked" id="popular"/>
        <label for="popular">Самые популярные</label>
        <input type="radio" name="odin" id="sale"/>
        <label for="sale" <?php if(!$isSalesExist) { echo 'style="display: none;"'; }?>>Со скидками</label>
        <input type="radio" name="odin" id="new"/>
        <label for="new" <?php if(!$isNewExist) { echo 'style="display: none;"'; }?>>Новинки</label>
        <hr>
        <div id="popular" class="content-entry">
            <?php

            echo $popular_content;
            ?>


        </div>
        <div id="sale" class="content-entry">
            <?php
                // Блок Товары со скидкой
                if ( $isSalesExist ) {
                     echo $salesContent;
                }
            ?>
        </div>
        <div id="new" class="content-entry">
            <?php
                // Блок Новинки
                if ( $isNewExist ) {
                    echo '<div class="woocommerce">' . $newContent . '</div>';
                }
            ?>
        </div>


        <script type="text/javascript">

            (function() {
                refreshSliderTab(jQuery('.content-wrapper input[name=odin]:checked').attr('id'));


                jQuery('.content-wrapper input').on('change', function() {refreshSliderTab(this.id)});

                function refreshSliderTab(tabId) {
                    //alert(tabId);

                    try {
                        jQuery('#' + tabId + ' .products').slick('refresh');
                    }catch (e) {
                        jQuery('#' + tabId + ' .products').slick({
                            touchThreshold: 100,
                            infinite: false,
                            dots: true,
                            slidesToShow: 4,
                            slidesToScroll: 4,
                            responsive: [
                                {
                                    breakpoint: 1064,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 3
                                    }
                                },
                                {
                                    breakpoint: 600,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 2
                                    }
                                }
                            ],
                            arrows: true,
                            nextArrow: jQuery('.products-slick-slider.num1 .nav-next'),
                            prevArrow: jQuery('.products-slick-slider.num1 .nav-prev')
                        });
                    }


                };
            })()
        </script>
    </div>
</div>

<div class="module-image">
    <img class="desktop" src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>banner_slim_1140_160.jpg" alt="">
    <img class="mobile" src="<?php echo get_stylesheet_directory_uri() . '/homepage/nivoslider/img/' ?>banner_slim_800_197.jpg" alt="">
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
                    touchThreshold: 100,
                    infinite: false,
                    dots: true,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1064,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
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

<div class="module-image">
    <!--img src="http://demo.towerthemes.com/tt_boxstore/image/cache/catalog/category/img1-category-870x125.jpg" alt=""-->
    <?php do_shortcode('[map2gis height=143px]'); ?>
</div>



