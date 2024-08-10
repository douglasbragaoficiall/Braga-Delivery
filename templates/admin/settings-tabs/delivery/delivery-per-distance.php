<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$active = $delivery_mode === 'per-distance' ? 'myd-tabs-content--active' : '' ;
?>
<div class="myd-delivery-type-content <?php echo esc_attr( $active );?>" id="myd-delivery-per-distance">
    <h2><?php esc_html_e( 'Price per Distance', 'drope-delivery' ) ;?></h2>
    <p><?php esc_html_e( 'With this method you can set a fixed price per kilometer according to your stores zip code', 'drope-delivery' );?></p>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="myd-google-maps-api"><?php esc_html_e( 'API Key', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input name="myd-google-maps-api" type="text" id="myd-google-maps-api" value="<?php echo esc_attr( get_option( 'myd-google-maps-api' ) );?>" class="regular-text">
                    <p class="description"><?php esc_html_e( 'Click', 'drope-delivery' );?> <a href="https://developers.google.com/maps/documentation/distance-matrix/get-api-key?hl=pt-br" target="_blank"><?php esc_html_e( 'here', 'drope-delivery' );?></a> <?php esc_html_e( 'to get your API key', 'drope-delivery' );?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="myd-zip-code-origin"><?php esc_html_e( 'ZIP Code of origin', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input name="myd-zip-code-origin" type="text" id="myd-zip-code-origin" value="<?php echo esc_attr( get_option( 'myd-zip-code-origin' ) );?>" class="regular-text">
                    <p class="description"><?php esc_html_e( 'Enter the stores zip code', 'drope-delivery' );?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="myd-value-per-kilometer"><?php esc_html_e( 'Kilometer value', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input name="myd-value-per-kilometer" type="text" id="myd-value-per-kilometer" value="<?php echo esc_attr( get_option( 'myd-value-per-kilometer' ) );?>" class="regular-text">
                    <p class="description"><?php esc_html_e( 'Enter the amount that will be charged per kilometer', 'drope-delivery' );?></p>
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="myd-min-value-per-kilometer"><?php esc_html_e( 'Minimum shipping amount', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input name="myd-min-value-per-kilometer" type="text" id="myd-min-value-per-kilometer" value="<?php echo esc_attr( get_option( 'myd-min-value-per-kilometer' ) );?>" class="regular-text">
                    <p class="description"><?php esc_html_e( 'This will be the shipping cost for orders with the same ZIP code as the store or if the distance is less than 1 kilometer', 'drope-delivery' );?></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>