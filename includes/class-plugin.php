<?php

namespace MydPro\Includes;

use License;
use MydPro\Includes\Store_Data;
use MydPro\Includes\Admin\Settings;
use MydPro\Includes\Admin\Custom_Posts;
use MydPro\Includes\Admin\Admin_Page;
use MydPro\Includes\Custom_Fields\Myd_Custom_Fields;
use MydPro\Includes\Custom_Fields\Register_Custom_Fields;
use MydPro\Includes\Widgets\Register_Elementor_Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Plugin main class
 *
 * @since 1.9.6
 */
final class Plugin {

	/**
	 * Store data
	 *
	 * @since 1.9.6
	 *
	 * TODO: change to protected and create method to get
	 */
	public $store_data;

	/**
	 * License
	 *
	 * @since 1.9.6
	 *
	 * TODO: change to protected and create method to get
	 */
	public $license;

	/**
	 * License
	 *
	 * @since 1.9.6
	 */
	protected $admin_settings;

	/**
	 * Custom Posts
	 *
	 * @since 1.9.6
	 */
	protected $custom_posts;

	/**
	 * Admin menu pages
	 */
	protected $admin_menu_pages;

	/**
	 * Instance
	 *
	 * @since 1.9.4
	 *
	 * @access private
	 * @static
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.9.4
	 *
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Disable class cloning and throw an error on object clone.
	 *
	 * @access public
	 * @since 1.9.6
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'drope-delivery' ), '1.0' );
	}
	/**
	 * Disable unserializing of the class.
	 *
	 * @access public
	 * @since 1.9.6
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'drope-delivery' ), '1.0' );
	}

	/**
	 * Construct class
	 *
	 * @since 1.2
	 * @return void
	 */
	private function __construct() {
		do_action( 'drope_delivery_init' );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
		register_activation_hook( DRP_PLUGIN_MAIN_FILE, [ $this, 'activation' ] );
		register_deactivation_hook( DRP_PLUGIN_MAIN_FILE, [ $this, 'deactivation' ] );
		add_filter('plugin_row_meta', [ $this, 'custom_links' ], 10, 2);
		add_filter('plugin_action_links_' . DRP_PLUGIN_BASENAME, [ $this, 'link_actions' ], 10, 2);
	}

