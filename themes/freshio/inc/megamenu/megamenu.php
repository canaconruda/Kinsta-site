<?php

defined( 'ABSPATH' ) || exit();


class Freshio_Megamenu {

	private $is_megamenu = false;
	private $menu_items  = [];

	public function __construct() {
		$this->includes_core();
		if ( $this->check_megamenu() ) {
			$this->includes();
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_filter( 'freshio_nav_menu_args', [ $this, 'set_menu_args' ], 99999 );
		}

	}

	public function set_menu_args( $args ) {
		$args['walker'] = new Freshio_Megamenu_Walker();

		return $args;
	}

	private function check_megamenu() {
		$all_locations = get_nav_menu_locations();
		$main = $vertical = $mobile = false;
		if (isset(get_nav_menu_locations()['vertical'])) {
			$vertical = wp_get_nav_menu_items(get_term($all_locations['vertical'], 'nav_menu')->term_id);
		}
		if (isset(get_nav_menu_locations()['primary'])) {
			$main = wp_get_nav_menu_items(get_term($all_locations['primary'], 'nav_menu')->term_id);
		}

        if (isset(get_nav_menu_locations()['handheld'])) {
            $mobile = wp_get_nav_menu_items(get_term($all_locations['handheld'], 'nav_menu')->term_id);
        }

		$all = wp_parse_args( $main, wp_parse_args($vertical, $mobile));
		foreach ( $all as $menu_item ) {
			$elementor_id = freshio_megamenu_get_post_related_menu( $menu_item->ID );

            if (isset($menu_item->mega_data) && !empty($menu_item->mega_data) || $elementor_id ) {
                $this->is_megamenu  = true;
            }

			if ( $elementor_id ) {
				$this->menu_items[] = $elementor_id;
			}
		}
		return $this->is_megamenu;
	}

	private function includes_core(){
		if ( is_admin() ) {
			include_once get_template_directory() . '/inc/megamenu/includes/admin/class-admin.php';
            include_once get_template_directory() . '/inc/megamenu/includes/hook-functions.php';

        }
		include_once get_template_directory() . '/inc/megamenu/includes/core-functions.php';
	}

	private function includes() {

		include_once get_template_directory() . '/inc/megamenu/includes/class-menu-walker.php';
	}

	public function enqueue_scripts() {
		global $freshio_version;
		wp_enqueue_script( 'freshio-megamenu-frontend', get_template_directory_uri() . '/inc/megamenu/assets/js/frontend.js', array( 'jquery' ), $freshio_version, true );

		foreach ( $this->menu_items as $id ) {
			Elementor\Core\Files\CSS\Post::create( $id )->enqueue();
		}
	}

}

return new Freshio_Megamenu();
