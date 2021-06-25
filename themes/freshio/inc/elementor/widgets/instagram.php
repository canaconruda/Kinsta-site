<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


class Freshio_Elementor_Instagram extends Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve testimonial widget name.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'freshio-instagram';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve testimonial widget title.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Freshio Instagram', 'freshio' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve testimonial widget icon.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-social-icons';
	}

	public function get_categories() {
		return array( 'freshio-addons' );
	}

    public function get_script_depends() {
        return [ 'freshio-elementor-instagram', 'slick' ];
    }

	/**
	 * Register testimonial widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_instagram',
			[
				'label' => esc_html__( 'Instagram Config', 'freshio' ),
			]
		);


		$this->add_control(
			'username',
			[
				'label'   => esc_html__( 'Username', 'freshio' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'instagram'
			]
		);

		$this->add_control(
			'number',
			[
				'label'   => esc_html__( 'Number of photos', 'freshio' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

		$this->add_responsive_control(
			'per_row',
			[
				'label'   => esc_html__( 'Columns', 'freshio' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8],
                'desktop_default' => 5,
                'tablet_default'  => 3,
                'mobile_default'  => 1,
                'description'   => 'Columns 7,8  only applies when "Enable Carousel"'
			]
		);

        $this->add_responsive_control(
            'image_spacing',
            [
                'label'     => esc_html__( 'Space Between', 'freshio' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .instagram-widget .instagram-picture'         => 'padding: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}} .instagram-pics '         => 'margin: calc( -{{SIZE}}{{UNIT}}/2 );',
                ],
            ]
        );


        $this->add_control(
			'size',
			[
				'label'   => esc_html__( 'Photo size', 'freshio' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'thumbnail',
				'options' => [
					'thumbnail' => 'Thumbnail',
					'large'     => 'Large',
				],
			]
		);

		$this->add_control(
			'target',
			[
				'label'   => esc_html__( 'Open link in', 'freshio' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '_blank',
				'options' => [
					'_self'  => 'Current window (_self)',
					'_blank' => 'New window (_blank)',
				],
			]
		);

        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable Carousel', 'freshio'),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => esc_html__('Off', 'freshio'),
                'label_on' => esc_html__('On', 'freshio'),
            ]
        );

		$this->end_controls_section();

	}

	/**
	 * Render testimonial widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since  1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$class = 'instagram-widget ';
		echo '<div class="' . esc_attr( $class ) . '" >';
		if ( ! empty( $settings['username'] ) ) {
			$media_array = $this->osf_handler_json_instagram( $settings['username'], $settings['number'] );
			if ( is_wp_error( $media_array ) ) {
				echo esc_html( $media_array->get_error_message() );
			} else {

                $this->add_render_attribute('row', 'class', 'instagram-pics');

			    if (!$settings['enable_carousel']) {
                    $this->add_render_attribute('row', 'data-elementor-columns', $settings['per_row']);
                    if (!empty($settings['per_row_tablet'])) {
                        $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['per_row_tablet']);
                    }
                    if (!empty($settings['per_row_mobile'])) {
                        $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['per_row_mobile']);
                    }

                }
			    else{
                    $carousel_settings = array(
                        'items'              => $settings['per_row'],
                        'items_tablet'       => $settings['per_row_tablet'] ? $settings['per_row_tablet'] : $settings['per_row'],
                        'items_mobile'       => $settings['per_row_mobile'] ? $settings['per_row_mobile'] : 1,
                        'rtl'                => is_rtl() ? true : false,
                    );
                    $this->add_render_attribute( 'row', 'data-settings', wp_json_encode( $carousel_settings ) );
                    $this->add_render_attribute( 'row', 'class', 'instagram-carousel');

                }

                echo '<div ' . freshio_elementor_get_render_attribute_string('row', $this) . '>';

				foreach ( $media_array as $item ) {

					$image       = ( ! empty( $item[ $settings['size'] ] ) ) ? $item[ $settings['size'] ] : $item['thumbnail'];
					$result
					             = '<div class="instagram-picture column-item">
                        <div class="wrapp-picture">
                            <a href="' . esc_url( $item['link'] ) . '" target="' . esc_attr( $settings['target'] ) . '"></a>
                                <img src="' . esc_url( $image ) . '" alt="instagram-img" />';

					$result      .= '</div>';

					$result
						.= '</div>';

					echo wp_kses_post($result);

				}

				?>
                </div>
				<?php
			}
		}

		echo '</div>';
	}

    private function osf_scrape_instagram($username) {
        $username = strtolower($username);
        if (false === ($instagram = get_transient('freshio-instagram-' . sanitize_title_with_dashes($username)))) {
            $remote = wp_remote_get('https://instagram.com/' . trim($username) . '/?__a=1');

            if (is_wp_error($remote)) {
                return new WP_Error('site_down', esc_html__('Unable to communicate with Instagram.', 'freshio'));
            }

            if (200 != wp_remote_retrieve_response_code($remote)) {
                return new WP_Error('invalid_response', esc_html__('Instagram did not return a 200.', 'freshio'));
            }

            $instagram = $remote['body'];

//             do not set an empty transient - should help catch private or empty accounts
            if (!empty($instagram)) {
                set_transient('freshio-instagram-' . sanitize_title_with_dashes($username), $instagram, apply_filters('freshio_instagram_cache_time', HOUR_IN_SECONDS * 2));
            }
        }
        if (!empty($instagram)) {
            return $instagram;
        } else {
            return new WP_Error('no_images', esc_html__('Instagram did not return any images.', 'freshio'));
        }
    }

    public function osf_handler_json_instagram($username, $slice = 9) {
        $remote = wp_remote_get('https://instagram.com/' . trim($username) . '/');
        $instagram_string = $this->osf_scrape_instagram($username);
        $instagram        = array();
        if (is_wp_error($instagram_string)) {
            return $instagram_string;
        } else {
            $json = json_decode($instagram_string, true);

            if (isset($json['graphql']['user']['edge_owner_to_timeline_media']['edges'])) {
                $images = $json['graphql']['user']['edge_owner_to_timeline_media']['edges'];
                if (!is_array($images)) {
                    return new WP_Error('bad_array', esc_html__('Instagram has returned invalid data.', 'freshio'));
                }
                foreach ($images as $i) {
                    $image = $i['node'];
                    if ($image['is_video'] == true) {
                        $type = 'video';
                    } else {
                        $type = 'image';
                    }
                    $instagram[] = array(
                        'link'        => '//instagram.com/p/' . $image['shortcode'],
                        'description' => isset($image['edge_media_to_caption']['edges'][0]['node']['text']) ? $image['edge_media_to_caption']['edges'][0]['node']['text'] : '',
                        'time'        => $image['taken_at_timestamp'],
                        'comments'    => $image['edge_media_to_comment']['count'],
                        'likes'       => $image['edge_media_preview_like']['count'],
                        'thumbnail'   => $image['thumbnail_src'],
                        'large'       => $image['display_url'],
                        'type'        => $type
                    );
                }
            }
        }

        return array_slice($instagram, 0, $slice);
    }


	private function osf_pretty_number( $x = 0 ) {
		$x = (int) $x;

		if ( $x > 1000000 ) {
			return floor( $x / 1000000 ) . 'M';
		}

		if ( $x > 10000 ) {
			return floor( $x / 1000 ) . 'k';
		}

		return $x;
	}

	private function osf_fnc_excerpt( $excerpt, $limit, $afterlimit = '[...]' ) {
		$limit = empty( $limit ) ? 20 : $limit;
		if ( $excerpt != '' ) {
			$excerpt = @explode( ' ', strip_tags( $excerpt ), $limit );
		} else {
			$excerpt = @explode( ' ', strip_tags( get_the_content() ), $limit );
		}
		if ( count( $excerpt ) >= $limit ) {
			@array_pop( $excerpt );
			$excerpt = @implode( " ", $excerpt ) . ' ' . $afterlimit;
		} else {
			$excerpt = @implode( " ", $excerpt );
		}
		$excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );

		return strip_shortcodes( $excerpt );
	}

	private function osf_fnc_time( $time ) {
		$date = ( current_time( 'timestamp' ) - $time ) / ( 3600 * 24 );

		if ( $date > 7 ) {
			return date_i18n( get_option( 'date_format' ), $time );
		} else {
			return human_time_diff( $time, current_time( 'timestamp' ) ) . esc_html__( ' ago', 'freshio' );
		}
	}
}
$widgets_manager->register_widget_type(new Freshio_Elementor_Instagram());
