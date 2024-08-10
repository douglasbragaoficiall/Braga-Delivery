<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$active = $delivery_mode === 'fixed-per-neighborhood' ? 'myd-tabs-content--active' : '' ;
/**
 * TODO: check this latter.
 */
$delivery_mode_fixed_per_neighborhood_price = isset( $delivery_mode_options['fixed-per-neighborhood']['price'] ) ? $delivery_mode_options['fixed-per-neighborhood']['price'] : '';
$delivery_mode_fixed_per_neighborhood_options = isset( $delivery_mode_options['fixed-per-neighborhood']['options'] ) ? $delivery_mode_options['fixed-per-neighborhood']['options'] : '';
?>
<div class="myd-delivery-type-content <?php echo esc_attr( $active );?>" id="myd-delivery-fixed-per-neighborhood">
    <h2><?php esc_html_e( 'Fixed price (Limit by Neighborhood)', 'drope-delivery' ) ;?></h2>
    <p><?php esc_html_e( 'Soon we will have this option to calculate shipping using the Google Maps API.', 'drope-delivery' ) ;?></p>

<table class="form-table">
        <tbody>
    	    <tr>
        	    <th scope="row">
                    <label for="myd-delivery-mode-options[fixed-per-neighborhood][price]"><?php esc_html_e( 'Price', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input name="myd-delivery-mode-options[fixed-per-neighborhood][price]" type="number" step="0.001" id="myd-delivery-mode-options[fixed-per-neighborhood][price]" value="<?php echo esc_attr( $delivery_mode_fixed_per_neighborhood_price );?>" class="regular-text">
                </td>
            </tr>
        </tbody>
    </table>

    <table class="wp-list-table widefat fixed striped myd-options-table">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Neighborhood', 'drope-delivery' );?></th>
                <th class="myd-options-table__action"><?php esc_html_e( 'Action', 'drope-delivery' );?></th>
            </tr>
        </thead>
        <tbody>
            <?php if( isset( $delivery_mode_fixed_per_neighborhood_options ) && ! empty( $delivery_mode_fixed_per_neighborhood_options ) ): ?>
                
                <?php foreach( $delivery_mode_fixed_per_neighborhood_options as $k => $v ): ?>
                    <tr class="myd-options-table__row-content" data-row-index='<?php echo esc_attr( $k );?>' data-row-field-base="myd-delivery-mode-options[fixed-per-neighborhood][options]">
                        <td>
                            <input name="myd-delivery-mode-options[fixed-per-neighborhood][options][<?php echo esc_attr( $k );?>][from]" data-data-index="from" type="text" id="myd-delivery-mode-options[fixed-per-neighborhood][options][<?php echo esc_attr( $k );?>][from]" value="<?php echo esc_attr( $v['from'] );?>" class="regular-text myd-input-full">
                        </td>
                        <td>
                            <span class="myd-repeater__remove" onclick="mydRepeaterTableRemoveRow(this)"><?php echo esc_html_e( 'remove', 'drope-delivery' );?></span>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <tr class="myd-options-table__row-content" data-row-index='0' data-row-field-base="myd-delivery-mode-options[fixed-per-neighborhood][options]">
                    <td>
                        <input name="myd-delivery-mode-options[fixed-per-neighborhood][options][0][from]" data-data-index="from" type="text" id="myd-delivery-mode-options[fixed-per-neighborhood][options][0][from]" value="" class="regular-text myd-input-full">
                    </td>
                    <td>
                        <span class="myd-repeater__remove" onclick="mydRepeaterTableRemoveRow(this)"><?php echo esc_html_e( 'remove', 'drope-delivery' );?></span>
                    </td>
                </tr>

            <?php endif;?>
        </tbody>
    </table>
    <a href="#" class="button button-small button-secondary myd-repeater-table__button" onclick="mydRepeaterTableAddRow(event)"><?php esc_html_e( 'Add more', 'drope-delivery' );?></a>
</div>