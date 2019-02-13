<?php

//подключаем js с функцией прилипания
add_action( 'wp_enqueue_scripts', function (){
    wp_enqueue_script( 'stickeyscript', get_stylesheet_directory_uri() . '/design/stickeymenu/stickeymenu.js');
});

add_action('storefront_header', 'stickey_menu_wrapper');

function stickey_menu_wrapper()
{
    ?>

    <div id="stickey_menu_wrapper">
        <div class="col-full">
            <div id="menu-stickey-wrapper">

                <nav id="site-navigation-stickey" class="main-navigation" role="navigation" aria-label="<?php esc_html_e( 'Primary Navigation', 'storefront' ); ?>">
                    <button class="menu-toggle" aria-controls="site-navigation" aria-expanded="false"><span><?php echo esc_attr( apply_filters( 'storefront_menu_toggle_text', __( 'Menu', 'storefront' ) ) ); ?></span></button>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'container_class' => 'primary-navigation',
                        )
                    );

                    wp_nav_menu(
                        array(
                            'theme_location'  => 'handheld',
                            'container_class' => 'handheld-navigation',
                        )
                    );
                    ?>
                    <div style="clear: both"></div>
                </nav><!-- #site-navigation-stickey -->
            </div>
            <div id="site-header-cart-stickey-wrapper">

            </div>
        </div>
    </div>
    <?php
}
