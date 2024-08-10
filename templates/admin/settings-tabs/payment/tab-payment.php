<?php

use MydPro\Includes\Myd_Currency;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$currency_list = Myd_Currency::get_currency_list();
$saved_currency_code = Myd_Currency::get_currency_code();

?>
<div id="tab-payment-content" class="myd-tabs-content">
	<h2><?php esc_html_e( 'Payment Settings', 'drope-delivery' ); ?></h2>
	<p><?php esc_html_e( 'In this section you can configure the payment methods and others settings.', 'drope-delivery' ); ?></p>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="myd-currency"><?php esc_html_e( 'Currency', 'drope-delivery' ); ?></label>
				</th>
				<td>
					<select name="myd-currency" id="myd-currency">
						<option value=""><?php esc_html_e( 'Select', 'drope-delivery' ); ?></option>
						<?php foreach ( $currency_list as $currency_code => $currency_value ) : ?>
							<?php $currency_name = $currency_value['name'] . ' (' . $currency_value['symbol'] . ')'; ?>
							<option
								value="<?php echo esc_attr( $currency_code ); ?>"
								<?php selected( $saved_currency_code, $currency_code ); ?>
								>
								<?php echo esc_html( $currency_name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="fdm-number-decimal"><?php esc_html_e( 'Number of decimals', 'drope-delivery' );?></label>
				</th>
				<td>
					<input name="fdm-number-decimal" type="number" id="fdm-number-decimal" value="<?php echo esc_attr( get_option( 'fdm-number-decimal' ) ); ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'This sets the number of decimal points show in displayed price.', 'drope-delivery' );?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="fdm-decimal-separator"><?php esc_html_e( 'Decimal separator', 'drope-delivery' ); ?></label>
				</th>
				<td>
					<input name="fdm-decimal-separator" type="text" id="fdm-decimal-separator" value="<?php echo esc_attr( get_option( 'fdm-decimal-separator' ) ); ?>" class="regular-text">
					<p class="description"><?php esc_html_e( 'This sets the decimal separator of displayed prices ', 'drope-delivery' ); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="fdm-payment-in-cash"><?php esc_html_e( 'Cash Payment?', 'drope-delivery' );?></label>
				</th>
				<td>
					<select name="fdm-payment-in-cash" id="fdm-payment-in-cash">
						<option value=""><?php esc_html_e( 'Select', 'drope-delivery' ); ?></option>
						<option value="yes" <?php selected( get_option( 'fdm-payment-in-cash' ), 'yes' ); ?> ><?php esc_html_e( 'Yes, my store receive payments in cash', 'drope-delivery' );?></option>
						<option value="no" <?php selected( get_option( 'fdm-payment-in-cash' ), 'no' ); ?> ><?php esc_html_e( 'No, my store dont`t receive payments in cash', 'drope-delivery' );?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<label for="fdm-payment-type"><?php esc_html_e( 'Payment Methods', 'drope-delivery' ); ?></label>
				</th>
				<td>
					<textarea placeholder="<?php esc_html_e( 'Credit card, Debit card...', 'drope-delivery' ); ?>" id="fdm-payment-type" name="fdm-payment-type" cols="50" rows="5" class="large-text"><?php echo esc_attr( get_option( 'fdm-payment-type' ) ); ?></textarea>
					<p class="description"><?php esc_html_e( 'List all payment methods separated by comma (,). Like: Credit card,Debit Card,Voucher.', 'drope-delivery' ); ?></p>
					<p class="description"><?php esc_html_e( 'To activate automatic payment, enter the PIX payment method.', 'drope-delivery' ); ?></p>
				</td>
			</tr>

			<!-- MercadoPago -->
			<tr>
                <th scope="row">
                    <label>MercadoPago</label>
                </th>
                <td>
					<input type="checkbox" name="myd-mp-mode" id="myd-mp-mode" value="sandbox" <?php checked( get_option('myd-mp-mode'), 'sandbox' ); ?>>
                    <label for="myd-mp-mode">Sandbox</label> <br>
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="myd-tempo-expiracao">Expiração Pix</label>
				</th>
				<td>
				<input name="myd-tempo-expiracao" type="number" id="myd-tempo-expiracao" value="<?php echo esc_attr( get_option( 'myd-tempo-expiracao' ) ); ?>" class="regular-text">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="myd-mp-sandbox-token">Token SandBox</label>
				</th>
				<td>
				<input name="myd-mp-sandbox-tk" type="text" id="myd-sandbox-tk" value="<?php echo esc_attr( get_option( 'myd-mp-sandbox-tk' ) ); ?>" class="large-text">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="myd-mp-sandbox-public">Public SandBox</label>
				</th>
				<td>
				<input name="myd-mp-sandbox-public" type="text" id="myd-sandbox-public" value="<?php echo esc_attr( get_option( 'myd-mp-sandbox-public' ) ); ?>" class="large-text">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="myd-mp-production-token">Token Produção</label>
				</th>
				<td>
				<input name="myd-mp-production-tk" type="text" id="myd-production-tk" value="<?php echo esc_attr( get_option( 'myd-mp-production-tk' ) ); ?>" class="large-text">
				</td>
			</tr>

			<tr>
				<th scope="row">
					<label for="myd-mp-production-public">Public Produção</label>
				</th>
				<td>
				<input name="myd-mp-production-public" type="text" id="myd-production-public" value="<?php echo esc_attr( get_option( 'myd-mp-production-public' ) ); ?>" class="large-text">
				</td>
			</tr>

			<tr>
                <th scope="row">
                    <label>Métodos Habilitados</label>
                </th>
                <td>
					<input type="checkbox" name="myd-mp-pix" id="myd-mp-pix" value="bank_transfer" <?php checked( get_option('myd-mp-pix'), 'bank_transfer' ); ?>>
                    <label for="myd-mp-pix">PIX</label><br>

					<input type="checkbox" name="myd-mp-credito" id="myd-mp-credito" value="credit_card" <?php checked( get_option('myd-mp-credito'), 'credit_card' ); ?>>
                    <label for="myd-mp-credito">Cartão de Crédito</label><br>

					<input type="checkbox" name="myd-mp-debito" id="myd-mp-debito" value="debit_card" <?php checked( get_option('myd-mp-debito'), 'debit_card' ); ?>>
                    <label for="myd-mp-debito">Cartão de Débito (Caixa)</label>
				</td>
			</tr>


			<!-- Action/run function to list registered payment gateway and their options -->
		</tbody>
	</table>
</div>
