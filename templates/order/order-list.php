<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if (empty(get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ==')))) : exit; endif;
?>
<?php if ( $orders->have_posts() ) : ?>
	<?php while ( $orders->have_posts() ) : ?>

		<?php $orders->the_post(); ?>

		<?php $postid = get_the_ID(); ?>
		<?php $date = get_post_meta( $postid, 'order_date', true ); ?>
		<?php $date = date( 'd/m - H:i', strtotime( $date ) ); ?>
		<?php $order_status = get_post_meta( $postid, 'order_status', true ); ?>

		<?php switch( $order_status ) :
			case 'new':
				$order_status = __( 'New', 'drope-delivery' );
				$background = '#d0ad02';
				break;
			case 'confirmed':
				$order_status = __( 'Confirmed', 'drope-delivery' );
				$background = '#208e2a';
				break;
			case 'in-delivery':
				$order_status = __( 'In Delivery', 'drope-delivery' );
				$background = '#d8800d';
				break;
			case 'done':
				$order_status = __( 'Done', 'drope-delivery' );
				$background = '#037d91';
				break;
			case 'waiting':
				$order_status = __( 'Waiting', 'drope-delivery' );
				$background = '#4e6585';
				break;
			endswitch; ?>

		<div class="fdm-orders-items" id="<?php echo esc_attr( $postid ); ?>">
			<div class="fdm-orders-items-left">
				<div class="fdm-order-list-items-order-number"><?php esc_html_e( 'Order', 'drope-delivery' ); ?> <?php echo get_the_title( $postid ); ?></div>
				<div class="fdm-order-list-items-date"><?php echo esc_html( $date ); ?></div>
				<div class="fdm-order-list-items-customer"><?php echo esc_html( get_post_meta( $postid, 'order_customer_name', true ) ); ?></div>
				<div class="fdm-order-list-items-customer"><?php echo esc_html( get_post_meta( $postid, 'customer_phone', true ) ); ?></div>
			</div>

			<div class="fdm-orders-items-right">
				<div class="fdm-order-list-items-status" style="background:<?php echo esc_attr( $background ); ?>">
					<?php echo esc_html( $order_status ); ?>
				</div>
			</div>
		</div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
