<?php
/*
Plugin Name: Contabilium Oficial para Woo
Plugin URI:  https://contabilium.com/
Description: Conector de integración a la API de Contabilium. Sincronice su stock, precios y ventas con Contabilium.
Version:     0.4
Author:      contabilium
Author URI:  https://contabilium.com
WC tested up to: 5.5
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: contabilium-oficial-woo
Domain Path: /languages
*/
require(dirname(__FILE__) . '/classes/CbApi.php');
require(dirname(__FILE__) . '/classes/Concept.php');
require(dirname(__FILE__) . '/classes/Tools.php');

use Contabilium\CbApi;
use Contabilium\Concept;
use Contabilium\Tools;

defined('ABSPATH') or die('¡Acceso prohibido! Su dirección IP ha sido reportada');

global $woocommerce;

$payment_methods = [
	'Efectivo'    => 'Efectivo',
	'Cheque'      => 'Cheque',
	'MercadoPago' => 'MercadoPago',
	'Transferencia' => 'Transferencia',
	'Cuenta corriente' => 'Cuenta corriente',
];

/**
 * Check if WooCommerce is active
 **/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins') ) ) ) {
	wp_cache_delete( 'alloptions', 'options' );

	if ( defined( 'cb_api_client_id' ) == null || defined( 'cb_api_client_secret' ) == null ) {
		add_option( 'cb_api_client_id', get_option( 'user_email' ) );
		add_option( 'cb_api_client_secret', '' );
	}

	function woocommerce_contabilium() 
	{
		return true;
	}

	function contabilium_main_menu() {
		add_menu_page( 'Configuración', 'Contabilium', 'manage_options', 'contabilium_main_menu', 'contabilium_config_page_html', plugin_dir_url( __FILE__ ) . 'images/logo-icon.svg', 20 );
	}
	add_action( 'admin_menu', 'contabilium_main_menu' );

	function contabilium_config_page_html() 
	{
		wp_enqueue_script( 'jquery' );

		// check user capabilities
		if ( !current_user_can('manage_options') ) {
			return;
		}

		if (Tools::isSubmit('submit')) {
			delete_transient( 'contabilium_access_token' ); // borro el cache del token para forzar reconectar a la API suponiendo que el submit es porque se cambio el user o el access key

			update_option('cb_api_client_id',  sanitize_email( empty($_POST["wc_api_client_id"]) ) ? null : $_POST["wc_api_client_id"]);
			update_option('cb_api_client_secret', sanitize_key( empty($_POST["wc_api_client_secret"]) ) ? null : $_POST["wc_api_client_secret"]);

			update_option('cb_api_integration', filter_input(INPUT_POST, 'wc_api_integration'));
			update_option('cb_sync_price', filter_input(INPUT_POST, 'wc_sync_price'));
			update_option('cb_sync_price_with_iva', filter_input(INPUT_POST, 'wc_sync_price_with_iva'));
			update_option('cb_sync_stock', filter_input(INPUT_POST, 'wc_sync_stock'));
			update_option('wc_add_dni_fields', filter_input(INPUT_POST, 'wc_add_dni_fields'));

			update_option('cb_cancelled_status', sanitize_text_field( isset($_POST['wc_contabilium_cancelled_status']) ) ? $_POST['wc_contabilium_cancelled_status'] : []);
			update_option('cb_accepted_status', sanitize_text_field( isset($_POST['wc_contabilium_accepted_status']) ) ? $_POST['wc_contabilium_accepted_status'] : []);
			
			cb_message('La configuración se actualizó correctamente', 'success');
		}

		if ( get_option( 'cb_api_client_id' ) && get_option( 'cb_api_client_secret' ) ) {
			$api = CbApi::getInstance( get_option( 'cb_api_client_id' ), get_option( 'cb_api_client_secret' ) );
			$api->getAuth();
		}
		$statuses = wc_get_order_statuses();
		?>
		<div class="wrap">
			<div class="cb_container">
				<div class="cb_heading"><?php echo esc_html(get_admin_page_title()); ?></div>
				<p class="cb_description">Ingrese los datos de acceso por API REST (Estan en Mi cuenta->Datos de mi empresa->API).</p>
				<form action="" method="post">
					<input type="hidden" name="action" value="updatesettings"/>
					<?php wp_nonce_field('add-user', '_wpnonce_add-user') ?>
					<table class="form-table">
						<thead></thead>
						<tbody>
						<tr class="form-field form-required">
							<th scope="row">
								<label><?php echo esc_html('Email', 'woocommerce') ?> 
									<span class="description"><?php esc_html_e('(required)'); ?></span>
								</label></th>
							<td><input type="email" required name="wc_api_client_id" id="wc_api_client_id" value="<?php echo sanitize_email( get_option('cb_api_client_id') ); ?>" autocapitalize="none" autocorrect="off" maxlength="60"/></td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row">
								<label><?php echo esc_html('Api Key', 'woocommerce'); ?>
									<span class="description"><?php esc_html_e('(required)'); ?></span>
								</label>
							</th>
							<td>
								<input type="text" required name="wc_api_client_secret" id="wc_api_client_secret" value="<?php echo sanitize_key( get_option('cb_api_client_secret') ); ?>"/>
							</td>
						</tr>
						<tr class="form-field form-required">
							<th scope="row">
								<label><?php echo esc_html('ID de Integración', 'woocommerce') ?> 
								<span class="description"><?php esc_html_e('(required)'); ?></span>
							</label>
						</th>
							<td><input type="text" required name="wc_api_integration" id="wc_api_integration" value="<?php echo absint( get_option('cb_api_integration') ); ?>"/></td>
						</tr>

						<tr class="form-field">
							<th scope="row"><label
									for=""><?php echo __('Estado de conexión', 'contabilium') ?> </label></th>
							<td>
							<?php if (is_object($api) && $api->last_error !== false ) {
								cb_message($api->last_error, 'error');
							} elseif (is_object($api) && $api->last_error === false ) {
								cb_message('Conectado a la API', 'success');
							} else {
								cb_message('Upsss! algo no funcionó bien al conectar a Contabilium', 'warning');
							}
							?></td>
						</tr>

						<tr class="form-field">
							<th scope="row">
								<label for="wc_sync_price"><?php echo esc_html('Sincronizar precios', 'contabilium') ?> </label>
							</th>
							<td>
								<input type="checkbox" name="wc_sync_price" id="wc_sync_price" value="yes" <?php echo 'yes' === get_option('cb_sync_price') ? 'checked' : '' ?>/>
							</td>
						</tr>

						<tr class="form-field">
							<th scope="row">
								<label for="wc_sync_price_with_iva"><?php echo esc_html('Utilizar precio con IVA incluido', 'contabilium') ?> </label>
							</th>
							<td>
								<input type="checkbox" name="wc_sync_price_with_iva" id="wc_sync_price_with_iva" value="yes" <?php echo 'yes' === get_option('cb_sync_price_with_iva') ? 'checked' : '' ?>/>
							</td>
						</tr>
						<tr class="form-field">
							<th scope="row">
								<label for="wc_sync_stock">
									<?php echo __('Sincronizar stock', 'contabilium'); ?>
								</label>
							</th>
							<td><input type="checkbox" name="wc_sync_stock" id="wc_sync_stock"
									value="yes" <?php echo 'yes' === get_option('cb_sync_stock') ? 'checked' : ''; ?>/>
							</td>
						</tr>
						<tr>
							<th>
								<label for="accepted_status">
									<?php echo __('Pedidos aceptados', 'contabilium'); ?>
								</label>
							</th>
							<td>
								<select name="wc_contabilium_accepted_status[]" id="accepted_status" multiple>
									<?php
									$status = get_option('cb_accepted_status', [ 'completed' ]);

									if (! is_array($status)) {
										$status = [];
									}
									?>
									<?php foreach ($statuses as $key => $label) : ?>
										<option value="<?php echo $key; ?>" <?php echo in_array($key, $status) ? 'selected="selected"' : ''; ?>>
											<?php echo $label; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>
								<label for="cancelled_status">Pedidos cancelados</label>
							</th>
							<td>
								<select name="wc_contabilium_cancelled_status[]" id="cancelled_status" multiple>
									<?php
									$status = get_option('cb_cancelled_status', [ 'refunded' ]);

									if (! is_array($status)) {
										$status = [];
									}
									?>
									<?php foreach ($statuses as $key => $label) : ?>
										<option value="<?php echo $key; ?>" <?php echo in_array($key, $status) ? 'selected="selected"' : ''; ?>>
											<?php echo $label; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</td>
						</tr>
						<tr class="form-field">
							<th scope="row"><label
									for="wc_sync_price_with_iva"><?php echo __('Identificación en checkout', 'contabilium') ?> </label></th>
							<td><input type="checkbox" name="wc_add_dni_fields" id="wc_add_dni_fields"
							           value="yes" <?php echo 'yes' === get_option('wc_add_dni_fields') ? 'checked' : '' ?>/>
									   <p>Solicitar tipo y número de documento en checkout</p>
							</td>
						</tr>
						<tr class="form-field">
							<td colspan="2">
								<h3>URL para ser configurada en Contabilium.com</h3>
							</td>
						</tr>
						<tr>
							<th>Callback URL</th>
							<td>
								<input type="text" id="callback" name="callback_url" readonly="readonly" value="<?php esc_url( bloginfo('url') ); ?>/wp-json/wp/v2/contabilium/" style="width: 80%">
							</td>
						</tr>
						</tbody>
						<tfooter>
							<th scope="row">
							</td>
							<td><?php submit_button('Guardar'); ?></td>
						</tfooter>
					</table>
				</form>
			</div>
			<?php if ($api->getAuth()): ?>
			<?php
			if ( Tools::getValue( 'proceed_single' ) && Tools::getValue( 'item_sku' ) ) {
				Concept::syncOneForUpdate( Tools::getValue( 'item_sku') );
			} elseif ( Tools::getValue( 'proceed_full') ) {
				Concept::syncAllForUpdate();
			}
			?>
			<a id="#sync_form"></a>
			<div class="cb_container">
				<form action="admin.php?page=contabilium_main_menu#sync_form" method="post">
					<div class="cb_heading">
						Sincronizaci&oacute;n manual
					</div>
					<?=cb_message('Use esta opción si desea actualizar el listado de productos desde Contabilium a su tienda', 'info')?>
					<input type="hidden" name="item_sku" id="item_sku" value="" />
					
					<table>
						<tr class="form-field">
							<td>
								<button type="submit" class="button button-secondary" name="proceed_full" value="1"><?=_e("Iniciar sincronización completa", "woocommerce")?></button>
							</td>
							<td width="50">&nbsp;</td>
							<td>
								<button type="submit" class="button button-secondary" name="proceed_single" value="1"
									onclick="code = prompt('Por favor ingresá un código de producto válido'); if(code) { document.getElementById('item_sku').value = code; } else { return false; }">
									<?=_e("Iniciar sincronización de un solo producto", "woocommerce")?>
								</button>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<?php endif; ?>
		</div>
		<script>
			jQuery(document).ready(function () {
				jQuery('#wc_sync_price').on('click', function () {
					if (jQuery(this).prop('checked')) {
						jQuery('tr.update-price').removeClass('hidden');
					} else {
						jQuery('tr.update-price').addClass('hidden');
					}
				});
			});
		</script>
		<?php
	}

	function contabilium_sync_page_html() {
		$active_tab = sanitize_text_field( !empty($_GET["tab"]) ) ? $_GET["tab"] : 'concepts-tab';
		if (!current_user_can('manage_options')) {
			return;
		}
		?>
		<div class="wrap">
			<?php
			if ($active_tab != null) {
				$file = dirname(__FILE__) . '/tabs/' . $active_tab . '.php';
				if (file_exists($file)) {
					require($file);
				} else {
					cb_message('Opción no válida, por favor seleccione otra', 'error');
				}
			}
			?>
		</div>
		<?php
	}

