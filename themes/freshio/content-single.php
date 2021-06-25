<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php
	/**
	 * Functions hooked in to freshio_single_post_top action
	 *
	 * @see freshio_post_header_single       - 10
	 */
	do_action( 'freshio_single_post_top' );

	/**
	 * Functions hooked in to freshio_single_post action
	 *
	 * @see freshio_post_thumbnail          - 10
	 * @see freshio_post_content         - 30
	 */
	do_action( 'freshio_single_post' );

	/**
	 * Functions hooked in to freshio_single_post_bottom action
	 *
	 * @see freshio_post_taxonomy      - 5
	 * @see freshio_post_nav         	- 10
	 * @see freshio_display_comments 	- 20
	 */
	do_action( 'freshio_single_post_bottom' );
	?>

</article><!-- #post-## -->
