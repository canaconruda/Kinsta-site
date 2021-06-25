<?php

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Freshio_Elementor' ) ) :

	/**
	 * The Freshio Elementor Integration class
	 */
	class Freshio_Elementor {
		private $suffix = '';

		public function __construct() {
			$this->suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			add_action( 'wp', [ $this, 'register_auto_scripts_frontend' ] );
			add_action( 'elementor/init', array( $this, 'add_category' ) );
			add_action( 'wp_enqueue_scripts', [ $this, 'add_scripts' ], 15 );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_widgets' ) );
			add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'add_js' ] );

			// Custom Animation Scroll
			add_filter( 'elementor/controls/animations/additional_animations', [ $this, 'add_animations_scroll' ] );

			// Elementor Fix Noitice WooCommerce
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'woocommerce_fix_notice' ) );

			// Backend
			add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'add_scripts_editor' ] );
			add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'add_style_editor' ], 99 );
//
//			// Add Icon Custom
			add_action( 'elementor/icons_manager/native', [ $this, 'add_icons_native' ] );
			add_action( 'elementor/controls/controls_registered', [ $this, 'add_icons' ] );

			if ( ! freshio_is_elementor_pro_activated() ) {
				require trailingslashit( get_template_directory() ) . 'inc/elementor/custom-css.php';
			}

			// Fix Parallax granular-controls-for-elementor
			if ( function_exists( 'granular_get_options' ) ) {
				if ( 'yes' === granular_get_options( 'granular_editor_parallax_on', 'granular_editor_settings', 'no' ) ) {
					add_action( 'elementor/frontend/section/after_render', [
						$this,
						'granular_editor_after_render'
					], 10, 1 );
				}
			}
			add_filter( 'elementor/fonts/additional_fonts', [ $this, 'update_google_fonts' ] );
		}

		public function update_google_fonts( $fonts ) {
			$fonts["Bebas Neue"] = 'googlefonts';

			return $fonts;
		}

		public function granular_editor_after_render( $element ) {
			$settings = $element->get_settings();
			if ( $element->get_settings( 'section_parallax_on' ) == 'yes' ) {
				$type        = $settings['parallax_type'];
				$and_support = $settings['android_support'];
				$ios_support = $settings['ios_support'];
				$speed       = $settings['parallax_speed'];
				?>

				<script type="text/javascript">
					(function ($) {
						"use strict";
						var granularParallaxElementorFront = {
							init: function () {
								elementorFrontend.hooks.addAction('frontend/element_ready/global', granularParallaxElementorFront.initWidget);
							},
							initWidget: function ($scope) {
								$('.elementor-element-<?php echo esc_js( $element->get_id() ); ?>').jarallax({
									type: '<?php echo esc_js( $type ); ?>',
									speed: <?php echo esc_js( $speed ); ?>,
									keepImg: true,
									imgSize: 'cover',
									imgPosition: '50% 0%',
									noAndroid: <?php echo esc_js( $and_support ); ?>,
									noIos: <?php echo esc_js( $ios_support ); ?>
								});
							}
						};
						$(window).on('elementor/frontend/init', granularParallaxElementorFront.init);
					}(jQuery));
				</script>

			<?php }
		}

		public function add_js() {
			global $freshio_version;
			wp_enqueue_script( 'freshio-elementor-frontend', get_theme_file_uri( '/assets/js/elementor-frontend.js' ), [], $freshio_version );
		}

		public function add_style_editor() {
			global $freshio_version;
			wp_enqueue_style( 'freshio-elementor-editor-icon', get_theme_file_uri( '/assets/css/admin/elementor/icons.css' ), [], $freshio_version );
		}

		public function add_scripts_editor() {
			global $freshio_version;
//			wp_enqueue_script( 'freshio-elementor-admin-editor', get_theme_file_uri( '/assets/js/elementor/editor/backend.js' ), [], $freshio_version, true );
		}

		public function add_scripts() {
			global $freshio_version;
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_enqueue_style( 'freshio-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', $freshio_version );
			wp_style_add_data( 'freshio-elementor', 'rtl', 'replace' );

//			Dark Version
            if ( freshio_get_theme_option( 'site_mode', 'light' ) === 'dark' ) {
                wp_enqueue_style('freshio-elementor-dark-style', get_template_directory_uri() . '/assets/css/woocommerce/dark-elementor.css', array(), $freshio_version);
            }

			// Add Scripts
			wp_register_script( 'tweenmax', get_theme_file_uri( '/assets/js/vendor/TweenMax.min.js' ), array( 'jquery' ), '1.11.1' );
			wp_register_script( 'parallaxmouse', get_theme_file_uri( '/assets/js/vendor/jquery-parallax.js' ), array( 'jquery' ), $freshio_version );

			if ( freshio_elementor_check_type( 'animated-bg-parallax' ) ) {
				wp_enqueue_script( 'tweenmax' );
				wp_enqueue_script( 'jquery-panr', get_theme_file_uri( '/assets/js/vendor/jquery-panr' . $suffix . '.js' ), array( 'jquery' ), '0.0.1' );
			}
		}


		public function register_auto_scripts_frontend() {
            global $freshio_version;
            wp_register_script('freshio-elementor-brand', get_theme_file_uri('/assets/js/elementor/brand.js'), array('jquery','elementor-frontend'), $freshio_version, true);
            wp_register_script('freshio-elementor-image-carousel', get_theme_file_uri('/assets/js/elementor/image-carousel.js'), array('jquery','elementor-frontend'), $freshio_version, true);
            wp_register_script('freshio-elementor-posts-grid', get_theme_file_uri('/assets/js/elementor/posts-grid.js'), array('jquery','elementor-frontend'), $freshio_version, true);
            wp_register_script('freshio-elementor-product-tab', get_theme_file_uri('/assets/js/elementor/product-tab.js'), array('jquery','elementor-frontend'), $freshio_version, true);
            wp_register_script('freshio-elementor-products', get_theme_file_uri('/assets/js/elementor/products.js'), array('jquery','elementor-frontend'), $freshio_version, true);
            wp_register_script('freshio-elementor-tab-hover', get_theme_file_uri('/assets/js/elementor/tab-hover.js'), array('jquery','elementor-frontend'), $freshio_version, true);
            wp_register_script('freshio-elementor-testimonial', get_theme_file_uri('/assets/js/elementor/testimonial.js'), array('jquery','elementor-frontend'), $freshio_version, true);
           
        }

		public function add_category() {
			Elementor\Plugin::instance()->elements_manager->add_category(
				'freshio-addons',
				array(
					'title' => esc_html__( 'Freshio Addons', 'freshio' ),
					'icon'  => 'fa fa-plug',
				),
				1 );
		}

		public function add_animations_scroll( $animations ) {
			$animations['Freshio Animation'] = [
				'opal-move-up'    => 'Move Up',
				'opal-move-down'  => 'Move Down',
				'opal-move-left'  => 'Move Left',
				'opal-move-right' => 'Move Right',
				'opal-flip'       => 'Flip',
				'opal-helix'      => 'Helix',
				'opal-scale-up'   => 'Scale',
				'opal-am-popup'   => 'Popup',
			];

			return $animations;
		}

		/**
		 * @param $widgets_manager Elementor\Widgets_Manager
		 */
		public function include_widgets( $widgets_manager ) {
			$files = glob( get_theme_file_path( '/inc/elementor/widgets/*.php' ) );
			foreach ( $files as $file ) {
				if ( file_exists( $file ) ) {
					require_once $file;
				}
			}

//			 Button
			add_action( 'elementor/element/button/section_style/after_section_end', function ( $element, $args ) {
				/** @var \Elementor\Element_Base $element */
				$element->update_control( 'button_type', [
					'options' => [
						''        => esc_html__( 'Default', 'freshio' ),
						'primary' => esc_html__( 'Primary', 'freshio' ),
						'underline' => esc_html__( 'Underline', 'freshio' ),
						'info'    => esc_html__( 'Info', 'freshio' ),
						'success' => esc_html__( 'Success', 'freshio' ),
						'warning' => esc_html__( 'Warning', 'freshio' ),
						'danger'  => esc_html__( 'Danger', 'freshio' ),
					],
				] );
			}, 10, 2 );

			add_action( 'elementor/element/button/section_style/before_section_end', function ( $element, $args ) {
				$element->add_control(
					'icon_effect',
					[
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label' => __( 'Icon Effect', 'freshio' ),
						'default'	=> 'yes',
						'prefix_class'	=> 'icon-effect-'
					]
				);
			},10,2);

			// Heading
			add_action( 'elementor/element/heading/section_title_style/after_section_end', function ( $element, $args ) {
				/** @var \Elementor\Element_Base $element */
				// Remove Schema
				$element->update_control( 'title_color', [
					'scheme' => [],
				] );
			}, 10, 2 );

			// Counter
			add_action( 'elementor/element/counter/section_number/after_section_end', function ( $element, $args ) {
				/** @var \Elementor\Element_Base $element */
				// Remove Schema
				$element->update_control( 'title_color', [
					'scheme' => [],
				] );
			}, 10, 2 );

			// Toggle
			add_action( 'elementor/element/toggle/section_toggle_style_title/after_section_end', function ( $element, $args ) {
				/** @var \Elementor\Element_Base $element */
				// Remove Schema
				$element->update_control( 'title_color', [
					'scheme' => [],
				] );

				$element->update_control( 'tab_active_color', [
					'scheme' => [],
				] );
			}, 10, 2 );

			// Icon box
			add_action( 'elementor/element/icon-box/section_style_content/after_section_end', function ( $element, $args ) {

				$element->update_control( 'view', [
					'options' => [
						'default' => __( 'Default', 'freshio' ),
						'stacked' => __( 'Stacked', 'freshio' ),
						'stacked-freshio' => __( 'Stacked Freshio', 'freshio' ),
						'framed' => __( 'Framed', 'freshio' ),
					],
				] );

				$element->update_control( 'primary_color', [
					'selectors' => [
						'{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-framed .elementor-icon, {{WRAPPER}}.elementor-view-default .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}}; border-color: {{VALUE}};',
						'{{WRAPPER}}.elementor-view-stacked-freshio .elementor-icon svg' => 'fill: {{VALUE}};',
                        '{{WRAPPER}}.elementor-view-stacked-freshio .elementor-icon-box-wrapper:hover i' => 'color: {{VALUE}};',
					],
				] );

                $element->update_control( 'secondary_color', [
                    'selectors' => [
                        '{{WRAPPER}}.elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-view-stacked .elementor-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                        '{{WRAPPER}}.elementor-view-stacked-freshio .elementor-icon' => 'color: {{VALUE}};',
                    ],
                ] );

			}, 10, 2 );

			// Image Box
			add_action( 'elementor/element/image-box/section_style_content/after_section_end', function ( $element, $args ) {
				/** @var \Elementor\Element_Base $element */
				// Remove Schema
				$element->update_control( 'title_color', [
					'scheme' => [],
				] );

				$element->update_control( 'title_typography', [
					'scheme' => [],
				] );

				$element->update_control( 'description_color', [
					'scheme' => [],
				] );

				$element->update_control( 'description_typography', [
					'scheme' => [],
				] );

			}, 10, 2 );

			add_action( 'elementor/element/image-box/section_style_content/before_section_end', function ( $element, $args ) {
				$element->add_responsive_control(
					'content_padding',
					[
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'label' => __( 'Padding', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} .elementor-image-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
			},10,2);

			add_action( 'elementor/element/image-box/section_style_image/before_section_end', function ( $element, $args ) {
				$element->add_control(
					'imgbox_border_radius',
					[
						'label' => __( 'Border Radius', 'freshio' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors' => [
							'{{WRAPPER}} .elementor-image-box-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
			},10,2);




			// Icon Box
			add_action( 'elementor/element/icon-box/section_style_content/after_section_end', function ( $element, $args ) {
				/** @var \Elementor\Element_Base $element */
				// Remove Schema
				$element->update_control( 'primary_color', [
					'scheme' => [],
				] );

				$element->update_control( 'title_color', [
					'scheme' => [],
				] );

				$element->update_control( 'title_typography', [
					'scheme' => [],
				] );

				$element->update_control( 'description_color', [
					'scheme' => [],
				] );

				$element->update_control( 'description_typography', [
					'scheme' => [],
				] );
			}, 10, 2 );

			// Icon List
			add_action( 'elementor/element/icon-list/section_text_style/after_section_end', function ( $element, $args ) {
				/** @var \Elementor\Element_Base $element */
				// Remove Schema
				$element->update_control( 'icon_color', [
					'scheme' => [],
				] );

				$element->update_control( 'text_color', [
					'scheme'    => [],
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item .elementor-icon-list-text' => 'color: {{VALUE}};',
					],
				] );

				$element->update_control( 'text_color_hover', [
					'scheme'    => [],
					'selectors' => [
						'{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}};',
					],
				] );

				$element->update_control( 'icon_typography', [
					'scheme'    => [],
					'selectors' => '{{WRAPPER}} .elementor-icon-list-items .elementor-icon-list-item:hover .elementor-icon-list-text',
				] );

				$element->update_control( 'divider_color', [
					'scheme'  => [],
					'default' => ''
				] );

			}, 10, 2 );

//			Call to action
			add_action( 'elementor/element/call-to-action/button_style/before_section_end', function ( $element, $args ) {

                $element->update_control(
                    'button_border_width',
                    [
                        'type' => Controls_Manager::DIMENSIONS,
                        'selectors' => [
                            '{{WRAPPER}} .elementor-cta__button' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                        ],
                    ]
                );

				$element->add_control(
					'button_padding',
					[
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'label' => __( 'Padding', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} .elementor-cta__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$element->add_control(
					'button_effect',
					[
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label' => __( 'Effect Hover', 'freshio' ),
						'prefix_class'	=> 'button-effect-'
					]
				);
			},10,2);

//			Countdown
			add_action( 'elementor/element/countdown/section_countdown/before_section_end', function ( $element, $args ) {

				$element->add_control(
					'show_dot',
					[
					'label'     => __( 'Show Dots', 'freshio' ),
					'type'      => Controls_Manager::SWITCHER,
					'selectors' => [
						'{{WRAPPER}} .elementor-countdown-item:after' => 'content: "";',
					],
					'separator' => 'before'
					]
				);

			},10,2);

			//			accordion
			add_action( 'elementor/element/accordion/section_toggle_style_icon/before_section_end', function ( $element, $args ) {

                $element->add_control(
                    'icon_size',
                    [
                        'label' => __( 'Size', 'freshio' ),
                        'type' => Controls_Manager::SLIDER,
                        'range' => [
                            'px' => [
                                'min' => 6,
                                'max' => 300,
                            ],
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

				$element->add_control(
					'icon_background',
					[
						'label' => __( 'Background icon', 'freshio' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'background-color: {{VALUE}};',
						],
					]
				);
				$element->add_control(
					'icon_background_active',
					[
						'label' => __( 'Background icon active', 'freshio' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .elementor-accordion-icon' => 'background-color: {{VALUE}};',
						],
					]
				);

				$element->add_control(
					'border_width_icon',
					[
						'label' => __( 'Border Width icon', 'freshio' ),
						'type' => Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 10,
							],
						],
						'selectors' => [
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'border-width: {{SIZE}}{{UNIT}};',
						],
					]
				);

				$element->add_control(
					'border_color_icon',
					[
						'label' => __( 'Border Color icon', 'freshio' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title .elementor-accordion-icon' => 'border-color: {{VALUE}};',
						],
					]
				);
				$element->add_control(
					'border_color_icon_active',
					[
						'label' => __( 'Border Color icon active', 'freshio' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-accordion .elementor-tab-title.elementor-active .elementor-accordion-icon' => 'border-color: {{VALUE}};',
						],
					]
				);

			},10,2);


//			Form
			add_action( 'elementor/element/form/section_field_style/before_section_end', function ( $element, $args ) {
				$element->add_control(
					'field_border_color_focus',
					[
						'label' => __( 'Border Color Focus', 'freshio' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .elementor-field-group:not(.elementor-field-type-upload) .elementor-field:not(.elementor-select-wrapper):focus' => 'border-color: {{VALUE}};',
							'{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select:focus' => 'border-color: {{VALUE}};',
						],
					]
				);

				$element->add_control(
					'field_text_padding',
					[
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'label' => __( 'Padding', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} .elementor-field-group:not(.elementor-field-type-upload):not(.elementor-field-type-recaptcha_v3):not(.elementor-field-type-recaptcha) .elementor-field:not(.elementor-select-wrapper)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
							'{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$element->add_control(
					'field_text_margin',
					[
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'label' => __( 'Margin', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} .elementor-field-group .elementor-field' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$element->add_control(
					'textarea_heading',
					[
						'type' => \Elementor\Controls_Manager::HEADING,
						'label' => __( 'Textarea', 'freshio' ),
						'separator'	=> 'before'
					]
				);

				$element->add_control(
					'textarea_color',
					[
						'type' => \Elementor\Controls_Manager::COLOR,
						'label' => __( 'Color', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} textarea.elementor-field' => 'color: {{VALUE}} !important',
						],
					]
				);

				$element->add_control(
					'textarea_background',
					[
						'type' => \Elementor\Controls_Manager::COLOR,
						'label' => __( 'Background', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} textarea.elementor-field' => 'background: {{VALUE}} !important',
						],
					]
				);

				$element->add_control(
					'textarea_border_color',
					[
						'type' => \Elementor\Controls_Manager::COLOR,
						'label' => __( 'Border Color', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} textarea.elementor-field ' => 'border-color: {{VALUE}} !important',
						],
					]
				);

				$element->add_control(
					'textarea_border_color_active',
					[
						'type' => \Elementor\Controls_Manager::COLOR,
						'label' => __( 'Border Color Active', 'freshio' ),
						'selectors' => [
							'{{WRAPPER}} textarea.elementor-field:focus ' => 'border-color: {{VALUE}} !important',
						],
					]
				);

				$element->add_control(
					'textarea_border',
					[
						'label' => __( 'Border Width', 'freshio' ),
						'type' => \Elementor\Controls_Manager::SLIDER,
						'range' => [
							'px' => [
								'min' => 0,
								'max' => 20,
							],
						],
						'selectors' => [
							'{{WRAPPER}} textarea.elementor-field' => 'border-width: {{SIZE}}{{UNIT}} !important;',
						],
					]
				);

				$element->add_control(
					'textarea_padding',
					[
						'label' => __( 'Padding', 'freshio' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .elementor-field-group-message textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
						],
					]
				);


			},10,2);

			add_action( 'elementor/element/form/section_button_style/before_section_end', function ( $element, $args ) {
				$element->add_control(
					'button_submit_effect',
					[
						'type' => \Elementor\Controls_Manager::SWITCHER,
						'label' => __( 'Effect Hover', 'freshio' ),
						'prefix_class'	=> 'button-effect-'
					]
				);
			},10,2);

		}

		public function woocommerce_fix_notice() {
			if ( freshio_is_woocommerce_activated() ) {
				remove_action( 'woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5 );
				remove_action( 'woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_cart', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_account_content', 'woocommerce_output_all_notices', 10 );
				remove_action( 'woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10 );
			}
		}

		public function add_icons( $manager ) {
            $new_icons = json_decode( '{"freshio-icon-angle-double-down":"angle-double-down","freshio-icon-angle-double-left":"angle-double-left","freshio-icon-angle-double-right":"angle-double-right","freshio-icon-angle-double-up":"angle-double-up","freshio-icon-apple-alt":"apple-alt","freshio-icon-badge-percent":"badge-percent","freshio-icon-calendar":"calendar","freshio-icon-comments-alt":"comments-alt","freshio-icon-consultant":"consultant","freshio-icon-creation":"creation","freshio-icon-curated_2":"curated_2","freshio-icon-curated":"curated","freshio-icon-design":"design","freshio-icon-drag":"drag","freshio-icon-egg-fried":"egg-fried","freshio-icon-envelope-open-text":"envelope-open-text","freshio-icon-experiences":"experiences","freshio-icon-farm":"farm","freshio-icon-fresh":"fresh","freshio-icon-handmade_2":"handmade_2","freshio-icon-handmade":"handmade","freshio-icon-hapiness":"hapiness","freshio-icon-headphones-alt":"headphones-alt","freshio-icon-ice-cream":"ice-cream","freshio-icon-language":"language","freshio-icon-leaf":"leaf","freshio-icon-long-arrow-down":"long-arrow-down","freshio-icon-long-arrow-left":"long-arrow-left","freshio-icon-long-arrow-right":"long-arrow-right","freshio-icon-long-arrow-up":"long-arrow-up","freshio-icon-meat":"meat","freshio-icon-natural":"natural","freshio-icon-oneclick":"oneclick","freshio-icon-performance":"performance","freshio-icon-pizza-slice":"pizza-slice","freshio-icon-play":"play","freshio-icon-product":"product","freshio-icon-quality":"quality","freshio-icon-return":"return","freshio-icon-salad":"salad","freshio-icon-savemoney":"savemoney","freshio-icon-seo":"seo","freshio-icon-shipping":"shipping","freshio-icon-sizing":"sizing","freshio-icon-sustainable":"sustainable","freshio-icon-theme-contact":"theme-contact","freshio-icon-theme-drag":"theme-drag","freshio-icon-theme-heart":"theme-heart","freshio-icon-theme-language":"theme-language","freshio-icon-theme-oneclick":"theme-oneclick","freshio-icon-theme-performance":"theme-performance","freshio-icon-theme-quality":"theme-quality","freshio-icon-theme-quote":"theme-quote","freshio-icon-theme-seo":"theme-seo","freshio-icon-theme-shipping":"theme-shipping","freshio-icon-volleyball-ball":"volleyball-ball","freshio-icon-angle-down":"angle-down","freshio-icon-angle-left":"angle-left","freshio-icon-angle-right":"angle-right","freshio-icon-angle-up":"angle-up","freshio-icon-arrow-circle-down":"arrow-circle-down","freshio-icon-arrow-circle-left":"arrow-circle-left","freshio-icon-arrow-circle-right":"arrow-circle-right","freshio-icon-arrow-circle-up":"arrow-circle-up","freshio-icon-bars":"bars","freshio-icon-caret-down":"caret-down","freshio-icon-caret-left":"caret-left","freshio-icon-caret-right":"caret-right","freshio-icon-caret-up":"caret-up","freshio-icon-cart-empty":"cart-empty","freshio-icon-check-square":"check-square","freshio-icon-chevron-circle-left":"chevron-circle-left","freshio-icon-chevron-circle-right":"chevron-circle-right","freshio-icon-chevron-down":"chevron-down","freshio-icon-chevron-left":"chevron-left","freshio-icon-chevron-right":"chevron-right","freshio-icon-chevron-up":"chevron-up","freshio-icon-circle":"circle","freshio-icon-cloud-download-alt":"cloud-download-alt","freshio-icon-comment":"comment","freshio-icon-comments":"comments","freshio-icon-contact":"contact","freshio-icon-credit-card":"credit-card","freshio-icon-dot-circle":"dot-circle","freshio-icon-edit":"edit","freshio-icon-envelope":"envelope","freshio-icon-expand-alt":"expand-alt","freshio-icon-external-link-alt":"external-link-alt","freshio-icon-eye":"eye","freshio-icon-file-alt":"file-alt","freshio-icon-file-archive":"file-archive","freshio-icon-filter":"filter","freshio-icon-folder-open":"folder-open","freshio-icon-folder":"folder","freshio-icon-free_ship":"free_ship","freshio-icon-frown":"frown","freshio-icon-gift":"gift","freshio-icon-grip-horizontal":"grip-horizontal","freshio-icon-heart-fill":"heart-fill","freshio-icon-heart":"heart","freshio-icon-history":"history","freshio-icon-home":"home","freshio-icon-info-circle":"info-circle","freshio-icon-instagram":"instagram","freshio-icon-level-up-alt":"level-up-alt","freshio-icon-long-arrow-alt-down":"long-arrow-alt-down","freshio-icon-long-arrow-alt-left":"long-arrow-alt-left","freshio-icon-long-arrow-alt-right":"long-arrow-alt-right","freshio-icon-long-arrow-alt-up":"long-arrow-alt-up","freshio-icon-map-marker-check":"map-marker-check","freshio-icon-meh":"meh","freshio-icon-minus-circle":"minus-circle","freshio-icon-mobile-android-alt":"mobile-android-alt","freshio-icon-money-bill":"money-bill","freshio-icon-pencil-alt":"pencil-alt","freshio-icon-plus-circle":"plus-circle","freshio-icon-plus":"plus","freshio-icon-quote":"quote","freshio-icon-random":"random","freshio-icon-reply-all":"reply-all","freshio-icon-reply":"reply","freshio-icon-search-plus":"search-plus","freshio-icon-search":"search","freshio-icon-shield-check":"shield-check","freshio-icon-shopping-basket":"shopping-basket","freshio-icon-shopping-cart":"shopping-cart","freshio-icon-sign-out-alt":"sign-out-alt","freshio-icon-smile":"smile","freshio-icon-spinner":"spinner","freshio-icon-square":"square","freshio-icon-star":"star","freshio-icon-store":"store","freshio-icon-sync":"sync","freshio-icon-tachometer-alt":"tachometer-alt","freshio-icon-th-large":"th-large","freshio-icon-th-list":"th-list","freshio-icon-thumbtack":"thumbtack","freshio-icon-times-circle":"times-circle","freshio-icon-times":"times","freshio-icon-trophy-alt":"trophy-alt","freshio-icon-truck":"truck","freshio-icon-user-headset":"user-headset","freshio-icon-user-shield":"user-shield","freshio-icon-user":"user","freshio-icon-adobe":"adobe","freshio-icon-amazon":"amazon","freshio-icon-android":"android","freshio-icon-angular":"angular","freshio-icon-apper":"apper","freshio-icon-apple":"apple","freshio-icon-atlassian":"atlassian","freshio-icon-behance":"behance","freshio-icon-bitbucket":"bitbucket","freshio-icon-bitcoin":"bitcoin","freshio-icon-bity":"bity","freshio-icon-bluetooth":"bluetooth","freshio-icon-btc":"btc","freshio-icon-centos":"centos","freshio-icon-chrome":"chrome","freshio-icon-codepen":"codepen","freshio-icon-cpanel":"cpanel","freshio-icon-discord":"discord","freshio-icon-dochub":"dochub","freshio-icon-docker":"docker","freshio-icon-dribbble":"dribbble","freshio-icon-dropbox":"dropbox","freshio-icon-drupal":"drupal","freshio-icon-ebay":"ebay","freshio-icon-facebook":"facebook","freshio-icon-figma":"figma","freshio-icon-firefox":"firefox","freshio-icon-google-plus":"google-plus","freshio-icon-google":"google","freshio-icon-grunt":"grunt","freshio-icon-gulp":"gulp","freshio-icon-html5":"html5","freshio-icon-jenkins":"jenkins","freshio-icon-joomla":"joomla","freshio-icon-link-brand":"link-brand","freshio-icon-linkedin":"linkedin","freshio-icon-mailchimp":"mailchimp","freshio-icon-opencart":"opencart","freshio-icon-paypal":"paypal","freshio-icon-pinterest-p":"pinterest-p","freshio-icon-reddit":"reddit","freshio-icon-skype":"skype","freshio-icon-slack":"slack","freshio-icon-snapchat":"snapchat","freshio-icon-spotify":"spotify","freshio-icon-trello":"trello","freshio-icon-twitter":"twitter","freshio-icon-vimeo":"vimeo","freshio-icon-whatsapp":"whatsapp","freshio-icon-wordpress":"wordpress","freshio-icon-yoast":"yoast","freshio-icon-youtube":"youtube"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

		public function add_icons_native( $tabs ) {
			global $freshio_version;
			$tabs['opal-custom'] = [
				'name'          => 'freshio-icon',
				'label'         => esc_html__( 'Freshio Icon', 'freshio' ),
				'prefix'        => 'freshio-icon-',
				'displayPrefix' => 'freshio-icon-',
				'labelIcon'     => 'fab fa-font-awesome-alt',
				'ver'           => $freshio_version,
				'fetchJson'     => get_theme_file_uri( '/inc/elementor/icons.json' ),
				'native'        => true,
			];

			return $tabs;
		}
	}

endif;

return new Freshio_Elementor();
