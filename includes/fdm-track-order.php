<?php

namespace MydPro\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Track order page
 * TODO: Refactor!!!
 */
class Fdm_Track_Order {
	/**
	 * Construct
	 */
	public function __construct() {
		add_shortcode( 'drope-delivery-track-order', [ $this, 'output_content' ] );
	}

	/**
	 * Output content for shortcode
	 *
	 * @return string
	 */
	public function output_content() {
		if ( empty( $this->get_order_id() ) ) {
			?>
				<div class="fdm-not-logged"><?php esc_html_e( 'Sorry, you don\'t have orders to show.', 'drope-delivery' ); ?></div>
			<?php
		} else {
			?>
			<?php $postid = $this->get_order_id(); ?>
			<?php $currency_simbol = Store_Data::get_store_data( 'currency_simbol' ); ?>
			<?php $date = get_post_meta( $postid, 'order_date', true ); ?>
			<?php $date = date( 'd/m - H:i', strtotime( $date ) ); ?>
			<?php $order_status = $this->get_order_info( 'order_status' ); ?>
			<?php $status_color = $this->get_status_color( $order_status ); ?>
			<?php $coupon = get_post_meta( $postid, 'order_coupon', true ); ?>

			<div class="fdm-track-order-wrap">
				<div class="fdm-track-order-content">
					<div class="fdm-track-order-content-status <?php echo esc_attr( $status_color ); ?>">
						<?php echo esc_html( $this->convert_status_name( $order_status ) ); ?>
					</div>

					<div class="fdm-track-order-content-customer">
					<div class="fdm-order-list-items-type"><?php echo esc_html( $this->get_order_info( 'order_ship_method' ) ); ?></div>
                    <div class="fdm-order-list-items-order-number"><?php echo __( 'Order', 'drope-delivery' ); ?> <?php echo esc_html( $postid ); ?></div>
                    <div class="fdm-order-list-items-date"><?php echo esc_html( $date ); ?></div>
                    <hr class="fdm-divider">

					<?php echo $this->get_order_type_data(); ?>

					</div>
						<div class="fdm-track-order-content-products">
							<?php echo $this->get_order_items( $this->get_order_id() ); ?>
							<hr class="fdm-divider">
							<div class="fdm-order-list-items-customer">
								<?php echo esc_html__( 'Delivery', 'drope-delivery' ); ?>
								<?php echo esc_html( $currency_simbol ); ?> <?php echo $this->get_order_info( 'order_delivery_price' ); ?>
							</div>
							<?php if ( ! empty( $coupon ) ) : ?>
								<div class="fdm-order-list-items-customer">
									<?php esc_html_e( 'Coupon code', 'drope-delivery' ); ?>: <?php echo esc_html( $coupon ); ?>
								</div>
							<?php endif; ?>
                            <div class="fdm-order-list-items-customer-name">
								<?php echo esc_html__( 'Total', 'drope-delivery' ); ?>
								<?php echo esc_html( $currency_simbol ); ?> <?php echo $this->get_order_info('order_total'); ?>
							</div>
                            <div class="fdm-order-list-items-customer">
								<?php echo esc_html__( 'Payment Method', 'drope-delivery' ); ?> <?php echo $this->get_order_info('order_payment_method'); ?>
							</div>
                            <div class="fdm-order-list-items-customer">
								<?php echo esc_html__( 'Note', 'drope-delivery' ); ?> <?php echo $this->get_order_info('order_notes'); ?>
							</div>
						</div>
					</div>
				</div>
			<?php
		}
	}

