<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$pages = get_pages();
$options = [];
foreach( $pages as $key => $value ) {

    $options[] = '<option value="' . intval( $value->ID ) . '" ' . selected( get_option(' fdm-page-order-track' ), intval( $value->ID ), false ) . '>' . esc_html( $value->post_title ) . '</option>';
}

?>

<div id="tab-advanced-content" class="myd-tabs-content">
    
    <h2><?php esc_html_e( 'Advanced Settings', 'drope-delivery' );?></h2>
    <p><?php esc_html_e( 'In this section you can configure some advanced settings.', 'drope-delivery' );?></p>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="fdm-page-order-track"><?php esc_html_e( 'Track Order Page', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <select name="fdm-page-order-track" id="fdm-page-order-track">
                            <option value=""><?php esc_html_e( 'Select', 'drope-delivery' );?></option>
                            <?php echo implode( $options ); ?>
                        </select>
                        <p class="description"><?php esc_html_e( 'Select the page for show order track for customers. After that, get the shortcode and paste in selected page.', 'drope-delivery' );?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="fdm-mask-phone"><?php esc_html_e( 'Phone Mask', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <select name="fdm-mask-phone" id="fdm-mask-phone">
                            <option value=""><?php esc_html_e( 'Select', 'drope-delivery' );?></option>
                            <option value="fdm-tel-8dig" <?php selected( get_option('fdm-mask-phone'), 'fdm-tel-8dig' ); ?> >0000-0000 8 <?php esc_html_e( 'digitis', 'drope-delivery' );?></option>
                            <option value="myd-tel-9" <?php selected( get_option('fdm-mask-phone'), 'myd-tel-9' ); ?> >00000-0000 9 <?php esc_html_e( 'digitis', 'drope-delivery' );?></option>
                            <option value="myd-tel-8-ddd" <?php selected( get_option('fdm-mask-phone'), 'myd-tel-8-ddd' ); ?> >(00)0000-0000 DDD + 8 <?php esc_html_e( 'digitis', 'drope-delivery' );?></option>
                            <option value="myd-tel-9-ddd" <?php selected( get_option('fdm-mask-phone'), 'myd-tel-9-ddd' ); ?> >(00)00000-0000 DDD + 9 <?php esc_html_e( 'digitis', 'drope-delivery' );?></option>
                            <option value="myd-tel-us" <?php selected( get_option('fdm-mask-phone'), 'myd-tel-us' ); ?> >(000)000-0000 USA 10 <?php esc_html_e( 'digitis', 'drope-delivery' );?></option>
                            <option value="myd-tel-ven" <?php selected( get_option('fdm-mask-phone'), 'myd-tel-ven' ); ?> >(0000)000-0000 11 <?php esc_html_e( 'digitis', 'drope-delivery' );?></option>
                        </select>
                        <p class="description"><?php esc_html_e( 'Select the mask for forms on plugin.', 'drope-delivery' );?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label><?php esc_html_e( 'Remove Zipcode', 'drope-delivery') ;?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="myd-form-hide-zipcode" id="myd-form-hide-zipcode" value="yes" <?php checked( get_option( 'myd-form-hide-zipcode' ), 'yes' ); ?>>
                        <label for="myd-form-hide-zipcode"><?php esc_html_e( 'Yes, remove Zipcode input', 'drope-delivery' );?></label>
                        <p class="description"><?php esc_html_e('Remove input and verification from Zipcode field.', 'drope-delivery' );?></p>
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label><?php esc_html_e( 'Remove Address Number', 'drope-delivery' );?></label>
                    </th>
                    <td>
                        <input type="checkbox" name="myd-form-hide-address-number" id="myd-form-hide-address-number" value="yes" <?php checked( get_option( 'myd-form-hide-address-number' ), 'yes' ); ?>>
                        <label for="myd-form-hide-address-number"><?php esc_html_e( 'Yes, remove Address Number input', 'drope-delivery' );?></label>
                        <p class="description"><?php esc_html_e( 'Remove input and verification from address number field.', 'drope-delivery' );?></p> 
                    </td>
                </tr>

            </tbody>
        </table>
    </div>