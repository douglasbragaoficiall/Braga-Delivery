<?php

use MydPro\Includes\Fdm_svg;
use MydPro\Includes\Store_Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

//if (empty(get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ==')))) : exit; endif;

$product_category = isset( $args['product_category'] ) && $args['product_category'] !== 'all' ? array( $args['product_category'] ) : array();

?>
<div class="myd-popup-notification" id="myd-popup-notification">
					<div class="myd-popup-notification__message" id="myd-popup-notification__message"></div>
				</div>
<div class="container-div">
	<?php if ( Store_Data::$template_dependencies_loaded === false ) : ?>
		<div class="sticky-div">
			<section class="my-delivery-wrap" style="padding:0;">
				<div class="fdm-lightbox-image myd-hide-element" id="myd-image-preview-popup">
					<div class="fdm-lightbox-image-close" id="myd-image-preview-popup-close">
						<?php echo Fdm_svg::svg_close(); ?>
					</div>
					<div class="fdm-lightbox-image-link" id="myd-image-preview-wrapper">
						<img id="myd-image-preview-image" src="">
					</div>
				</div>

				<div class="myd-content">
					<?php if ( ! isset( $args['filter_type'] ) || isset( $args['filter_type'] ) && $args['filter_type'] !== 'hide' ) : ?>
						<div class="myd-content-filter">
							<?php if ( ! isset( $args['filter_type'] ) || isset( $args['filter_type'] ) && $args['filter_type'] !== 'hide_filter' ) : ?>
								<div class="myd-content-filter__categories">
									<?php foreach( $this->get_categories() as $v ) : ?>
										<div class="myd-content-filter__tag" data-anchor="<?php echo str_replace( ' ', '-', esc_attr( $v ) ); ?>"><?php echo esc_html( $v ); ?></div>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							<?php if ( ! isset( $args['filter_type'] ) || isset( $args['filter_type'] ) && $args['filter_type'] !== 'hide_search' ) : ?>
								<div class="myd-content-filter__search-icon" id="myd-content-filter__search-icon">
									<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="20px"; heigth="20px"; xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 511.999 511.999" style="enable-background:new 0 0 511.999 511.999;" xml:space="preserve"><g><g><path d="M225.773,0.616C101.283,0.616,0,101.622,0,225.773s101.284,225.157,225.773,225.157s225.774-101.006,225.774-225.157S350.263,0.616,225.773,0.616z M225.773,413.917c-104.084,0-188.761-84.406-188.761-188.145c0-103.745,84.677-188.145,188.761-188.145s188.761,84.4,188.761,188.145C414.535,329.511,329.858,413.917,225.773,413.917z"/></g></g><g><g><path d="M506.547,479.756L385.024,358.85c-7.248-7.205-18.963-7.174-26.174,0.068c-7.205,7.248-7.174,18.962,0.068,26.174l121.523,120.906c3.615,3.59,8.328,5.385,13.053,5.385c4.756,0,9.506-1.82,13.121-5.453C513.82,498.681,513.789,486.967,506.547,479.756z"/></g></g></svg>
								</div>
								<div class="myd-content-filter__search-input" id="myd-content-filter__search-input">
									<div class="myd-content-filter__search-icon" id="myd-content-filter__search-icon"></div>
									<input type="text" class="myd-search-products" name="myd-search-products" id="myd-search-products" placeholder="<?php esc_attr_e( 'Type to search', 'drope-delivery' ); ?>">
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</section>
		</div>
	<?php endif; ?>

	<section class="myd-products__wrapper">
		<?php echo $this->fdm_loop_products_per_categorie( $product_category ); ?>
	</section>

	<?php if ( Store_Data::$template_dependencies_loaded === false ) : ?>
		<section class="myd-float">
			<div class="myd-float__button-subtotal">
				<span id="myd-float__qty"></span>
				<span id="myd-float__price"></span>
			</div>
			<div class="myd-float__title">
				<?php esc_html_e( 'Your order', 'drope-delivery' ); ?> <?php echo Fdm_svg::arrow_right(); ?>
			</div>
		</section>

		<section class="myd-checkout" id="myd-checkout">
			<div class="myd-cart" id="myd-cart">
				<div class="myd-cart__nav">
					<div class="myd-cart__nav-back"><?php echo Fdm_svg::nav_arrow_left(); ?></div>
					<div class="myd-cart__nav-bag myd-cart__nav--active" data-tab-content="myd-cart__products" data-back="none" data-next="myd-cart__nav-shipping"><?php echo Fdm_svg::nav_bag(); ?> <div class="myd-cart__nav-desc"><?php esc_html_e( 'Bag', 'drope-delivery' );?></div>
						</div>
					<div class="myd-cart__nav-shipping" data-tab-content="myd-cart__checkout" data-back="myd-cart__nav-bag" data-next="myd-cart__nav-payment"><?php echo Fdm_svg::nav_checkout(); ?> <div class="myd-cart__nav-desc"><?php esc_html_e( 'Checkout', 'drope-delivery' );?></div>
						</div>
					<div class="myd-cart__nav-payment" data-tab-content="myd-cart__payment" data-back="myd-cart__nav-shipping" data-next="myd-cart__finished"><?php echo Fdm_svg::nav_confirm(); ?> <div class="myd-cart__nav-desc"><?php esc_html_e( 'Payment', 'drope-delivery' );?></div>
					</div>
					<div class="myd-cart__nav-close"><?php echo Fdm_svg::svg_close(); ?></div>
				</div>

				<div class="myd-cart__content">
					<?php include_once DRP_PLUGIN_PATH . '/templates/cart/cart-empty.php'; ?>
					<div class="myd-cart__products"></div>
					<?php include_once DRP_PLUGIN_PATH . '/templates/cart/cart-checkout.php'; ?>
					<?php include_once DRP_PLUGIN_PATH . '/templates/cart/cart-payment.php'; ?>
					<?php include_once DRP_PLUGIN_PATH . '/templates/cart/cart-finished-order.php'; ?>
				</div>

				<div class="myd-cart__button">
					<div class="myd-cart__button-text"><?php esc_html_e( 'Next', 'drope-delivery' ) ?></div>
				</div>
			</div>
		</section>
	<?php endif; ?>
</div>

<?php Store_Data::$template_dependencies_loaded = true; ?>
