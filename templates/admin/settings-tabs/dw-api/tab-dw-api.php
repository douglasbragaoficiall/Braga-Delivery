<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div id="tab-dw-api-content" class="myd-tabs-content">
    
    <h2><?php esc_html_e('DW-API Settings', 'drope-delivery' );?></h2>
    <p><?php esc_html_e('In this section you can configure all settings for integration with the DW-API.', 'drope-delivery' );?></p>
        <div class="card">
            <h2 class="title"><?php esc_html_e('Shortcodes', 'drope-delivery' );?></h2>
            <p>[ORDER] - <?php esc_html_e('Returns the order ID', 'drope-delivery' );?></p>
            <p>[NAME] - <?php esc_html_e('Returns the customer name', 'drope-delivery' );?></p>
            <p>[STATUS] - <?php esc_html_e('Returns order status', 'drope-delivery' );?></p>
            <p>[TRACK] - <?php esc_html_e('Returns the order tracking link', 'drope-delivery' );?></p>
            <p><?php esc_html_e('To insert a line break in the message, use the syntax', 'drope-delivery' );?> \n</p>
        </div>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e('Enable integration?', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="fdm-whatsapp-enable" id="fdm-whatsapp-enable" value="yes" <?php checked( get_option( 'fdm-whatsapp-enable' ), 'yes' );?>>
                        <label for="fdm-whatsapp-enable"><?php esc_html_e('Sim, ativar a integração Braga-API', 'drope-delivery'); ?></label>
                        <p class="description"><?php esc_html_e("Se você não selecioná-lo, o plugin irá ignorar o restante das configurações de integração", 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-token"><?php esc_html_e('Token', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input name="fdm-whatsapp-token" type="text" id="fdm-whatsapp-token" value="<?php echo get_option( 'fdm-whatsapp-token' ); ?>" class="regular-text">
                        <p class="description"><?php esc_html_e('Token de dispositivo registrado na API Braga. Você ganha token clique', 'drope-delivery' );?> <a href="https://bot.veroapp.com.br/" target="_blank"><?php esc_html_e('here', 'drope-delivery' );?></a></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-number"><?php esc_html_e('Number', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input name="fdm-whatsapp-number" type="text" id="fdm-whatsapp-number" value="<?php echo get_option( 'fdm-whatsapp-number' ); ?>" class="regular-text">
                        <p class="description"><?php esc_html_e('Number that will send messages (country code format + ddd + phone, e.g.: 559912345678)', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-page-tracker"><?php esc_html_e('Tracking page', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input name="fdm-whatsapp-page-tracker" type="text" id="fdm-whatsapp-page-tracker" value="<?php echo get_option( 'fdm-whatsapp-page-tracker' ); ?>" class="regular-text">
                        <p class="description"><?php esc_html_e('Enter tracking page URL', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-new"><?php esc_html_e('New order message', 'drope-delivery'); ?></label>
                    </th>
                    <td>
                        <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="fdm-whatsapp-new" name="fdm-whatsapp-new" cols="50" rows="3" class="large-text"><?php echo get_option('fdm-whatsapp-new'); ?></textarea>
                        <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-confirmed"><?php esc_html_e('Confirmed order message', 'drope-delivery'); ?></label>
                    </th>
                    <td>
                        <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="fdm-whatsapp-confirmed" name="fdm-whatsapp-confirmed" cols="50" rows="3" class="large-text"><?php echo get_option('fdm-whatsapp-confirmed'); ?></textarea>
                        <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-done"><?php esc_html_e('Done order message', 'drope-delivery'); ?></label>
                    </th>
                    <td>
                        <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="fdm-whatsapp-done" name="fdm-whatsapp-done" cols="50" rows="3" class="large-text"><?php echo get_option('fdm-whatsapp-done'); ?></textarea>
                        <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-waiting"><?php esc_html_e('Order message awaiting', 'drope-delivery'); ?></label>
                    </th>
                    <td>
                        <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="fdm-whatsapp-waiting" name="fdm-whatsapp-waiting" cols="50" rows="3" class="large-text"><?php echo get_option('fdm-whatsapp-waiting'); ?></textarea>
                        <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-in-delivery"><?php esc_html_e('Delivery order message', 'drope-delivery'); ?></label>
                    </th>
                    <td>
                        <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="fdm-whatsapp-in-delivery" name="fdm-whatsapp-in-delivery" cols="50" rows="3" class="large-text"><?php echo get_option('fdm-whatsapp-in-delivery'); ?></textarea>
                        <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-finished"><?php esc_html_e('Finished order message', 'drope-delivery'); ?></label>
                    </th>
                    <td>
                        <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="fdm-whatsapp-finished" name="fdm-whatsapp-finished" cols="50" rows="3" class="large-text"><?php echo get_option('fdm-whatsapp-finished'); ?></textarea>
                        <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-whatsapp-canceled"><?php esc_html_e('Order canceled message', 'drope-delivery'); ?></label>
                    </th>
                    <td>
                        <textarea placeholder="<?php esc_html_e('Type your message here', 'drope-delivery' );?>" id="fdm-whatsapp-canceled" name="fdm-whatsapp-canceled" cols="50" rows="3" class="large-text"><?php echo get_option('fdm-whatsapp-canceled'); ?></textarea>
                        <p class="description"><?php esc_html_e('Customize your message by inserting the available shortcodes.', 'drope-delivery' );?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>