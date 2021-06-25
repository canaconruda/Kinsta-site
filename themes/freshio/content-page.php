<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to freshio_page action
	 *
	 * @see freshio_page_header          - 10
	 * @see freshio_page_content         - 20
	 *
	 */
	do_action( 'freshio_page' );
	?>
</article><!-- #post-## -->