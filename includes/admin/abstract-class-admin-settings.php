<?php

namespace MydPro\Includes\Admin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Admin_Settings {

    /**
     * Settings
     * 
     * @since 1.9.6
     */
    protected $settings;

    /**
     * Register admin settings
     *
     * @since 1.9.6
     */
    public function register_settings() {

        $settings = apply_filters( 'mydp_before_regigster_settings', $this->settings );

        foreach( $settings as $setting ) {

            register_setting(
                $setting['option_group'],
                $setting['name'],
                $setting['args']
            );

            if( isset( $setting['args']['default'] ) && ! empty( $setting['args']['default'] ) ) {

                add_option( $setting['name'], $setting['args']['default'] );
            }
        }
    }

    /**
     * TODO: custom sanitize for specifi settings
     */
}