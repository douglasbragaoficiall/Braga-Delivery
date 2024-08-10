<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

?>

<div id="tab-stock-content" class="myd-tabs-content">
        
        <h2 class="title"><?php esc_html_e('Product stock', 'drope-delivery' );?></h2>
        <p><?php esc_html_e('On this page, you will be able to enable the option to display the stock on the product or not.', 'drope-delivery' );?></p>
        
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e('Display stock?', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="myd-form-hide-stock" id="myd-form-hide-stock" value="yes" <?php checked( get_option('myd-form-hide-stock'), 'yes' ); ?>>
                        <label for="myd-form-hide-stock"><?php esc_html_e('Sim', 'drope-delivery' );?></label>
                        <p class="description"><?php esc_html_e('Shows the amount of stock on each product', 'drope-delivery' );?></p> 
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="card">
            <h3><?php esc_html_e( 'Important', 'drope-delivery' );?></h3>
            <p><?php esc_html_e( 'Stock control is in beta, use sparingly. We are still working on improving this amazing feature.', 'drope-delivery' );?></p>
        </div>
    </div>