	/**
	 * Init plugin
	 *
	 * @since 1.9.4
	 */
	public function init() {
		load_plugin_textdomain( 'drope-delivery', false, DRP_PLUGIN_DIRNAME . '/languages' );
		/**
		 * Required files (load classes)
		 */
		$this->set_required_files();

		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_admin_scripts' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frondend_scripts' ] );

		if ( is_admin() ) {
			$this->admin_settings = new Settings();
			add_action( 'admin_init', [ $this->admin_settings, 'register_settings' ] );

			$this->admin_menu_pages = new \Admin_Page();
			add_action( 'admin_menu', [ $this->admin_menu_pages, 'add_admin_pages' ] );
		}

		$this->custom_posts = new Custom_Posts();
		add_action( 'init', [ $this->custom_posts, 'register_custom_posts' ] );

		Store_Data::set_store_data();
		$this->store_data = Store_Data::get_store_data();

		if ( is_admin() ) {
			new Myd_Custom_Fields( Register_Custom_Fields::get_registered_fields() );
		}

		// Create a custom endpoint for the google api
        add_action( 'rest_api_init', function () {
            register_rest_route( 'drope-delivery/v1', '/google-api', array(
                'methods' => 'GET',
                'callback' => array( $this, 'drope_delivery_google_api' ),
            ) );
        } );
	}

	public function drope_delivery_google_api() {
        $destinations = $_GET['destination'];
        $origins = get_option('myd-zip-code-origin');
        $kmPrice = get_option('myd-value-per-kilometer');
        $api_key = get_option('myd-google-maps-api');
		$minPrice = get_option('myd-min-value-per-kilometer');

        $api_url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origins&destinations=$destinations&key=$api_key";

        $response = file_get_contents($api_url);
        $response = json_decode($response, true);
        $response = $response['rows'][0]['elements'][0];

        $response_data = [];

        $meters_distance = $response['distance']['value'];
        $km_distance = $meters_distance / 1000;

		if (($destinations == $origins) || ($km_distance < 1) ){
			$response_data['delivery_fee'] = (float)$minPrice;
		} else {
			$response_data['delivery_fee'] = $km_distance * $kmPrice;
		}

        $response_data['status'] = $response['status'];

        return $response_data;
    }

	/**
	 * Load required files
	 *
	 * @since 1.2
	 * @return void
	 */
	public function set_required_files() {
		if ( is_admin() ) {
			include_once DRP_PLUGIN_PATH . 'includes/admin/abstract-class-admin-settings.php';
			include_once DRP_PLUGIN_PATH . 'includes/admin/class-settings.php';
			include_once DRP_PLUGIN_PATH . 'includes/class-reports.php';
		}

		include_once DRP_PLUGIN_PATH . 'includes/legacy/class-legacy-repeater.php';
		include_once DRP_PLUGIN_PATH . 'includes/custom-fields/class-register-custom-fields.php';
		include_once DRP_PLUGIN_PATH . 'includes/custom-fields/class-label.php';
		include_once DRP_PLUGIN_PATH . 'includes/custom-fields/class-custom-fields.php';
		include_once DRP_PLUGIN_PATH . 'includes/class-store-data.php';
		include_once DRP_PLUGIN_PATH . 'includes/admin/class-custom-posts.php';
		include_once DRP_PLUGIN_PATH . 'includes/fdm-products-list.php';
		include_once DRP_PLUGIN_PATH . 'includes/myd-manage-cpt-columns.php';
		include_once DRP_PLUGIN_PATH . 'includes/class-orders-front-panel.php';
		include_once DRP_PLUGIN_PATH . 'includes/fdm-track-order.php';
		include_once DRP_PLUGIN_PATH . 'includes/class-myd-ajax.php';
		include_once DRP_PLUGIN_PATH . 'includes/api.php';
		include_once DRP_PLUGIN_PATH . 'includes/add-templates.php';
		include_once DRP_PLUGIN_PATH . 'includes/set-custom-styles.php';
		include_once DRP_PLUGIN_PATH . 'includes/class-legacy.php';
		include_once DRP_PLUGIN_PATH . 'includes/class-store-orders.php';
		include_once DRP_PLUGIN_PATH . 'includes/class-store-formatting.php';
		include_once DRP_PLUGIN_PATH . 'includes/class-currency.php';
		include_once DRP_PLUGIN_PATH . 'includes/myd-register-widgets.php';
		include_once DRP_PLUGIN_PATH . 'includes/dw-api/dw-api.php';
	}

	/**
	 * Enqueu admin styles/scripts
	 *
	 * @since 1.2
	 * @return void
	 */
	public function enqueue_admin_scripts() {
		wp_register_script( 'myd-admin-scritps', DRP_PLUGN_URL . 'assets/js/admin/admin-scripts.min.js', [], DRP_CURRENT_VERSION, true );
		wp_enqueue_script( 'myd-admin-scritps' );

		wp_register_script( 'myd-admin-cf-media-library', DRP_PLUGN_URL . 'assets/js/admin/custom-fields/media-library.min.js', [], DRP_CURRENT_VERSION, true );
		wp_register_script( 'myd-admin-cf-repeater', DRP_PLUGN_URL . 'assets/js/admin/custom-fields/repeater.min.js', [], DRP_CURRENT_VERSION, true );

		wp_register_style( 'myd-admin-style', DRP_PLUGN_URL . 'assets/css/admin/admin-style.min.css', [], DRP_CURRENT_VERSION );
		wp_enqueue_style( 'myd-admin-style' );

		wp_register_script( 'myd-chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), DRP_CURRENT_VERSION, true );
	}

	/**
	 * Enqueue front end styles/scripts
	 *
	 * @since 1.2
	 * @return void
	 */
	public function enqueue_frondend_scripts() {
		wp_enqueue_script( 'fdm-scripts-front-js', DRP_PLUGN_URL . 'assets/js/scripts.min.js', array( 'jquery' ), time() );
		wp_enqueue_script( 'myd-jquery-mask', DRP_PLUGN_URL . 'assets/lib/js/jquery.mask.js', array( 'jquery' ), DRP_CURRENT_VERSION );

		wp_enqueue_script( 'plugin_pdf', 'https://printjs-4de6.kxcdn.com/print.min.js', array(), DRP_CURRENT_VERSION, true );
		wp_enqueue_style( 'plugin_pdf_css', 'https://printjs-4de6.kxcdn.com/print.min.css', array(), DRP_CURRENT_VERSION, true );

		wp_enqueue_script( 'myd-order-list-ajax', DRP_PLUGN_URL . 'assets/js/order-list-ajax.min.js', array(), DRP_CURRENT_VERSION, true );
		wp_localize_script(
			'myd-order-notification',
			'ajax_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
			)
		);
		wp_enqueue_script( 'myd-order-notification', DRP_PLUGN_URL . 'assets/js/order-notification.min.js', array(), DRP_CURRENT_VERSION, true );
		wp_localize_script(
			'myd-order-notification',
			'order_ajax_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'myd-order-notification' ),
			)
		);

		wp_enqueue_script( 'mercadopago', 'https://sdk.mercadopago.com/js/v2', array(), DRP_CURRENT_VERSION, true );
		wp_enqueue_script( 'copy-clipboard', 'https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js', array(), DRP_CURRENT_VERSION, true );
		wp_enqueue_script( 'myd-create-order', DRP_PLUGN_URL . 'assets/js/create-order.min.js', array(), time(), true );

		$mp_public = get_option('myd-mp-mode') === 'sandbox' ? esc_attr(get_option('myd-mp-sandbox-public')) : esc_attr(get_option('myd-mp-production-public'));

		wp_localize_script(
			'myd-create-order',
			'ajax_object',
			array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'order_nonce' => wp_create_nonce( 'myd-create-order' ),
				'mp_public' => $mp_public,
				'pix_enabled' => checked( get_option('myd-mp-pix'), 'bank_transfer', false) !== '' ? true : false,
				'credito_enabled' => checked( get_option('myd-mp-credito'), 'credit_card' , false) !== '' ? true : false,
				'debito_enabled' => checked( get_option('myd-mp-debito'), 'debit_card', false ) !== '' ? true : false,
				'tempo_expiracao' => get_option('myd-tempo-expiracao', 5)

			)
		);


		wp_enqueue_script( 'myd-essentials', DRP_PLUGN_URL . 'assets/js/essentials.min.js', array(), DRP_CURRENT_VERSION, true );

		wp_enqueue_style( 'myd-delivery-frontend', DRP_PLUGN_URL . 'assets/css/delivery-frontend.min.css', array(), DRP_CURRENT_VERSION );
		wp_enqueue_style( 'myd-order-panel-frontend', DRP_PLUGN_URL . 'assets/css/order-panel-frontend.min.css', array(), DRP_CURRENT_VERSION );
		wp_enqueue_style( 'myd-track-order-frontend', DRP_PLUGN_URL . 'assets/css/track-order-frontend.min.css', array(), DRP_CURRENT_VERSION );

		wp_register_script( 'myd-autocomplete-br', DRP_PLUGN_URL . 'assets/js/autocomplete-br.min.js', array( 'jquery' ), DRP_CURRENT_VERSION, true );
		wp_enqueue_script( 'myd-autocomplete-br' );

		if ( ! get_option( 'fdm-business-country' ) === 'Brazil' ) {
			wp_dequeue_script( 'myd-autocomplete-br' );
		}

		wp_register_script( 'myd-browser-notification', DRP_PLUGN_URL . 'assets/js/browser-notification.min.js', array(), DRP_CURRENT_VERSION, true );

		wp_register_script( 'myd-money-mask', DRP_PLUGN_URL . 'assets/lib/js/jquery-maskmoney.min.js', array( 'jquery' ), DRP_CURRENT_VERSION, true );
		wp_enqueue_script( 'myd-money-mask' );
	}

	/**
	 * Check if plugin is activated
	 *
	 * @since 1.9.4
	 * @return boolean
	 * @param string $plugin
	 */
	public function plugin_is_active( $plugin ) {
		return function_exists( 'is_plugin_active' ) ? is_plugin_active( $plugin ) : in_array( $plugin, (array) get_option( 'active_plugins', array() ), true );
	}

	/**
	 * Activation hook
	 *
	 * @since 1.9.6
	 * @return void
	 */
	public function activation() {

		flush_rewrite_rules();
	}

	/**
	 * Deactivation hook
	 *
	 * @since 1.9.6
	 * @return void
	 */
	public function deactivation() {

		flush_rewrite_rules();
	}

	/**
	 * Custom links
	 *
	 * @since 1.9.6
	 * @return void
	 */
	public function custom_links( $plugin_meta, $plugin_file ) {

		if ( strpos( $plugin_file, 'drope-delivery.php' ) !== false ) {
			$new_links = array(
					'doc' => '<a href="https://docs.bragasistemasdeinformacao.com.br/docs-category/braga-delivery/" target="_blank" style="background:#000;padding:0 5px 2px 5px;color:#fff;border-radius:5px;">Manual de Uso</a>',
					'support' => '<a href="https://bragasistemasdeinformacao.com.br/suporte" target="_blank" style="background:#229EB2;padding:0 5px 2px 5px;color:#fff;border-radius:5px;">Suporte</a>'
					);
			
			$plugin_meta = array_merge( $plugin_meta, $new_links );
		}
		
		return $plugin_meta;
	}

	/**
	 * Link actions
	 *
	 * @since 1.9.6
	 * @return void
	 */
	public function link_actions( $plugin_meta, $plugin_file ) {

		if ( strpos( $plugin_file, 'drope-delivery.php' ) !== false ) {
			$new_links = array(
					'repository' => '<a href="https://bragasistemasdeinformacao.com.br" target="_blank" style="color:#229EB2;font-weight:700;">' . esc_html('Outros plugins', 'plugin-loterias-drope-drope') . '</a>'
					);
			
			$plugin_meta = array_merge( $plugin_meta, $new_links );
		}
		
		return $plugin_meta;
	}
}
