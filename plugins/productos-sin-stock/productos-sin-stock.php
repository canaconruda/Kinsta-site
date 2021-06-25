<?php

/**			
 *
 * Plugin Name: 			Productos sin stock
 * Description: 			Reordena los productos sin stock, colocándolos al final de las listas de productos (en tienda, categorías, etiquetas, etc)
 * Plugin URI: 				https://www.enriquejros.com/plugins/reordena-productos-sin-stock/
 * Author: 					Enrique J. Ros
 * Author URI: 				https://www.enriquejros.com/
 * Version: 				1.2.0
 * License: 				Copyright 2017 - 2020 Enrique J. Ros (email: enrique@enriquejros.com)
 * Text Domain: 			sin-stock
 * Domain Path: 			/lang/
 * Requires at least:		5.0
 * Tested up to:			5.5.0
 * WC requires at least:	3.0
 * WC tested up to: 		4.4
 *
 * @author 					Enrique J. Ros
 * @link					https://www.enriquejros.com/
 * @since					1.0.0
 * @package					ProductosSinStock
 *
 */

defined ('ABSPATH') or exit;

if (!class_exists ('Plugin_Productos_Sin_Stock')) :

	Class Plugin_Productos_Sin_Stock {

		private static $instancia;

		private function __construct () {

			$this->nombre   = __('Productos sin stock', 'sin-stock');
			$this->domain   = 'sin-stock';
			$this->json     = 'productos-sin-stock';
			$this->archivos = ['clase'];
			$this->clases   = ['Clase_Productos_Sin_Stock'];
			$this->dirname  = dirname (__FILE__);

			$this->carga_archivos();
			$this->carga_traducciones();
			$this->actualizaciones();

			add_action ('init', array($this, 'arranca_plugin'), 10);
			add_filter ('plugin_action_links', array($this, 'enlaces_accion'), 10, 2);
			}

		public function __clone () {

			_doing_it_wrong (__FUNCTION__, sprintf ('No puedes clonar instancias de %s.', get_class ($this)), '1.0.0');
			}

		public function carga_archivos () {

			foreach ($this->archivos as $archivo)
				require ($this->dirname . '/' . $archivo . '.php');
			}

		public function arranca_plugin () {

			if ($this->woocommerce_activo())
				foreach ($this->clases as $clase)
					new $clase;
			}

		private function woocommerce_activo () {

			if (!class_exists ('WooCommerce')) {

				add_action ('admin_notices', function () {
					?>
						<div class="notice notice-error is-dismissible">
							<p><?php printf (__('El plugin %s necesita que WooCommerce esté activado. Por favor, activa WooCommerce primero.', 'sin-stock'), '<i>' . $this->nombre . '</i>'); ?></p>
						</div>
					<?php
					}, 10);

				return false;
				}

			return true;
			}

		public function carga_traducciones () {

			$locale = function_exists ('determine_locale') ? determine_locale() : (is_admin() && function_exists ('get_user_locale') ? get_user_locale() : get_locale());
			$locale = apply_filters ('plugin_locale', $locale, $this->domain);

			unload_textdomain ($this->domain);
			load_textdomain ($this->domain, $this->dirname . '/lang/' . $this->domain . '-' . $locale . '.mo');
			load_plugin_textdomain ($this->domain, false, $this->dirname . '/lang');
			}

		public function enlaces_accion ($damelinks, $plugin) {

			static $nostock;
			isset ($nostock) or $nostock = plugin_basename (__FILE__);

			if ($nostock == $plugin) {
				
				$enlaces['support']  = sprintf ('<a target="_blank" href="https://www.enriquejros.com/soporte/">%s</a>', __('Soporte', 'sin-stock'));
				$damelinks = array_merge ($enlaces, $damelinks);
				}
			
			return $damelinks;
			}

		public function actualizaciones () {

			include_once ($this->dirname . '/includes/updates/plugin-update-checker.php');
			$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker('https://www.enriquejros.com/wp-content/descargas/updates/' . $this->json . '.json', __FILE__, $this->json);
			}

		public static function instancia () {

			if (null === self::$instancia)
				self::$instancia = new self();

			return self::$instancia;
			}

	}

endif;

Plugin_Productos_Sin_Stock::instancia();