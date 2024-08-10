<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register elementor widget
 *
 * @since 1.0.0
 * @return void
 */
function drope_delivery_elementor_widget( $elements_manager ) {
	$elements_manager->add_category(
		'plugin-rifa-category',
		[
			'title' => esc_html__( 'DROPE Delivery', 'drope-delivery' ),
			'icon' => 'fa fa-plug',
		]
	);
}

add_action( 'elementor/elements/categories_registered', 'drope_delivery_elementor_widget' );

/**
 * Register elementor widget
 *
 * @since 1.0.0
 * @return void
 */

function drope_delivery_elementor( $widgets_manager ) {
	include_once DRP_PLUGIN_PATH . 'includes/widgets/class-widget-delivery-page.php';
	$widgets_manager->register( new \Widget_Delivery_Page() );
}

add_action( 'elementor/widgets/register', 'drope_delivery_elementor' );