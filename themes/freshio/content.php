<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to freshio_loop_post action.
	 *
	 * @see freshio_post_thumbnail       - 10
	 * @see freshio_post_header          - 15
	 * @see freshio_post_content         - 30
	 */
	do_action( 'freshio_loop_post' );
	?>

</article><!-- #post-## -->

