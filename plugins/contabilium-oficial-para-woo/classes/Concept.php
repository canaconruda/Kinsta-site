<?php
namespace Contabilium;

use mysql_xdevapi\Exception;

class Concept 
{
	public static function get( $sku ) 
	{
		return ( CbApi::getInstance( get_option( 'cb_api_client_id' ), get_option( 'cb_api_client_secret' ) ) )->getRet(
			'https://rest.contabilium.com/api/conceptos/' . rawurlencode($sku)
		);
	}

	public static function getByCodigo( $sku ) {
		return ( CbApi::getInstance( get_option( 'cb_api_client_id' ), get_option( 'cb_api_client_secret' ) ) )->getRequest( 
			'https://rest.contabilium.com/api/conceptos/getInfoForEcommerce?idIntegracion=' . get_option( 'cb_api_integration' ) . '&codigo=' . rawurlencode($sku)
		);
	}

	public static function triggerFullSync( ) {
		return ( CbApi::getInstance( get_option( 'cb_api_client_id' ), get_option( 'cb_api_client_secret' ) ) )->postRequest( 
			'https://rest.contabilium.com/api/conceptos/syncEcommerce?idIntegracion=' . get_option( 'cb_api_integration' ),
			array()
		);
	}

	public static function updateWcProductById( $id ) {
		if ( self::updateWcProductDetailsById( $id ) ) {
			return true;
		} else {
			return false;
		}
	}

	public static function updateWcProductDetailsById( $data ) {
		update_post_meta( $data["wc_id"], '_price', $data["price"] );
		update_post_meta( $data["wc_id"], '_stock', $data["stock"] );

		return true;
	}


	public static function syncOneForUpdate( $sku ) {
		$wcprd = Concept::getWcProductBySKU( $sku );

		if (!$wcprd) { 
			cb_message('No se encontró el producto ' . $sku, 'error');
			return;
		}

		$concepto = self::getByCodigo( $sku );
		try {
			if ( Tools::update_product_price( $wcprd, $concepto ) ) {
				if ( 'variable' === $wcprd->get_type() ) {
					$variations = $wcprd->get_available_variations();

					if ( ! empty( $variations ) ) {
						foreach ( $variations as $variation ) {
							if ( ! empty( $variation['sku'] ) ) {
								$child_product = wc_get_product( $variation['variation_id'] );
								if ( $child_product ) {
									$updated_child = Tools::update_product_price( $child_product, $concepto );
								}
							}
						}
					}
				}
			}
		} catch ( \Exception $e ) {
			cb_message($e->getMessage(), 'error');
			return;
		}
		
		if ( 'yes' === get_option( 'cb_sync_stock' ) ) {
			$stock = $concepto->Stock;
		} else {
			$stock = 'No sincronizado por config.';
		}

		if ( 'yes' === get_option( 'cb_sync_price' ) ) {
			$newPrice = $concepto->Precio . " (sin IVA incluido)";

        	if ( 'yes' === get_option( 'cb_sync_price_with_iva' ) ) {
            	$newPrice = $concepto->PrecioFinal . " (con IVA incluido)";
        	}
		} else {
			$newPrice = 'No sincronizado por config.';
		}

		cb_message('Se ha actualizado correctamente el producto "' . $sku . '". Precio: ' . $newPrice . ' -- Stock: ' . $stock, 'success');
		return;
	}

	public static function syncAllForUpdate( ) {
		$api = CbApi::getInstance( get_option( 'cb_api_client_id' ), get_option( 'cb_api_client_secret' ) );
		$concept  = self::search('', '', '', 1, $api->getAuth());
		$per_page = is_object($concept) ? $concept->TotalPage : 10;
		$pages    = is_object($concept) ? ceil($concept->TotalItems / $concept->TotalPage) : 1;
		$items    = is_object($concept) ? $concept->TotalItems : 100;


		if ($pages > 1) {
			self::triggerFullSync();
			cb_message('Se ha solicitado la actualización de todos los productos. El proceso correrá en background y le notificaremos via mail cuando termine.', 'success');
			return;
		}

		$success     = 0;
		$Products    = Concept::getAllForUpdate( $pages, $per_page );
		$invalid_skus = [];
		$error_msg   = null;

		foreach ( $Products as $i => $concepto ) {
			$concepto = (object) $concepto;
			$wcprd    = Concept::getWcProductBySKU( $concepto->Codigo );

			try {
				if ( $wcprd != null && $wcprd != "Invalid product." ) {
					if ( Tools::update_product_price( $wcprd, $concepto ) ) {
						if ( 'variable' === $wcprd->get_type() ) {
							$variations = $wcprd->get_available_variations();

							if ( ! empty( $variations ) ) {
								foreach ( $variations as $variation ) {
									if ( ! empty( $variation['sku'] ) ) {
										$child_product = wc_get_product( $variation['variation_id'] );
										if ( $child_product ) {
											$updated_child = Tools::update_product_price( $child_product, $concepto );
										}
									}
								}
							}
						}

						$success ++;
					}
				}
			} catch ( \Exception $e ) {
				$invalid_skus[] = $concepto->Codigo;
				$error_msg = $e->getMessage();
			}
		}

		if ( $error_msg ) {
			$_SESSION['error'] = 'Problema al sincronizar los siguientes SKUs:<br>' .
				implode( ', ', $invalid_skus ) . '. Error: ' . $error_msg;

			return false;
		} else {
			return $success;
		}

	}

	public static function getAllForUpdate( $pages, $per_page ) {
		$p = [];
		for ( $i = 1; $i <= $pages; $i ++ ) {
			$api = CbApi::getInstance( get_option( 'cb_api_client_id' ), get_option( 'cb_api_client_secret' ) );
			$concept = Concept::search( '', date( "Y-m-01" ), date( "Y-m-d" ), $i );
			Tools::dieObject($concept);
			for ( $j = 0; $j < $concept->TotalPage; $j ++ ) {

				if ( $concept->Items[ $j ]->Codigo != null && ( $concept->Items[ $j ]->PrecioFinal != 0 || $concept->Items[ $j ]->Stock != null ) ) {
					array_push( $p, [
						"Codigo" => $concept->Items[ $j ]->Codigo,
						"PrecioFinal" => $concept->Items[ $j ]->PrecioFinal,
						"Stock"  => $concept->Items[ $j ]->Stock
					] );
				}
			}
		}

		return $p;
	}

	public static function search( $filter, $from = '', $to = '', $page = 1 ) {
		return ( CbApi::getInstance( get_option( 'cb_api_client_id' ), get_option( 'cb_api_client_secret' ) ) )->getRequest( 
			'https://rest.contabilium.com/api/conceptos/search?idIntegracion=' . intval( get_option( 'cb_api_integration' ) ) . '&filtro=' . $filter . '&fechaDesde=' . $from . '&fechaHasta=' . $to . '&page=' . $page
		);
	}

	public static function getWcProductBySKU( $sku ) {
		global $wpdb;

		try {
			$product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value='%s' LIMIT 1", $sku ) );

			return $product_id ? wc_get_product( $product_id ) : null;
		} catch ( \Exception $e ) {
			return $e->getMessage();
		}
	}
}