// Get customer ID
	function get_customer_id($order_id) {
		// Get the user ID
		$user_id = get_post_meta($order_id, '_customer_user', true);
		return $user_id;
	}

	function get_customer_address($user_id) {

		$address = '';
		$address .= get_user_meta($user_id, 'shipping_first_name', true);
		$address .= ' ';
		$address .= get_user_meta($user_id, 'shipping_last_name', true);
		$address .= "\n";
		$address .= get_user_meta($user_id, 'shipping_company', true);
		$address .= "\n";
		$address .= get_user_meta($user_id, 'shipping_address_1', true);
		$address .= "\n";
		$address .= get_user_meta($user_id, 'shipping_address_2', true);
		$address .= "\n";
		$address .= get_user_meta($user_id, 'shipping_city', true);
		$address .= "\n";
		$address .= get_user_meta($user_id, 'shipping_state', true);
		$address .= "\n";
		$address .= get_user_meta($user_id, 'shipping_postcode', true);
		$address .= "\n";
		$address .= get_user_meta($user_id, 'shipping_country', true);

		return $address;
	}


	function cb_message($text, $type = 'success', $domain = 'woocommerce') {
		if (! empty($text)) {
			$class   = 'notice notice-' . $type;
			$message = __($text, $domain);
			printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
		}
	}

	add_action('admin_notices', 'cb_message');


	/** WooCommerce campos extras necesarios para el registro **/
	function wc_extra_register_fields() { ?>
		      <p class="form-row form-row-wide">
			      <label for=""><?php _e('Nombre / Razón Social', 'woocommerce'); ?><span
					class="required">*</span></label>
			      <input type="text" class="input-text" name="cbCustomerName" id="" value=""/>
			      </p>
				      
				<p class="form-row form-row-wide">
					      <label for=""><?php _e('Tipo y Número de Documento', 'woocommerce'); ?><span
							class="required">*</span></label>
					<select class="woocommmerce-input input-text" name="cbDocumentType" id="cbDocumentType"
							style="max-width:14%;float:left;margin-right:1%;display: block;">
						<option value="DNI">DNI</option>
						<option value="CUIT">CUIT/CUIL</option>
					</select>
					      <input type="text" style="max-width:80%;float:left;display: block;"
								class="woocommmerce-input input-text" name="cbDocumentNumber" id="cbDocumentNumber"
								placeholder="Ingrese el número"/>
					      
				</p>
				<p class="form-row form-row-wide">
					      <label for=""><?php _e('Domicilio', 'woocommerce'); ?><span class="required">*</span></label>
					      <input type="text" class="input-text" name="cbCustomerAddress" id="cbCustomerAddress"
								placeholder="Ingrese su dirección"/>
					      </p>
				      
				<div class="clear"></div>
		      <?php
	}

	add_action('woocommerce_register_form_start', 'wc_extra_register_fields');

	/** Hoja de estilos propia **/
	add_action('admin_head', 'cb_styles');

	function cb_styles() {
		echo '<style>
    .cb_container {
        background:white;
        border-top:3px solid #2B9B8F;
        border-bottom:1px solid #ebebeb;
        border-right:1px solid #ebebeb;
        border-left:1px solid #ebebeb;
        margin: 0 0 10px 0;
        padding:8px;
        overflow:auto;
        -moz-box-shadow: 0 3px 0 rgba(12,12,12,0.03);
    -webkit-box-shadow: 0 3px 0 rgba(12,12,12,0.03);
    box-shadow: 0 3px 0 rgba(12,12,12,0.03);
    }
    .cb_container .cb_heading {
        color: #666;
        text-transform: uppercase;
        border-bottom: 1px solid #ebebeb;
        margin-bottom: 6px;
        padding: 4px 0;
        font-weight: bold;
    }
    .cb_container .cb_footer {
        color: #666;
        border-top: 1px solid #ebebeb;
        margin-top: 6px;
        padding: 4px 0;
    }
    .cb_container label {

    }
    .cb_row {
        padding: 2px;
        margin-top: 0px;
        margin-left: 0px;
        margin-right: 0px;
        margin-bottom: 12px;
    }   
    .cb_container .cb_description {
        color: #777;
    }
 </style>';
	}

}

// New modifications
function contabilium_hide_top_menu() {
	echo '<style  type="text/css">.toplevel_page_contabilium_main_menu .wp-first-item {display: none }</style>';
}

add_action('admin_head', 'contabilium_hide_top_menu');

include_once('api.php');
include_once('includes/manage-orders.php');