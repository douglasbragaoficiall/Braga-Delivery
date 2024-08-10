<?php

namespace MydPro\Includes\License;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

interface License_Action {

    public function run();
    public function get_response_status();
    public function get_response();
}