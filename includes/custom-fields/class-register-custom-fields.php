<?php

namespace MydPro\Includes\Custom_Fields;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Custom Fields Class.
 * TODO: Refactor.
 * @since 1.9.31
 */
class Register_Custom_Fields {
	/**
	 * Registered fields
	 *
	 * @var array
	 */
	public static $myd_fields = array();

	/**
	 * Get registered fields
	 *
	 * @return array
	 */
	public static function get_registered_fields() {
		if ( ! empty( self::$myd_fields ) ) {
			return self::$myd_fields;
		}

		self::set_custom_fields();
		return self::$myd_fields;
	}

	/**
	 * Set custom fields
	 *
	 * @return void
	 */
	public static function set_custom_fields() {
		/**
		 * Coupon fields
		 *
		 * @since 1.9.5
		 */
		self::$myd_fields['myd_coupons_options'] = [
			'id' => 'myd_coupons_options',
			'name' => __( 'Coupons info', 'drope-delivery' ),
			'screens' => 'mydelivery-coupons',
			'fields' => [
				'myd_coupon_type' => [
					'type' => 'select',
					'label' => __( 'What the coupon type?', 'drope-delivery' ),
					'id' => 'myd_coupon_type',
					'name' => 'myd_coupon_type',
					'custom_class' => '',
					'required' => true,
					'select_options' => [
						'discount-total' => __( 'Total discount', 'drope-delivery' ),
						'discount-delivery' => __( 'Delivery discount', 'drope-delivery' )
					]
				],
				'myd_discount_format' => [
					'type' => 'select',
					'label' => __( 'Discount format' , 'drope-delivery' ),
					'id' => 'myd_discount_format',
					'name' => 'myd_discount_format',
					'custom_class' => '',
					'required' => true,
					'select_options' => [
						'amount' => __( 'Amount discount ($)', 'drope-delivery' ),
						'percent' => __( 'Percent discount (%)', 'drope-delivery' )
					]
				],
				'myd_discount_value' => [
					'type' => 'number',
					'label' => __( 'Discount value', 'drope-delivery' ),
					'id' => 'myd_discount_value',
					'name' => 'myd_discount_value',
					'custom_class' => '',
					'min' => 0,
					'max' => '',
					'required' => true
				],
				'myd_coupont_description' => [
					'type' => 'textarea',
					'label' => __( 'Coupon Description', 'drope-delivery' ),
					'id' => 'myd_coupon_description',
					'name' => 'myd_coupon_description',
					'custom_class' => '',
					'required' => false
				]
			]
		];

		/**
		 * Products fields
		 *
		 * @since 1.9.5
		 */
		$category_options = array();
		$categories = \get_option( 'fdm-list-menu-categories' );
		$categories = explode( ',', $categories );
		$categories = array_map( 'trim', $categories );

		if ( is_array( $categories ) ) {
			foreach ( $categories as $category ) {
				$category_options[ $category ] = $category;
			}
		}

		self::$myd_fields['myd_product_options'] = [
			'id' => 'myd_product_options',
			'name' => __( 'Product Info', 'drope-delivery' ),
			'screens' => 'mydelivery-produtos',
			'fields' => [
				'myd_product_image' => [
					'type' => 'image',
					'label' => __( 'Image', 'drope-delivery' ),
					'id' => 'myd_product_image',
					'name' => 'product_image',
					'custom_class' => '',
					'required' => true,
				],
				'myd_product_available' => [
					'type' => 'select',
					'label' => __( 'Available?', 'drope-delivery' ),
					'id' => 'myd_product_available',
					'name' => 'product_available',
					'custom_class' => '',
					'required' => true,
					'value' => 'show',
					'select_options' => [
						'show' => __( 'Yes, show the product', 'drope-delivery' ),
						'hide' => __( 'No, hide the product', 'drope-delivery' ),
						'not-available' => __( 'Show as not available', 'drope-delivery' ),
					],
				],
				'myd_product_category' => [
					'type' => 'select',
					'label' => __( 'Category', 'drope-delivery' ),
					'id' => 'myd_product_category',
					'name' => 'product_type',
					'custom_class' => '',
					'required' => true,
					'select_options' => $category_options,
				],
				/*
				** Controle de estoque
				*/
				'myd_product_stock_active' => [
					'type' => 'select',
					'label' => __( 'Control stock?', 'drope-delivery' ),
					'id' => 'myd_product_stock_active',
					'name' => 'product_stock_active',
					'custom_class' => '',
					'required' => true,
					'value' => 'false',
					'select_options' => [
						'true' => __( 'Sim', 'drope-delivery' ),
						'false' => __( 'Não', 'drope-delivery' ),
					],
				],
				'myd_product_stock' => [
					'type' => 'number',
					'label' => __( 'Stock', 'drope-delivery' ),
					'id' => 'myd_product_stock',
					'name' => 'product_stock',
					'custom_class' => '',
					'required' => false
				],
				'myd_discount_value' => [
					'type' => 'number',
					'label' => __( 'Price', 'drope-delivery' ),
					'id' => 'myd_product_price',
					'name' => 'product_price',
					'custom_class' => '',
					'required' => true,
				],
				'myd_product_price_label' => [
					'type' => 'select',
					'label' => __( 'Price label', 'drope-delivery' ),
					'id' => 'myd_product_price_label',
					'name' => 'product_price_label',
					'value' => 'show',
					'required' => true,
					'select_options' => [
						'show' => __( 'Show the price', 'drope-delivery' ),
						'hide' => __( 'Hide the price', 'drope-delivery' ),
						'from' => __( 'Show as "From {{product price}}"', 'drope-delivery' ),
						'consult' => __( 'Show as "By Consult"', 'drope-delivery' ),
					],
				],
				'myd_product_description' => [
					'type' => 'textarea',
					'label' => __( 'Description', 'drope-delivery' ),
					'id' => 'myd_product_description',
					'name' => 'product_description',
					'custom_class' => '',
					'required' => false,
				],
			]
		];

		self::$myd_fields['myd_product_extras'] = [
			'id' => 'myd_product_extras',
			'name' => __( 'Product Extras', 'drope-delivery' ),
			'screens' => 'mydelivery-produtos',
			'wrapper' => 'wide',
			'fields' => [
				'myd_product_extras' => [
					'type' => 'repeater',
					'label' => __( 'Extras', 'drope-delivery' ),
					'id' => 'myd_product_extras',
					'name' => 'myd_product_extras',
					'legacy' => 'product_extras',
					'custom_class' => '',
					'fields' => [
						[
							'type' => 'select',
							'label' => __( 'Available?', 'drope-delivery' ),
							'id' => 'myd_product_extra_available',
							'name' => 'extra_available',
							'custom_class' => '',
							'required' => true,
							'value' => 'show',
							'default_value' => 'show',
							'select_options' => [
								'show' => __( 'Yes, show the product extra', 'drope-delivery' ),
								'hide' => __( 'No, hide the product extra', 'drope-delivery' ),
								'not-available' => __( 'Show as not available', 'drope-delivery' ),
							],
						],
						[
							'type' => 'text',
							'label' => __( 'Title', 'drope-delivery' ),
							'id' => 'myd_product_extras_title',
							'name' => 'extra_title',
							'legacy' => 'extra_title',
						],
						[
							'type' => 'number',
							'label' => __( 'Limit min.', 'drope-delivery' ),
							'id' => 'myd_product_extras_min_limit',
							'name' => 'extra_min_limit',
							'custom_class' => 'myd-input-size-10',
							'min' => 1,
						],
						[
							'type' => 'number',
							'label' => __( 'Limit max.', 'drope-delivery' ),
							'id' => 'myd_product_extras_limit',
							'name' => 'extra_max_limit',
							'legacy' => 'product_extra_limit_how_many',
							'custom_class' => 'myd-input-size-10',
						],
						[
							'type' => 'checkbox',
							'label' => __( 'Required?', 'drope-delivery' ),
							'id' => 'myd_product_extras_required',
							'name' => 'extra_required',
							'legacy' => 'extra_required',
							'custom_class' => 'myd-input-size-10',
						],
						[
							'type' => 'repeater',
							'label' => __( 'Options', 'drope-delivery' ),
							'id' => 'myd_options_extras',
							'name' => 'myd_extra_options',
							'legacy' => 'extra_option',
							'repeater_type' => 'internal',
							'custom_class' => '',
							'fields' => [
								[
									'type' => 'select',
									'label' => __( 'Available?', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_available',
									'name' => 'extra_option_available',
									'custom_class' => '',
									'required' => true,
									'value' => 'show',
									'default_value' => 'show',
									'select_options' => [
										'show' => __( 'Yes, show the product extra option', 'drope-delivery' ),
										'hide' => __( 'No, hide the product extra option', 'drope-delivery' ),
										'not-available' => __( 'Show as not available', 'drope-delivery' ),
									],
								],
								[
									'type' => 'text',
									'label' => __( 'Extra name', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_name',
									'name' => 'extra_option_name',
									'legacy' => 'extra_name',
									'custom_class' => ' myd-input-size-75',
								],
								[
									'type' => 'number',
									'label' => __( 'Extra Price', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_price',
									'name' => 'extra_option_price',
									'legacy' => 'extra_price',
									'custom_class' => 'myd-input-size-20',
								],
								[
									'type' => 'textarea',
									'label' => __( 'Extra Description', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_description',
									'name' => 'extra_option_description',
									'legacy' => 'extra_description',
									'custom_class' => '',
								],
							]
						],
					],
				],
			]
		];

		self::$myd_fields['myd_global_extras'] = [
			'id' => 'myd_global_extras',
			'name' => __( 'Extras Globais', 'drope-delivery' ),
			'screens' => 'mydelivery-gextras',
			'wrapper' => 'wide',
			'fields' => [
				'myd_global_extras' => [
					'type' => 'repeater',
					'label' => __( 'Extras Globais', 'drope-delivery' ),
					'id' => 'myd_global_extras',
					'name' => 'myd_global_extras',
					'legacy' => 'global_extras',
					'custom_class' => '',
					'fields' => [
						[
							'type' => 'select',
							'label' => __( 'Available?', 'drope-delivery' ),
							'id' => 'myd_product_extra_available',
							'name' => 'extra_available',
							'custom_class' => '',
							'required' => true,
							'value' => 'show',
							'default_value' => 'show',
							'select_options' => [
								'show' => __( 'Yes, show the global extra', 'drope-delivery' ),
								'hide' => __( 'No, hide the global extra', 'drope-delivery' ),
								'not-available' => __( 'Show as not available', 'drope-delivery' ),
							],
						],
						[
							'type' => 'text',
							'label' => __( 'Title', 'drope-delivery' ),
							'id' => 'myd_global_extras_title',
							'name' => 'extra_title',
							'legacy' => 'extra_title',
						],
						[
							'type' => 'select',
							'label' => __( 'Categoria', 'drope-delivery' ),
							'id' => 'myd_global_extras_cat',
							'name' => 'extra_cat',
                            'required' => true,
							'value' => 'show',
							'legacy' => 'extra_cat',
                            'select_options' => $category_options,
						],
						[
							'type' => 'number',
							'label' => __( 'Limit min.', 'drope-delivery' ),
							'id' => 'myd_global_extras_min_limit',
							'name' => 'extra_min_limit',
							'custom_class' => 'myd-input-size-10',
							'min' => 1,
						],
						[
							'type' => 'number',
							'label' => __( 'Limit max.', 'drope-delivery' ),
							'id' => 'myd_global_extras_limit',
							'name' => 'extra_max_limit',
							'legacy' => 'product_extra_limit_how_many',
							'custom_class' => 'myd-input-size-10',
						],
						[
							'type' => 'checkbox',
							'label' => __( 'Required?', 'drope-delivery' ),
							'id' => 'myd_global_extras_required',
							'name' => 'extra_required',
							'legacy' => 'extra_required',
							'custom_class' => 'myd-input-size-10',
						],
						[
							'type' => 'repeater',
							'label' => __( 'Options', 'drope-delivery' ),
							'id' => 'myd_options_extras',
							'name' => 'myd_extra_options',
							'legacy' => 'extra_option',
							'repeater_type' => 'internal',
							'custom_class' => '',
							'fields' => [
								[
									'type' => 'select',
									'label' => __( 'Available?', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_available',
									'name' => 'extra_option_available',
									'custom_class' => '',
									'required' => true,
									'value' => 'show',
									'default_value' => 'show',
									'select_options' => [
										'show' => __( 'Yes, show the product extra option', 'drope-delivery' ),
										'hide' => __( 'No, hide the product extra option', 'drope-delivery' ),
										'not-available' => __( 'Show as not available', 'drope-delivery' ),
									],
								],
								[
									'type' => 'text',
									'label' => __( 'Extra name', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_name',
									'name' => 'extra_option_name',
									'legacy' => 'extra_name',
									'custom_class' => ' myd-input-size-75',
								],
								[
									'type' => 'number',
									'label' => __( 'Extra Price', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_price',
									'name' => 'extra_option_price',
									'legacy' => 'extra_price',
									'custom_class' => 'myd-input-size-20',
								],
								[
									'type' => 'textarea',
									'label' => __( 'Extra Description', 'drope-delivery' ),
									'id' => 'myd_product_extra_option_description',
									'name' => 'extra_option_description',
									'legacy' => 'extra_description',
									'custom_class' => '',
								],
							]
						],
					],
				],
			]
		];

		/**
		 * Order fields
		 *
		 * @since 1.9.5
		 */
		self::$myd_fields['myd_order_data'] = [
			'id' => 'myd_order_data',
			'name' => __( 'Order Data', 'drope-delivery' ),
			'screens' => 'mydelivery-orders',
			'fields' => [
				'myd_order_status' => [
					'type' => 'select',
					'label' => __( 'Status', 'drope-delivery' ),
					'id' => 'myd_order_status',
					'name' => 'order_status',
					'custom_class' => '',
					'required' => true,
					'select_options' => array(
						'new' => __( 'New', 'drope-delivery' ),
						'confirmed' => __( 'Confirmed', 'drope-delivery' ),
						'done' => __( 'Done', 'drope-delivery' ),
						'waiting' => __( 'Waiting', 'drope-delivery' ),
						'in-delivery' => __( 'In Delivery', 'drope-delivery' ),
						'finished' => __( 'Finished', 'drope-delivery' ),
						'canceled' => __( 'Canceled', 'drope-delivery' ),
					),
				],
				'myd_order_date' => [
					'type' => 'text',
					'label' => __( 'Date', 'drope-delivery' ),
					'id' => 'myd_order_date',
					'name' => 'order_date',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_ship_method' => [
					'type' => 'text',
					'label' => __( 'Type', 'drope-delivery' ),
					'id' => 'myd_order_ship_method',
					'name' => 'order_ship_method',
					'custom_class' => '',
					'required' => true
				],
			]
		];

		self::$myd_fields['myd_order_customer'] = [
			'id' => 'myd_order_customer',
			'name' => __( 'Customer', 'drope-delivery' ),
			'screens' => 'mydelivery-orders',
			'fields' => [
				'myd_order_customer_name' => [
					'type' => 'text',
					'label' => __( 'Full name', 'drope-delivery' ),
					'id' => 'myd_order_customer_name',
					'name' => 'order_customer_name',
					'custom_class' => '',
					'required' => true
				],
				'myd_order_customer_phone' => [
					'type' => 'text',
					'label' => __( 'Phone', 'drope-delivery' ),
					'id' => 'myd_order_customer_phone',
					'name' => 'customer_phone',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_customer_address' => [
					'type' => 'text',
					'label' => __( 'Address', 'drope-delivery' ),
					'id' => 'myd_order_customer_address',
					'name' => 'order_address',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_customer_address_number' => [
					'type' => 'number',
					'label' => __( 'Number', 'drope-delivery' ),
					'id' => 'myd_order_customer_address_number',
					'name' => 'order_address_number',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_customer_address_comp' => [
					'type' => 'text',
					'label' => __( 'Apartment, suite, etc.', 'drope-delivery' ),
					'id' => 'myd_order_customer_address_comp',
					'name' => 'order_address_comp',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_customer_neighborhood' => [
					'type' => 'text',
					'label' => __( 'Neighborhood', 'drope-delivery' ),
					'id' => 'myd_order_customer_neighborhood',
					'name' => 'order_neighborhood',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_customer_order_zipcode' => [
					'type' => 'text',
					'label' => __( 'Zipcode', 'drope-delivery' ),
					'id' => 'myd_order_customer_order_zipcode',
					'name' => 'order_zipcode',
					'custom_class' => '',
					'required' => false
				],
			]
		];

		self::$myd_fields['myd_order_payment'] = [
			'id' => 'myd_order_payment',
			'name' => __( 'Payment', 'drope-delivery' ),
			'screens' => 'mydelivery-orders',
			'fields' => [
				'myd_order_delivery_price' => [
					'type' => 'text',
					'label' => __( 'Delivery Price', 'drope-delivery' ),
					'id' => 'myd_order_delivery_price',
					'name' => 'order_delivery_price',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_coupon' => [
					'type' => 'text',
					'label' => __( 'Coupon code', 'drope-delivery' ),
					'id' => 'myd_order_coupon',
					'name' => 'order_coupon',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_total' => [
					'type' => 'text',
					'label' => __( 'Total', 'drope-delivery' ),
					'id' => 'myd_order_total',
					'name' => 'order_total',
					'custom_class' => '',
					'required' => false
				],
				'myd_order_payment_method' => [
					'type' => 'text',
					'label' => __( 'Payment Method', 'drope-delivery' ),
					'id' => 'myd_order_payment_method',
					'name' => 'order_payment_method',
					'custom_class' => '',
					'required' => false
				],
			]
		];

		self::$myd_fields['myd_order_in_store'] = [
			'id' => 'myd_order_in_store',
			'name' => __( 'Order in Store', 'drope-delivery' ),
			'screens' => 'mydelivery-orders',
			'fields' => [
				'myd_order_table' => [
					'type' => 'number',
					'label' => __( 'Table', 'drope-delivery' ),
					'id' => 'myd_order_table',
					'name' => 'order_table',
					'custom_class' => '',
					'required' => false
				]
			]
		];

		self::$myd_fields['myd_order_note'] = [
			'id' => 'myd_order_note',
			'name' => __( 'Note', 'drope-delivery' ),
			'screens' => 'mydelivery-orders',
			'fields' => [
				'myd_order_notes' => [
					'type' => 'textarea',
					'label' => __( 'Note', 'drope-delivery' ),
					'id' => 'myd_order_notes',
					'name' => 'order_notes',
					'custom_class' => '',
					'required' => false
				]
			]
		];

		/**
		 * TODO: check problem with ID on item. Is important use name and not ID to construct the name of custom field. (main case)
		 */
		self::$myd_fields['myd_order_details'] = [
			'id' => 'myd_order_details',
			'name' => __( 'Order Details', 'drope-delivery' ),
			'screens' => 'mydelivery-orders',
			'wrapper' => 'wide',
			'fields' => [
				'myd_order_details' => [
					'type' => 'repeater',
					'label' => __( 'Order Items', 'drope-delivery' ),
					'id' => 'myd_order_items',
					'name' => 'myd_order_items',
					'legacy' => 'order_items',
					'custom_class' => '',
					'fields' => [
						[
							'type' => 'text',
							'label' => __( 'Product name', 'drope-delivery' ),
							'id' => 'myd_order_product_name',
							'name' => 'product_name',
							'legacy' => 'order_product',
							'custom_class' => 'myd-input-size-100',
						],
						[
							'type' => 'textarea',
							'label' => __( 'Product extras', 'drope-delivery' ),
							'id' => 'myd-order-product-extras',
							'name' => 'product_extras',
							'legacy' => 'order_item_extra',
							'custom_class' => '',
						],
						[
							'type' => 'text',
							'label' => __( 'Product price', 'drope-delivery' ),
							'id' => 'myd-order-product-price',
							'name' => 'product_price',
							'legacy' => 'order_item_price',
							'custom_class' => '',
						],
						[
							'type' => 'textarea',
							'label' => __( 'Item note', 'drope-delivery' ),
							'id' => 'myd-order-product-note',
							'name' => 'product_note',
							'legacy' => 'order_item_note',
							'custom_class' => '',
						],
					],
				],
			],
		];

		/**
		 * Do action before insert custom fields
		 *
		 * @since 1.9.5
		 */
		\do_action( 'myd_before_insert_custom_fields', self::$myd_fields );
	}
}
