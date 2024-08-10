<?php

namespace MydPro\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * TODO: refactor the class
 */
class Myd_Orders_Front_Panel {
	/**
	 * Queried orders object
	 *
	 * @var object
	 */
	protected $orders_object;

	/**
	 * Default args
	 *
	 * @var array
	 */
	protected $default_args = [
		'post_type' => 'mydelivery-orders',
		'posts_per_page' => 30,
		'no_found_rows' => true,
		'post_status' => 'publish',
		'meta_query' => [
			'relation' => 'OR',
			[
				'key'     => 'order_status',
				'value'   => 'new',
				'compare' => '=',
			],
			[
				'key'     => 'order_status',
				'value'   => 'confirmed',
				'compare' => '=',
			],
			[
				'key'     => 'order_status',
				'value'   => 'in-delivery',
				'compare' => '=',
			],
			[
				'key'     => 'order_status',
				'value'   => 'done',
				'compare' => '=',
			],
			[
				'key'     => 'order_status',
				'value'   => 'waiting',
				'compare' => '=',
			],
		]
	];

	/**
	 * Construct the class
	 */
	public function __construct () {
		add_shortcode( 'drope-delivery-orders', [ $this, 'show_orders_list'] );
		add_action( 'wp_ajax_reload_orders', [ $this, 'ajax_reload_orders'] );
		add_action( 'wp_ajax_nopriv_reload_orders', [ $this, 'ajax_reload_orders'] );
		add_action( 'wp_ajax_update_orders', [ $this, 'update_orders'] );
		add_action( 'wp_ajax_nopriv_update_orders', [ $this, 'update_orders'] );
		add_action( 'wp_ajax_print_orders', [ $this, 'ajax_print_order'] );
		add_action( 'wp_ajax_nopriv_print_orders', [ $this, 'ajax_print_order'] );
	}

	/**
	 * Output template panel
	 *
	 * TODO: move to new class
	 *
	 * @return void
	 * @since 1.9.5
	 */
	public function show_orders_list () {
		if( is_user_logged_in() && current_user_can( 'edit_posts' ) ) {
			wp_enqueue_script( 'myd-browser-notification' );
			/**
			 * Query orders
			 */
			$orders = new Myd_Store_Orders( $this->default_args );
			$orders = $orders->get_orders_object();
			$this->orders_object = $orders;

			/**
			 * Include templates
			 */
			ob_start();
			include DRP_PLUGIN_PATH . 'templates/order/panel.php';
			return ob_get_clean();
		} else {
			return '<div class="fdm-not-logged">' . __( 'Sorry, you dont have access to this page.', 'drope-delivery' ) . '</div>';
		}
	}

	/**
	 * Loop orders list
	 *
	 * TODO: move to new class
	 *
	 * @return void
	 * @since 1.9.5
	 */
	public function loop_orders_list () {
		$orders = $this->orders_object;

		ob_start();
		include DRP_PLUGIN_PATH . 'templates/order/order-list.php';
		return ob_get_clean();
	}

	/**
	 * Orders content
	 *
	 * TODO: move to new class
	 *
	 * @return void
	 * @since 1.9.5
	 */
	public function loop_orders_full () {
		$orders = $this->orders_object;

		ob_start();
		include DRP_PLUGIN_PATH . 'templates/order/order-content.php';
		return ob_get_clean();
	}

	/**
	 * Orders print
	 *
	 * TODO: move to new class
	 *
	 * @return void
	 * @since 1.9.5
	 */
	public function loop_print_order () {
		$orders = $this->orders_object;

		ob_start();
		include DRP_PLUGIN_PATH . 'templates/order/print.php';
		return ob_get_clean();
	}

	/**
	 * Get data order to show
	 *
	 * @param int $postid
	 * @return void
	 */
	public function get_order_type_data( $postid ) {
		if ( ! empty( get_post_meta( $postid, 'order_ship_method', true ) ) ) {
			$table = get_post_meta( $postid, 'order_table', true );
			$address = get_post_meta( $postid, 'order_address', true );

			if ( ! empty( $table ) ) {
				return '<div class="fdm-order-list-items-customer-name">' . get_post_meta( $postid, 'order_customer_name', true ) . '</div>
                        <div class="fdm-order-list-items-customer">' . get_post_meta( $postid, 'customer_phone', true ) . '</div>
                        <div class="fdm-order-list-items-customer">' . esc_html__( 'Table', 'drope-delivery' ) . ' ' . get_post_meta( $postid, 'order_table', true ) . '</div>';
			}

			if ( ! empty( $address ) ) {
				return '<div class="fdm-order-list-items-customer-name">' . get_post_meta( $postid, 'order_customer_name', true ) . '</div>
                        <div class="fdm-order-list-items-customer">' . get_post_meta( $postid, 'customer_phone', true ) . '</div>
                        <div class="fdm-order-list-items-customer">' . get_post_meta( $postid, 'order_address', true ) . ', ' . get_post_meta( $postid, 'order_address_number', true ) . ' | ' . get_post_meta( $postid, 'order_address_comp', true ) . '</div>
                        <div class="fdm-order-list-items-customer">' . get_post_meta( $postid, 'order_neighborhood', true ) . ' | ' . get_post_meta( $postid, 'order_zipcode', true ) . '</div>';
			}

			if ( empty( $address ) && empty( $table ) ) {
				return '<div class="fdm-order-list-items-customer-name">' . get_post_meta( $postid, 'order_customer_name', true ) . '</div>
                        <div class="fdm-order-list-items-customer">' . get_post_meta( $postid, 'customer_phone', true ) . '</div>';
			}
		}
	}

