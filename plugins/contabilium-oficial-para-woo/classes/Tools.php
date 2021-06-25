<?php
namespace Contabilium;

class Tools
{
	/**
	 * Updates price for a product
	 *
	 * @param WC_Product $wc_product WooCommerce Product
	 * @param \stdClass  $concepto   Concepto de Contabilium
	 */
	public static function update_product_price( $wc_product, $concepto ) 
	{
		if ( 'yes' === get_option( 'cb_sync_stock' ) ) {
			$wc_product->set_stock_quantity( $concepto->Stock );
		}

		if ( 'yes' === get_option( 'cb_sync_price' ) ) {
			$newPrice = $concepto->Precio;

        	if ( 'yes' === get_option( 'cb_sync_price_with_iva' ) ) {
            	$newPrice = $concepto->PrecioFinal;
        	}
			$wc_product->set_regular_price( $newPrice );
		}

		return $wc_product->save();
	}

	public static function isSubmit($field)
    {
        return ( isset( $field ) && self::getValue( "$field" ) !== null ) ? true : false;
    }

	public static function getValue( $field )
    {
		return sanitize_text_field(empty( $_REQUEST[ "$field" ] )) ? null : $_REQUEST["$field"]; 
	}
	
	public static function dieObject( $obj )
	{
		print "<pre>";
		var_export($obj);
		print "</pre>";
		die();
	}
}