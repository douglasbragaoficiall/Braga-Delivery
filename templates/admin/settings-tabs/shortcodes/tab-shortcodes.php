<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div id="tab-shortcodes-content" class="myd-tabs-content">
    
    <h2><?php esc_html_e( 'Shortcodes', 'drope-delivery' );?></h2>
    <p><?php esc_html_e( 'On this page you will find the shortcodes for use in your pages.', 'drope-delivery');?></p>
    
        <table class="form-table">
            <tbody>
                
                <tr>
                    <th scope="row">
                        <label for="myd-shortcode-products"><?php esc_html_e( 'Delivery Page', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input type="text" id="myd-shortcode-products" value="[drope-delivery-products]" class="regular-text">
                        <p class="description"><?php esc_html_e( 'Show delivery system with produtcs, menu, card and more.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="myd-shortcode-orders"><?php esc_html_e( 'Orders', 'drope-delivery' ); ?></label>
                    </th>
                    <td>
                        <input type="text" id="myd-shortcode-orders" value="[drope-delivery-orders]" class="regular-text">
                        <p class="description"><?php esc_html_e( 'Show page to manage orders in progress.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                
                <tr>
                    <th scope="row">
                        <label for="myd-shortcode-track-order"><?php esc_html_e( 'Track Order', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input type="text" id="myd-shortcode-track-order" value="[drope-delivery-track-order]" class="regular-text">
                        <p class="description"><?php esc_html_e( 'Show the page for customers check your order data', 'drope-delivery' );?></p>
                    </td>
                </tr>
            
            </tbody>
        </table>
        <div class="card">
            <h3><?php esc_html_e( 'Important', 'drope-delivery' );?></h3>
            <p><?php esc_html_e( 'You must use these shortcodes in your pages for the system works. If you use our widget for Elementor, you dont need to use them.', 'drope-delivery' );?></p>
        </div>
</div>