<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shipping method
 */
$shipping_type = get_option( 'myd-delivery-mode' );
$shipping_options = get_option( 'myd-delivery-mode-options' );
$shipping_options = isset( $shipping_options[ $shipping_type ] ) ? $shipping_options[ $shipping_type ] : '';

// get payment methods options
$payments = get_option( 'fdm-payment-type' );
$payments = explode( ",", $payments );
$payments = array_map( 'trim', $payments );

// coupons
$coupons_args = [
	'post_type' => 'mydelivery-coupons',
	'no_found_rows' => true,
	'post_status' => 'publish',
];

$coupons_list = new \WP_Query( $coupons_args );
$coupons_list = $coupons_list->posts;

if ( ! empty( $coupons_list ) ) {
	foreach ( $coupons_list as $k => $v ) {
		$coupons[ $k ] = [ 'name' => $v->post_title ];
		$coupons[ $k ] = $coupons[ $k ] + [ 'type' => get_post_meta( $v->ID, 'myd_coupon_type', true ) ];
		$coupons[ $k ] = $coupons[ $k ] + [ 'format' => get_post_meta( $v->ID, 'myd_discount_format', true ) ];
		$coupons[ $k ] = $coupons[ $k ] + [ 'value' => get_post_meta( $v->ID, 'myd_discount_value', true ) ];
	}
}

