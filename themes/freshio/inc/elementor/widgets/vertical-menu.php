<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Freshio_Elementor_Vertical_Menu extends Elementor\Widget_Base
{

    public function get_name()
    {
        return 'freshio-vertical-menu';
    }

    public function get_title()
    {
        return __('Vertical Menu', 'freshio');
    }

    public function get_icon()
    {
        return 'eicon-nav-menu';
    }

    public function get_categories()
    {
        return array('freshio-addons');
    }

    protected function _register_controls(){
        $this->start_controls_section(
            'menu_content',
            [
                'label' => __('Menu','freshio'),
            ]
        );

        $this->add_control(
            'type_menu',
            [
                'label'     => __('Type', 'freshio'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'default',
                'options'   => [
                    'default'    => __('Default', 'freshio'),
                    'hover'     => __('Hover', 'freshio'),
                ],
                'prefix_class'  => 'menu-vertical-type-'
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        freshio_vertical_navigation();
    }

}

$widgets_manager->register_widget_type(new Freshio_Elementor_Vertical_Menu());
