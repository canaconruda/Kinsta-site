<?php
/**
 * Freshio WooCommerce hooks
 *
 * @package freshio
 */

/**
 * Layout
 *
 * @see  freshio_before_content()
 * @see  freshio_after_content()
 * @see  woocommerce_breadcrumb()
 * @see  freshio_shop_messages()
 */
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

add_action('woocommerce_before_main_content', 'freshio_before_content', 10);
add_action('woocommerce_after_main_content', 'freshio_after_content', 10);


add_action('woocommerce_before_shop_loop', 'freshio_sorting_wrapper', 19);
add_action('woocommerce_before_shop_loop', 'freshio_button_shop_canvas', 19);
add_action('woocommerce_before_shop_loop', 'freshio_button_shop_dropdown', 19);
add_action('woocommerce_before_shop_loop', 'freshio_button_grid_list_layout', 25);
add_action('woocommerce_before_shop_loop', 'freshio_sorting_wrapper_close', 31);
//if (freshio_get_theme_option('woocommerce_archive_layout') == 'dropdown') {
//    add_action('woocommerce_before_shop_loop', 'freshio_render_woocommerce_shop_dropdown', 35);
//}

//Position label onsale
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
add_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 30);

//Wrapper content single
add_action('woocommerce_before_single_product_summary', 'freshio_woocommerce_single_content_wrapper_start', 0);
add_action('woocommerce_single_product_summary', 'freshio_woocommerce_single_content_wrapper_end', 99);


// Legacy WooCommerce columns filter.
if (defined('WC_VERSION') && version_compare(WC_VERSION, '3.3', '<')) {
    add_filter('loop_shop_columns', 'freshio_loop_columns');
    add_action('woocommerce_before_shop_loop', 'freshio_product_columns_wrapper', 40);
    add_action('woocommerce_after_shop_loop', 'freshio_product_columns_wrapper_close', 40);
}

/**
 * Products
 *
 * @see freshio_upsell_display()
 * @see freshio_single_product_pagination()
 */


remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
add_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 21);
add_action('yith_quick_view_custom_style_scripts', function () {
    wp_enqueue_script('flexslider');
});

add_action('woocommerce_single_product_summary', 'freshio_single_product_pagination', 1);
add_action('woocommerce_single_product_summary', 'freshio_stock_label', 2);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);

remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
add_action('woocommerce_after_single_product_summary', 'freshio_upsell_display', 15);

add_action('woocommerce_share', 'freshio_social_share', 10);

add_theme_support('wc-product-gallery-zoom');
add_theme_support('wc-product-gallery-lightbox');
add_theme_support('wc-product-gallery-slider');

/**
 * Cart fragment
 *
 * @see freshio_cart_link_fragment()
 */
if (defined('WC_VERSION') && version_compare(WC_VERSION, '2.3', '>=')) {
    add_filter('woocommerce_add_to_cart_fragments', 'freshio_cart_link_fragment');
} else {
    add_filter('add_to_cart_fragments', 'freshio_cart_link_fragment');
}

remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display');

add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_order_review_start', 5);
add_action('woocommerce_checkout_order_review', 'woocommerce_checkout_order_review_end', 15);

/*
 *
 * Layout Product
 *
 * */
function freshio_include_hooks_product_blocks() {

    remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
    remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);

    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
    remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);


    remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
    add_action('woocommerce_before_shop_loop_item', 'freshio_woocommerce_product_loop_start', -1);
    add_action('woocommerce_after_shop_loop_item', 'freshio_woocommerce_product_loop_end', 999);
    add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 4);

    /**
     * Integrations
     *
     * @see freshio_template_loop_product_thumbnail()
     *
     */
    add_action('woocommerce_before_shop_loop_item_title', 'freshio_woocommerce_product_loop_image', 10);

//    add_action('woocommerce_shop_loop_item_title', 'freshio_woocommerce_get_product_category', 5);

    add_action('freshio_woocommerce_product_loop_image', 'freshio_woocommerce_get_product_label_stock', 11);
    add_action('freshio_woocommerce_product_loop_image', 'woocommerce_show_product_loop_sale_flash', 12);

    add_action('freshio_woocommerce_product_loop_image', 'freshio_template_loop_product_thumbnail', 10);


    add_action('freshio_woocommerce_product_loop_image', 'woocommerce_template_loop_product_link_open', 99);
    add_action('freshio_woocommerce_product_loop_image', 'woocommerce_template_loop_product_link_close', 99);

    /**
     * Integrations
     *
     * @see freshio_woocommerce_product_loop_action()
     *
     */
    add_action('freshio_woocommerce_product_loop_image', 'freshio_woocommerce_product_loop_action', 20);

    // Wishlist
    remove_action('freshio_woocommerce_product_loop_action', 'freshio_woocommerce_product_loop_wishlist_button', 5);

    // Compare
    add_action('freshio_woocommerce_product_loop_action', 'freshio_woocommerce_product_loop_compare_button', 10);

    // QuickView
    if (freshio_is_woocommerce_extension_activated('YITH_WCQV')) {
        remove_action('woocommerce_after_shop_loop_item', array(
            YITH_WCQV_Frontend::get_instance(),
            'yith_add_quick_view_button'
        ), 15);
        add_action('freshio_woocommerce_product_loop_action', array(
            YITH_WCQV_Frontend::get_instance(),
            'yith_add_quick_view_button'
        ), 15);
    }
}

freshio_include_hooks_product_blocks();

