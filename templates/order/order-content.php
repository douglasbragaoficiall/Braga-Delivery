<?php

use MydPro\Includes\Store_Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<?php if ( $orders->have_posts() ) : ?>
	<?php $currency_simbol = Store_Data::get_store_data( 'currency_simbol' ); ?>
	<?php while( $orders->have_posts() ) : ?>
		<?php $orders->the_post(); ?>
		<?php $postid = get_the_ID(); ?>
		<?php $date = get_post_meta( $postid, 'order_date', true ); ?>
		<?php $date = date( 'd/m - H:i', strtotime( $date ) ); ?>
		<?php $status = get_post_meta( $postid, 'order_status', true ); ?>
		<?php $coupon = get_post_meta( $postid, 'order_coupon', true ); ?>
		<?php $method = get_post_meta( $postid, 'order_payment_method', true ) === 'Pagamento Online' ? '&nbsp; &nbsp; &nbsp;<span class="fdm-order-list-items-type">Pagamento Online Efetuado</span>' : esc_html(  get_post_meta( $postid, 'order_payment_method', true ) ); ?>

		<div class="fdm-orders-full-items" id="content-<?php echo esc_attr( $postid ); ?>">
			<div>
				<div class="fdm-orders-items-order">
					<div class="fdm-order-list-items">
						<div class="fdm-order-list-items-type"><?php echo esc_html( get_post_meta( $postid, 'order_ship_method', true ) ); ?></div>
						<div class="fdm-order-list-items-order-number"> <?php esc_html_e( 'Order', 'drope-delivery' ); ?> <?php echo get_the_title( $postid ); ?></div>
						<div class="fdm-order-list-items-date"><?php echo esc_html( $date ); ?></div>

						<hr class="fdm-divider">
						<?php echo $this->get_order_type_data( $postid ); ?>
					</div>
				</div>

				<div class="fdm-orders-items-products">
					<div class="fdm-order-list-items">
						<?php echo $this->get_order_items( $postid ); ?>
						<hr class="fdm-divider">
						<div class="fdm-order-list-items-customer"><?php esc_html_e( 'Delivery', 'drope-delivery' ); ?> <?php echo esc_html( $currency_simbol ); ?> <?php echo esc_html( get_post_meta( $postid, 'order_delivery_price', true ) ); ?></div>
						<?php if ( ! empty( $coupon ) ) : ?>
							<div class="fdm-order-list-items-customer"><?php esc_html_e( 'Coupon code', 'drope-delivery' ); ?>: <?php echo esc_html( $coupon ); ?></div>
						<?php endif; ?>
						<div class="fdm-order-list-items-customer-name"><?php esc_html_e( 'Total', 'drope-delivery'); ?> <?php echo esc_html( $currency_simbol ); ?> <?php echo esc_html( get_post_meta( $postid, 'order_total', true ) ); ?></div>
						<div class="fdm-order-list-items-customer"><?php esc_html_e( 'Payment Method', 'drope-delivery' ); ?> <?php echo $method; ?></div>
						<div class="fdm-order-list-items-customer"><?php echo esc_html( get_post_meta( $postid, 'order_notes', true ) ); ?></div>
					</div>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
