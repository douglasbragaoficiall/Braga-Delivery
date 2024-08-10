<?php

namespace MydPro\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Myd Create Order
 *
 * Class for create order.
 *
 * @since 1.8
 */
class Myd_Create_Order {

    /**
     * Order data
     *
     * @since 1.8
     */
    public $order_data = array();

    /**
     * Order id
     *
     * @since 1.8
     */
    public $order_id = '';
    public $hide = false;

	/**
	 * Construct class.
	 *
	 * @since 1.8
	 */
	public function __construct( array $order, $hide = false ) {
		$this->order_data = $order;
        $this->hide = $hide;
	}

    /**
     * Create Order
     *
     * @since 1.8
     * @return void
     */
    public function create_order() {
		$order = [
            'post_title'    => '#',
            'post_status'   => $this->hide === true ? 'pending' : 'publish',
            'post_type'   => 'mydelivery-orders',
        ];

        $order_number = wp_insert_post( $order );
        wp_update_post( [
            'ID' => $order_number,
            'post_title' => $order_number
            ]
        );

        $this->order_id = $order_number;
        $this->update_order();
    }

	/**
	 * Update order
	 *
	 * @since 1.8
	 * @return void
	 */
	public function update_order() {
		$order_items = array();
		$extras = array();

        foreach ( $this->order_data['products'] as $v ) {
			if ( ! empty( $v['extras'] ) ) {

				foreach ( $v['extras'] as $v2 ) {
					$extras[] = $v2['extraType'] . ':' . PHP_EOL . implode( PHP_EOL, array_column( $v2['extraOptions'], 'extraOptionName' ) ) . PHP_EOL;
				}

				$order_items[] = [
					'product_name' => '' . $v['productQty'] . ' x ' . $v['productName'] . '',
					'product_extras' => implode( PHP_EOL, $extras ),
					'product_price' => Myd_Store_Formatting::format_price( $this->convert_number( $v['productPriceTotal'] ) ),
					'product_note' => $v['productNote'],
				];
                
			} else {
				$order_items[] = [
					'product_name' => '' . $v['productQty'] . ' x ' . $v['productName'] . '',
					'product_extras' => '',
					'product_price' => Myd_Store_Formatting::format_price( $this->convert_number( $v['productPriceTotal'] ) ),
					'product_note' => $v['productNote'],
				];
			}

			$extras = array();

            if (\get_post_meta($v['productId'], 'product_stock_active', true) == 'true'){
                \update_post_meta($v['productId'], 'product_stock', $v['productStock'] - $v['productQty']);
            }
		}

		\update_post_meta( $this->order_id, 'myd_order_items', $order_items );

		$change = empty( $this->order_data['orderTotal']['change'] ) ? '' : __( 'Change for', 'drope-delivery' ) . ' ' . Store_Data::get_store_data( 'currency_simbol' ) . Myd_Store_Formatting::format_price(sanitize_text_field( $this->order_data['orderTotal']['change'] ));
		// update order info
		\update_post_meta( $this->order_id, 'order_status', 'new' );
		\update_post_meta( $this->order_id, 'order_date', current_time( 'd-m-Y H:i' ) );
		\update_post_meta( $this->order_id, 'order_customer_name', sanitize_text_field( $this->order_data['customer']['name'] ) );
		\update_post_meta( $this->order_id, 'customer_phone', sanitize_text_field( $this->order_data['customer']['phone'] ) );
		\update_post_meta( $this->order_id, 'order_address', sanitize_text_field( $this->order_data['address']['street'] ) );
		\update_post_meta( $this->order_id, 'order_address_number', sanitize_text_field( $this->order_data['address']['number'] ) );
		\update_post_meta( $this->order_id, 'order_address_comp', sanitize_text_field( $this->order_data['address']['comp'] ) );
		\update_post_meta( $this->order_id, 'order_neighborhood', sanitize_text_field( $this->order_data['address']['neighborhood'] ) );
		\update_post_meta( $this->order_id, 'order_zipcode', sanitize_text_field( $this->order_data['address']['zipcode'] ) );
		\update_post_meta( $this->order_id, 'order_total', sanitize_text_field( Myd_Store_Formatting::format_price( $this->convert_number( $this->order_data['orderTotal']['finalPrice'] ) ) ) );
		\update_post_meta( $this->order_id, 'order_payment_method', sanitize_text_field( $this->order_data['orderTotal']['paymentMethod'] ) );
		\update_post_meta( $this->order_id, 'order_notes', $change );
		\update_post_meta( $this->order_id, 'order_ship_method', sanitize_text_field( $this->order_data['orderType']['typeName'] ) );
		\update_post_meta( $this->order_id, 'order_coupon', sanitize_text_field( $this->order_data['orderTotal']['coupon'] ) );
		\update_post_meta( $this->order_id, 'order_coupon_discount', sanitize_text_field( $this->order_data['orderTotal']['couponDesc'] ) );
		\update_post_meta( $this->order_id, 'order_delivery_price', sanitize_text_field( Myd_Store_Formatting::format_price( $this->convert_number( $this->order_data['shipping']['price'] ) ) ) );
		\update_post_meta( $this->order_id, 'order_table', sanitize_text_field( $this->order_data['shipping']['table'] ) );
	}

