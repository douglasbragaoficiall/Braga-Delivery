<?php

use MydPro\Includes\Fdm_svg;
use MydPro\Includes\Store_Data;
use MydPro\Includes\Myd_Store_Formatting;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$postid = get_the_ID();
$image_id = get_post_meta( $postid, 'product_image', true );
$image_url = wp_get_attachment_image_url( $image_id, 'large' );
$box_shadow = get_option( 'myd-products-list-boxshadow' );
$product_price = get_post_meta( $postid, 'product_price', true );
$product_price = empty( $product_price ) ? 0 : $product_price;
$product_note = get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='));
$button_text = apply_filters( 'myd-product-loop-button-text', '+' );
$currency_simbol = Store_Data::get_store_data( 'currency_simbol' );
$is_available = get_post_meta( $postid, 'product_available', true );
$price_label = get_post_meta( $postid, 'product_price_label', true );
$hide_price_class = $price_label === 'hide' ? 'myd-product-item__price--hide' : '';
$stock_manager = get_post_meta($postid, 'product_stock_active', true );
$product_stock = get_post_meta( $postid, 'product_stock', true );

if ($product_stock == 0){ 
    $stock = esc_html__( 'Product unavailable', 'drope-delivery' );
} else if ($product_stock == 1){ 
    $stock = esc_html__( 'Stock', 'drope-delivery' ) . ': '. $product_stock. ' ' . esc_html__( 'unit', 'drope-delivery' );
} else { 
    $stock = esc_html__( 'Stock', 'drope-delivery' ) . ': '. $product_stock. ' ' . esc_html__( 'units', 'drope-delivery' );
} 

$disabled_class = $is_available === 'not-available' || $product_stock == 0 ? 'myd-product-disabled' : '';

?>

