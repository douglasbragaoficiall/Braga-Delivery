<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="tab-layout-content" class="myd-tabs-content">
	<h2><?php esc_html_e( 'Layout Settings', 'drope-delivery' ); ?></h2>
	<p><?php esc_html_e( 'In this section you can configure some layout options.', 'drope-delivery' ); ?></p>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="fdm-principal-color"><?php esc_html_e( 'Main color', 'drope-delivery' ); ?></label>
				</th>
				<td>
					<input name="fdm-principal-color" type="color" id="fdm-principal-color" value="<?php echo esc_attr( get_option( 'fdm-principal-color' ) ); ?>">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="myd-price-color"><?php esc_html_e( 'Price color', 'drope-delivery' ); ?></label>
				</th>
				<td>
					<input name="myd-price-color" type="color" id="myd-price-color" value="<?php echo esc_attr( get_option( 'myd-price-color' ) ); ?>">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="myd-products-list-columns"><?php esc_html_e( 'Product grid columns', 'drope-delivery' ); ?></label>
				</th>
				<td>
					<select name="myd-products-list-columns" id="myd-products-list-columns">
						<option value=""><?php esc_html_e( 'Select', 'drope-delivery' ); ?></option>
						<option value="myd-product-list--1column" <?php selected( get_option( 'myd-products-list-columns'), 'myd-product-list--1column' ); ?>>1 <?php esc_html_e( 'column', 'drope-delivery' ); ?></option>
						<option value="myd-product-list--2columns" <?php selected( get_option( 'myd-products-list-columns'), 'myd-product-list--2columns' ); ?>>2 <?php esc_html_e( 'columns', 'drope-delivery' ); ?></option>
					</select>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label><?php esc_html_e( 'Box shadow', 'drope-delivery' ); ?></label>
				</th>
				<td>
					<input type="checkbox" name="myd-products-list-boxshadow" id="myd-p roducts-list-boxshadow" value="myd-product-item--boxshadow" <?php checked( get_option( 'myd-products-list-boxshadow'), 'myd-product-item--boxshadow' ); ?>>
					<label for="myd-products-list-boxshadow"><?php esc_html_e( 'Yes, add box shadow on products card', 'drope-delivery' ); ?></label>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="card">
		<h2 class="title"><?php esc_html_e( 'More flexibility with DROPE Delivery Widgets', 'drope-delivery' ); ?></h2>
		<p><?php echo wp_kses_post( __( 'We have a <b>free widget</b> for Elementor where you can customize the layout in many ways. Edit your page with Elementor and search for <b>"DROPE Delivery"</b>.', 'drope-delivery' ) ); ?></p>
	</div>
</div>