    /**
     * WhatsApp link
     *
     * @since 1.8
     * @return string
     */
    public function whatsapp_link() {
        $custom_message = get_option('drope-message-whatsapp-button');
        $store_whats = get_option( 'myd-business-whatsapp' );

        if (empty($custom_message)){
            $order_type = $this->order_data['orderType']['type'];
            $order_number = $this->order_id;
            $ship = $this->order_data['orderType']['typeName'];
            $currency = Store_Data::get_store_data( 'currency_simbol' );
            $order_tax = $this->convert_number( $this->order_data['shipping']['price'] );
            $total_order = $this->convert_number( $this->order_data['orderTotal']['finalPrice'] );
            $payment = $this->order_data['orderTotal']['paymentMethod'];
            $name = $this->order_data['customer']['name'];
            $phone = $this->order_data['customer']['phone'];
            $address = $this->order_data['address']['street'];
            $address_number = $this->order_data['address']['number'];
            $address_comp = $this->order_data['address']['comp'];
            $address_neighborhood = $this->order_data['address']['neighborhood'];
            $zipcode = $this->order_data['address']['zipcode'];
            $order_table = $this->order_data['shipping']['table'];
            $page_track = $page_track = get_permalink( get_option( 'fdm-page-order-track' ) );
            $change = '';
            if( $this->order_data['orderTotal']['change'] != '' ) {

                $change = $this->convert_number( $this->order_data['orderTotal']['change'] );
                $change = '%20-%20'.esc_html__('Change','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $change ).'';
            }


            foreach ( $this->order_data['products'] as $v ) {

                if( !empty( $v['extras'] ) ) {

                    foreach( $v['extras'] as $v2 ) {

                        $extras[] = $v2['extraType'].':%0D%0A'.implode( '%0D%0A', array_column( $v2['extraOptions'], 'extraOptionName' ) ).'%0D%0A';
                    }

                    $products_items[] = ''.$v['productQty'].'x%20'.$v['productName'].'%0D%0A'.implode( '%0D%0A', $extras ).'%20'.$v['productNote'].'%0D%0A';
                    unset( $extras );
                }
                else {

                    $products_items[] = ''.$v['productQty'].'x%20'.$v['productName'].'%0D%0A'.$v['productNote'].'%0D%0A';
                }
            }


            switch ( $order_type ) {
                case 'delivery':
                    $message = '======%20'.esc_html__('Order','drope-delivery').'%20'.$order_number.'======%0D%0A%0D%0A'.implode( PHP_EOL, $products_items ).''.$ship.'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $order_tax ).'%0D%0A*'.esc_html__('Order%20Total:','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $total_order ).'*%0D%0A'.$payment.''.$change.'%0D%0A%0D%0A======'.esc_html__('Customer','drope-delivery').'======%0D%0A%0D%0A👤%20'.$name.'%0D%0A📱%20'.$phone.'%0D%0A📍%20'.$address.',%20'.$address_number.'%20|%20'.$address_comp.'%0D%0A'.$address_neighborhood.'%20-%20'.$zipcode.'%0D%0A%0D%0A======'.esc_html__('Track Order','drope-delivery').'======%0D%0A%0D%0A'.$page_track.'?on='.base64_encode($order_number).'';
                break;

                case 'take-away':
                    $message = '======%20'.esc_html__('Order','drope-delivery').'%20'.$order_number.'======%0D%0A%0D%0A'.implode( PHP_EOL, $products_items ).''.$ship.'%0D%0A*'.esc_html__('Order%20Total:','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $total_order ).'*%0D%0A'.$payment.''.$change.'%0D%0A%0D%0A======'.esc_html__('Customer','drope-delivery').'======%0D%0A%0D%0A👤%20'.$name.'%0D%0A📱%20'.$phone.'%0D%0A%0D%0A======'.esc_html__('Track Order','drope-delivery').'======%0D%0A%0D%0A'.$page_track.'?on='.base64_encode($order_number).'';
                break;

                case 'order-in-store':
                    $message = '======🥰%20'.esc_html__('Order','drope-delivery').'%20'.$order_number.'======%0D%0A%0D%0A'.implode( PHP_EOL, $products_items ).''.$ship.'%0D%0A'.esc_html__('Table','drope-delivery').'%20'.$order_table.'%0D%0A*'.esc_html__('Order%20Total:','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $total_order ).'*%0D%0A'.$payment.''.$change.'%0D%0A%0D%0A======'.esc_html__('Customer','drope-delivery').'======%0D%0A%0D%0A👤%20'.$name.'%0D%0A📱%20'.$phone.'%0D%0A%0D%0A======'.esc_html__('Track Order','drope-delivery').'======%0D%0A%0D%0A'.$page_track.'?on='.base64_encode($order_number).'';
                break;
            }

            return 'https://wa.me/'.$store_whats.'?text='.$message.'';
        } else {
            return $this->formatMessage($this->order_id, $custom_message);
        }
        
    }

    //Função para criar link do WhatsApp para pagamentos via Cartão
    public static function _whatsapp_link($order){

        $custom_message = get_option('drope-message-whatsapp-button');
        $store_whats = get_option( 'myd-business-whatsapp' );

        if (empty($custom_message)){

            $order_type = $order->order_data['orderType']['type'];
            $order_number = $order->order_id;
            $ship = $order->order_data['orderType']['typeName'];
            $currency = Store_Data::get_store_data( 'currency_simbol' );;
            $order_tax = $order->convert_number( $order->order_data['shipping']['price'] );
            $total_order = $order->convert_number( $order->order_data['orderTotal']['finalPrice'] );
            $payment = $order->order_data['orderTotal']['paymentMethod'];
            $name = $order->order_data['customer']['name'];
            $phone = $order->order_data['customer']['phone'];
            $address = $order->order_data['address']['street'];
            $address_number = $order->order_data['address']['number'];
            $address_comp = $order->order_data['address']['comp'];
            $address_neighborhood = $order->order_data['address']['neighborhood'];
            $zipcode = $order->order_data['address']['zipcode'];
            $order_table = $order->order_data['shipping']['table'];
            $page_track = $page_track = get_permalink( get_option( 'fdm-page-order-track' ) );
            $change = '';
            if( $order->order_data['orderTotal']['change'] != '' ) {

                $change = $order->convert_number( $order->order_data['orderTotal']['change'] );
                $change = '%20-%20'.esc_html__('Change','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $change ).'';
            }


            foreach ( $order->order_data['products'] as $v ) {

                if( !empty( $v['extras'] ) ) {

                    foreach( $v['extras'] as $v2 ) {

                        $extras[] = $v2['extraType'].':%0D%0A'.implode( '%0D%0A', array_column( $v2['extraOptions'], 'extraOptionName' ) ).'%0D%0A';
                    }

                    $products_items[] = ''.$v['productQty'].'x%20'.$v['productName'].'%0D%0A'.implode( '%0D%0A', $extras ).'%20'.$v['productNote'].'%0D%0A';
                    unset( $extras );
                }
                else {

                    $products_items[] = ''.$v['productQty'].'x%20'.$v['productName'].'%0D%0A'.$v['productNote'].'%0D%0A';
                }
            }


            switch ( $order_type ) {
                case 'delivery':
                    $message = '======%20'.esc_html__('Order','drope-delivery').'%20'.$order_number.'%20======%0D%0A%0D%0A'.implode( PHP_EOL, $products_items ).''.$ship.'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $order_tax ).'%0D%0A*'.esc_html__('Order%20Total:','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $total_order ).'*%0D%0A'.$payment.''.$change.'%0D%0A%0D%0A======'.esc_html__('Customer','drope-delivery').'======%0D%0A%0D%0A👤%20'.$name.'%0D%0A📱%20'.$phone.'%0D%0A📍%20'.$address.',%20'.$address_number.'%20|%20'.$address_comp.'%0D%0A'.$address_neighborhood.'%20-%20'.$zipcode.'%0D%0A%0D%0A======'.esc_html__('Track Order','drope-delivery').'======%0D%0A%0D%0A'.$page_track.'?on='.base64_encode($order_number).'';
                break;

                case 'take-away':
                    $message = '======%20'.esc_html__('Order','drope-delivery').'%20'.$order_number.'%20======%0D%0A%0D%0A'.implode( PHP_EOL, $products_items ).''.$ship.'%0D%0A*'.esc_html__('Order%20Total:','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $total_order ).'*%0D%0A'.$payment.''.$change.'%0D%0A%0D%0A======'.esc_html__('Customer','drope-delivery').'======%0D%0A%0D%0A👤%20'.$name.'%0D%0A📱%20'.$phone.'%0D%0A%0D%0A======'.esc_html__('Track Order','drope-delivery').'======%0D%0A%0D%0A'.$page_track.'?on='.base64_encode($order_number).'';
                break;

                case 'order-in-store':
                    $message = '======🥰%20'.esc_html__('Order','drope-delivery').'%20'.$order_number.'%20======%0D%0A%0D%0A'.implode( PHP_EOL, $products_items ).''.$ship.'%0D%0A'.esc_html__('Table','drope-delivery').'%20'.$order_table.'%0D%0A*'.esc_html__('Order%20Total:','drope-delivery').'%20'.$currency.'%20'.Myd_Store_Formatting::format_price( $total_order ).'*%0D%0A'.$payment.''.$change.'%0D%0A%0D%0A======'.esc_html__('Customer','drope-delivery').'======%0D%0A%0D%0A👤%20'.$name.'%0D%0A📱%20'.$phone.'%0D%0A%0D%0A======'.esc_html__('Track Order','drope-delivery').'======%0D%0A%0D%0A'.$page_track.'?on='.base64_encode($order_number).'';
                break;
            }

            return 'https://wa.me/'.$store_whats.'?text='.$message.'';
        } else {
            return self::_formatMessage($order->order_id, $custom_message);
        }
        
    }

    //Função para criar link do WhatsApp para pagamentos via PIX
    public static function _whatsapp_linkV2($order_id){
        $custom_message = get_option('drope-message-whatsapp-button');
        $store_whats = get_option( 'myd-business-whatsapp' );

        if (empty($custom_message)){
            $page_track = get_permalink( get_option( 'fdm-page-order-track' ) ) . '?on='.base64_encode($order_id);
            $ship_method = get_post_meta($order_id, 'order_ship_method', true);
            $currency = Store_Data::get_store_data( 'currency_simbol' );
            $order_total = get_post_meta($order_id, 'order_total', true);
            $name = get_post_meta($order_id, 'order_customer_name', true);
            $phone = get_post_meta($order_id, 'customer_phone', true);
            
            $message = '======%20Pedido%20' . $order_id . '%20======%0A%0A' . $ship_method . '%0ATotal%20do%20Pedido:%20' . $currency . Myd_Store_Formatting::format_price($order_total) . '%0APagamento%20Online%0A%0A======%20Cliente%20======%0A%0A👤%20' . $name . '%0A📱%20' . $phone . '%0A%0A======%20Acompanhar%20Pedido%20======%0A%0A' . $page_track . '';

            return 'https://api.whatsapp.com/send?phone=' . $store_whats . '&text=' . $message;
        } else {
            return self::_formatMessage($order_id, $custom_message);
        }
        
    }

    /**
     * Send WhatsApp message
     * 
     * @since 1.8
     * @return string
     */
    public function send_whatsapp_message() {

        $message = get_option('fdm-whatsapp-new');
        $name = $this->order_data['customer']['name'];
        $phone = $this->order_data['customer']['phone'];
        $status = get_post_meta( $this->order_id, 'order_status', true );
        $page_track = get_option( 'fdm-whatsapp-page-tracker' ) . '?on=' . base64_encode($this->order_id);

        $message = str_replace("[ORDER]", $this->order_id, $message);
		$message = str_replace("[NAME]", $name, $message);
		$message = str_replace("[STATUS]", $status, $message);
		$message = str_replace("[TRACK]", $page_track, $message);

        if (get_option( 'fdm-whatsapp-enable' )){
            if ($message != "" && !empty($message)){

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
                    'redirection' => 5,
                    'blocking'    => true,
                    'httpversion' => '1.0',
                    'sslverify'   => false,
                    'data_format' => 'body',
                ];

                $response = wp_remote_post($endpoint, $options);
            }
        }

    }

    public static function _send_whatsapp_message($order_id) {

        $message = get_option('fdm-whatsapp-new');
        $name = get_post_meta($order_id, 'order_customer_name', true);
        $phone = get_post_meta($order_id, 'customer_phone', true);
        $status = get_post_meta( $order_id, 'order_status', true );
        $page_track = get_option( 'fdm-whatsapp-page-tracker' ) . '?on=' . base64_encode($order_id);

        $message = str_replace("[ORDER]", $order_id, $message);
		$message = str_replace("[NAME]", $name, $message);
		$message = str_replace("[STATUS]", $status, $message);
		$message = str_replace("[TRACK]", $page_track, $message);

        if (get_option( 'fdm-whatsapp-enable' )){
            if ($message != "" && !empty($message)){

                $endpoint 	= 'https://api.dw-api.com/send';

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
                    'redirection' => 5,
                    'blocking'    => true,
                    'httpversion' => '1.0',
                    'sslverify'   => false,
                    'data_format' => 'body',
                ];

                $response = wp_remote_post($endpoint, $options);

            }
        }

    }

    /**
     * Track order link
     *
     * @since 1.8
     * @return string
     */
    public function track_link() {

        return get_permalink( get_option( 'fdm-page-order-track' ) ).'?on='.base64_encode( $this->order_id );
    }

    public static function _track_link($id){
        return get_permalink( get_option( 'fdm-page-order-track' ) ).'?on='.base64_encode( $id );
    }

    /**
     * Convert number
     *
     * @since 1.8
     * @return string
     */
    public function convert_number( $number ) {

        $dec = get_option( 'fdm-number-decimal' );
        return substr( $number, 0, -$dec).'.'.substr( $number, -$dec);
    }

    /**
     * Format message
     *
     * @since 1.0.0
     * @return string
     */
    public function formatMessage($order_id, $message){
        $store_whats = get_option( 'myd-business-whatsapp' );
        $page_track = get_permalink( get_option( 'fdm-page-order-track' ) ) . '?on='.base64_encode($order_id);
        $ship_method = get_post_meta($order_id, 'order_ship_method', true);
        $order_total = Store_Data::get_store_data( 'currency_simbol' ) . Myd_Store_Formatting::format_price(get_post_meta($order_id, 'order_total', true));
        $name = get_post_meta($order_id, 'order_customer_name', true);
        $status = get_post_meta($order_id, 'order_status', true);
        
        $produtos = get_post_meta($order_id, 'myd_order_items', true);

        foreach ($produtos as $produto){
            $product_list = $product_list . $produto['product_name'] . '%0A%0A';

            if (!empty($produto['product_extras'])){
                $extras = json_encode(explode('\n\n', $produto['product_extras']));
                $extras = str_replace('["', '', $extras);
                $extras = str_replace('"]', '', $extras);
                $extras = str_replace('\r\n', '%0A', $extras);
                $product_list = $product_list . esc_html__('Product extras','drope-delivery') . '%0A%0A' . $extras . '%0A';
            }

            if (!empty($produto['product_note'])){
                $product_list = $product_list . esc_html__('Note','drope-delivery'). ': ' . $produto['product_note'] . '%0A';
            }

            $product_list = $product_list . '-----%0A%0A';
        }
        
        $message = str_replace("[ORDER]", $order_id, $message);
        $message = str_replace("[NAME]", $name, $message);
        $message = str_replace("[STATUS]", $status, $message);
        $message = str_replace("[TRACK]", $page_track, $message);
        $message = str_replace("[TOTAL]", $order_total, $message);
        $message = str_replace("[SHIP_METHOD]", $ship_method, $message);
        $message = str_replace("[PRODUCT]", $product_list, $message);

        return 'https://api.whatsapp.com/send?phone=' . $store_whats . '&text=' . $message;
    }

    public static function _formatMessage($order_id, $message){
        $store_whats = get_option( 'myd-business-whatsapp' );
        $page_track = get_permalink( get_option( 'fdm-page-order-track' ) ) . '?on='.base64_encode($order_id);
        $ship_method = get_post_meta($order_id, 'order_ship_method', true);
        $order_total = Store_Data::get_store_data( 'currency_simbol' ) . Myd_Store_Formatting::format_price(get_post_meta($order_id, 'order_total', true));
        $name = get_post_meta($order_id, 'order_customer_name', true);
        $status = get_post_meta($order_id, 'order_status', true);
        
        $produtos = get_post_meta($order_id, 'myd_order_items', true);

        foreach ($produtos as $produto){
            $product_list = $product_list . $produto['product_name'] . '%0A%0A';

            if (!empty($produto['product_extras'])){
                $extras = json_encode(explode('\n\n', $produto['product_extras']));
                $extras = str_replace('["', '', $extras);
                $extras = str_replace('"]', '', $extras);
                $extras = str_replace('\r\n', '%0A', $extras);
                $product_list = $product_list . esc_html__('Product extras','drope-delivery') . '%0A%0A' . $extras . '%0A';
            }

            if (!empty($produto['product_note'])){
                $product_list = $product_list . esc_html__('Note','drope-delivery'). ': ' . $produto['product_note'] . '%0A';
            }

            $product_list = $product_list . '-----%0A%0A';
        }
        
        $message = str_replace("[ORDER]", $order_id, $message);
        $message = str_replace("[NAME]", $name, $message);
        $message = str_replace("[STATUS]", $status, $message);
        $message = str_replace("[TRACK]", $page_track, $message);
        $message = str_replace("[TOTAL]", $order_total, $message);
        $message = str_replace("[SHIP_METHOD]", $ship_method, $message);
        $message = str_replace("[PRODUCT]", $product_list, $message);

        return 'https://api.whatsapp.com/send?phone=' . $store_whats . '&text=' . $message;
    }

}
