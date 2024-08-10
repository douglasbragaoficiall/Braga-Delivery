<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="myd-cart-payment" class="myd-cart__payment">
	<div class="myd-cart__payment-amount-details">
		<div class="myd-card__flex-row">
			<h4 id="myd-cart-payment-subtotal-label" class="myd-cart__title-inline"><?php esc_html_e( 'Subtotal', 'drope-delivery' ); ?></h4>
			<span id="myd-cart-payment-subtotal-value"></span>
		</div>
		<div id="myd-card-payment-row-delivery-fee" class="myd-card__flex-row myd-hidden">
			<h4 id="myd-cart-payment-delivery-fee-label" class="myd-cart__title-inline"><?php esc_html_e( 'Delivery Fee', 'drope-delivery' ); ?></h4>
			<span id="myd-cart-payment-delivery-fee-value"></span>
		</div>
		<div id="myd-card-payment-row-coupon" class="myd-card__flex-row myd-hidden">
			<h4 id="myd-cart-payment-coupon-label" class="myd-cart__title-inline"><?php esc_html_e( 'Coupon', 'drope-delivery' ); ?></h4>
			<span id="myd-cart-payment-coupon-value"></span>
		</div>
		<div class="myd-card__flex-row">
			<h4 id="myd-cart-payment-total-label" class="myd-cart__title-inline"><?php esc_html_e( 'Total', 'drope-delivery' ); ?></h4>
			<span id="myd-cart-payment-total-value"></span>
		</div>
	</div>
	<!-- ADD PAYMENT LOGIC HERE -->
	<div class="myd-cart__checkout-payment">
		
		<div class="hide-payment"><div class="myd-cart__checkout-title"><?php esc_html_e( 'Payment', 'drope-delivery' ); ?></div>
		<label class="myd-cart__checkout-label" for="input-payment"><?php esc_html_e( 'Payment Method', 'drope-delivery' ); ?></label>
		<select class="myd-cart__checkout-input" id="input-payment" name="input-checkout-payment" required>
			<option value=""><?php esc_html_e( 'Select', 'drope-delivery' ); ?></option>

			<?php if( get_option('fdm-payment-in-cash' ) == 'yes' ) : ?>
				<option value="<?php esc_html_e( 'Cash', 'drope-delivery' ); ?>" data-type="cash"><?php esc_html_e( 'Cash', 'drope-delivery' ); ?></option>
			<?php endif;

			foreach ( $payments as $k => $v ) : ?>
				<option value="<?php echo esc_attr( $v ); ?>" data-type="other"><?php echo esc_html( $v ); ?></option>
			<?php endforeach; ?>
		</select>

		<label class="myd-cart__checkout-label" id="label-payment-change" for="input-payment-change"><?php esc_html_e( 'Change for', 'drope-delivery' ); ?></label>
		<input type="text" class="myd-cart__checkout-input" id="input-payment-change" name="input-payment-change"></div>

		<center id="mercadopago_bricks">

		</center>

		<style>
			/*QuickReset*/
			*{margin:0;box-sizing:border-box;}
			html,body{height:100%;font:14px/1.4 sans-serif;}
			input, textarea{font:14px/1.4 sans-serif;}

			.input-group{
			border: 1px solid;
			display: table;
			border-collapse: collapse;
			width:100%;
			margin-top: 25px;
			}
			.input-group > div{
			display: table-cell;
			vertical-align: middle;  /* needed for Safari */
			}
			.input-group-icon{
			color: #777;
			padding: 0 12px
			}
			.input-group-area{
			width:100%;
			}
			.input-group input{
			border: 0;
			display: block;
			width: 100%;
			padding: 8px;
			}

		</style>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<center id="expirado">
			<p style="font-size: 18px; color: red;"><b>Pedido cancelado, prazo expirado.</b></p>
		</center>

		<center id="qr_code">
			<p style="font-size: 18px;"><b>Aguardando Pagamento...</b></p>
			<span class="description">Abra o aplicativo do seu banco pelo celular, selecione PIX e escaneie ou copie e cole o código PIX.</span>

			<div>
				<p>Tempo para pagamento:</p>
				<h1 id="time">0:00</h1>
			</div>

			<div class="qr_code" style="margin-top: 5px;"></div>


			<p style="margin-top: 15px;"><b>Copia e Cola:</b></p>
			

			<div class="input-group">
				<div class="input-group-area"><input readonly type="text" value="" id="copia_cola"></div>
				<div class="input-group-icon"><a href="#" onclick="window.copiar();"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M19 21H8V7h11m0-2H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2m-3-4H4a2 2 0 0 0-2 2v14h2V3h12V1Z"/></svg></a></div>
			</div>

		</center>
	
	
	</div>


</div>
