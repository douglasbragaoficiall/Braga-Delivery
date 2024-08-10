<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function myd_add_footer_templates() {
	include_once DRP_PLUGIN_PATH . '/templates/cart/cart-product-item.php';

	include_once DRP_PLUGIN_PATH . '/templates/cart/cart-product-extra.php';

	include_once DRP_PLUGIN_PATH . '/templates/cart/cart-product-extra-name.php';

	include_once DRP_PLUGIN_PATH . '/templates/animation/order-loading-animation.php';
}

add_action( 'wp_footer', 'myd_add_footer_templates' );
