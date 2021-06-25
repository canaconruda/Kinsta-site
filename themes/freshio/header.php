<!doctype html>
<html <?php language_attributes(); ?> class="<?php echo freshio_get_theme_option('site_mode') == 'dark' ? 'site-dark' : ''; ?>">
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="profile" href="//gmpg.org/xfn/11">
	<?php
	/**
	 * Functions hooked in to wp_head action
	 *
	 * @see freshio_pingback_header - 1
	 */
	wp_head();

	?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php do_action('freshio_before_site'); ?>

<div id="page" class="hfeed site">
	<?php
	/**
	 * Functions hooked in to freshio_before_header action
	 *
	 *
	 */
	do_action('freshio_before_header');

	get_template_part('template-parts/header/header', freshio_get_theme_option('header-type', 1));

    get_template_part('template-parts/header', 'sticky');
	/**
	 * Functions hooked in to freshio_before_content action
	 *
	 * @see freshio_breadcrumb - 10
	 *
	 */
	do_action('freshio_before_content');
	?>

	<div id="content" class="site-content" tabindex="-1">
		<div class="col-full">

<?php
/**
 * Functions hooked in to freshio_content_top action
 *
 * @see freshio_shop_messages - 10 - woo
 */
do_action('freshio_content_top');
