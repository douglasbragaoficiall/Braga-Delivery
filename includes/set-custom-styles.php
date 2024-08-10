<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function myd_add_settings_sytles() {
	?>
	<style>
		.myd-cart__button, .my-delivery-add-to-cart-popup, .myd-cart__finished-track-order, .fdm-add-to-cart-popup, .myd-cart__nav-back, .myd-cart__nav-close, .myd-cart__checkout-option--active, .myd-float { background: <?php echo esc_html( get_option( 'fdm-principal-color' ) ); ?>}
		.myd-cart__nav--active .myd-cart__nav-desc, #myd-float__qty { color: <?php echo esc_html( get_option( 'fdm-principal-color' ) ); ?> }
		.myd-cart__nav--active svg { fill: <?php echo esc_html( get_option( 'fdm-principal-color' ) ); ?> !important }
		.myd-extra-price, .myd-product-item__price { color: <?php echo esc_html( get_option( 'myd-price-color' ) ); ?> }
		.myd-product-item__button span.mais{color:#fff;padding:0px 5px 0px 5px;border-radius:5px;margin-right:10px;font-size:24px;font-weight:500;background:<?php echo esc_attr( get_option( 'fdm-principal-color' ) ); ?>}
		.fdm-extra-option-title-text {    background: none;    padding: 0;    border-radius: 0;    margin-bottom: 0;}
		.drope-delivery-card {background:#fff;padding:20px;border-radius:8px;border:1px solid #c3c4c7;max-width:96%;margin-top:20px}
		.nohref {pointer-events:none}
		.myd-content-filter__tag {background: <?php echo sanitize_text_field(get_option('fdm-principal-color')); ?> !important}
		.container-div {position:relative}
		.sticky-div {position:sticky;top:0;z-index:999}
		.fdm-click-plus-icon{margin:auto;font-weight:600;width:100%;padding: 5px;margin-left: 8px}
		.fdm-click-plus-off {display:none;align-items:center;border:1px solid #ddd;margin-left:5px;border-radius:0 5px 5px 0;padding:0;height:40px;width:40px;cursor:pointer;justify-content:center;font-size:20px;font-weight: 700}
	</style>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<?php
}

add_action( 'wp_head', 'myd_add_settings_sytles', 99 );
