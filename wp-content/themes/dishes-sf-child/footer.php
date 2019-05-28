<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */
//Это замена файла footer.php в родительской теме

// Регистрируем меню для футера в functions.php

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<div class="footer-block logo-address-block">
                <h3>Title</h3>
                <p></p>
            </div>
            <div class="footer-block menu-block">
                <?php
                    // подгружаем элементы меню
                    require_once( get_stylesheet_directory() . '/design/footermenu/footermenu.php' );
                ?>
            </div>
            <div class="footer-block links-block">
                <div class="row first">
                    <h3>Title</h3>
                    <p></p>
                </div>
                <div class="row second">
                    <h3>Title</h3>
                    <p></p>
                </div>
            </div>

		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
