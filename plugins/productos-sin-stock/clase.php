<?php

/**
 * Clase principal
 * copyright Enrique J. Ros - enrique@enriquejros.com
 *
 * @author 			Enrique J. Ros
 * @link 			https://www.enriquejros.com
 * @since 			1.0.0
 * @package 		ProductosSinStock
 *
 */

defined ('ABSPATH') or exit;

if (!class_exists ('Clase_Productos_Sin_Stock')) :

	Class Clase_Productos_Sin_Stock {

		public function __construct () {

			add_filter ('posts_clauses', array($this, 'sin_stock_al_final'), PHP_INT_MAX, 1);
			}

		public function sin_stock_al_final ($posts_clauses) {

			global $wpdb;

			if (is_archive() && is_woocommerce() && (is_shop() || is_product_category() || is_product_tag())) {

				$posts_clauses['join']   .= " INNER JOIN $wpdb->postmeta istockstatus ON ($wpdb->posts.ID = istockstatus.post_id) ";
				$posts_clauses['orderby'] = " istockstatus.meta_value ASC, " . $posts_clauses['orderby'];
				$posts_clauses['where']   = " AND istockstatus.meta_key = '_stock_status' AND istockstatus.meta_value <> '' " . $posts_clauses['where'];
				}

			return $posts_clauses;
			}

	}

endif;