<?php if ($stock_manager == 'false'){ ?>
	<article class="myd-product-item <?php echo esc_attr( $box_shadow ); ?> <?php echo esc_attr( $disabled_class ); ?>" itemscope itemtype="http://schema.org/Product" data-id="<?php echo esc_attr( $postid ); ?>">
		<?php if (!empty($product_note)){ ?>
			<?php if ( $is_available === 'not-available' ) : ?>
				<span class="myd-product-item__not-available"><?php esc_html_e( 'Not available', 'drope-delivery' ); ?></span>
				<div class="myd-product-item__not-available-overlay"></div>
			<?php endif; ?>
			<div class="myd-product-item__content">
				<h3 class="myd-product-item__title" itemprop="name"><?php echo esc_html( get_the_title() ); ?></h3>
				<p class="myd-product-item__desc" itemprop="description"><?php echo esc_html( get_post_meta( $postid, 'product_description', true ) ); ?></p>
				<div class="myd-product-item__actions">
				<div class="myd-product-item__button" id="<?php echo esc_attr( $postid ); ?>"><span class="mais"><?php echo esc_html( $button_text ); ?></span></div>
					<span class="myd-product-item__price <?php echo esc_attr( $hide_price_class ); ?>" itemprop="price">
						<?php if ( $price_label === 'show' || $price_label === '' ) : ?>
							<?php echo esc_html( $currency_simbol . ' ' . Myd_Store_Formatting::format_price( get_post_meta( $postid, 'product_price', true ) ) ); ?>
						<?php endif; ?>

						<?php if ( $price_label === 'from' ) : ?>
							<?php echo esc_html__( 'From', 'drope-delivery' ); ?> <?php echo esc_html( $currency_simbol . ' ' . Myd_Store_Formatting::format_price( get_post_meta( $postid, 'product_price', true ) ) ); ?>
						<?php endif; ?>

						<?php if ( $price_label === 'consult' ) : ?>
							<?php echo esc_html__( 'By Consult', 'drope-delivery' ); ?>
						<?php endif; ?>
					</span>
				</div>
			</div>

			<div class="myd-product-item__img" data-image="<?php echo esc_attr( $image_url ); ?>">
				<?php echo wp_get_attachment_image( $image_id, 'medium', false, [ 'class' => 'myd-product-item-img attachment-medium size-medium', 'alt' => 'DROPE Delivery Product Image' ] ); ?>
			</div>
		<?php } ?>
	</article>

	<?php if (!empty($product_note)){ ?>
		<?php if ( $is_available !== 'not-available' ) : ?>
			<div class="fdm-popup-product-init myd-hide-element" id="popup-<?php echo esc_attr( $postid ); ?>">
				<div class="fdm-popup-product-content">
					<div class=fdm-popup-close-btn>
						<?php echo Fdm_svg::svg_close(); ?>
					</div>
					<div class="nohref">
						<div class="myd-product-popup__img" data-image="<?php echo esc_attr( $image_url ); ?>">
							<?php echo wp_get_attachment_image( $image_id, 'medium', false, [ 'class' => 'myd-product-popup-img attachment-medium size-medium', 'alt' => 'DROPE Delivery Product Image' ] ); ?>
						</div>
					</div>

					<h3><?php echo esc_html( get_the_title() ); ?></h3>
					<p><?php echo esc_html( get_post_meta( $postid, 'product_description', true ) ); ?></p>

						<div class="drope-margin">
							<div class="fdm-product-add-extras">
								<?php echo $this->format_product_extra( $postid ); ?>
							</div>
						<input type="text" id="myd-product-note-<?php echo esc_attr( $postid ); ?>" placeholder="<?php echo esc_html__( 'any special requests?', 'drope-delivery' ); ?>" class="myd-product-popup__note">
						</div>

					<div class="fdm-popup-product-action">
						<div class="fdm-popup-product-content-qty">
							<div class="fdm-click-minus">-</div>
							<input type="number" id="fmd-item-qty-<?php echo esc_attr( $postid ); ?>" class="fdm-popup-input-text fmd-item-qty" value="1" disabled="disabled">
							<div class="fdm-click-plus">+</div>
						</div>

						<input id="fmd-item-stock-<?php echo esc_attr( $postid ); ?>" type="hidden" value="false">

						<div class="fdm-popup-product-content-add-cart">
							<a class="fdm-add-to-cart-popup" id="<?php echo esc_attr( $postid ); ?>" data-name="<?php echo esc_attr( get_the_title() ); ?>" data-price="<?php echo Myd_Store_Formatting::format_price( $product_price ); ?>" data-image="<?php echo esc_attr( $image_url ); ?>"><?php echo Fdm_svg::svg_cart() . ' ' . esc_html__( 'Add to cart', 'drope-delivery' ); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	<?php } ?>
<?php } else { ?>
	<article class="myd-product-item <?php echo esc_attr( $box_shadow ); ?> <?php echo esc_attr( $disabled_class ); ?>" itemscope itemtype="http://schema.org/Product" data-id="<?php echo esc_attr( $postid ); ?>">
		<?php if (!empty($product_note)){ ?>
			<?php if ( $product_stock == 0 ) : ?>
				<span class="myd-product-item__not-available"><?php esc_html_e( 'Out of stock', 'drope-delivery' ); ?></span>
				<div class="myd-product-item__not-available-overlay"></div>
			<?php endif; ?>
			<?php if ( $is_available === 'not-available' ) : ?>
				<span class="myd-product-item__not-available"><?php esc_html_e( 'Not available', 'drope-delivery' ); ?></span>
				<div class="myd-product-item__not-available-overlay"></div>
			<?php endif; ?>
			<div class="myd-product-item__content">
				<h3 class="myd-product-item__title" itemprop="name"><?php echo esc_html( get_the_title() ); ?></h3>
				<p class="myd-product-item__desc" itemprop="description"><?php echo esc_html( get_post_meta( $postid, 'product_description', true ) ); ?></p>
				<div class="myd-product-item__actions">
				<div class="myd-product-item__button" id="<?php echo esc_attr( $postid ); ?>" onclick="initialStock<?php echo esc_attr( $postid ); ?>('<?php echo esc_attr( $postid ); ?>', '<?php echo $product_stock; ?>')"><span class="mais"><?php echo esc_html( $button_text ); ?></span></div>
					<span class="myd-product-item__price <?php echo esc_attr( $hide_price_class ); ?>" itemprop="price">
						<?php if ( $price_label === 'show' || $price_label === '' ) : ?>
							<?php echo esc_html( $currency_simbol . ' ' . Myd_Store_Formatting::format_price( get_post_meta( $postid, 'product_price', true ) ) ); ?>
						<?php endif; ?>

						<?php if ( $price_label === 'from' ) : ?>
							<?php echo esc_html__( 'From', 'drope-delivery' ); ?> <?php echo esc_html( $currency_simbol . ' ' . Myd_Store_Formatting::format_price( get_post_meta( $postid, 'product_price', true ) ) ); ?>
						<?php endif; ?>

						<?php if ( $price_label === 'consult' ) : ?>
							<?php echo esc_html__( 'By Consult', 'drope-delivery' ); ?>
						<?php endif; ?>
					</span>
				</div>
			</div>

			<div class="myd-product-item__img" data-image="<?php echo esc_attr( $image_url ); ?>">
				<?php echo wp_get_attachment_image( $image_id, 'medium', false, [ 'class' => 'myd-product-item-img attachment-medium size-medium', 'alt' => 'DROPE Delivery Product Image' ] ); ?>
			</div>
		<?php } ?>
	</article>

	<?php if (!empty($product_note)){ ?>
		<?php if ( $is_available !== 'not-available' ) : ?>
			<div class="fdm-popup-product-init myd-hide-element" id="popup-<?php echo esc_attr( $postid ); ?>">
				<div class="fdm-popup-product-content">
					<div class=fdm-popup-close-btn>
						<?php echo Fdm_svg::svg_close(); ?>
					</div>
					<div class="nohref">
						<div class="myd-product-popup__img" data-image="<?php echo esc_attr( $image_url ); ?>">
							<?php echo wp_get_attachment_image( $image_id, 'medium', false, [ 'class' => 'myd-product-popup-img attachment-medium size-medium', 'alt' => 'DROPE Delivery Product Image' ] ); ?>
						</div>
					</div>

					<h3><?php echo esc_html( get_the_title() ); ?></h3>
					<?php if( get_option( 'myd-form-hide-stock' ) == 'yes' ) : ?>
						<p><?php echo esc_attr( $stock ); ?></p>
					<?php endif; ?>
					<p><?php echo esc_html( get_post_meta( $postid, 'product_description', true ) ); ?></p>

						<div class="drope-margin">
							<div class="fdm-product-add-extras">
								<?php echo $this->format_product_extra( $postid ); ?>
							</div>
						<input type="text" id="myd-product-note-<?php echo esc_attr( $postid ); ?>" placeholder="<?php echo esc_html__( 'any special requests?', 'drope-delivery' ); ?>" class="myd-product-popup__note">
						</div>

					<?php if($product_stock == 0){?>
					<div class="fdm-popup-product-action" style="background:#cb2027;color:white;margin-top:10px;border-radius: 5px;">
					<?php echo esc_html__( 'Out of stock', 'drope-delivery' ); ?>
					</div>
					<?php }else{ ?>
						<div class="fdm-popup-product-action">
							<div class="fdm-popup-product-content-qty">
								<div class="fdm-click-minus" onclick="uncheckStock<?php echo esc_attr( $postid ); ?>('<?php echo esc_attr( $postid ); ?>', '<?php echo $product_stock; ?>')">-</div>
								<input type="number" id="fmd-item-qty-<?php echo esc_attr( $postid ); ?>" class="fdm-popup-input-text fmd-item-qty" value="1" min="1" max="<?php echo $product_stock; ?>" disabled="disabled">
								<div id="btn-plus-<?php echo esc_attr( $postid ); ?>" class="fdm-click-plus" onclick="checkStock<?php echo esc_attr( $postid ); ?>('<?php echo esc_attr( $postid ); ?>', '<?php echo $product_stock; ?>')" style=""><div class="fdm-click-plus-icon">+</div></div>
								<div id="btn-plus-out-<?php echo esc_attr( $postid ); ?>" class="fdm-click-plus-off" style=" "><div class="fdm-click-plus-icon">+</div></div>
							</div>
							<input id="fmd-item-stock-<?php echo esc_attr( $postid ); ?>" type="hidden" value="<?php echo $product_stock; ?>">
							<div class="fdm-popup-product-content-add-cart">
								<a class="fdm-add-to-cart-popup" id="<?php echo esc_attr( $postid ); ?>" data-name="<?php echo esc_attr( get_the_title() ); ?>" data-price="<?php echo Myd_Store_Formatting::format_price( $product_price ); ?>" data-image="<?php echo esc_attr( $image_url ); ?>"><?php echo Fdm_svg::svg_cart() . ' ' . esc_html__( 'Add to cart', 'drope-delivery' ); ?></a>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php endif; ?>
	<?php } ?>
<script>
    function initialStock<?php echo esc_attr($postid); ?>(pid, stock) {
      var plus = document.getElementById("btn-plus-<?php echo esc_attr( $postid ); ?>");
      var plusout = document.getElementById("btn-plus-out-<?php echo esc_attr( $postid ); ?>");
      if(parseInt(stock) == 1){
            plus.style.display = "none";
            plusout.style.display = "block";
        } 
    }

    function checkStock<?php echo esc_attr($postid); ?>(pid, stock) {
      var current = document.getElementById("fmd-item-qty-"+ pid).value;
      var plus = document.getElementById("btn-plus-<?php echo esc_attr( $postid ); ?>");
      var plusout = document.getElementById("btn-plus-out-<?php echo esc_attr( $postid ); ?>");

      if(parseInt(current) == parseInt(stock) - 1){
            notificationBar("error", "Estoque máximo alçando, para este produto.");
            plus.style.display = "none";
            plusout.style.display = "block";
        } 
    }
    
    function uncheckStock<?php echo esc_attr( $postid ); ?>(pid, stock) {
      var current = document.getElementById("fmd-item-qty-"+ pid).value;
      var plus = document.getElementById("btn-plus-<?php echo esc_attr( $postid ); ?>");
      var plusout = document.getElementById("btn-plus-out-<?php echo esc_attr( $postid ); ?>");
      if(parseInt(current) == parseInt(stock)){
        plus.style.display = "block";
        plusout.style.display = "none";
      }
    }
</script>
<?php } ?>