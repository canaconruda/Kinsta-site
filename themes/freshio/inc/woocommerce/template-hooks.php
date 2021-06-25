<?php
/**
 * =================================================
 * Hook freshio_page
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_single_post_top
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_single_post
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_single_post_bottom
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_loop_post
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_footer
 * =================================================
 */
add_action('freshio_footer', 'freshio_handheld_footer_bar', 25);

/**
 * =================================================
 * Hook freshio_after_footer
 * =================================================
 */
add_action('freshio_after_footer', 'freshio_sticky_single_add_to_cart', 999);

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'freshio_render_woocommerce_shop_canvas', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_before_content
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_content_top
 * =================================================
 */
add_action('freshio_content_top', 'freshio_shop_messages', 10);

/**
 * =================================================
 * Hook freshio_post_header_before
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_sidebar
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_loop_after
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_page_after
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_woocommerce_before_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_woocommerce_before_shop_loop_item_title
 * =================================================
 */
add_action('freshio_woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action('freshio_woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
add_action('freshio_woocommerce_before_shop_loop_item_title', 'freshio_woocommerce_product_loop_action', 20);

/**
 * =================================================
 * Hook freshio_woocommerce_shop_loop_item_title
 * =================================================
 */
add_action('freshio_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('freshio_woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);

/**
 * =================================================
 * Hook freshio_woocommerce_after_shop_loop_item_title
 * =================================================
 */
add_action('freshio_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 15);
add_action('freshio_woocommerce_after_shop_loop_item_title', 'freshio_woocommerce_get_product_description', 20);
add_action('freshio_woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 25);

/**
 * =================================================
 * Hook freshio_woocommerce_after_shop_loop_item
 * =================================================
 */
