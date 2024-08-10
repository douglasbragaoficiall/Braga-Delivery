<?php

use MydPro\Includes\Myd_Legacy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Delivery mode
 */
$delivery_mode = get_option( 'myd-delivery-mode' );
if ( empty( $delivery_mode ) ) {
	$old_delivery_mode = Myd_Legacy::get_old_delivery_type();
	switch ( $old_delivery_mode ) {
		case 'unique-zipcode':
			update_option( 'myd-delivery-mode', 'fixed-per-cep' );
			break;

		case 'unique-neighborhood':
			update_option( 'myd-delivery-mode', 'fixed-per-neighborhood' );
			break;

		case 'per_zipcode':
			update_option( 'myd-delivery-mode', 'per-cep-range' );
			break;

		case 'per_neighborhood':
			update_option( 'myd-delivery-mode', 'per-neighborhood' );
			break;
	}

	$delivery_mode = get_option( 'myd-delivery-mode' );
}

/**
 * Delivery mode options
 */
$delivery_mode_options = get_option( 'myd-delivery-mode-options' );
if ( isset( $delivery_mode_options[0] ) && $delivery_mode_options[0] === 'initial' ) {
	$old_delivery_area = Myd_Legacy::get_old_delivery_area();
	update_option( 'myd-delivery-mode-options', $old_delivery_area );
	$delivery_mode_options = get_option( 'myd-delivery-mode-options' );
}

?>
<div id="tab-delivery-content" class="myd-tabs-content">
	<h2>
		<?php esc_html_e( 'Delivery Settings', 'drope-delivery' );?>
	</h2>
	<p>
		<?php esc_html_e( 'In this section you can configure all delivery settings.', 'drope-delivery' );?>
	</p>

	<table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="fdm-estimate-time-delivery"><?php esc_html_e( 'Estimate Delivery time', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input name="fdm-estimate-time-delivery" type="text" id="fdm-estimate-time-delivery" value="<?php echo esc_attr( get_option( 'fdm-estimate-time-delivery' ) );?>" class="regular-text">
                    <p class="description"><?php esc_html_e( 'This option is showing in order page.', 'drope-delivery' );?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label for="myd-delivery-mode"><?php esc_html_e( 'Delivery price mode', 'drope-delivery' );?></label>
                </th>
                <td>
                    <select name="myd-delivery-mode" id="myd-delivery-mode" onchange="mydSelectDeliveryPrice(this)">
                        <option value="select"><?php esc_html_e( 'Select', 'drope-delivery' );?></option>
                        <option value="fixed-per-cep" <?php selected( $delivery_mode, 'fixed-per-cep' );?>><?php esc_html_e( 'Fixed price (Limit by Zipcode range)', 'drope-delivery' );?></option>
                        <option value="fixed-per-neighborhood" <?php selected( $delivery_mode, 'fixed-per-neighborhood' );?>><?php esc_html_e( 'Fixed price (Limit by Neighborhood)', 'drope-delivery' );?></option>
                        <option value="per-cep-range" <?php selected( $delivery_mode, 'per-cep-range' );?>><?php esc_html_e( 'Price per Zipcode range', 'drope-delivery' );?></option>
                        <option value="per-neighborhood" <?php selected( $delivery_mode, 'per-neighborhood' );?>><?php esc_html_e( 'Price per Neighborhood', 'drope-delivery' );?></option>
                        <option value="per-distance" <?php selected( $delivery_mode, 'per-distance' );?>><?php esc_html_e( 'Price per Distance', 'drope-delivery' );?></option>
                    </select>
                    <p class="description"><?php esc_html_e( 'Select the delivery mode to see more options.', 'drope-delivery' );?></p>
                </td>
            </tr>
        </tbody>
	</table>

	<?php include_once DRP_PLUGIN_PATH . '/templates/admin/settings-tabs/delivery/delivery-fixed-per-cep.php';?>
	<?php include_once DRP_PLUGIN_PATH . '/templates/admin/settings-tabs/delivery/delivery-fixed-per-neighborhood.php';?>
	<?php include_once DRP_PLUGIN_PATH . '/templates/admin/settings-tabs/delivery/delivery-per-cep-range.php';?>
	<?php include_once DRP_PLUGIN_PATH . '/templates/admin/settings-tabs/delivery/delivery-per-neighborhood.php';?>
	<?php include_once DRP_PLUGIN_PATH . '/templates/admin/settings-tabs/delivery/delivery-per-distance.php';?>
</div>
