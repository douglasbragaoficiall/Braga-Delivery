<?php

namespace MydPro\Includes\Admin;

use MydPro\Includes\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Custom_Posts {
	/**
	 * Custom posts
	 * 
	 * @since 1.9.6
	 */
	protected $custom_posts;

	/**
	 * License status
	 * 
	 * @since 1.9.6
	 */
	protected $license;

	/**
	 * Construct the class
	 * 
	 * @since 1.9.6
	 */
	public function __construct() {
		$this->license = Plugin::instance()->license;

		$this->custom_posts = [
			'mydelivery-produtos' => [
				'condition' => true,
				'args' => [
					'label' => __('MyDelivery Products', 'drope-delivery'),
					'labels' => [
						'name' => __('Products', 'drope-delivery'),
						'singular_name' => __('Products', 'drope-delivery'),
						'menu_name' => __('Products', 'drope-delivery'),
						'all_items' => __('Products', 'drope-delivery'),
						'add_new' => __('Add product', 'drope-delivery'),
						'add_new_item' => __('Add product', 'drope-delivery'),
						'edit_item' => __('Edit product', 'drope-delivery'),
						'new_item' => __('New product', 'drope-delivery'),
						'view_item' => __('View product', 'drope-delivery'),
						'view_items' => __('View products', 'drope-delivery'),
						'search_items' => __('Search products', 'drope-delivery')
					],
					'description' => 'Plugin MyD Delivery products menu.',
					'public' => true,
					'publicly_queryable' => false,
					'show_ui' => true,
					'delete_with_user' => false,
					'show_in_rest' => true,
					'rest_base' => '',
					'rest_controller_class' => 'WP_REST_Posts_Controller',
					'has_archive' => false,
					'show_in_menu' => 'drope-delivery-dashboard',
					'show_in_nav_menus' => true,
					'exclude_from_search' => false,
					'capability_type' => 'post',
					'map_meta_cap' => true,
					'hierarchical' => false,
					'rewrite' => [
						'slug' => 'mydelivery-produtos',
						'with_front' => true
					],
					'query_var' => true,
					'supports' => [
						'title'
					]
				]
			],

            'mydelivery-gextras' => [
                'condition' => true,
                'args' => [
                    'label' => __('DROPE Delivery Global Extras', 'drope-delivery'),
                    'labels' => [
                        'name' => __('Global Extras', 'drope-delivery'),
                        'singular_name' => __('Global Extras', 'drope-delivery'),
                        'menu_name' => __('Global Extras', 'drope-delivery'),
                        'all_items' => __('Global Extras', 'drope-delivery'),
                        'add_new' => __('Add Global Extra', 'drope-delivery'),
                        'add_new_item' => __('Add Global Extra', 'drope-delivery'),
                        'edit_item' => __('Edit Global Extra', 'drope-delivery'),
                        'new_item' => __('New Global Extra', 'drope-delivery'),
                        'view_item' => __('View Global Extra', 'drope-delivery'),
                        'view_items' => __('View Global Extras', 'drope-delivery'),
                        'search_items' => __('Search Global Extras', 'drope-delivery')
                    ],
                    'description' => 'Plugin DROPE Delivery Extras Globais menu.',
                    'public' => true,
                    'publicly_queryable' => false,
                    'show_ui' => true,
                    'delete_with_user' => false,
                    'show_in_rest' => true,
                    'rest_base' => '',
                    'rest_controller_class' => 'WP_REST_Posts_Controller',
                    'has_archive' => false,
                    'show_in_menu' => 'drope-delivery-dashboard',
                    'show_in_nav_menus' => true,
                    'exclude_from_search' => false,
                    'capability_type' => 'post',
                    'map_meta_cap' => true,
                    'hierarchical' => false,
                    'rewrite' => [
                        'slug' => 'mydelivery-gextras',
                        'with_front' => true
                    ],
                    'query_var' => true,
                    'supports' => [
                        'title'
                    ]
                ]
            ],
			'mydelivery-orders' => [
				'condition' => true,
				'args' => [
					'label' => __('MyDelivery Orders', 'drope-delivery'),
					'labels' => [
						'name' => __('Orders', 'drope-delivery'),
						'singular_name' => __('Order', 'drope-delivery'),
						'menu_name' => __('Orders', 'drope-delivery'),
						'all_items' => __('Orders', 'drope-delivery'),
						'add_new' => __('Add order', 'drope-delivery'),
						'add_new_item' => __('Add order', 'drope-delivery'),
						'edit_item' => __('Edit order', 'drope-delivery'),
						'new_item' => __('New order', 'drope-delivery'),
						'view_item' => __('View order', 'drope-delivery'),
						'view_items' => __('View orders', 'drope-delivery'),
						'search_items' => __('Search orders', 'drope-delivery'),
					],
					'description' => 'Plugin MyDelivery orders menu.',
					'public' => true,
					'publicly_queryable' => false,
					'show_ui' => true,
					'delete_with_user' => false,
					'show_in_rest' => true,
					'rest_base' => '',
					'rest_controller_class' => 'WP_REST_Posts_Controller',
					'has_archive' => false,
					'show_in_menu' => 'drope-delivery-dashboard',
					'show_in_nav_menus' => true,
					'exclude_from_search' => false,
					'capability_type' => 'post',
					'map_meta_cap' => true,
					'hierarchical' => false,
					'rewrite' => [
						'slug' => 'mydelivery-orders',
						'with_front' => true
					],
					'query_var' => true,
					'supports' => [
						'title'
					]
				]
			],
			'mydelivery-coupons' => [
				'condition' => true,
				'args' => [
					'label' => __('MyDelivery Coupons', 'drope-delivery'),
					'labels' => [
						'name' => __('Coupons', 'drope-delivery'),
						'singular_name' => __('Coupons', 'drope-delivery'),
						'menu_name' => __('Coupons', 'drope-delivery'),
						'all_items' => __('Coupons', 'drope-delivery'),
						'add_new' => __('Add coupon', 'drope-delivery'),
						'add_new_item' => __('Add coupon', 'drope-delivery'),
						'edit_item' => __('Edit coupon', 'drope-delivery'),
						'new_item' => __('New coupon', 'drope-delivery'),
						'view_item' => __('View coupon', 'drope-delivery'),
						'view_items' => __('View coupons', 'drope-delivery'),
						'search_items' => __('Search coupons', 'drope-delivery'),
					],
					'description' => 'Coupons for MyD Delivery',
					'public' => true,
					'publicly_queryable' => false,
					'show_ui' => true,
					'delete_with_user' => false,
					'show_in_rest' => true,
					'rest_base' => '',
					'rest_controller_class' => 'WP_REST_Posts_Controller',
					'has_archive' => false,
					'show_in_menu' => 'drope-delivery-dashboard',
					'show_in_nav_menus' => true,
					'exclude_from_search' => false,
					'capability_type' => 'post',
					'map_meta_cap' => true,
					'hierarchical' => false,
					'rewrite' => [
						'slug' => 'mydelivery-coupons',
						'with_front' => true
					],
					'query_var' => true,
					'supports' => [
						'title'
					]
				]
			]
		];
	}

	/**
	 * Register custom posts
	 * 
	 * @since 1.9.6
	 */
	public function register_custom_posts() {
		$custom_posts = apply_filters( 'mydp_before_regigster_custom_posts', $this->custom_posts );

		foreach ( $custom_posts as $custom_post => $options ) {
			if ( $options['condition'] === false || $options['condition'] === true ) {
				register_post_type( $custom_post, $options['args'] );
			}
		}
	}
}
