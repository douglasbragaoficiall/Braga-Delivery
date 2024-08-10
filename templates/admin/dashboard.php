<?php

use MydPro\Includes\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="wrap">
	<h1><?php esc_html_e( 'Dashboard', 'drope-delivery' ); ?></h1>

	<section class="myd-custom-content-page">
			<div class="myd-admin-cards myd-card-3columns">
				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/package.png'); ?>" width="100px" alt="products">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Products', 'drope-delivery' );?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Create, edit and manage your products', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="<?php echo esc_attr( site_url( '/wp-admin/edit.php?post_type=mydelivery-produtos' ) ); ?>">
						<?php echo esc_html_e( 'Go to Products', 'drope-delivery' );?>
					</a>
				</div>

				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/global-extras.png');?>" width="100px" alt="Global Extras">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Global Extras', 'drope-delivery' ); ?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Create, edit and manage your global addons', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="<?php echo esc_attr( site_url( '/wp-admin/edit.php?post_type=mydelivery-gextras' ) ); ?>">
						<?php echo esc_html_e( 'Go to Global Extras', 'drope-delivery' );?>
					</a>
				</div>

				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/orders.png');?>" width="100px" alt="orders">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Orders', 'drope-delivery' ); ?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Check all your orders and manage it', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="<?php echo esc_attr( site_url( '/wp-admin/edit.php?post_type=mydelivery-orders' ) ); ?>">
						<?php echo esc_html_e( 'Go to Orders', 'drope-delivery' );?>
					</a>
				</div>

				<!--
				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/customers.png');?>" width="100px" alt="customers">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Customers', 'drope-delivery' ); ?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Manage all your customers', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="<?php echo esc_attr( site_url( '/wp-admin/admin.php?page=drope-deliverycustomers' ) ); ?>">
						<?php echo esc_html_e( 'Go to Customers', 'drope-delivery' ); ?>
					</a>
				</div>
				-->

				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/coupon.png');?>" width="100px" alt="coupons">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Coupons', 'drope-delivery' ); ?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Do you want give a discount? Use your cupons for it', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="<?php echo esc_attr( site_url( '/wp-admin/edit.php?post_type=mydelivery-coupons' ) ); ?>">
						<?php echo esc_html_e( 'Go to Coupons', 'drope-delivery' );?>
					</a>
				</div>

				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/reports.png');?>" width="100px" alt="reports">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Reports', 'drope-delivery' ); ?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Check many info about your store, orders and more', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="<?php echo esc_attr( site_url( '/wp-admin/admin.php?page=drope-delivery-reports' ) ); ?>">
						<?php echo esc_html_e( 'Go to Reports', 'drope-delivery' );?>
					</a>
				</div>

				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/settings.png');?>" width="100px" alt="settings">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Settings', 'drope-delivery' ); ?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Manage your Store settings here', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="<?php echo esc_attr( site_url( '/wp-admin/admin.php?page=drope-delivery-settings' ) ); ?>">
						<?php echo esc_html_e( 'Go to Settings', 'drope-delivery' );?>
					</a>
				</div>

				<div class="myd-admin-cards__item myd-cards--flex-centered myd-card--20padding">
					<img src="<?php echo esc_attr( DRP_PLUGN_URL . 'assets/img/documentation.png');?>" width="100px" alt="documentation">
					<h3 class="myd-admin-cards__title"><?php esc_html_e( 'Documentation', 'drope-delivery' ); ?></h3>
					<p class="myd-admin-cards__description"><?php esc_html_e( 'Watch plugin tutorial videos', 'drope-delivery' ); ?></p>
					<a class="button button-primary myd-cards--margin-top10" href="https://docs.bragasistemasdeinformacao.com.br/docs-category/braga-delivery/" target="_blank">
						<?php echo esc_html_e( 'Go to Documentation', 'drope-delivery' );?>
					</a>
				</div>
			</div>
	</section>
</div>
