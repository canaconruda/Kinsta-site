
		</div><!-- .col-full -->
	</div><!-- #content -->

	<?php do_action( 'freshio_before_footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
		/**
		 * Functions hooked in to freshio_footer action
		 *
		 * @see freshio_footer_default - 20
         * @see freshio_handheld_footer_bar - 25 - woo
		 *
		 */
		do_action( 'freshio_footer' );

		?>

	</footer><!-- #colophon -->

	<?php

		/**
		 * Functions hooked in to freshio_after_footer action
		 * @see freshio_sticky_single_add_to_cart 	- 999 - woo
		 */
		do_action( 'freshio_after_footer' );
	?>

</div><!-- #page -->

<?php

/**
 * Functions hooked in to wp_footer action
 * @see freshio_template_account_dropdown 	- 1
 * @see freshio_mobile_nav - 1
 * @see freshio_render_woocommerce_shop_canvas - 1 - woo
 */

wp_footer();
?>

</body>
</html>
