<?php

use MydPro\Includes\Fdm_svg;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

?>
<div class="myd-cart__products-empty myd-cart__content--active">
    <?php echo Fdm_svg::cart_bag(); ?>
    <p class="myd-cart__products-empty-desc"><?php esc_html_e( 'Cart empty. Add products for create your order.', 'drope-delivery' ); ?></p>
</div>