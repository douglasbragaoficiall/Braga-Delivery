<?php

if (!defined('ABSPATH')) {
    exit;
}

$order_id = (!empty($_REQUEST['id']) ? (int) $_REQUEST['id'] : false);
$status = (!empty($_REQUEST['order_action']) ? $_REQUEST['order_action'] : '');
$name = get_post_meta( $order_id, 'order_customer_name', true );
$phone = get_post_meta( $order_id, 'customer_phone', true );
$page_track = get_option( 'fdm-whatsapp-page-tracker' ) . '?on=' . base64_encode($order_id);
$message = '';

if ($status == "confirmed"){
	$message = get_option('fdm-whatsapp-confirmed');
} elseif ($status == "done"){
	$message = get_option('fdm-whatsapp-done');
} elseif ($status == "in-delivery"){
	$message = get_option('fdm-whatsapp-in-delivery');
} elseif ($status == "waiting"){
	$message = get_option('fdm-whatsapp-waiting');
} elseif ($status == "finished"){
	$message = get_option('fdm-whatsapp-finished');
} elseif ($status == "canceled"){
	$message = get_option('fdm-whatsapp-canceled');
}

if (get_option( 'fdm-whatsapp-enable' )){
	if ($message != "" && !empty($message)){

		$message = str_replace("[ORDER]", $order_id, $message);
		$message = str_replace("[NAME]", $name, $message);
		$message = str_replace("[STATUS]", $status, $message);
		$message = str_replace("[TRACK]", $page_track, $message);

		$endpoint 	= 'https://api.veroapp.com.br/send';

		$body = [
			'token' => get_option( 'fdm-whatsapp-token' ),
			'sender' => get_option( 'fdm-whatsapp-number' ),
			'receiver' => '55' . $phone,
			'msgtext' => $message
		];
			
		$body = stripslashes(wp_json_encode($body, JSON_UNESCAPED_UNICODE));
			
		$options = [
			'body'        => $body,
			'headers'     => [
				'Content-Type' => 'application/json',
			],
			'timeout'     => 0,
			'blocking'    => true,
			'httpversion' => '1.0',
			'sslverify'   => false,
			'data_format' => 'body',
		];

		$response = wp_remote_post($endpoint, $options);
	}
}