<?php

defined( 'ABSPATH' ) || exit();


class Freshio_Footer_Builder {
	private $footer_id = 0;

	public function __construct() {
		if ( $this->check_builder() ) {
			remove_action( 'freshio_footer', 'freshio_footer_default', 20 );
			add_action( 'freshio_footer', [ $this, 'render_footer' ], 20 );
			add_action( 'wp_enqueue_scripts', [ $this, 'add_css' ] );
			add_filter( 'body_class', [ $this, 'body_class' ] );

			// Remove Sidebar FooterBuilder
			add_action('init', [$this, 'setup']);
		}

	}

	public function setup(){
		if(is_singular('elementor_library')){
			remove_action('freshio_sidebar', 'freshio_get_sidebar', 10);
		}
	}

	private function check_builder() {
		if ( freshio_get_theme_option( 'enable-footer-builder', false ) ) {
			$slug = freshio_get_theme_option( 'footer-builder-slug', '' );
			if ( $slug ) {

				$queried_post = get_page_by_path( $slug, OBJECT, 'elementor_library' );

				if ( isset( $queried_post->ID ) ) {

					$this->footer_id = $queried_post->ID;

					return true;
				}
			}

		}

		return false;
	}

	public function body_class( $class ) {
		$class[] = 'freshio-footer-builder';
		return $class;
	}

	public function add_css() {
		Elementor\Core\Files\CSS\Post::create( $this->footer_id )->enqueue();
	}

	//
	public function render_footer() {
	    // WPML
        $wpml_id  = apply_filters( 'wpml_object_id', $this->footer_id );
		$this->footer_id = $wpml_id ? $wpml_id : $this->footer_id;

		// Polylang
		if(function_exists('pll_get_post')){
			$this->footer_id = pll_get_post($this->footer_id);
		}

		echo Elementor\Plugin::instance()->frontend->get_builder_content( $this->footer_id );
	}
}

return new Freshio_Footer_Builder();
