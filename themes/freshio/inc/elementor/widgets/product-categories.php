<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!freshio_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

/**
 * Elementor Freshio_Elementor_Products_Categories
 * @since 1.0.0
 */
class Freshio_Elementor_Products_Categories extends Elementor\Widget_Base {

    public function get_categories() {
        return array('freshio-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'freshio-product-categories';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return __('Product Categories', 'freshio');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => __('Settings', 'freshio'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'categories_name',
            [
                'label' => __('Alternate Name', 'freshio'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'       => __('Categories', 'freshio'),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $this->get_product_categories(),
                'multiple'    => false,
            ]
        );

        $this->add_control(
            'category_image',
            [
                'label'      => __('Choose Image', 'freshio'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]

        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `brand_image_size` and `brand_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'category_style',
            [
                'label'        => esc_html__('Style', 'freshio'),
                'type'         => Controls_Manager::SELECT,
                'default'      => '1',
                'options'      => [
                    '1' => esc_html__('Style 1', 'freshio'),
                    '2' => esc_html__("Style 2", 'freshio'),
                ],
                'prefix_class' => 'category-style-',
            ]
        );

        $this->add_responsive_control(
            'box_min_height',
            [
                'label'     => esc_html__('Height', 'freshio'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min'  => 0,
                        'step' => 1,
                        'max'  => 1000
                    ]
                ],
                'condition' => [
                    'category_style' => '1'
                ],
                'selectors' => [
                    '{{WRAPPER}} .cat-image' => 'min-height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_style',
            [
                'label' => __('Box', 'freshio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'alignment',
            [
                'label'        => __('Alignment', 'freshio'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'   => [
                        'title' => __('Left', 'freshio'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'freshio'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'freshio'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'prefix_class' => 'box-align-'
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => __('Padding', 'freshio'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .product-cat-caption' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'title_style',
            [
                'label' => __('Title', 'freshio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tilte_typography',
                'selector' => '{{WRAPPER}} .cat-title',
            ]
        );

        $this->start_controls_tabs('tab_title');
        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __('Normal', 'freshio'),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background',
            [
                'label'     => __('Background', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-title ' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __('Hover', 'freshio'),
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Hover Color', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-title a:hover ' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'title_background_hover',
            [
                'label'     => __('Background Hover', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .product-cat:hover .cat-title ' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'total_style',
            [
                'label' => __('Total', 'freshio'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'total_typography',
                'selector' => '{{WRAPPER}} .cat-total',
            ]
        );

        $this->start_controls_tabs('tab_total');
        $this->start_controls_tab(
            'tab_total_normal',
            [
                'label' => __('Normal', 'freshio'),
            ]
        );
        $this->add_control(
            'total_color',
            [
                'label'     => __('Color', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-total' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'total_background',
            [
                'label'     => __('Background', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .cat-total ' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_total_hover',
            [
                'label' => __('Hover', 'freshio'),
            ]
        );
        $this->add_control(
            'total_color_hover',
            [
                'label'     => __('Color Hover', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .product-cat:hover .cat-total' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'total_background_hover',
            [
                'label'     => __('Background Hover', 'freshio'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .product-cat:hover .cat-total ' => 'background: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if (empty($settings['categories'])) {
            echo esc_html__('Choose Category', 'freshio');
            return;
        }

        $category = get_term_by('slug', $settings['categories'], 'product_cat');
        if (!is_wp_error($category)) {

            if (!empty($settings['category_image']['id'])) {
                $image = Group_Control_Image_Size::get_attachment_image_src($settings['category_image']['id'], 'image', $settings);
            } else {
                $thumbnail_id = get_woocommerce_term_meta($category->term_id, 'thumbnail_id', true);
                if (!empty($thumbnail_id)) {
                    $image = wp_get_attachment_url($thumbnail_id);
                } else {
                    $image = wc_placeholder_img_src();
                }
            }
            ?>

            <div class="product-cat">
                <div class="cat-image">
                    <a class="link_category_product" href="<?php echo esc_url(get_term_link($category)); ?>" title="<?php echo esc_attr($category->name); ?>">
                        <img src="<?php echo esc_url_raw($image); ?>" alt="<?php echo esc_html($category->name); ?>">
                    </a>

                    <div class="product-cat-caption">
                        <?php if ($settings['category_style'] == '2'): ?>
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 190 190" style="enable-background:new 0 0 190 190;" xml:space="preserve"><g>
                                    <g>
                                        <path d="M189.7,87.6c-0.3-4.1-0.9-8.1-1.7-12.1c-2.4-11.5-6.8-22.2-13.1-32c-0.4-0.7-0.9-1.4-1.4-2c-0.4-0.6-0.9-1.3-1.3-1.9 c-0.5-0.7-1-1.3-1.5-2c-0.5-0.6-0.9-1.2-1.4-1.8c-0.5-0.6-1-1.3-1.6-1.9c-0.5-0.6-0.9-1.3-1.5-1.7c-0.7-0.5-1.1-1.2-1.6-1.8 c-0.2-0.2-0.4-0.3-0.5-0.4c-0.4,0.2-0.8,0.3-1.2,0.5c-0.6,0.3-1,0.1-1.4-0.3c-0.3-0.3-0.5-0.7-0.5-1.1c0-1-0.3-1.8-1.2-2.4 c-0.3-0.2-0.3-0.4-0.2-0.8c0-0.1,0.1-0.3,0.1-0.4c-0.3-0.3-0.4-0.6-0.8-0.6c-0.2,0.2-0.3,0.4-0.4,0.6c-0.1-0.1-0.2-0.1-0.3-0.1 c-0.6-0.8-1.2-1.6-2-2.3c-0.1-0.1-0.1-0.1-0.1-0.2c0-0.8-0.7-1.1-1.1-1.5c-3.7-3-7.6-5.7-11.7-8.1c-1.1-0.6-2.2-1.2-3.3-1.9 c-0.4-0.2-0.7-0.3-1.2-0.2c-0.4,0.1-0.8,0.1-1.2,0.2c-0.4,0.1-0.8,0.3-1.2,0.4c-0.3-0.8,0.1-1.6-0.2-2.4c-4-1.9-8.1-3.6-12.5-5 c-0.4,0.8-1,0.9-1.8,0.6c0-0.2-0.1-0.4-0.1-0.6c-0.1-0.2-0.1-0.5-0.2-0.7c-2.1-0.7-3.3-1-4.2-1c-0.2,0.3-0.3,0.7-0.5,1.1 c-0.6,1.3-1.5,2.2-2.8,2.8c-0.6,0.3-0.7,0.2-1.3-0.3c0.5-0.8,0.9-1.6,2-1.7c0.1,0,0.2-0.1,0.2-0.1c0.4-0.3,0.4-0.8,0-1.1
			c-0.3-0.2-0.5-0.2-0.8-0.1c-0.7,0.4-1.4,0.7-2.2,1.1c-0.2,0.1-0.5,0.2-0.8,0.3c-0.7-0.8-0.4-1.6,0.1-2.3c-0.2-0.2-0.3-0.4-0.4-0.6 c-1.1,0.4-1.6,1.1-1.5,2.2c0,0.3,0,0.6,0,1c-0.4,0.3-0.7,0.6-1,0.9c-0.1,0.1-0.3,0.3-0.2,0.4c2.4,0.5,4.8,1,7.2,1.5
			c0.2,0,0.5,0.2,0.7,0.1c0.7-0.4,1.3-0.1,1.8,0.3c0.5,0.4,1.1,0.6,1.7,0.7c0.7,0.2,1.3,0.4,2,0.6c28.9,9.1,52,32.3,59.9,62.7 c1.5,5.6,2.4,11.3,2.8,17.1c0.3,4.2,0.2,8.5-0.1,12.7c-0.2,2.9-0.6,5.8-1.1,8.6c-1.6,8.6-4.3,16.8-8.3,24.6
			c-1.2,2.3-2.5,4.6-3.8,6.8c-0.1,0.2-0.2,0.4-0.3,0.5c0,0.2,0.1,0.4,0.2,0.7c-0.4,0.3-0.9,0.6-1.3,0.9c-0.4,0.4-0.6,0.9-0.9,1.3 c0,0.1,0,0.2,0,0.2c0.6,1.3,0,1.7-1,2c-0.1,0-0.2,0-0.2,0.1c-0.4,0.1-0.7,0.3-1,0.7c-0.2,0.3-0.4,0.5-0.6,0.8
			c-9.4,12.2-21.1,21.5-35.3,27.7c-6.2,2.7-12.7,4.7-19.3,5.9c-2.6,0.5-5.2,0.9-7.9,1.1c-1.3,0.1-2.7,0.2-4,0.3c-3,0.2-6,0.2-9,0 c-1.3-0.1-2.6-0.2-3.9-0.2c-0.1,0.2-0.2,0.4-0.3,0.7c-0.1,0.3-0.2,0.5-0.3,0.8c-0.1,0.3-0.4,0.5-0.7,0.3c-0.5-0.2-1-0.4-1.6-0.7
			c0.1-0.5,0.5-1,0-1.4c-0.4-0.1-0.9-0.2-1.4-0.2c-1.6-0.3-3.3-0.5-4.9-0.8c-5.5-1.1-10.9-2.8-16.1-4.9c-0.4-0.2-0.7-0.4-1.2-0.3 c-0.1,0-0.2-0.1-0.3-0.1c-0.3-0.5-0.8-0.5-1.2-0.7c-4.1-1.8-8-4-11.8-6.4c0,0,0,0,0,0c-0.3-0.2-0.6-0.5-1-0.6
			c-0.4-0.1-0.9-0.1-1.3-0.2c-0.1-0.7-0.1-0.7-0.6-1.1c-0.2-0.1-0.3-0.2-0.5-0.3c-11.8-8.4-21.1-19-27.8-31.8 c-3.6-6.9-6.2-14.2-7.9-21.8c-0.1-0.4-0.1-0.7-0.4-1c-0.2,0-0.4-0.1-0.6-0.1c-0.2,0-0.5,0-0.6,0c-0.5,0.7-1,1.4-1.5,2
			c-0.6,0.6-1.3,1-1.9,1.5c0.4,2,1,3.9,1.6,5.9c0.1,0.2,0.3,0.3,0.5,0.5c-0.1,0.8-0.1,0.8,0.1,1.7c2.3,6.9,5.3,13.4,9.1,19.6 c0.1,0.2,0.3,0.5,0.5,0.7c0.3-0.2,0.5-0.4,0.7-0.5c0.5-0.2,0.9,0,0.9,0.6c0.1,0.7,0,1.5-0.3,2.2c0.5,0.7,1,1.5,1.4,2.2
			c8.8,12.5,20,22.3,33.5,29.4c8.1,4.3,16.6,7.3,25.6,9.1c2.9,0.6,5.8,1,8.7,1.4c1.3,0.2,2.5,0.2,3.8,0.3c0.3,0,0.6,0,0.8-0.2 c0.6-0.5,1.3-0.6,2-0.9c0.2-0.1,0.4-0.1,0.6,0.1c0,0.3-0.1,0.7-0.2,1.1c1.1,0.2,2.2,0.1,3.2,0.1c1.1,0,2.1,0,3.2,0
			c1.1,0,2.1-0.2,3.1-0.2c0.8-1.3,1.3-2.8,2.2-4c0.6,0.4,0.9,0.7,1,1.1c0.1,0.3,0.2,0.7,0.2,1.1c0.1,0.6-0.4,1.1-0.7,1.6 c0.4,0,0.8,0,1.1,0c1.5-0.2,3.1-0.4,4.6-0.6c0.3,0,0.6,0,0.8-0.1c0.3-0.1,0.5-0.4,0.7-0.6c0.3,0.4,0.6,0.5,1,0.3
			c0.5-0.1,1-0.2,1.6-0.3c6.8-1.4,13.4-3.5,19.7-6.3c17.2-7.7,30.9-19.6,41.2-35.4c2.4-3.7,4.5-7.6,6.3-11.6 c0.2-0.4,0.3-0.8,0.2-1.3c-0.1-0.6,0.1-1.3,0.7-1.7c0.5-0.3,0.7-0.8,0.9-1.2c3.9-9.6,6.1-19.5,6.8-29.8
			C190.1,96.4,190,92,189.7,87.6z M122.3,7.7c-0.4,0-0.8,0-1.2-0.1c-0.5-0.1-0.6-0.7-0.4-1.1c0.1-0.1,0.1-0.2,0.2-0.3 c0.1-0.1,0.3-0.2,0.4-0.2c0.7,0.4,1.2,1,1.7,1.5C122.8,7.8,122.5,7.7,122.3,7.7z M124.9,5.9c-0.1,0.1-0.3,0.2-0.4,0.2
			c-0.4,0-0.7-0.2-0.7-0.7c0.4,0,0.8-0.1,1.1-0.1C125.2,5.6,125.1,5.7,124.9,5.9z M4,120.1c-0.2,0-0.4-0.1-0.4-0.3 c0-0.3,0.1-0.5,0.5-0.5c0.1,0.1,0.3,0.2,0.3,0.3C4.5,119.9,4.3,120.1,4,120.1z M4.7,117.2c-0.2,0-0.4-0.1-0.4-0.3
			c0-0.1,0.1-0.3,0.1-0.3c0.3,0,0.6,0.2,0.6,0.4C5,117,4.8,117.2,4.7,117.2z M8.2,131.5c-0.1-0.6,0.2-1,0.5-1.3 c0.1-0.1,0.3-0.2,0.4-0.2c0.6,0.1,1.1,0.3,1.5,0.8C9.8,131.1,9,131.4,8.2,131.5z M20.6,152.5c0-0.1-0.2-0.2-0.1-0.3
			c0.2-0.4,0.5-0.5,0.9-0.6c0.1,0,0.2,0.2,0.2,0.2C21.4,152.2,21,152.5,20.6,152.5z M46.2,171.6c-0.1,0.1-0.2,0.1-0.3,0.1 c-0.1,0-0.2-0.1-0.2-0.2c-0.1-0.4,0.2-0.7,0.4-1c0.2-0.2,0.4-0.3,0.7-0.2C46.8,170.8,46.5,171.2,46.2,171.6z M48.5,173.8
			c-0.3-0.2-0.4-0.5-0.6-1.6c1-0.1,1.3,0.2,1.8,1.6C49.3,174,48.9,174,48.5,173.8z M69.7,184.4c-0.3,0.3-0.7,0.6-1.5,0.9 c0-0.2-0.1-0.4,0-0.6c0.1-0.5,0.1-0.9,0-1.4c-0.2-0.7-0.1-0.9,0.6-1.7c0.6,0.4,0.9,0.9,1.2,1.4C70.2,183.6,70.1,184,69.7,184.4z
			 M89.7,187.6c-0.1,0.3-0.2,0.4-0.5,0.4c-0.3,0-0.5-0.1-0.6-0.3c-0.4-0.6-0.2-1.2,0.5-2C89.8,186.3,89.9,186.9,89.7,187.6z M135,179.8c-0.2,0.2-0.5,0.2-0.7,0c-0.2-0.3-0.4-0.9-0.5-2c0.3,0,0.4,0,0.6,0.1C135.6,178.2,135.8,178.8,135,179.8z M178.5,132.7
			c0.6-0.5,0.7-0.5,1,0c0.1,0.1,0.2,0.3,0.2,0.4c0,0.1,0,0.2,0.1,0.3c-0.1,0.1-0.3,0.3-0.5,0.4C178.8,133.6,178.6,133.2,178.5,132.7 z M179.7,135.3c-0.1,0-0.3-0.1-0.3-0.2c-0.1-0.2,0.2-0.4,0.7-0.4c0,0.1,0.2,0.2,0.2,0.3C180.2,135.2,180,135.3,179.7,135.3z
			 M181.6,128.9c0,0.5,0.1,1-0.3,1.4c-0.1,0-0.2,0-0.3-0.1c-1.3-1-1.2-1.8,0.5-2.7C181.8,128,181.6,128.5,181.6,128.9z M182.5,123.5 c-0.5,0.1-0.8,0.1-1.1-0.3c0.3-0.8,1.2-2.1,2.1-2.7C183.8,121.9,183,122.7,182.5,123.5z M183.9,120.2c-0.1-0.1-0.2-0.2-0.2-0.2
			c0.1-0.1,0.2-0.3,0.4-0.4c0,0,0.2,0.1,0.2,0.2C184.2,119.9,184.1,120,183.9,120.2z M3.9,111.2c-0.1-0.1-0.3-0.2-0.4-0.2 c-0.2-0.1-0.4-0.1-0.6-0.2c-0.5-0.2-0.7-0.5-0.8-1c-0.2-1-0.5-2-0.7-3c-0.1-0.2-0.1-0.5-0.1-0.8c0.3,0,0.4,0,0.4,0.1
			c0.3,0.2,0.5,0.4,0.8,0.6c0.5,0.5,1,1,1.6,1.6c0.8,0.8,1.7,1.3,2.7,1.7c0.2-1,0.2-1-0.3-2c-0.1,0-0.3,0-0.5,0 c-1,0.3-1.7-0.1-2.2-0.9c-0.9-1.3-1-2.6-0.4-4c0.8-0.6,1.7-0.4,2.6-0.7c0-0.7-0.1-1.3-0.1-2c-0.2-0.1-0.4-0.3-0.6-0.4
			c-0.3-0.3-0.4-0.5-0.2-0.9C4.9,99,5,98.8,5.1,98.7c0.4-0.4,0.5-0.9,0.5-1.4c0-2.2,0.1-4.5,0.1-6.7c0.1-4,0.7-7.9,1.4-11.8 c0.1-0.6,0.2-1.1-0.1-1.7c-0.2-0.5-0.1-1,0.3-1.3C7.7,75.5,7.8,75,8,74.5c0.4-1.5,0.7-2.9,1.2-4.4C17.2,42.3,38.7,18.9,68,9.7
			c0.4-0.1,0.8-0.3,1-0.4c0.3-0.3-0.1-0.7,0.3-0.9c0.3,0,0.6,0,0.9,0.1c0.6,0.2,1.1,0.1,1.7,0c1.2-0.3,2.4-0.6,3.6-0.9 c3.3-0.8,6.7-1.3,10.1-1.7c1.2-0.1,2.3-0.2,3.5-0.3c3.8-0.3,7.7-0.2,11.5,0c1.5,0.1,2.9,0.3,4.4,0.4c0.5,0,0.9,0.1,1.5,0.1
			c0.1-0.7,0.2-1.3,0.2-1.9c0-0.1,0-0.2,0-0.4c0-1.2-0.5-1.8-1.6-2c-0.3-0.1-0.7-0.2-1.1-0.3c0.2-0.4,0.4-0.7,0.6-1.1 c-4.2-0.8-15.6-1-25.5,0.7c-12.4,2.2-24,6.5-34.7,13.2c-11,6.9-20.1,15.7-27.5,26.4C9.4,51.9,4.3,63.9,1.7,76.9
			C0.3,84-0.3,94.1,0.2,97.5c0.2,0,0.4,0,0.6,0.1c0.4,0.1,0.6,0.5,0.4,0.8c-0.3,0.4-0.6,0.7-0.9,1c0,0.4,0,0.8,0,1.2 c0.2,4.2,0.8,8.3,1.5,12.4c0,0.1,0.1,0.2,0.3,0.3c0.4-0.7,1.1-0.8,1.8-1.1C4.2,112,4.2,111.5,3.9,111.2z M75.3,2.9
			c0.6,0.2,0.9,0.6,0.9,1.4c-0.1,0.1-0.2,0.3-0.3,0.3c-0.7,0.1-1.3-0.5-1.3-1.1C74.6,3.1,74.9,2.8,75.3,2.9z M65.8,6.2 c-0.1,0.2-0.1,0.4-0.1,0.5c-0.2,0.2-0.4,0.4-0.7,0.4c-0.2,0.1-0.4,0-0.6-0.1c-0.3-0.2-0.5-0.4-0.5-0.8C64.5,6.1,65.1,6.1,65.8,6.2
			z M12.6,53.7c0.2-0.2,0.4-0.2,0.5,0c0.2,0.2,0.4,0.4,0.6,0.6c-0.2,0.4-0.4,0.5-0.7,0.3c-0.2-0.1-0.3-0.2-0.4-0.4 C12.5,54.1,12.5,53.9,12.6,53.7z M2.2,101.9c0.2-0.3,0.5-0.3,0.7-0.2c0.1,0,0.1,0.2,0.3,0.3c-0.1,0.2-0.2,0.4-0.3,0.4
			c-0.2,0.1-0.5,0.1-0.6-0.1C2.1,102.3,2.1,102,2.2,101.9z M112.8,2.6c0.1-0.4,0.2-0.7-0.2-0.8c-0.3-0.1-0.4,0.3-0.5,0.5 c0,0,0,0.1,0,0.2C112.3,2.5,112.5,2.5,112.8,2.6z"/>
                                    </g>
                                </g></svg>
                        <?php endif; ?>
                        <div class="cat-title">
                            <a href="<?php echo esc_url(get_term_link($category)); ?>" title="<?php echo esc_attr($category->name); ?>">
                                <span class="cats-title-text"><?php echo empty($settings['categories_name']) ? esc_html($category->name) : wp_kses_post($settings['categories_name']); ?></span>
                            </a>
                            <div class="cat-total"><?php echo esc_html($category->count) . ' ' . esc_html__('products', 'freshio'); ?></div>
                        </div>

                    </div>
                </div>
            </div>
            <?php

        }

    }
}

$widgets_manager->register_widget_type(new Freshio_Elementor_Products_Categories());

