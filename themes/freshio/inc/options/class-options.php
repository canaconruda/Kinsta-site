<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Freshio_Options')) :
    /**
     * The Freshio Options class
     */
    class Freshio_Options {


        public $opt_name = "freshio_options";

        public function __construct() {
            if (freshio_is_redux_activated()) {
                $this->setup_redux();
                Redux::init($this->opt_name);
            }

            if (freshio_is_cmb2_activated()) {
                $this->setup_metabox();
            }

            add_action('wp_enqueue_scripts', [$this, 'add_inline_css'], 9999);
        }

        private function setup_metabox() {
            add_action('cmb2_admin_init', [$this, 'metabox_page']);
        }

        public function metabox_page() {
            $cmb2 = new_cmb2_box(array(
                'id'           => 'freshio_page_settings',
                'title'        => esc_html__('Page Settings', 'freshio'),
                'object_types' => array('page',), // Post type
                'context'      => 'normal',
                'priority'     => 'high',
                'show_names'   => true, // Show field names on the left
                // 'cmb_styles' => false, // false to disable the CMB stylesheet
                // 'closed'     => true, // Keep the metabox closed by default
            ));

            //Breadcrumb
            $cmb2->add_field(array(
                'name'    => esc_html__('Breadcrumb Background Color', 'freshio'),
                'id'      => 'freshio_breadcrumb_bg_color',
                'type'    => 'colorpicker',
                'default' => '',
            ));

            $cmb2->add_field(array(
                'name'         => esc_html__('Breadcrumb Background', 'freshio'),
                'desc'         => 'Upload an image or enter an URL.',
                'id'           => 'freshio_breadcrumb_bg_image',
                'type'         => 'file',
                'options'      => array(
                    'url' => false, // Hide the text input for the url
                ),
                'text'         => array(
                    'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
                ),
                'preview_size' => 'large', // Image size to use when previewing in the admin.
            ));
        }

        public function add_inline_css() {
            $handle = 'freshio-style';
            if (freshio_is_woocommerce_activated()) {
                $handle = 'freshio-woocommerce';
            }

            if (freshio_get_theme_option('site_mode', 'light') === 'dark') {
                $handle .= '-dark';
            }

            wp_add_inline_style($handle . '-style', $this->render_css());
        }

        private function render_css() {
            $cssCode    = '';
            $allPrimary = freshio_get_theme_option('color-primary', false);
            if ($allPrimary) {
                $primary       = $allPrimary['regular'];
                $primary_hover = $allPrimary['hover'];
            }

            $body    = freshio_get_theme_option('color-body', false);
            $heading = freshio_get_theme_option('color-heading', false);
            $border  = freshio_get_theme_option('color-border', false);
            $light   = freshio_get_theme_option('color-light', false);
            $dark    = freshio_get_theme_option('color-dark', false);

            // Auto render
            $cssCode = require get_theme_file_path('/inc/options/colors.php');

            if (freshio_is_woocommerce_activated()) {
                $cssCode = require get_theme_file_path('/inc/options/colors-woo.php');
            }

            if (freshio_is_elementor_activated()) {
                $cssCode = require get_theme_file_path('/inc/options/colors-elementor.php');
            }

            if (freshio_is_cmb2_activated() && is_page()) {
                $cssCode = require get_theme_file_path('/inc/options/css/page.php');
            }
            if (freshio_get_theme_option('site_layout', 'wide') == 'boxed') {
                $cssCode = require get_theme_file_path('/inc/options/css/layout.php');
            }


            return $cssCode;
        }

        private function setup_redux() {
            $theme = wp_get_theme(); // For use with some settings. Not necessary.
            $args  = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'             => $this->opt_name,
                // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'         => $theme->get('Name'),
                // Name that appears at the top of your panel
                'display_version'      => $theme->get('Version'),
                // Version that appears at the top of your panel
                'menu_type'            => 'menu',
                //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'       => true,
                // Show the sections below the admin menu item or not
                'menu_title'           => esc_html__('Freshio Options', 'freshio'),
                'page_title'           => esc_html__('Freshio Options', 'freshio'),
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key'       => apply_filters('freshio_google_api_key', ''),
                // Set it you want google fonts to update weekly. A google_api_key value is required.
                'google_update_weekly' => false,
                // Must be defined to add google fonts to the typography module
                'async_typography'     => false,
                // Use a asynchronous font on the front end or font string
                //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                'admin_bar'            => true,
                // Show the panel pages on the admin bar
                'admin_bar_icon'       => 'dashicons-portfolio',
                // Choose an icon for the admin bar menu
                'admin_bar_priority'   => 50,
                // Choose an priority for the admin bar menu
                'global_variable'      => '',
                // Set a different name for your global variable other than the opt_name
                'dev_mode'             => false,
                // Show the time the page took to load, etc
                'update_notice'        => true,
                // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                'customizer'           => false,
                // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'        => null,
                // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'          => 'themes.php',
                // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'     => 'manage_options',
                // Permissions needed to access the options panel.
                'menu_icon'            => '',
                // Specify a custom URL to an icon
                'last_tab'             => '',
                // Force your panel to always open to a specific tab (by id)
                'page_icon'            => 'icon-themes',
                // Icon displayed in the admin panel next to your menu_title
                'page_slug'            => 'freshio-options',
                // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
                'save_defaults'        => true,
                // On load save the defaults to DB before user clicks save or not
                'default_show'         => false,
                // If true, shows the default value next to each field that is not the default value.
                'default_mark'         => '',
                // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export'   => true,
                // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'       => 60 * MINUTE_IN_SECONDS,
                'output'               => true,
                // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'           => true,
                // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'             => '',
                // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'use_cdn'              => true,
                // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

                // HINTS
                'hints'                => array(
                    'icon'          => 'el el-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'   => 'red',
                        'shadow'  => true,
                        'rounded' => false,
                        'style'   => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'mouseover',
                        ),
                        'hide' => array(
                            'effect'   => 'slide',
                            'duration' => '500',
                            'event'    => 'click mouseleave',
                        ),
                    ),
                )
            );
            Redux::setArgs($this->opt_name, apply_filters('freshio_redux_args_options', $args));


            // Section Basic
            add_filter('redux/options/' . $this->opt_name . '/sections', [$this, 'section_site_indentity']);
            add_filter('redux/options/' . $this->opt_name . '/sections', [$this, 'section_site_header']);
            add_filter('redux/options/' . $this->opt_name . '/sections', [$this, 'section_breadcrumb']);
            add_filter('redux/options/' . $this->opt_name . '/sections', [$this, 'section_blog']);
            add_filter('redux/options/' . $this->opt_name . '/sections', [$this, 'section_social']);
            add_filter('redux/options/' . $this->opt_name . '/sections', [$this, 'section_site_footer']);

            if (freshio_is_woocommerce_activated()) {
                add_filter('redux/options/' . $this->opt_name . '/sections', [$this, 'get_wocommerce_section']);
            }

        }

        public function section_site_indentity($sections) {
            $sections[] = array(
                'title'  => esc_html__('Home', 'freshio'),
                'id'     => 'home',
                'icon'   => 'el el-home',
                'fields' => array(
                    array(
                        'id'      => 'site_mode',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Theme Style', 'freshio'),
                        'options' => array(
                            'light' => esc_html__('Light', 'freshio'),
                            'dark'  => esc_html__('Dark', 'freshio'),
                        ),
                        'default' => 'light'
                    ),
                    array(
                        'id'      => 'site_layout',
                        'type'    => 'button_set',
                        'title'   => esc_html__('Layout', 'freshio'),
                        'options' => array(
                            'wide'  => esc_html__('Wide', 'freshio'),
                            'boxed' => esc_html__('Boxed', 'freshio'),
                        ),
                        'default' => 'wide'
                    ),
                    array(
                        'id'            => 'boxed-container',
                        'type'          => 'slider',
                        'title'         => esc_html__('Boxed Container Width', 'freshio'),
                        "default"       => 1450,
                        "min"           => 1024,
                        "step"          => 1,
                        "max"           => 1920,
                        'display_value' => 'text',
                        'required'      => array('site_layout', 'equals', 'boxed'),
                    ),
                    array(
                        'id'            => 'offset-top',
                        'type'          => 'slider',
                        'title'         => esc_html__('Offset Top', 'freshio'),
                        "default"       => 30,
                        "min"           => 0,
                        "step"          => 1,
                        "max"           => 200,
                        'display_value' => 'text',
                        'required'      => array('site_layout', 'equals', 'boxed'),
                    ),
                    array(
                        'id'            => 'offset-bottom',
                        'type'          => 'slider',
                        'title'         => esc_html__('Offset Bottom', 'freshio'),
                        "default"       => 30,
                        "min"           => 0,
                        "step"          => 1,
                        "max"           => 200,
                        'display_value' => 'text',
                        'required'      => array('site_layout', 'equals', 'boxed'),
                    ),
                    array(
                        'id'            => 'border-radius-body',
                        'type'          => 'slider',
                        'title'         => esc_html__('Border Radius', 'freshio'),
                        "default"       => 5,
                        "min"           => 0,
                        "step"          => 1,
                        "max"           => 200,
                        'display_value' => 'text',
                        'required'      => array('site_layout', 'equals', 'boxed'),
                    ),
                    array(
                        'id'       => 'logo_light',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Logo Light', 'freshio'),
                        'required' => array('site_mode', 'equals', 'light'),
                    ),
                    array(
                        'id'       => 'logo_dark',
                        'type'     => 'media',
                        'url'      => true,
                        'title'    => esc_html__('Logo Dark', 'freshio'),
                        'required' => array('site_mode', 'equals', 'dark'),
                    ),
                    array(
                        'id'     => 'logo_size',
                        'type'   => 'dimensions',
                        'units'  => array('px'),
                        'title'  => esc_html__('Logo Size', 'freshio'),
                        'output' => array('.site-header .site-branding img')
                    ),
                    array(
                        'id'     => 'body-background',
                        'type'   => 'background',
                        'output' => ['body'],
                        'title'  => esc_html__('Body Background', 'freshio'),
                    ),
                )
            );

            $sections[] = array(
                'title'      => esc_html__('Colors', 'freshio'),
                'id'         => 'colors',
                'icon'       => 'el el-font',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'     => 'color-primary',
                        'type'   => 'link_color',
                        'title'  => esc_html__('Primary Color', 'freshio'),
                        'active' => false, // Disable Active Color
                    ),
                    array(
                        'id'       => 'color-body',
                        'type'     => 'color',
                        'title'    => esc_html__('Body Color', 'freshio'),
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'color-heading',
                        'type'     => 'color',
                        'title'    => esc_html__('Heading Color', 'freshio'),
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'color-border',
                        'type'     => 'color',
                        'title'    => esc_html__('Border Color', 'freshio'),
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'color-light',
                        'type'     => 'color',
                        'title'    => esc_html__('Light Color', 'freshio'),
                        'validate' => 'color',
                    ),
                    array(
                        'id'       => 'color-dark',
                        'type'     => 'color',
                        'title'    => esc_html__('Dark Color', 'freshio'),
                        'validate' => 'color',
                    ),
                )
            );

            $sections[] = array(
                'title'      => esc_html__('Typography', 'freshio'),
                'id'         => 'typography',
                'desc'       => esc_html__('For full documentation on this field, visit: ', 'freshio') . '<a href="//docs.reduxframework.com/core/fields/typography/" target="_blank">docs.reduxframework.com/core/fields/typography/</a>',
                'icon'       => 'el el-font',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'             => 'typography-body',
                        'type'           => 'typography',
                        'title'          => esc_html__('Body', 'freshio'),
                        'google'         => true,
                        'word-spacing'   => true,
                        'text-align'     => false,
                        'letter-spacing' => true,
                        'color'          => false,
                        'output'         => ['body, button, input, textarea']
                    ),
                    array(
                        'id'             => 'typography-heading',
                        'type'           => 'typography',
                        'title'          => esc_html__('Heading', 'freshio'),
                        'google'         => true,
                        'word-spacing'   => true,
                        'text-align'     => false,
                        'letter-spacing' => true,
                        'color'          => false,
                        'output'         => ['h1, h2, h3, h4, h5, h6, blockquote, .widget .widget-title']
                    ),
                    array(
                        'id'             => 'typography-tertiary',
                        'type'           => 'typography',
                        'title'          => esc_html__('Tertiary font', 'freshio'),
                        'google'         => true,
                        'word-spacing'   => true,
                        'text-align'     => false,
                        'letter-spacing' => true,
                        'color'          => false,
                        //						'output'         => [ 'h1, h2, h3, h4, h5, h6, blockquote, .widget .widget-title' ]
                    ),
                )
            );

            return $sections;
        }

        private function get_header_option() {
            $folderes = glob(get_template_directory() . '/template-parts/header/*');

            $folderes_child = glob(get_stylesheet_directory() . '/template-parts/header/*');

            $folderes = array_merge($folderes, $folderes_child);

            $output = array();

            foreach ($folderes as $folder) {
                $key          = str_replace("header-", '', str_replace('.php', '', wp_basename($folder)));
                $value        = str_replace('-', ' ', str_replace('.php', '', wp_basename($folder)));
                $output[$key] = $value;
            }

            return $output;
        }

        public function section_site_header($sections) {
            $sections[] = array(
                'title'  => esc_html__('Header', 'freshio'),
                'id'     => 'header',
                'icon'   => 'el el-credit-card',
                'fields' => array(
                    array(
                        'id'      => 'header-type',
                        'title'   => esc_html__('Header Style', 'freshio'),
                        'type'    => 'select',
                        'options' => $this->get_header_option(),
                        'default' => '1',
                    ),
                    array(
                        'id'      => 'show-header-search',
                        'type'    => 'switch',
                        'title'   => esc_html__('Show Header Search', 'freshio'),
                        'default' => true,
                        'on'      => esc_html__('Yes', 'freshio'),
                        'off'     => esc_html__('No', 'freshio'),
                    ),
                    array(
                        'id'      => 'show-header-cart',
                        'type'    => 'switch',
                        'title'   => esc_html__('Show Header Cart', 'freshio'),
                        'default' => true,
                        'on'      => esc_html__('Yes', 'freshio'),
                        'off'     => esc_html__('No', 'freshio'),
                    ),
                    array(
                        'id'       => 'header-cart-dropdown',
                        'title'    => esc_html__('Cart Content', 'freshio'),
                        'type'     => 'select',
                        'options'  => array(
                            'side'     => esc_html__('Cart Canvas', 'freshio'),
                            'dropdown' => esc_html__('Cart Dropdown', 'freshio'),
                        ),
                        'default'  => 'side',
                        'required' => array('show-header-cart', 'equals', true),
                    ),
                    array(
                        'id'      => 'show-header-account',
                        'type'    => 'switch',
                        'title'   => esc_html__('Show Header Account', 'freshio'),
                        'default' => true,
                        'on'      => esc_html__('Yes', 'freshio'),
                        'off'     => esc_html__('No', 'freshio'),
                    ),
                    array(
                        'id'      => 'show-header-wishlist',
                        'type'    => 'switch',
                        'title'   => esc_html__('Show Header Wishlist', 'freshio'),
                        'default' => true,
                        'on'      => esc_html__('Yes', 'freshio'),
                        'off'     => esc_html__('No', 'freshio'),
                    ),
                    array(
                        'id'      => 'welcome-message',
                        'type'    => 'textarea',
                        'title'   => esc_html__('Welcome Message', 'freshio'),
                        'default' => 'Welcome to our online store!'
                    ),
                    array(
                        'id'    => 'custom-link',
                        'type'  => 'textarea',
                        'title' => esc_html__('Custom Link', 'freshio'),
                    ),
                    array(
                        'id'    => 'contact-info',
                        'type'  => 'textarea',
                        'title' => esc_html__('Contact Info', 'freshio'),
                    ),
                ),
            );
            $sections[] = array(
                'title'      => esc_html__('Header Sticky', 'freshio'),
                'id'         => 'header-sticky',
                'subsection' => true,
                'fields'     => array(

                    array(
                        'id'      => 'show-header-sticky',
                        'type'    => 'switch',
                        'title'   => esc_html__('Show Header Sticky', 'freshio'),
                        'default' => true,
                        'on'      => esc_html__('Yes', 'freshio'),
                        'off'     => esc_html__('No', 'freshio'),
                    ),
                    array(
                        'id'       => 'color-header-sticky',
                        'type'     => 'color',
                        'validate' => 'color',
                        'title'    => esc_html__('Color Item', 'freshio'),
                        'required' => array('show-header-sticky', 'equals', true),
                        'output'   => [
                            'color' => '.menu-mobile-nav-button, .header-sticky .main-navigation ul > li.menu-item > a, .header-sticky .site-header-account > a i, .header-sticky .site-header-wishlist .header-wishlist i, .header-sticky .site-header-cart .cart-contents::before, .header-sticky .site-header-search > a i',
                        ]
                    ),
                    array(
                        'id'       => 'background-header-sticky',
                        'type'     => 'background',
                        'title'    => esc_html__('Background Header Sticky', 'freshio'),
                        'required' => array('show-header-sticky', 'equals', true),
                        'output'   => ['.header-sticky']
                    ),
                )

            );

            $sections[] = array(
                'title'      => esc_html__('Menu Canvas', 'freshio'),
                'id'         => 'menu-canvas',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'     => 'color-menu-canvas',
                        'type'   => 'color',
                        'title'  => esc_html__('Color', 'freshio'),
                        'output' => [
                            'color' => '.mobile-navigation ul li a, .mobile-navigation .dropdown-toggle, body .freshio-mobile-nav .freshio-social ul li a:before, .mobile-nav-close',
                        ],
                    ),
                    array(
                        'id'     => 'color-menu-canvas-active',
                        'type'   => 'color',
                        'title'  => esc_html__('Color Active', 'freshio'),
                        'output' => [
                            'color' => 'ul.menu li.current-menu-item > a',
                        ]
                    ),
                    array(
                        'id'     => 'color-menu-canvas-border',
                        'type'   => 'color',
                        'title'  => esc_html__('Color Border', 'freshio'),
                        'output' => [
                            'border-color'     => '.mobile-navigation ul li',
                            'border-top-color' => '.freshio-mobile-nav .freshio-social',
                        ]
                    ),
                    array(
                        'id'     => 'background-menu-canvas',
                        'type'   => 'color',
                        'title'  => esc_html__('Background', 'freshio'),
                        'output' => [
                            'background-color' => '.freshio-mobile-nav',
                        ]
                    ),
                )
            );


            return $sections;
        }

        public function get_wocommerce_section($sections) {

            $sections[] = array(
                'title'  => esc_html__('Wocommerce', 'freshio'),
                'id'     => 'wocommerce',
                'icon'   => 'el el-cog',
                'fields' => array(
                    array(
                        'id'      => 'woocommerce_product_hover',
                        'type'    => 'select',
                        'title'   => esc_html__('Animation Image Hover', 'freshio'),
                        // Must provide key => value pairs for select options
                        'options' => array(
                            'none'          => esc_html__('None', 'freshio'),
                            'default'       => esc_html__('Default', 'freshio'),
                            'bottom-to-top' => esc_html__('Bottom to Top', 'freshio'),
                            'top-to-bottom' => esc_html__('Top to Bottom', 'freshio'),
                            'right-to-left' => esc_html__('Right to Left', 'freshio'),
                            'left-to-right' => esc_html__('Left to Right', 'freshio'),
                            'swap'          => esc_html__('Swap', 'freshio'),
                            'fade'          => esc_html__('Fade', 'freshio'),
                            'zoom-in'       => esc_html__('Zoom In', 'freshio'),
                            'zoom-out'      => esc_html__('Zoom Out', 'freshio'),
                        ),
                        'default' => 'none',
                    )
                )
            );

            $sections[] = array(
                'title'      => esc_html__('Product Image', 'freshio'),
                'id'         => 'wocommerce-product-image',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'      => 'woocommerce_product_single_width',
                        'type'    => 'dimensions',
                        'units'   => 'px',
                        'title'   => esc_html__('Single Product Width', 'freshio'),
                        'height'  => false,
                        'default' => ['width' => 800],
                    ),
                    array(
                        'id'      => 'woocommerce_product_thumbnail_width',
                        'type'    => 'dimensions',
                        'units'   => 'px',
                        'title'   => esc_html__('Archive Product Width', 'freshio'),
                        'height'  => false,
                        'default' => ['width' => 450],
                    ),
                )
            );

            $sections[] = array(
                'title'      => esc_html__('Archive Product', 'freshio'),
                'id'         => 'wocommerce-archive-product',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'      => 'woocommerce_archive_layout',
                        'type'    => 'select',
                        'title'   => esc_html__('Layout Style', 'freshio'),
                        // Must provide key => value pairs for select options
                        'options' => array(
                            'default' => esc_html__('Sidebar', 'freshio'),
                        ),
                        'default' => 'default',
                    ),
                    array(
                        'id'       => 'woocommerce_archive_sidebar',
                        'type'     => 'select',
                        'title'    => esc_html__('Sidebar Position', 'freshio'),
                        // Must provide key => value pairs for select options
                        'options'  => array(
                            'left'  => esc_html__('Left', 'freshio'),
                            'right' => esc_html__('Right', 'freshio'),
                        ),
                        'default'  => 'left',
                        'required' => array('woocommerce_archive_layout', 'equals', 'default'),
                    ),
                )
            );

            $sections[] = array(
                'title'      => esc_html__('Single Product', 'freshio'),
                'id'         => 'wocommerce-single-product',
                'subsection' => true,
                'fields'     => array(
                    array(
                        'id'      => 'single-product-gallery-layout',
                        'type'    => 'select',
                        'title'   => esc_html__('Product gallery layout', 'freshio'),
                        'options' => array(
                            'horizontal' => esc_html__('Horizontal', 'freshio'),
                            'vertical'   => esc_html__('Vertical', 'freshio'),
                        ),
                        'default' => 'horizontal',
                    ),
                    array(
                        'id'      => 'single-product-related-columns',
                        'type'    => 'select',
                        'title'   => esc_html__('Related product columns', 'freshio'),
                        'options' => array(
                            '2' => esc_html__('2 Columns', 'freshio'),
                            '3' => esc_html__('3 Columns', 'freshio'),
                            '4' => esc_html__('4 Columns', 'freshio'),
                            '5' => esc_html__('5 Columns', 'freshio'),
                        ),
                        'default' => '4',
                    ),
                ),
            );

            return $sections;
        }


        public function section_breadcrumb($sections) {
            $sections[] = array(
                'title'  => esc_html__('Breadcrumb', 'freshio'),
                'id'     => 'breadcrumb',
                'icon'   => 'el el-flag',
                'fields' => array(
                    array(
                        'id'       => 'breadcrumb-default-color',
                        'type'     => 'color',
                        'title'    => esc_html__('Color', 'freshio'),
                        'validate' => 'color',
                        'output'   => ['.freshio-breadcrumb, .freshio-breadcrumb .breadcrumb-heading, .freshio-breadcrumb a'],
                    ),
                    array(
                        'id'     => 'breadcrumb-default-bg',
                        'type'   => 'background',
                        'title'  => esc_html__('Breadcrumb Background', 'freshio'),
                        'output' => ['.freshio-breadcrumb']
                    ),
                    array(
                        'id'     => 'breadcrumb-woo-bg',
                        'type'   => 'background',
                        'title'  => esc_html__('Breadcrumb Shop', 'freshio'),
                        'output' => ['body.woocommerce-page:not(.single-product) .freshio-breadcrumb']
                    ),
                )
            );

            return $sections;
        }

        public function section_blog($sections) {
            $sections[] = array(
                'title'  => esc_html__('Blog', 'freshio'),
                'id'     => 'blog',
                'icon'   => 'el el-blogger',
                'fields' => array(
                    array(
                        'id'      => 'blog-style',
                        'type'    => 'select',
                        'title'   => esc_html__('Blog style', 'freshio'),
                        'options' => array(
                            'standard' => __('Blog Standard', 'freshio'),
                            'grid'     => __('Blog Grid', 'freshio'),
                            'masonry'  => __('Blog Masonry', 'freshio'),
                        ),
                        'default' => 'standard',
                    ),
                )
            );

            return $sections;
        }

        public function section_social($sections) {
            $sections[] = array(
                'title'  => esc_html__('Social', 'freshio'),
                'id'     => 'social',
                'icon'   => 'el el-globe',
                'fields' => array(
                    array(
                        'id'       => 'social_text',
                        'type'     => 'multi_text',
                        'validate' => 'url',
                        'title'    => esc_html__('Social link', 'freshio'),
                        'subtitle' => esc_html__('Add your social link', 'freshio'),
                    ),
                    array(
                        'id'      => 'social-share',
                        'type'    => 'switch',
                        'title'   => esc_html__('Social Share', 'freshio'),
                        'default' => true,
                        'on'      => esc_html__('Yes', 'freshio'),
                        'off'     => esc_html__('No', 'freshio'),
                    ),
                    array(
                        'id'       => 'social-share-facebook',
                        'type'     => 'switch',
                        'title'    => esc_html__('Share Facebook', 'freshio'),
                        'default'  => true,
                        'on'       => esc_html__('Yes', 'freshio'),
                        'off'      => esc_html__('No', 'freshio'),
                        'required' => array('social-share', 'equals', true),
                    ),
                    array(
                        'id'       => 'social-share-twitter',
                        'type'     => 'switch',
                        'title'    => esc_html__('Share Twitter', 'freshio'),
                        'default'  => true,
                        'on'       => esc_html__('Yes', 'freshio'),
                        'off'      => esc_html__('No', 'freshio'),
                        'required' => array('social-share', 'equals', true),
                    ),
                    array(
                        'id'       => 'social-share-linkedin',
                        'type'     => 'switch',
                        'title'    => esc_html__('Share Linkedin', 'freshio'),
                        'default'  => true,
                        'on'       => esc_html__('Yes', 'freshio'),
                        'off'      => esc_html__('No', 'freshio'),
                        'required' => array('social-share', 'equals', true),
                    ),
                    array(
                        'id'       => 'social-share-google-plus',
                        'type'     => 'switch',
                        'title'    => esc_html__('Share Google Plus', 'freshio'),
                        'default'  => true,
                        'on'       => esc_html__('Yes', 'freshio'),
                        'off'      => esc_html__('No', 'freshio'),
                        'required' => array('social-share', 'equals', true),
                    ),
                    array(
                        'id'       => 'social-share-pinterest',
                        'type'     => 'switch',
                        'title'    => esc_html__('Share Pinterest', 'freshio'),
                        'default'  => true,
                        'on'       => esc_html__('Yes', 'freshio'),
                        'off'      => esc_html__('No', 'freshio'),
                        'required' => array('social-share', 'equals', true),
                    ),
                    array(
                        'id'       => 'social-share-email',
                        'type'     => 'switch',
                        'title'    => esc_html__('Share Email', 'freshio'),
                        'default'  => true,
                        'on'       => esc_html__('Yes', 'freshio'),
                        'off'      => esc_html__('No', 'freshio'),
                        'required' => array('social-share', 'equals', true),
                    ),
                )
            );

            return $sections;
        }

        public function section_site_footer($sections) {
            global $post;
            $option = array();
            $args   = array(
                'post_type'      => 'elementor_library',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                's'              => 'FooterBuilder ',
                'order'          => 'ASC',
            );

            $query1 = new WP_Query($args);
            while ($query1->have_posts()) {
                $query1->the_post();
                $option[$post->post_name] = $post->post_title;
            }

            $sections[] = array(
                'title'  => esc_html__('Footer', 'freshio'),
                'id'     => 'footer',
                'icon'   => 'el el-website',
                'fields' => array(
                    array(
                        'id'      => 'enable-footer-builder',
                        'type'    => 'switch',
                        'title'   => esc_html__('Enable Footer Builder', 'freshio'),
                        'default' => false,
                        'on'      => esc_html__('Yes', 'freshio'),
                        'off'     => esc_html__('No', 'freshio'),
                    ),
                    array(
                        'id'       => 'footer-builder-slug',
                        'title'    => esc_html__('Footer Builder', 'freshio'),
                        'type'     => 'select',
                        'options'  => $option,
                        'required' => array('enable-footer-builder', 'equals', true),
                        'default'  => ''
                    )
                ),
            );

            return $sections;
        }
    }

endif;

return new Freshio_Options();
