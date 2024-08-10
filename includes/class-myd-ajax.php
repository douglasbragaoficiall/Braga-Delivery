<?php

namespace MydPro\Includes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Myd Ajax class
 *
 * Class for all plugin AJAX requests.
 *
 * @since 1.8
 */
class Myd_Ajax {
	/**
	 * Construct class.
	 *
	 * @since 1.8
	 */
	public function __construct() {
		add_action( 'wp_ajax_myd_create_order', [ $this, 'create_order' ] );
		add_action( 'wp_ajax_nopriv_myd_create_order', [ $this, 'create_order' ] );

		add_action( 'wp_ajax_myd_pre_order', [ $this, 'pre_order'] );
		add_action( 'wp_ajax_myd_pix_status', [$this, 'get_pix_status'] );
		add_action( 'wp_ajax_nopriv_myd_pre_order', [$this, 'pre_order'] );
		add_action( 'wp_ajax_nopriv_myd_pix_status', [$this, 'get_pix_status']);

		// Create payment
		$tokenMp = get_option('myd-mp-mode', '') === 'sandbox' ? get_option('myd-mp-sandbox-tk') : get_option('myd-mp-production-tk');
		\MercadoPago\SDK::setAccessToken($tokenMp);

	}

	public function pre_order(){
		$nonce = $_POST['sec'] ?? null;
		if ( ! $nonce || ! wp_verify_nonce( $nonce, 'myd-create-order' ) ) {
			die( __( 'Ops! Security check failed.', 'my-delivey-wordpress' ) );
		}

		include_once DRP_PLUGIN_PATH . '/includes/class-myd-create-order.php';

		$data = json_decode( stripslashes( $_POST['data'] ), true );
		$dataResponse = get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='));
		$order = $data['order'];

		if($order['orderTotal']['paymentMethod'] === "Pagamento Online" && !empty($dataResponse)){
			// Pix gerar o qr code e retornar para ser tratado no fron.
			if($data['formData']['payment_method_id'] === 'pix'){

				$order = new Myd_Create_Order( $data['order'], true );
				$order->create_order();

				$payment = new \MercadoPago\Payment();
				$payment->transaction_amount = floatval($data['order']['orderTotal']['finalPrice']) / 100;
				$payment->description = "Pedido de número: " . $order->order_id;
				$payment->payment_method_id = "pix";
				$payment->payer = array(
					'email' => 'no-reply@dropestore.com'
				);
				$payment->external_reference = "{$order->order_id};" . time();
				$payment->setCustomHeader('X-Idempotency-Key', uniqid());
				$payment->save();

				echo json_encode(['waitPix' => true, 'reference' => $payment->id, 'point' => $payment->point_of_interaction->transaction_data]);
				exit;
			}
			
			$payment = new \MercadoPago\Payment();
			$payment->transaction_amount = floatval($data['order']['orderTotal']['finalPrice']) / 100;
			$payment->token = $data['formData']['token'];
			$payment->installments = 1;
			$payment->payment_method_id = $data['formData']['payment_method_id'];
			$payment->issuer_id = $data['formData']['issuer_id'];
			$payer = new \MercadoPago\Payer();
			$payer->email = $data['formData']['payer']['email'];
			$payer->identification = array(
				'type' => $data['formData']['identification']['type'],
				'number' => $data['formData']['identification']['number']
			);

			$payment->payer = $payer;
			$payment->setCustomHeader('X-Idempotency-Key', uniqid());
			$payment->save();

			if($payment->status === 'approved'){
				$order = new Myd_Create_Order( $data['order'], false );
				$order->create_order();

				echo json_encode([
					'status' => 'approved', 
					'link' => Myd_Create_Order::_whatsapp_link($order),
					'order_id' => $order->order_id,
					'trackLink' => $order->track_link(),
					'sendMessage' => $order->send_whatsapp_message(),
				]);

				exit;
			} else {
				echo json_encode([
					'status' => $payment->status,
					'error' => $payment->error
				]);
				exit;
			}
		}

		// Normal.
		$order = new Myd_Create_Order( $order );
		$order->create_order();

		$response = [
			'link' => $order->whatsapp_link(),
			'order_id' => $order->order_id,
			'trackLink' => $order->track_link(),
			'sendMessage' => $order->send_whatsapp_message(),
		];

		echo json_encode( $response );
		exit;

	}

	public function get_pix_status(){

		$Nhaku = get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='));
		$pagamento = \MercadoPago\Payment::get($_POST['reference']);
		include_once DRP_PLUGIN_PATH . '/includes/class-myd-create-order.php';

		if(($pagamento) && (!empty($Nhaku))){
			$time = explode(';', $pagamento->external_reference)[1];
			$order = intval(explode(';', $pagamento->external_reference)[0]);

			if(strtotime('+' . esc_attr(get_option('myd-tempo-expiracao', 5)) . ' minutes', $time) <= time()){
				// expirou
				wp_delete_post($order, true);

				$pagamento->status = 'cancelled';
				$pagamento->save();

				echo json_encode(['status' => 'expirou']);
				exit;
			} else {
				if($pagamento->status === 'approved'){
					
					wp_publish_post($order);
					echo json_encode([
						'status' => 'approved', 
						'link' => Myd_Create_Order::_whatsapp_linkV2($order),
						'order_id' => $order,
						'trackLink' => Myd_Create_Order::_track_link($order),
						'sendMessage' => Myd_Create_Order::_send_whatsapp_message($order),
					]);
					exit;
				} else {
					echo json_encode([
						'status' => 'pending',
					]);
					exit;
				}
			}

		}

		exit;
	}
	/**
	 * Create order
	 *
	 * Function to run create order class when called by AJAX.
	 *
	 * @since 1.8
	 */


	public function create_order() {

		$Mjiar = get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='));

		if (!empty($Mjiar)){
			$nonce = $_POST['sec'] ?? null;
			if ( ! $nonce || ! wp_verify_nonce( $nonce, 'myd-create-order' ) ) {
				die( __( 'Ops! Security check failed.', 'my-delivey-wordpress' ) );
			} else {

				$data = json_decode( stripslashes( $_POST['data'] ), true );

				include_once DRP_PLUGIN_PATH . '/includes/class-myd-create-order.php';
				$order = new Myd_Create_Order( $data );
				$order->create_order();

				$response = [
					'link' => $order->whatsapp_link(),
					'order_id' => $order->order_id,
					'trackLink' => $order->track_link(),
					'sendMessage' => $order->send_whatsapp_message()
				];

				echo json_encode( $response );
				exit;
			}
		}
	}
}

new Myd_Ajax();
