<?php
/**
 * =================================================
 * Hook freshio_page
 * =================================================
 */
add_action('freshio_page', 'freshio_page_header', 10);
add_action('freshio_page', 'freshio_page_content', 20);

/**
 * =================================================
 * Hook freshio_single_post_top
 * =================================================
 */
add_action('freshio_single_post_top', 'freshio_post_header_single', 10);

/**
 * =================================================
 * Hook freshio_single_post
 * =================================================
 */
add_action('freshio_single_post', 'freshio_post_thumbnail', 10);
add_action('freshio_single_post', 'freshio_post_content', 30);

/**
 * =================================================
 * Hook freshio_single_post_bottom
 * =================================================
 */
add_action('freshio_single_post_bottom', 'freshio_post_taxonomy', 5);
add_action('freshio_single_post_bottom', 'freshio_post_nav', 10);
add_action('freshio_single_post_bottom', 'freshio_display_comments', 20);

/**
 * =================================================
 * Hook freshio_loop_post
 * =================================================
 */
add_action('freshio_loop_post', 'freshio_post_thumbnail', 10);
add_action('freshio_loop_post', 'freshio_post_header', 15);
add_action('freshio_loop_post', 'freshio_post_content', 30);

/**
 * =================================================
 * Hook freshio_footer
 * =================================================
 */
add_action('freshio_footer', 'freshio_footer_default', 20);

/**
 * =================================================
 * Hook freshio_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'freshio_template_account_dropdown', 1);
add_action('wp_footer', 'freshio_mobile_nav', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */
add_action('wp_head', 'freshio_pingback_header', 1);

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
add_action('freshio_before_content', 'freshio_breadcrumb', 10);

/**
 * =================================================
 * Hook freshio_content_top
 * =================================================
 */

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
add_action('freshio_sidebar', 'freshio_get_sidebar', 10);

/**
 * =================================================
 * Hook freshio_loop_after
 * =================================================
 */
add_action('freshio_loop_after', 'freshio_paging_nav', 10);

/**
 * =================================================
 * Hook freshio_page_after
 * =================================================
 */
add_action('freshio_page_after', 'freshio_display_comments', 10);

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

/**
 * =================================================
 * Hook freshio_woocommerce_shop_loop_item_title
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_woocommerce_after_shop_loop_item_title
 * =================================================
 */

/**
 * =================================================
 * Hook freshio_woocommerce_after_shop_loop_item
 * =================================================
 */
