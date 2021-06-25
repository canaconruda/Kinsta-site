<?php

class Freshio_Merlin_Config {

	private $config = [];

	public function __construct() {
		$this->init();
		add_action( 'merlin_import_files', [ $this, 'import_files' ] );
		add_action( 'merlin_after_all_import', [ $this, 'after_import_setup' ], 10, 1 );
		add_filter( 'merlin_generate_child_functions_php', [ $this, 'render_child_functions_php' ] );
	}

	private function init() {
		$wizard = new Merlin(
			$config = array(
				'directory'          => 'inc/merlin',
				// Location / directory where Merlin WP is placed in your theme.
				'merlin_url'         => 'merlin',
				// The wp-admin page slug where Merlin WP loads.
				'parent_slug'        => 'themes.php',
				// The wp-admin parent page slug for the admin menu item.
				'capability'         => 'manage_options',
				// The capability required for this menu to be displayed to the user.
				'dev_mode'           => true,
				// Enable development mode for testing.
				'license_step'       => false,
				// EDD license activation step.
				'license_required'   => false,
				// Require the license activation step.
				'license_help_url'   => '',
				// URL for the 'license-tooltip'.
				'edd_remote_api_url' => '',
				// EDD_Theme_Updater_Admin remote_api_url.
				'edd_item_name'      => '',
				// EDD_Theme_Updater_Admin item_name.
				'edd_theme_slug'     => '',
				// EDD_Theme_Updater_Admin item_slug.
			),
			$strings = array(
				'admin-menu'          => esc_html__( 'Theme Setup', 'freshio' ),

				/* translators: 1: Title Tag 2: Theme Name 3: Closing Title Tag */
				'title%s%s%s%s'       => esc_html__( '%1$s%2$s Themes &lsaquo; Theme Setup: %3$s%4$s', 'freshio' ),
				'return-to-dashboard' => esc_html__( 'Return to the dashboard', 'freshio' ),
				'ignore'              => esc_html__( 'Disable this wizard', 'freshio' ),

				'btn-skip'                 => esc_html__( 'Skip', 'freshio' ),
				'btn-next'                 => esc_html__( 'Next', 'freshio' ),
				'btn-start'                => esc_html__( 'Start', 'freshio' ),
				'btn-no'                   => esc_html__( 'Cancel', 'freshio' ),
				'btn-plugins-install'      => esc_html__( 'Install', 'freshio' ),
				'btn-child-install'        => esc_html__( 'Install', 'freshio' ),
				'btn-content-install'      => esc_html__( 'Install', 'freshio' ),
				'btn-import'               => esc_html__( 'Import', 'freshio' ),
				'btn-license-activate'     => esc_html__( 'Activate', 'freshio' ),
				'btn-license-skip'         => esc_html__( 'Later', 'freshio' ),

				/* translators: Theme Name */
				'license-header%s'         => esc_html__( 'Activate %s', 'freshio' ),
				/* translators: Theme Name */
				'license-header-success%s' => esc_html__( '%s is Activated', 'freshio' ),
				/* translators: Theme Name */
				'license%s'                => esc_html__( 'Enter your license key to enable remote updates and theme support.', 'freshio' ),
				'license-label'            => esc_html__( 'License key', 'freshio' ),
				'license-success%s'        => esc_html__( 'The theme is already registered, so you can go to the next step!', 'freshio' ),
				'license-json-success%s'   => esc_html__( 'Your theme is activated! Remote updates and theme support are enabled.', 'freshio' ),
				'license-tooltip'          => esc_html__( 'Need help?', 'freshio' ),

				/* translators: Theme Name */
				'welcome-header%s'         => esc_html__( 'Welcome to %s', 'freshio' ),
				'welcome-header-success%s' => esc_html__( 'Hi. Welcome back', 'freshio' ),
				'welcome%s'                => esc_html__( 'This wizard will set up your theme, install plugins, and import content. It is optional & should take only a few minutes.', 'freshio' ),
				'welcome-success%s'        => esc_html__( 'You may have already run this theme setup wizard. If you would like to proceed anyway, click on the "Start" button below.', 'freshio' ),

				'child-header'         => esc_html__( 'Install Child Theme', 'freshio' ),
				'child-header-success' => esc_html__( 'You\'re good to go!', 'freshio' ),
				'child'                => esc_html__( 'Let\'s build & activate a child theme so you may easily make theme changes.', 'freshio' ),
				'child-success%s'      => esc_html__( 'Your child theme has already been installed and is now activated, if it wasn\'t already.', 'freshio' ),
				'child-action-link'    => esc_html__( 'Learn about child themes', 'freshio' ),
				'child-json-success%s' => esc_html__( 'Awesome. Your child theme has already been installed and is now activated.', 'freshio' ),
				'child-json-already%s' => esc_html__( 'Awesome. Your child theme has been created and is now activated.', 'freshio' ),

				'plugins-header'         => esc_html__( 'Install Plugins', 'freshio' ),
				'plugins-header-success' => esc_html__( 'You\'re up to speed!', 'freshio' ),
				'plugins'                => esc_html__( 'Let\'s install some essential WordPress plugins to get your site up to speed.', 'freshio' ),
				'plugins-success%s'      => esc_html__( 'The required WordPress plugins are all installed and up to date. Press "Next" to continue the setup wizard.', 'freshio' ),
				'plugins-action-link'    => esc_html__( 'Advanced', 'freshio' ),

				'import-header'      => esc_html__( 'Import Content', 'freshio' ),
				'import'             => esc_html__( 'Let\'s import content to your website, to help you get familiar with the theme.', 'freshio' ),
				'import-action-link' => esc_html__( 'Advanced', 'freshio' ),

				'ready-header'      => esc_html__( 'All done. Have fun!', 'freshio' ),

				/* translators: Theme Author */
				'ready%s'           => esc_html__( 'Your theme has been all set up. Enjoy your new theme by %s.', 'freshio' ),
				'ready-action-link' => esc_html__( 'Extras', 'freshio' ),
				'ready-big-button'  => esc_html__( 'View your website', 'freshio' ),
				'ready-link-1'      => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://wordpress.org/support/', esc_html__( 'Explore WordPress', 'freshio' ) ),
				'ready-link-2'      => sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://themebeans.com/contact/', esc_html__( 'Get Theme Support', 'freshio' ) ),
				'ready-link-3'      => sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'customize.php' ), esc_html__( 'Start Customizing', 'freshio' ) ),
			)
		);

		add_action( 'widgets_init', [ $this, 'widgets_init' ] );
	}

	public function render_child_functions_php() {
		$output
			= "<?php
/**
 * Theme functions and definitions.
 */
		 
		 ";

		return $output;
	}

	public function widgets_init() {
		require_once get_parent_theme_file_path( '/inc/merlin/includes/recent-post.php' );
		register_widget( 'Freshio_WP_Widget_Recent_Posts' );
		if ( freshio_is_woocommerce_activated() ) {
			require_once get_parent_theme_file_path( '/inc/merlin/includes/class-wc-widget-layered-nav.php' );
			register_widget( 'Freshio_Widget_Layered_Nav' );
		}
	}

	public function after_import_setup( $selected_import ) {
		$selected_import = ( $this->import_files() )[ $selected_import ];
		$check_oneclick  = get_option( 'freshio_check_oneclick', [] );
		$this->set_demo_menus();
		wp_delete_post( 1, true );

		// setup Home page
		$home = get_page_by_path( $selected_import['home'] );
		if ( $home ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $home->ID );
		}

		// Setup Options
		$options = $this->get_all_options();
		foreach ( $options as $key => $option ) {
			if ( count( $options ) > 0 ) {
				foreach ( $option as $k => $v ) {
					update_option( $k, $v );
				}
			}
		}

		if ( ! isset( $check_oneclick['mailchimp'] ) ) {
			$this->setup_mailchimp();
			$check_oneclick['mailchimp'] = 1;
		}
		$this->fixelementor();
		if ( ! isset( $check_oneclick['global_elementor'] ) ) {
			$this->set_elementor_global();
			$this->license_elementor_pro();
			$check_oneclick['global_elementor'] = 1;
		}

		\Elementor\Plugin::instance()->files_manager->clear_cache();

		update_option( 'freshio_check_oneclick', $check_oneclick );
	}

	private function fixelementor() {
		$datas = json_decode( file_get_contents( get_parent_theme_file_path( 'dummy-data/ejson.json' ) ), true );
		$query = new WP_Query( array(
			'post_type'      => [
				'page',
				'elementor_library',
			],
			'posts_per_page' => - 1
		) );
		while ( $query->have_posts() ): $query->the_post();
			global $post;
			$postid = get_the_ID();
			if ( get_post_meta( $post->ID, '_elementor_edit_mode', true ) === 'builder' ) {
				$data = json_decode( get_post_meta( $postid, '_elementor_data', true ) );
				if ( ! boolval( $data ) ) {
					if ( isset( $datas[ $post->post_name ] ) ) {
						update_post_meta( $postid, '_elementor_data', wp_slash( wp_json_encode( $datas[ $post->post_name ] ) ) );
					}
				}
			}
		endwhile;
		wp_reset_postdata();
	}

	private function setup_mailchimp() {
		$mailchimp = get_page_by_title( 'Opal MailChimp', OBJECT, 'mc4wp-form' );
		if ( $mailchimp ) {
			update_option( 'mc4wp_default_form_id', $mailchimp->ID );
		}
	}

	private function license_elementor_pro() {
		if ( defined( 'ELEMENTOR_PRO_VERSION' ) ) {
			$data = [
				'success'          => true,
				'license'          => 'valid',
				'item_id'          => false,
				'item_name'        => 'Elementor Pro',
				'is_local'         => false,
				'license_limit'    => '1000',
				'site_count'       => '1000',
				'activations_left' => 1,
				'expires'          => 'lifetime',
				'customer_email'   => 'customer@demo.com'
			];
			update_option( 'elementor_pro_license_key', 'Licence Hacked' );
			ElementorPro\License\API::set_license_data( $data, '+2 years' );
		}
	}

	public function get_all_options() {
		$options              = [];
		$options['elementor'] = array(
			'elementor_pro_version'                    => '3.1.1',
			'elementor_pro_license_key'                => 'Licence Hacked',
			'_elementor_pro_license_data'              =>
				array(
					'timeout' => 1678418737,
					'value'   => '{\"success\":true,\"license\":\"valid\",\"item_id\":false,\"item_name\":\"Elementor Pro\",\"is_local\":false,\"license_limit\":\"1000\",\"site_count\":\"1000\",\"activations_left\":1,\"expires\":\"lifetime\",\"customer_email\":\"customer@demo.com\"}',
				),
			'_elementor_pro_installed_time'            => '1597049813',
			'elementor_custom_icon_sets_config'        =>
				array(),
			'elementor_pro_theme_builder_conditions'   =>
				array(),
			'elementor_fonts_manager_font_types'       =>
				array(),
			'elementor_fonts_manager_fonts'            =>
				array(),
			'elementor_scheme_color'                   =>
				array(
					1 => '',
					2 => '',
					3 => '',
					4 => '',
				),
			'elementor_scheme_typography'              =>
				array(
					1 =>
						array(
							'font_family' => '',
							'font_weight' => '',
						),
					2 =>
						array(
							'font_family' => '',
							'font_weight' => '',
						),
					3 =>
						array(
							'font_family' => '',
							'font_weight' => '',
						),
					4 =>
						array(
							'font_family' => '',
							'font_weight' => '',
						),
				),
			'elementor_scheme_color-picker'            =>
				array(
					1 => '#6ec1e4',
					2 => '#54595f',
					3 => '#7a7a7a',
					4 => '#61ce70',
					5 => '#4054b2',
					6 => '#23a455',
					7 => '#000',
					8 => '#fff',
				),
			'_elementor_general_settings'              =>
				array(
					'default_generic_fonts' => 'Sans-serif',
					'container_width'       => '1290',
					'global_image_lightbox' => 'yes',
				),
			'elementor_cpt_support'                    =>
				array(
					0 => 'post',
					1 => 'page',
					2 => 'product',
				),
			'elementor_disable_color_schemes'          => '',
			'elementor_disable_typography_schemes'     => '',
			'elementor_allow_tracking'                 => 'no',
			'elementor_default_generic_fonts'          => 'Sans-serif',
			'elementor_container_width'                => '1290',
			'elementor_space_between_widgets'          => '',
			'elementor_stretched_section_container'    => '',
			'elementor_page_title_selector'            => '',
			'elementor_viewport_lg'                    => '',
			'elementor_viewport_md'                    => '',
			'elementor_global_image_lightbox'          => 'yes',
			'elementor_pro_recaptcha_site_key'         => '',
			'elementor_pro_recaptcha_secret_key'       => '',
			'elementor_pro_recaptcha_v3_site_key'      => '',
			'elementor_pro_recaptcha_v3_secret_key'    => '',
			'elementor_pro_recaptcha_v3_threshold'     => '0.5',
			'elementor_pro_facebook_app_id'            => '',
			'elementor_pro_mailchimp_api_key'          => '',
			'elementor_validate_api_data'              => '',
			'elementor_pro_drip_api_token'             => '',
			'elementor_pro_activecampaign_api_key'     => '',
			'elementor_pro_activecampaign_api_url'     => '',
			'elementor_pro_getresponse_api_key'        => '',
			'elementor_pro_convertkit_api_key'         => '',
			'elementor_pro_mailerlite_api_key'         => '',
			'elementor_use_mini_cart_template'         => 'initial',
			'elementor_typekit-kit-id'                 => '',
			'elementor_css_print_method'               => 'external',
			'elementor_editor_break_lines'             => '',
			'elementor_unfiltered_files_upload'        => '1',
			'elementor_load_fa4_shim'                  => '',
			'elementor_pro_tracker_notice'             => '1',
			'elementor_tracker_notice'                 => '1',
			'elementor_font_awesome_pro_kit_id'        => '',
			'elementor_enable_unfiltered_files_upload' => '',
			'elementor_install_history'                =>
				array(
					'2.9.14' => 1611988461,
					'2.10.3' => 1611988450,
					'3.0.10' => 1614239883,
					'3.1.0'  => 1611988462,
					'3.1.1'  => 1614239884,
				),
		);
		$options['bcn']       = array();

		return $options;
	}

	public function set_demo_menus() {
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

		set_theme_mod(
			'nav_menu_locations',
			array(
				'primary'  => $main_menu->term_id,
				'handheld' => $main_menu->term_id,
			)
		);
	}

	private function set_elementor_global() {
		$json
			= '
				{
				    "system_colors": [
				        {
				            "_id": "primary",
				            "title": "Primary",
				            "color": "#0a472e"
				        },
				        {
				            "_id": "secondary",
				            "title": "Secondary",
				            "color": "#0a472e"
				        },
				        {
				            "_id": "text",
				            "title": "Text",
				            "color": "#555555"
				        },
				        {
				            "_id": "accent",
				            "title": "Heading",
				            "color": "#000000"
				        }
				    ],
				    "custom_colors": [],
				    "system_typography": [
				        {
				            "_id": "primary",
				            "title": "Primary",
				            "typography_typography": "custom"
				        },
				        {
				            "_id": "secondary",
				            "title": "Secondary",
				            "typography_typography": "custom"
				        },
				        {
				            "_id": "text",
				            "title": "Text",
				            "typography_typography": "custom"
				        },
				        {
				            "_id": "accent",
				            "title": "Accent",
				            "typography_typography": "custom"
				        }
				    ],
				    "custom_typography": [],
				    "default_generic_fonts": "Sans-serif",
				    "site_name": "Freshio",
				    "site_description": "Just another WordPress site",
				    "page_title_selector": "h1.entry-title",
				    "activeItemIndex": 1
				}';


		$options = json_decode( $json, true );
		$id      = Elementor\Plugin::$instance->kits_manager->get_active_id();
		update_post_meta( $id, '_elementor_page_settings', $options );
	}

	public function import_files() {
		return array(
			array(
				'import_file_name'           => 'home 1',
				'home'                       => 'home-1',
				'local_import_file'          => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file'   => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'         => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-1.json' ),
						'option_name' => 'freshio_options',
					),
				),
				'import_rev_slider_file_url' => 'http://source.wpopal.com/freshio/dummy_data/revsliders/home-1/home-3.zip',
				'import_preview_image_url'   => get_theme_file_uri( '/assets/images/oneclick/home-1.jpg' ),
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'                => 'https://demo2.wpopal.com/freshio/home-1',
			),

			array(
				'import_file_name'           => 'home 2',
				'home'                       => 'home-2',
				'local_import_file'          => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file'   => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'         => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-2.json' ),
						'option_name' => 'freshio_options',
					),
				),
				'import_rev_slider_file_url' => 'http://source.wpopal.com/freshio/dummy_data/revsliders/home-2/home-2.zip',
				'import_preview_image_url'   => get_theme_file_uri( '/assets/images/oneclick/home-2.jpg' ),
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'                => 'https://demo2.wpopal.com/freshio/home-2',
			),

			array(
				'import_file_name'           => 'home 3',
				'home'                       => 'home-3',
				'local_import_file'          => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file'   => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'         => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-3.json' ),
						'option_name' => 'freshio_options',
					),
				),
				'import_rev_slider_file_url' => 'http://source.wpopal.com/freshio/dummy_data/revsliders/home-3/home-3.zip',
				'import_preview_image_url'   => get_theme_file_uri( '/assets/images/oneclick/home-3.jpg' ),
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'                => 'https://demo2.wpopal.com/freshio/home-3',
			),

			array(
				'import_file_name'           => 'home 4',
				'home'                       => 'home-4',
				'local_import_file'          => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file'   => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'         => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-4.json' ),
						'option_name' => 'freshio_options',
					),
				),
				'import_rev_slider_file_url' => 'http://source.wpopal.com/freshio/dummy_data/revsliders/home-4/home-4.zip',
				'import_preview_image_url'   => get_theme_file_uri( '/assets/images/oneclick/home-4.jpg' ),
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'                => 'https://demo2.wpopal.com/freshio/home-4',
			),

			array(
				'import_file_name'         => 'home 5',
				'home'                     => 'home-5',
				'local_import_file'        => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file' => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'       => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-5.json' ),
						'option_name' => 'freshio_options',
					),
				),

				'import_preview_image_url' => get_theme_file_uri( '/assets/images/oneclick/home-5.jpg' ),
				'import_notice'            => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'              => 'https://demo2.wpopal.com/freshio/home-5',
			),

			array(
				'import_file_name'           => 'home 6',
				'home'                       => 'home-6',
				'local_import_file'          => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file'   => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'         => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-6.json' ),
						'option_name' => 'freshio_options',
					),
				),
				'import_rev_slider_file_url' => 'http://source.wpopal.com/freshio/dummy_data/revsliders/home-6/home-6.zip',
				'import_preview_image_url'   => get_theme_file_uri( '/assets/images/oneclick/home-6.jpg' ),
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'                => 'https://demo2.wpopal.com/freshio/home-6',
			),

			array(
				'import_file_name'           => 'home 7',
				'home'                       => 'home-7',
				'local_import_file'          => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file'   => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'         => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-7.json' ),
						'option_name' => 'freshio_options',
					),
				),
				'import_rev_slider_file_url' => 'http://source.wpopal.com/freshio/dummy_data/revsliders/home-7/home-3.zip',
				'import_preview_image_url'   => get_theme_file_uri( '/assets/images/oneclick/home-7.jpg' ),
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'                => 'https://demo2.wpopal.com/freshio/home-7',
			),

			array(
				'import_file_name'           => 'home 8',
				'home'                       => 'home-8',
				'local_import_file'          => get_theme_file_path( '/dummy-data/content.xml' ),
				'local_import_widget_file'   => get_theme_file_path( '/dummy-data/widgets.json' ),
				'local_import_redux'         => array(
					array(
						'file_path'   => get_theme_file_path( '/dummy-data/redux/home-8.json' ),
						'option_name' => 'freshio_options',
					),
				),
				'import_rev_slider_file_url' => 'http://source.wpopal.com/freshio/dummy_data/revsliders/home-8/home-4.zip',
				'import_preview_image_url'   => get_theme_file_uri( '/assets/images/oneclick/home-8.jpg' ),
				'import_notice'              => esc_html__( 'After you import this demo, you will have to setup the slider separately.', 'freshio' ),
				'preview_url'                => 'https://demo2.wpopal.com/freshio/home-8',
			),
		);
	}
}

return new Freshio_Merlin_Config();
