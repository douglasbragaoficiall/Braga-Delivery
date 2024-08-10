<?php

use MydPro\Includes\Myd_Store_Formatting;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$postid = get_the_ID();

?>
<?php foreach ( $extras as $formated_extras ) : ?>
	<?php
	if ( empty( $formated_extras['extra_options'] ) || empty( $formated_extras['extra_title'] ) ) :
		return;
	endif;
	?>

	<?php
		$attr_extra_required = $product_extra->get_extra_required( $formated_extras );
		$min_to_select = $formated_extras['extra_min_limit'] ?? '';
		$max_to_select = $formated_extras['extra_limit'] ?? '';
		$is_product_extra_available = $formated_extras['extra_available'] ?? '';
	?>

	<?php if ( $is_product_extra_available !== 'hide' ) : ?>
		<div class="myd-product-extra-wrapper">
			<?php if ( $is_product_extra_available === 'not-available' ) : ?>
				<span class="myd-product-item__not-available"><?php esc_html_e( 'Not available', 'drope-delivery' ); ?></span>
				<div class="myd-product-item__not-available-overlay"></div>
				<?php $attr_extra_required = false; ?>
			<?php endif; ?>
			
			<div
				class="fdm-extra-option-title"
				data-obj="<?php echo \esc_attr( $attr_extra_required ); ?>"
				<?php if ( ! empty( $max_to_select ) ) : ?>
					data-select-limit="<?php echo \esc_attr( $max_to_select ); ?>"
				<?php endif; ?>
				<?php if ( ! empty( $min_to_select ) ) : ?>
					data-min="<?php echo \esc_attr( $min_to_select ); ?>"
				<?php endif; ?>
			>
				<?php
				$required_tag = $product_extra->get_extra_required_tag( $formated_extras );
				$extra_title = $product_extra->get_title( $formated_extras );
				?>

				<div class="accordion" id="<?php echo strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $formated_extras['extra_title'])) . $postid; ?>">
					<div class="accordion-item" style="border-radius:0!important;">
						<h2 class="accordion-header" id="accordion-<?php echo strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $formated_extras['extra_title'])) . $postid; ?>">
							<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordion-<?php echo strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $formated_extras['extra_title'])) . $postid; ?>-body" aria-expanded="true" aria-controls="accordion-<?php echo strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $formated_extras['extra_title'])) . $postid; ?>-body">              
								<div class="fdm-extra-option-title-text">
									<span class="fdm-extra-option-limit-text"><?php echo \esc_html( $extra_title ); ?></span><br>
									<?php if ( ! empty( $min_to_select ) ) : ?>
										<span class="fdm-extra-option-limit-desc" style="font-size:12px;">
											(Min: <?php echo \esc_html( $min_to_select ); ?>)
										</span>
									<?php endif; ?>
									<?php if ( ! empty( $max_to_select ) ) : ?>
										<span class="fdm-extra-option-limit-desc" style="font-size:12px;">
											(Max: <?php echo \esc_html( $max_to_select ); ?>)
										</span>
									<?php endif; ?>
									<span class="fdm-extra-option-required" style="font-size:12px;"><?php echo \esc_html( $required_tag ); ?></span>
								</div>
							</button>
						</h2>
					</div>
				</div>
				<div id="accordion-<?php echo strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $formated_extras['extra_title'])) . $postid; ?>-body" class="accordion-collapse collapse" aria-labelledby="accordion-<?php echo strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $formated_extras['extra_title'])) . $postid; ?>"
						data-bs-parent="#<?php echo strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $formated_extras['extra_title'])) . $postid; ?>">
					<div class="accordion-body">
						<?php foreach ( $formated_extras['extra_options'] as $options ) : ?>
							<?php if ( $options['extra_option_available'] !== 'hide' ) : ?>
								<?php $price = empty( $options['extra_option_price'] ) ? '0' : Myd_Store_Formatting::format_price( $options['extra_option_price'] ); ?>
								<?php $formated_price = $product_extra->format_extra_price( $product->get_currency(), $product->get_price( $options['extra_option_price'] ) ); ?>
								<?php $data_type = $product_extra->get_title( $formated_extras ); ?>
								<?php $custom_class = $product_extra->cat_to_class( $product_extra->get_title( $formated_extras ) ); ?>
								<div class="myd-extra-item-loop">
									<?php if ( $options['extra_option_available'] === 'not-available' ) : ?>
										<span class="myd-product-item__not-available"><?php esc_html_e( 'Not available', 'drope-delivery' ); ?></span>
										<div class="myd-product-item__not-available-overlay"></div>
									<?php endif; ?>
									<div class="myd-extra-item-loop-text">
										<label class="myd-extra-label" for="option_prod_exta[]"><?php echo esc_html( $options['extra_option_name'] ); ?></label><br>
										<p class="myd-extra-description"><?php echo \esc_html( $options['extra_option_description'] ); ?></p>
										<span class="myd-extra-price"><?php echo \esc_html( $formated_price ); ?></span>
									</div>
									<?php if ( $options['extra_option_available'] !== 'not-available' && $is_product_extra_available !== 'not-available' ) : ?>
										<div class="myd-extra-item-loop-checkbox">
											<input
												type="checkbox"
												data-name="<?php echo \esc_attr( $options['extra_option_name'] ); ?>"
												data-price="<?php echo \esc_attr( $price ); ?>"
												data-type="<?php echo \esc_attr( $data_type ); ?>"
												data-min-limit="<?php echo \esc_attr( $min_to_select ); ?>"
												data-max-limit="<?php echo \esc_attr( $max_to_select ); ?>"
												class="option_prod_exta <?php echo \esc_attr( $custom_class ); ?>"
												name="option_prod_exta[]"
												value="<?php echo \esc_attr( $options['extra_option_name'] ); ?> - <?php echo \esc_attr( $options['extra_option_price'] ); ?>">
										</div>
									<?php endif; ?>
								</div>
								<div style="margin-top: 10px; margin-bottom:10px; border-top: 1px dashed #cdcdcd !important; border: 1px; margin-right: 10px !important;"></div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endforeach; ?>
