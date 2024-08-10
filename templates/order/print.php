<?php

use MydPro\Includes\Store_Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<?php if ( $orders->have_posts() ) : ?>
	<?php $currency_simbol = Store_Data::get_store_data( 'currency_simbol' ); ?>
	<?php while ( $orders->have_posts() ) : ?>
		<?php $orders->the_post(); ?>
		<?php $postid = get_the_ID(); ?>
		<?php $date = get_post_meta( $postid, 'order_date', true ); ?>
		<?php $date = date( 'd/m - H:i', strtotime( $date ) ); ?>
		<?php $coupon = get_post_meta( $postid, 'order_coupon', true ); ?>

		<div class="order-print" id="print-<?php echo esc_attr( $postid ); ?>">
		<?php if (get_option('myd-option-header-print')) { ?>
			<div class="order-header" style="margin-bottom:10px;">
                <div>
                    <img class="custom-logo" src="<?= DRP_CUSTOM_LOGO ?>" />
                </div>
                <p class="fdm-business-name font-bold title"><?=  get_option( 'fdm-business-name' ); ?></p>
                <p class="myd-business-address"><?=  get_option( 'myd-business-mail' ); ?></p>
                <?php
                    $whatsapp = get_option( 'myd-business-whatsapp' );
                    $whatsappPhone = substr($whatsapp, -9);
                    $whatsappDDD = substr($whatsapp, -11, 2);
                    $whatsappFomated = "($whatsappDDD)  $whatsappPhone";
                ?>
                <p class="myd-business-address"><?= $whatsappFomated; ?></p>
            </div>
			<div style="border-top: 1px dashed #000; margin: 5px 0;"></div>
			<?php } ?>
			<div class="order-header"><?php echo esc_html_e( 'Order', 'drope-delivery' ) . ' ' . esc_html( $postid ); ?> | <?php echo esc_html( get_post_meta( $postid, 'order_ship_method', true ) ); ?></div>
			<div style="border-top: 1px dashed #000; margin: 5px 0 10px 0;"></div>
			<div><?php echo esc_html( $date ); ?></div>
			<?php echo $this->get_order_print_type_data( $postid ); ?>
			<div style="border-top: 1px dashed #000; margin: 10px 0;"></div>
			<?php echo $this->get_order_items_print( $postid ); ?>
			<div style="border-top: 1px dashed #000; margin: 10px 0;"></div>
			<div><?php esc_html_e( 'Delivery','drope-delivery'); ?> <?php echo esc_html( $currency_simbol ); ?> <?php echo esc_html( get_post_meta( $postid, 'order_delivery_price', true ) ); ?></div>
			<?php if ( ! empty( $coupon ) ) : ?>
				<div class="fdm-order-list-items-customer"><?php esc_html_e( 'Coupon code', 'drope-delivery' ); ?>: <?php echo esc_html( $coupon ); ?></div>
			<?php endif; ?>
			<div><?php esc_html_e( 'Total', 'drope-delivery' ); ?> <?php echo esc_html( $currency_simbol ); ?> <?php echo esc_html( get_post_meta( $postid, 'order_total', true ) ); ?></div>
			<div><?php esc_html_e( 'Payment Method', 'drope-delivery' ); ?> <?php echo esc_html( get_post_meta( $postid, 'order_payment_method', true ) ); ?></div>
			<div><?php echo esc_html( get_post_meta( $postid, 'order_notes', true ) ); ?></div>
		</div>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
