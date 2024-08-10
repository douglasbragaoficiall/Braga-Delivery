<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

?>
<div id="tab-print-content" class="myd-tabs-content">
    
    <h2><?php esc_html_e( 'Print Settings', 'drope-delivery' );?></h2>
    <p><?php esc_html_e( 'In this section you can configure the print options.', 'drope-delivery' );?></p>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="fdm-print-size"><?php esc_html_e( 'Print size', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <select name="fdm-print-size" id="fdm-print-size">
                            <option value=""><?php esc_html_e( 'Select', 'drope-delivery' );?></option>
                            <option value="52mm" <?php selected( get_option('fdm-print-size'), '52mm' );?>>58mm</option>
                            <option value="70mm" <?php selected( get_option('fdm-print-size'), '70mm' );?>>76mm</option>
                            <option value="74mm" <?php selected( get_option('fdm-print-size'), '74mm' );?>>80mm</option>
                        </select>
                        <p class="description"><?php esc_html_e( 'Select the printing page size.', 'drope-delivery' );?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="fdm-print-font-size"><?php esc_html_e( 'Font size', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input name="fdm-print-font-size" type="number" id="fdm-print-font-size" value="<?php echo get_option( 'fdm-print-font-size' );?>" class="regular-text">
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e('Add store information on print?', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="myd-option-header-print" id="myd-option-header-print" value="yes" <?php checked( get_option( 'myd-option-header-print' ), 'yes' );?>>
                        <label for="myd-option-header-print"><?php esc_html_e('Yes, add store information on printout', 'drope-delivery'); ?></label>
                        <p class="description"><?php esc_html_e( "If you don't select it, the plugin will not insert store information at the top of the print order.", 'drope-delivery' );?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    <div class="card">
        <h2 class="title"><?php esc_html_e( 'Important', 'drope-delivery' );?></h2>
        <p><?php esc_html_e( 'The print order is executaded direct on you web browser, its not a software installed in you computer. This plugin will be generate the the file and visualization like configured above, but same times you need set some configurations direct in your printer.', 'drope-delivery' );?></p>
    </div>

    <h2><?php esc_html_e( 'Print message', 'drope-delivery' );?></h2>
    <p><?php esc_html_e( 'In this section you can customize your print message.', 'drope-delivery' );?></p>

    <div class="card">
        <h2 class="title"><?php esc_html_e( 'Coming soon!', 'drope-delivery' );?></h2>
        <p><?php esc_html_e( 'Soon you will can customize all text/message in your printing file.', 'drope-delivery' );?></p>
    </div>
</div>