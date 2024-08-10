<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<div id="tab-order-content" class="myd-tabs-content">
    <h2><?php esc_html_e( 'Order settings', 'drope-delivery' );?></h2>
    <p><?php esc_html_e( 'In this section you can configure the order message used when the customer is redirected to WhatsApp.', 'drope-delivery' );?></p>
    
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="myd-option-minimum-price"><?php esc_html_e( 'Minimum price', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input name="myd-option-minimum-price" type="number" id="myd-option-minimum-price" value="<?php echo get_option( 'myd-option-minimum-price' ); ?>" class="regular-text">
                    <p class="description"><?php esc_html_e( "If you don't want to set a minimum price for orders, just leave this input blank.", 'drope-delivery' );?></p>
                </td>
            </tr>

            <tr>
                <th scope="row">
                    <label><?php esc_html_e( 'Redirect to WhatsApp?', 'drope-delivery' );?></label>
                </th>
                <td>
                    <input type="checkbox" name="myd-option-redirect-whatsapp" id="myd-option-redirect-whatsapp" value="yes" <?php checked( get_option( 'myd-option-redirect-whatsapp' ), 'yes' );?>>
                    <label for="myd-option-redirect-whatsapp"><?php esc_html_e('Yes, redirect the customer to WhatsApp after checkout', 'drope-delivery'); ?></label>
                    <p class="description"><?php esc_html_e( "If you don't select it, the plugin will be show the button to send order on WhatsApp.", 'drope-delivery' );?></p>
                </td>
            </tr>

        </tbody>
    </table>

    <h2><?php esc_html_e( 'Order message', 'drope-delivery' );?></h2>
    <p><?php esc_html_e( 'In this section you can configure the order message used when the customer is redirected to WhatsApp.', 'drope-delivery' );?></p>

    <!--
    <div class="card">
        <h3 class="title"><?php esc_html_e( 'Coming soon!', 'drope-delivery' );?></h3>
        <p><?php esc_html_e( 'Yes, we are still finalizing this feature to release for you. But, soon you will be able to configure your order message with dynamic tokens.', 'drope-delivery' );?></p>
    </div>
    -->

    <div class="card">
        <h2 class="title"><?php esc_html_e('Shortcodes', 'drope-delivery' );?></h2>
        <p>[ORDER] -  <?php esc_html_e('Returns the order ID', 'drope-delivery' );?></p>
        <p>[NAME] - <?php esc_html_e('Returns the customer name', 'drope-delivery' );?></p>
        <p>[STATUS] - <?php esc_html_e('Returns order status', 'drope-delivery' );?></p>
        <p>[TRACK] - <?php esc_html_e('Returns the order tracking link', 'drope-delivery' );?></p>
        <p>[TOTAL] - <?php esc_html_e('Returns the total amount of the orderk', 'drope-delivery' );?></p>
        <p>[SHIP_METHOD] - <?php esc_html_e('Returns the delivery type', 'drope-delivery' );?></p>
        <p>[PRODUCT] - <?php esc_html_e('Returns the list of products from the order', 'drope-delivery' );?></p><hr>
        <p>%0A - <?php esc_html_e('Use this syntax to break the line', 'drope-delivery' );?></p>
    </div>

    <table class="form-table">
        <tbody>
            <tr>
                <td style="padding:15px 0px 0px 0px;">
                    <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="drope-message-whatsapp-button" name="drope-message-whatsapp-button" cols="50" rows="3" class="large-text"><?php echo get_option('drope-message-whatsapp-button'); ?></textarea>
                    <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                </td>
            </tr>
        </tbody>
    </table>
</div>