<?php


$origins = get_option('myd-zip-code-origin');
$destinations = $_GET['destination'];
$kmPrice = get_option('myd-value-per-kilometer');
$api_key = 'AIzaSyCqjDyJXm-IGeYX6YaqE-Y_vq_vb8q4Akc';

$api_url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=$origins&destinations=$destinations&key=$api_key";

$response = file_get_contents($api_url);
$response = json_decode($response, true);
$response = $response['rows'][0]['elements'][0];

$response_data = [];

$meters_distance = $response['distance']['value'];
$km_distance = $meters_distance / 1000;
$response_data['delivery_fee'] = $km_distance * $kmPrice;
$response_data['wp_format_delivery_fee'] = Myd_Store_Formatting::format_price($response_data['delivery_fee']);
$response_data['status'] = $response['status'];

return $response_data;