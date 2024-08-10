<?php

namespace MydPro\Includes;

use MydPro\Includes\Myd_Currency;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Store data static class
 *
 * @since 1.9.5
 */
class Store_Data {
	/**
	 * Store data definitions
	 *
	 * @since 1.9.5
	 */
	protected static $store_data = [];

	/**
	 * TEMP. VARIABLE TO START A FEATURE AND CONTROLE THE RENDER ELEMENTS
	 *
	 * @since 1.0.0
	 */
	public static $template_dependencies_loaded = false;

	/**
	 * Set store data
	 *
	 * @since 1.9.5
	 */
	public static function set_store_data() {
		$store_data = [
			'name' => get_option( 'fdm-business-name' ),
			'whatasapp' => get_option( 'myd-business-whatsapp' ),
			'email' => get_option( 'myd-business-mail' ),
			'country' => get_option( 'fdm-business-country' ),
			'operation_mode' => '',
			'delivery_time' => get_option( 'fdm-estimate-time-delivery' ),
			'delivery_mode' => get_option( 'myd-delivery-mode' ),
			'delivery_options' => get_option( 'myd-delivery-mode-options' ),
			'delivery_hours' => get_option( 'myd-delivery-time' ),
			'force_open_close_store' => get_option( 'myd-delivery-force-open-close-store' ),
			'minimum_order' => get_option( 'myd-option-minimum-price' ),
			'auto_redirect' => get_option( 'myd-option-redirect-whatsapp' ),
			'currency_simbol' => Myd_Currency::get_currency_symbol(),
			'number_decimals' => get_option( 'fdm-number-decimal' ),
			'decimal_separator' => get_option( 'fdm-decimal-separator' ),
			'cash_payment' => get_option( 'fdm-payment-in-cash' ),
			'print_size' => get_option( 'fdm-print-size' ),
			'print_font_size' => get_option( 'fdm-print-font-size' ),
			'product_categories' => get_option( 'fdm-list-menu-categories' ),
			// MercadoPago
			'myd-mp-mode' => get_option('myd-mp-mode'),
			'myd-mp-sandbox-tk' => get_option('myd-mp-sandbox-tk'),
			'myd-mp-sandbox-public' => get_option('myd-mp-sandbox-public'),
			'myd-mp-production-tk' => get_option('myd-mp-production-tk'),
			'myd-mp-production-public' => get_option('myd-mp-production-public'),
			'myd-mp-pix' => get_option('myd-mp-pix'),
			'myd-mp-credito' => get_option('myd-mp-credito'),
			'myd-mp-debito' => get_option('myd-mp-debito'),
			'myd-tempo-expiracao' => get_option('myd-tempo-expiracao'),
		];

		self::$store_data = $store_data;
	}

	/**
	 * Get store data
	 *
	 * @since 1.9.5
	 * @param string $data
	 */
	public static function get_store_data( $data = '' ) {
		if ( empty( $data ) ) {
			return self::$store_data;
		}

		if ( array_key_exists( $data, self::$store_data ) ) {
			return self::$store_data[ $data ];
		}
	}
}
