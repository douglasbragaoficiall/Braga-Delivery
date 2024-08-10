<?php

namespace MydPro\Includes\Admin;

/**
 * Uma class para implementar todos os methods (settings) que eu tenho passando eles por um objects e filtro.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to register plugin admin settings
 *
 * @since 1.9.6
 */
class Settings extends Admin_Settings {
	/**
	 * Config group
	 *
	 * @since 1.9.6
	 */
	private const CONFIG_GROUP = 'fmd-settings-group';

	/**
	 * License group
	 *
	 * @since 1.9.6
	 */
	private const LICENSE_GROUP = 'fmd-license-group';

	/**
	 * Construct the class
	 *
	 * @since 1.9.6
	 */
	public function __construct() {

		$this->settings = [
			[
				'name' => 'myd-currency',
				'option_group' => self::CONFIG_GROUP,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				],
			],
            [
                'name' => 'fdm-payment-type',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-business-name',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-business-country',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-mask-phone',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-estimate-time-delivery',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ],
            [
                'name' => 'fdm-list-menu-categories',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-payment-in-cash',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-principal-color',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '#ea1d2b'
                ]
            ],
            [
                'name' => 'myd-price-color',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-number-decimal',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'intval',
                    'default' => '2'
                ]
            ],
            [
                'name' => 'fdm-decimal-separator',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ','
                ]
            ],
            [
                'name' => 'fdm-page-order-track',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-print-size',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-print-font-size',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-option-header-print',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-operation-mode-delivery',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'delivery'
                ]
            ],
            [
                'name' => 'myd-operation-mode-take-away',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-operation-mode-in-store',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-products-list-columns',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'myd-product-list--2columns'
                ]
            ],
            [
                'name' => 'myd-products-list-boxshadow',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'myd-product-item--boxshadow'
                ]
            ],
            [
                'name' => 'myd-form-hide-zipcode',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-form-hide-address-number',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-option-minimum-price',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-option-redirect-whatsapp',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-delivery-time',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'default' => [ 'initial' ] //TODO: sanitize custom array
                ]
            ],
            [
                'name' => 'myd-delivery-mode',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-delivery-mode-options',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'default' => [ 'initial' ] //TODO: sanitize custom array
                ]
            ],
            [
                'name' => 'myd-business-mail',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-business-whatsapp',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'fdm-license',
                'option_group' => self::LICENSE_GROUP,
                'args' => []
            ],
            [
				'name' => 'myd-delivery-force-open-close-store',
				'option_group' => self::CONFIG_GROUP,
				'args' => [],
			],

            /// MercadoPago
            
            [
                'name' => 'myd-mp-mode',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'sandbox'
                ]
            ],
            [
                'name' => 'myd-mp-sandbox-tk',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],
            [
                'name' => 'myd-mp-sandbox-public',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],
            [
                'name' => 'myd-mp-production-tk',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'myd-mp-production-public',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'myd-mp-pix',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'bank_transfer'
                ]
            ],

            [
                'name' => 'myd-mp-credito',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'credit_card'
                ]
            ],

            [
                'name' => 'myd-mp-debito',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => 'debit_card'
                ]
            ],

            [
                'name' => 'myd-tempo-expiracao',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => '5'
                ]
            ],

            //DROPE Delivery

            [
                'name' => 'fdm-whatsapp-enable',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-token',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-number',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-page-tracker',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-new',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-confirmed',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-done',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-waiting',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-in-delivery',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-finished',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            [
                'name' => 'fdm-whatsapp-canceled',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                    'default' => ''
                ]
            ],

            //Message for order WhatsApp Button

            [
                'name' => 'drope-message-whatsapp-button',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => '',
                    'default' => ''
                ]
            ],

            //Show stock

            [
                'name' => 'myd-form-hide-stock',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],

            //Google Maps API

            [
                'name' => 'myd-google-maps-api',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field'
                ]
            ],
            [
                'name' => 'myd-zip-code-origin',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ],
            [
                'name' => 'myd-value-per-kilometer',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ],
            [
                'name' => 'myd-min-value-per-kilometer',
                'option_group' => self::CONFIG_GROUP,
                'args' => [
                    'sanitize_callback' => 'sanitize_text_field',
                ]
            ],

        ];
    }
}
