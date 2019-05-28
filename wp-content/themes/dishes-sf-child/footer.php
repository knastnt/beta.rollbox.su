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
            <div class="footer-wrapper">
                <div class="footer-block logo-address-block">
                    <a href="/"><img src="<?php echo get_stylesheet_directory_uri() . '/img/logo-fixed.png'; ?>"></a>
                    <p><b>ООО "СНЕТ" // ROLLBOX</b></p>
                    <p>ИНН: 2703032391, ОГРН: 1052740252388</p>
                    <p>Хабаровский край, г. Комсомольск-на-Амуре, пр. Мира 29</p>
                    <p>Тел.: <b id="footer-mobile-phone">8-924-100-5522</b>, <b id="footer-fixed-phone">54-51-58</b></p>
                    <p>E-Mail: <a href="mailto:rollboxinfo@mail.ru">rollboxinfo@mail.ru</a></p>
                </div>
                <script>
                    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                        document.getElementById("footer-mobile-phone").innerHTML = '<a href="tel:+79241005522">8-924-100-5522</a>';
                        document.getElementById("footer-fixed-phone").innerHTML = '<a href="tel:+74217545158">54-51-58</a>';
                    }
                </script>
                <div class="footer-block menu-block">
                    <?php
                        // подгружаем элементы меню
                        require_once( get_stylesheet_directory() . '/design/footermenu/footermenu.php' );
                    ?>
                </div>
                <!--div class="footer-block links-block">
                    <div class="row first">
                        <h3>Title</h3>
                        <p></p>
                    </div>
                    <div class="row second">
                        <h3>Title</h3>
                        <p></p>
                    </div>
                </div-->
                <div style="clear: both"></div>
            </div><!-- .footer-wrapper -->
		</div><!-- .col-full -->
	</footer><!-- #colophon -->

	<?php do_action( 'storefront_after_footer' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
