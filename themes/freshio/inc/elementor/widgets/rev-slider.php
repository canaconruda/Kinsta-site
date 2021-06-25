<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! freshio_is_revslider_activated() ) {
	return;
}

use Elementor\Controls_Manager;

class Freshio_Elementor_RevSlider extends Elementor\Widget_Base {

	public function get_name() {
		return 'freshio-revslider';
	}

	public function get_title() {
		return esc_html__( 'Freshio Revolution Slider', 'freshio' );
	}

	public function get_categories() {
		return array( 'freshio-addons' );
	}

	public function get_icon() {
		return 'freshio-icon-sync';
	}


	protected function _register_controls() {
		$this->start_controls_section(
			'rev_slider',
			[
				'label' => esc_html__( 'General', 'freshio' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$slider     = new RevSlider();
		$arrSliders = $slider->getArrSliders();

		$revsliders = array();
		if ( $arrSliders ) {
			foreach ( $arrSliders as $slider ) {
				/** @var $slider RevSlider */
				$revsliders[ $slider->getAlias() ] = $slider->getTitle();
			}
		} else {
			$revsliders[0] = esc_html__( 'No sliders found', 'freshio' );
		}

		$this->add_control(
			'rev_alias',
			[
				'label'   => esc_html__( 'Revolution Slider', 'freshio' ),
				'type'    => Controls_Manager::SELECT,
				'options' => $revsliders,
				'default' => ''
			]
		);
		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( ! $settings['rev_alias'] ) {
			return;
		}
		echo apply_filters( 'opal_revslider_shortcode', do_shortcode( '[rev_slider ' . $settings['rev_alias'] . ']' ) );
	}
}

$widgets_manager->register_widget_type( new Freshio_Elementor_RevSlider() );