	/**
	 * Prepare items order
	 *
	 * @param int $postid
	 * @return void
	 *
	 * TODO: check this because get repeater like other items.
	 */
	public function get_order_items( $postid ) {
		$items = get_post_meta( $postid, 'myd_order_items', true );
		$list = '';

		if ( ! empty( $items ) ) {
			foreach ( $items as $value ) {
				$list .= '<div class="fdm-products-order-loop">';
				$list .= '<div class="fdm-order-list-items-product">' . $value['product_name'] . '</div>';

				if ( $value['product_extras'] !== '' ) {
					$list .= '<div class="fdm-order-list-items-product-extra">' . $value['product_extras'] . '</div>';
				}

				if ( ! empty( $value['product_note'] ) ) {
					$list .= '<div class="fdm-order-list-items-customer">' . __( 'Note', 'drope-delivery' ) . ' ' . $value['product_note'] . '</div>';
				}

				$list .= '<div class="fdm-order-list-items-product-extra">' . Store_Data::get_store_data( 'currency_simbol' ) . ' ' . $value['product_price'] . '</div>';

				$list .= '</div>';
			}
		}

		return $list;
	}

	/**
	 * Prepare items to order
	 *
	 * @param int $postid
	 * @return void
	 *
	 * TODO: check this because get repeater like other items.
	 */
	public function get_order_items_print( $postid ) {
		$items = get_post_meta( $postid, 'myd_order_items', true );
		$list = '';

		if ( ! empty( $items ) ) {
			foreach ( $items as $value ) {
				$list .= '<div>';
				$list .= '<div>' . $value['product_name'] . '</div>';

				if ( $value['product_extras'] !== '' ) {
					$list .= '<div style="white-space: pre;">' . $value['product_extras'] . '</div>';
				}

				if ( ! empty( $value['product_note'] ) ) {
					$list .= '<div>' . __( 'Note', 'drope-delivery' ) . ' ' . $value['product_note'] . '</div>';
				}

				$list .= '<div>' . Store_Data::get_store_data( 'currency_simbol' ) . ' ' . $value['product_price'] . '</div>';
				$list .= '</div>';
				$list .= '<div style="margin: 10px 0;"></div>';
			}
		}

		return $list;
	}

	/**
	 * Get data order to show
	 *
	 * @param int $postid
	 * @return void
	 */
	public function get_order_print_type_data( $postid ) {
		if ( ! empty( get_post_meta( $postid, 'order_ship_method', true ) ) ) {
			$table = get_post_meta( $postid, 'order_table', true );
			$address = get_post_meta( $postid, 'order_address', true );

			if ( ! empty( $table ) ) {
				return '<div>' . get_post_meta( $postid, 'order_customer_name', true ) . '</div>
                        <div>' . get_post_meta( $postid, 'customer_phone', true ) . '</div>
                        <div>' . esc_html__( 'Table', 'drope-delivery' ) . ' ' . get_post_meta( $postid, 'order_table', true ) . '</div>';
			}

			if ( ! empty( $address ) ) {
				return '<div>' . get_post_meta( $postid, 'order_customer_name', true ) . '</div>
                        <div>' . get_post_meta( $postid, 'customer_phone', true ) . '</div>
                        <div>' . get_post_meta( $postid, 'order_address', true ) . ', ' . get_post_meta( $postid, 'order_address_number', true ) . ' | ' . get_post_meta( $postid, 'order_address_comp', true ) . '</div>
                        <div>' . get_post_meta( $postid, 'order_neighborhood', true ) . ' | ' . get_post_meta( $postid, 'order_zipcode', true ) . '</div>';
			}

			if ( empty( $address ) && empty( $table ) ) {
				return '<div>' . get_post_meta( $postid, 'order_customer_name', true ) . '</div>
                        <div>' . get_post_meta( $postid, 'customer_phone', true ) . '</div>';
			}
		}
	}

	/**
	 * Count orders
	 *
	 * @return void
	 */
	public function count_orders() {
		$orders = $this->query_orders();
		$orders = $orders->get_posts();

		return count( $orders );
	}

	/**
	 * Ajax class items
	 *
	 * @return void
	 */
	public function ajax_reload_orders() {
		$order_id = sanitize_text_field( $_REQUEST['id'] );
		$order_action = sanitize_text_field( $_REQUEST['order_action'] );
		update_post_meta( $order_id, 'order_status', $order_action );
		if ( empty( $this->orders_object ) ) {
			/**
			 * Query orders
			 */
			$orders = new Myd_Store_Orders( $this->default_args );
			$orders = $orders->get_orders_object();
			$this->orders_object = $orders;
		}

		echo json_encode( array(
			'loop' => $this->loop_orders_list(),
			'full' => $this->loop_orders_full(),
		));

		exit;
	}

	/**
	 * Ajax to reload order after update (new order)
	 *
	 * @return void
	 */
	public function update_orders() {
		$nonce = $_REQUEST['nonce'] ?? null;
		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'myd-order-notification' ) ) {
			die( __( 'Ops! Security check failed.', 'my-delivey-wordpress' ) );
		} else {
			if ( empty( $this->orders_object ) ) {
				/**
				 * Query orders
				 */
				$orders = new Myd_Store_Orders( $this->default_args );
				$orders = $orders->get_orders_object();
				$this->orders_object = $orders;
			}

			echo json_encode( array(
				'loop' => $this->loop_orders_list(),
				'full' => $this->loop_orders_full(),
				'print' => $this->loop_print_order(),
			));

			exit;
		}
	}
}

new Myd_Orders_Front_Panel();