	/**
	 * Get order type data
	 */
	public function get_order_type_data() {
		$postid = $this->get_order_id();
		$table = get_post_meta( $postid, 'order_table', true );
		$address = get_post_meta( $postid, 'order_address', true );

		if ( ! empty( $table ) ) {
			return '<div class="fdm-order-list-items-customer-name">'.get_post_meta( $postid, 'order_customer_name', true ).'</div>
                    <div class="fdm-order-list-items-customer">'.get_post_meta( $postid, 'customer_phone', true ).'</div>
                    <div class="fdm-order-list-items-customer">'.esc_html__('Table','drope-delivery').' '.get_post_meta( $postid, 'order_table', true ).'</div>';
		}

		if ( ! empty( $address ) ) {
			return '<div class="fdm-order-list-items-customer-name">'.get_post_meta( $postid, 'order_customer_name', true ).'</div>
                    <div class="fdm-order-list-items-customer">'.get_post_meta( $postid, 'customer_phone', true ).'</div>
                    <div class="fdm-order-list-items-customer">'.get_post_meta( $postid, 'order_address', true ).', '.get_post_meta( $postid, 'order_address_number', true ).' | '.get_post_meta( $postid, 'order_address_comp', true ).'</div>
                    <div class="fdm-order-list-items-customer">'.get_post_meta( $postid, 'order_neighborhood', true ).' | '.get_post_meta( $postid, 'order_zipcode', true ).'</div>';
		}

		if ( empty( $address ) and empty( $table ) ) {
			return '<div class="fdm-order-list-items-customer-name">'.get_post_meta( $postid, 'order_customer_name', true ).'</div>
                    <div class="fdm-order-list-items-customer">'.get_post_meta( $postid, 'customer_phone', true ).'</div>';
		}
	}

	/**
	 * Get order id
	 */
	public function get_order_id() {
		if ( ! empty( $_GET['on'] ) ) {
			$parameter = sanitize_text_field( $_GET['on'] );
			return base64_decode( $parameter );
		} else {
			return;
		}
	}

	/**
	 * Get order info
	 */
	public function get_order_info( $meta ) {
		$order_meta = get_post_meta( $this->get_order_id(), $meta, true );

		if ( ! empty( $order_meta ) ) {
			return $order_meta;
		} else {
			return;
		}
	}

	/**
	 * Get currency
	 */
	public function get_option_currency() {
		return ;
	}

	/**
	 * Prepare items
	 */
	public function get_order_items( $postid ) {
		/**
		 * TODO: check this with new model.
		 */
		$items = get_post_meta( $postid, 'myd_order_items', true );
		$currency_simbol = Store_Data::get_store_data( 'currency_simbol' );
		$list = '';

		if ( ! empty( $items ) ) {
			foreach ( $items as $value ) {
				$list .= '<div class="fdm-products-order-loop">';
				$list .= '<div class="fdm-order-list-items-product">' . esc_html( $value['product_name'] ) . '</div>';
				if ( $value['product_extras'] !== '' ) {
					$list .= '<div class="fdm-order-list-items-product-extra">- ' . esc_html( $value['product_extras'] ) . '</div>';
				}

				if ( ! empty( $value['product_note'] ) ) {
					$list .= '<div class="fdm-order-list-items-customer">' . __( 'Note', 'drope-delivery' ) . ' ' . esc_html( $value['product_note'] ) . '</div>';
				}

				$list .= '<div class="fdm-order-list-items-product-extra">' . esc_html( $currency_simbol ) . ' ' . esc_html( $value['product_price'] ) . '</div>';
				$list .= '</div>';
			}
		}

		return $list;
	}

	/**
	 * Check status color
	 *
	 * @return string
	 */
	public function get_status_color( $status ) {
		switch ( $status ) {
    		case 'new':
    			return 'myd-track-order-status--new';
    			break;
    		case 'confirmed':
    			return 'myd-track-order-status--confirmed';
    			break;
    		case 'in-delivery':
    			return 'myd-track-order-status--indelivery';
    			break;
    		case 'finished':
    			return 'myd-track-order-status--finished';
    			break;
    		case 'canceled':
    			return 'myd-track-order-status--canceled';
    			break;
			case 'done':
				return 'myd-track-order-status--done';
				break;
			case 'waiting':
				return 'myd-track-order-status--waiting';
				break;
		}
	}

	/**
	 * Convert order status
	 */
	public function convert_status_name( $status ) {
		switch ( $status ) {
    		case 'new':
    			return esc_html__( 'New', 'drope-delivery' );
    			break;
    		case 'confirmed':
    			return esc_html__( 'Confirmed', 'drope-delivery' );
    			break;
    		case 'in-delivery':
    			return esc_html__( 'In Delivery', 'drope-delivery' );
    			break;
    		case 'finished':
    			return esc_html__( 'Finished', 'drope-delivery' );
    			break;
    		case 'canceled':
    			return esc_html__( 'Canceled', 'drope-delivery' );
    			break;
			case 'done':
				return esc_html__( 'Done', 'drope-delivery' );
				break;
			case 'waiting':
				return esc_html__( 'Waiting', 'drope-delivery' );
				break;
		}
	}
}

new Fdm_Track_Order();