?>
<div class="myd-cart__checkout">
	<div class="myd-cart__checkout-type">

        <div class="myd-cart__checkout-title"><?php esc_html_e( 'Order Type', 'drope-delivery' ); ?></div>

            <div class="myd-cart__checkout-option-wrap">

                <?php if( get_option( 'myd-operation-mode-delivery' ) === 'delivery' ) : ?>

                    <div class="myd-cart__checkout-option myd-cart__checkout-option--active" data-type="delivery" data-content=".myd-cart__checkout-customer, .myd-cart__checkout-delivery">
                        <div class="myd-cart__checkout-option-delivery" data-type="delivery"><?php esc_html_e( 'Delivery', 'drope-delivery' ); ?></div>
                    </div>

                <?php endif; ?>

                <?php if( get_option( 'myd-operation-mode-take-away' ) === 'take-away' ) : ?>

                <div class="myd-cart__checkout-option" data-type="take-away" data-content=".myd-cart__checkout-customer">
                    <div class="myd-cart__checkout-option-order-in-store" data-type="take-away"><?php esc_html_e( 'Take Away', 'drope-delivery' ); ?></div>
                </div>

                <?php endif; ?>

                <?php if( get_option( 'myd-operation-mode-in-store' ) === 'order-in-store' ) : ?>

                    <div class="myd-cart__checkout-option" data-type="order-in-store" data-content=".myd-cart__checkout-customer, .myd-cart__checkout-in-store">
                    <div class="myd-cart__checkout-option-order-in-store" data-type="order-in-store"><?php esc_html_e( 'Order in Store', 'drope-delivery' ); ?></div>
                </div>

                <?php endif; ?>
            </div>
        </div>

    <div class="myd-cart__checkout-customer myd-cart__checkout-field-group--active">

        <div class="myd-cart__checkout-title"><?php esc_html_e( 'Customer Info', 'drope-delivery' ); ?></div>

        <label class="myd-cart__checkout-label" for="input-customer-name"><?php esc_html_e( 'Name', 'drope-delivery' ); ?></label>
        <input type="text" class="myd-cart__checkout-input" id="input-customer-name" name="input-customer-name" required>

        <label class="myd-cart__checkout-label" for="input-customer-phone"><?php esc_html_e( 'Phone', 'drope-delivery' ); ?></label>
        <input type="text" class="myd-cart__checkout-input <?php echo get_option( 'fdm-mask-phone' ); ?>" id="input-customer-phone" name="input-customer-phone" required>

    </div>

    <div class="myd-cart__checkout-delivery myd-cart__checkout-field-group--active">

        <div class="myd-cart__checkout-title"><?php esc_html_e( 'Delivery Info', 'drope-delivery' ); ?></div>

        <?php if( get_option( 'myd-form-hide-zipcode' ) != 'yes' ) : ?>
            <label class="myd-cart__checkout-label" for="input-delivery-zipcode"><?php esc_html_e( 'Zipcode', 'drope-delivery' ); ?></label>
            <input type="text" class="myd-cart__checkout-input" id="input-delivery-zipcode" name="input-delivery-zipcode" autocomplete="none" required>
        <?php endif; ?>

        <label class="myd-cart__checkout-label" for="input-delivery-street-name"><?php esc_html_e( 'Street Name', 'drope-delivery' ); ?></label>
        <input type="text"class="myd-cart__checkout-input" id="input-delivery-street-name" name="input-delivery-street-name" required>

        <?php if( get_option( 'myd-form-hide-address-number' ) != 'yes' ) : ?>
            <label class="myd-cart__checkout-label" for="input-delivery-address-number"><?php esc_html_e( 'Address Number', 'drope-delivery' ); ?></label>
            <input type="number" class="myd-cart__checkout-input" id="input-delivery-address-number" name="input-delivery-address-number" required>
        <?php endif; ?>

        <label class="myd-cart__checkout-label" for="input-delivery-comp"><?php esc_html_e( 'Apartment, suite, etc.', 'drope-delivery' ); ?></label>
        <input type="text" class="myd-cart__checkout-input" id="input-delivery-comp" name="input-delivery-comp">

        <?php if( get_option( 'fdm-business-country' ) == 'Brazil' && $shipping_type == 'per-cep-range' || $shipping_type == 'fixed-per-cep' ) : ?>
            <label class="myd-cart__checkout-label" for="input-delivery-neighborhood"><?php esc_html_e( 'Neighborhood', 'drope-delivery' ); ?></label>
            <input type="text" class="myd-cart__checkout-input" id="input-delivery-neighborhood" name="input-delivery-neighborhood" required>
        <?php endif; ?>

        <?php if( $shipping_type == 'fixed-per-neighborhood' || $shipping_type == 'per-neighborhood' ) : ?>
            <label class="myd-cart__checkout-label" for="input-delivery-neighborhood"><?php esc_html_e( 'Neighborhood', 'drope-delivery' ); ?></label>
            <select class="" id="input-delivery-neighborhood" name="input-delivery-neighborhood" required>
                <option value=""><?php esc_html_e( 'Select', 'drope-delivery' ); ?></option>
                <?php if( isset( $shipping_options['options'] ) ) :
                    foreach( $shipping_options['options'] as $k => $v ) : ?>
                        <option value="<?php echo esc_attr( $v['from'] ); ?>"><?php echo esc_html( $v['from'] ); ?></option>
                    <?php endforeach;
                endif; ?>
            </select>
        <?php endif; ?>
    </div>

	<div class="myd-cart__checkout-in-store">
		<div class="myd-cart__checkout-title"><?php esc_html_e( 'Store Info', 'drope-delivery' ); ?></div>
		<label class="myd-cart__checkout-label" for="input-in-store-table"><?php esc_html_e( 'Table number', 'drope-delivery' ); ?></label>
		<input type="text" class="myd-cart__checkout-input" id="input-in-store-table" name="input-in-store-table">
	</div>

	<div class="myd-cart__checkout-coupon">
		<label class="myd-cart__checkout-label" for="input-checkout-coupon"><?php esc_html_e( 'Coupon', 'drope-delivery' ); ?></label>
		<input type="text" class="myd-cart__checkout-input" id="input-coupon" name="input-checkout-coupon">
		<p><?php esc_html_e( 'If you have a discount coupon, add it here.', 'drope-delivery' ); ?></p>

		<?php if ( ! empty( $coupons ) ) : ?>
			<div class="myd-cart__coupons-obj" id="myd-cart__coupons-obj">
				<?php echo json_encode( $coupons ); ?>
			</div>
		<?php endif; ?>
	</div>
</div>
