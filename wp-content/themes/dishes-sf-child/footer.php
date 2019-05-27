<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package storefront
 */

?>

		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'storefront_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="col-full">

			<?php
			/**
			 * Functions hooked in to storefront_footer action
			 *
			 * @hooked storefront_footer_widgets - 10
			 * @hooked storefront_credit         - 20
			 *-/
			do_action( 'storefront_footer' );*/
			?>

            <div class="footer-block logo-address-block">
                <h3>Title</h3>
                <p></p>
            </div>
            <div class="footer-block menu-block">
                <div class="column first">
                    <h3>Title</h3>
                    <ul>
                        <li>1</li>
                        <li>2</li>
                    </ul>
                </div>
                <div class="column second">
                    <h3>Title</h3>
                    <ul>
                        <li>1</li>
                        <li>2</li>
                    </ul>
                </div>
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
