<?php

namespace MydPro\Includes;

use MydPro\Includes\Legacy\Legacy_Repeater;
use MydPro\Includes\Custom_Fields\Register_Custom_Fields;

if (!defined('ABSPATH')) {
    exit;
}

include_once dirname(__FILE__) . '/fdm-custom-svg.php';
include_once dirname(__FILE__) . '/class-myd-product-extra.php';
include_once dirname(__FILE__) . '/class-myd-product.php';
include_once DRP_PLUGIN_PATH . 'includes/legacy/class-legacy-repeater.php';

/**
 * Class to show products
 *
 * TODO: Refactor!
 */
class Fdm_products_show {
    /**
     * Register shortcode with template.
     *
     * @return void
     * @since 1.9.15
     */
    public function register_shortcode() {
		add_shortcode( 'drope-delivery-products', array( $this, 'fdm_list_products' ) );
    }

    /*
	*
	* Return functions to shortcode
	*
	*/
    public function fdm_list_products() {
        return $this->fdm_list_products_html();
    }

    /**
     * Get product extra
     *
     * @param int $id
     * @return void|array
     * @since 1.6
     */
    public function get_product_extra($id) {
        $product_extra = get_post_meta($id, 'myd_product_extras', true);
        $product_extra_legacy = get_post_meta($id, 'product_extras', true);

        /**
         * Check if is necessary migrate legacy data to new.
         */
        $args = Register_Custom_Fields::get_registered_fields();
        $args = isset($args['myd_product_extras']['fields']['myd_product_extras']) ? $args['myd_product_extras']['fields']['myd_product_extras'] : array();
        $update_db = Legacy_Repeater::need_update_db($product_extra_legacy, $product_extra);
        if ($update_db && !empty($args)) {
            $product_extra = Legacy_Repeater::update_repeater_database($product_extra_legacy, $args, $id);
        }

        if (empty($product_extra)) {
            return array();
        }

        foreach ($product_extra as $item) {
            $formated_extras[] = array(
                'extra_available' => $item['extra_available'] ?? '',
                'extra_limit' => $item['extra_max_limit'],
                'extra_min_limit' => $item['extra_min_limit'] ?? '',
                'extra_required' => $item['extra_required'],
                'extra_title' => $item['extra_title'],
                'extra_options' => $item['myd_extra_options'],
            );
        }

        return $formated_extras;
    }

    public function get_category_extras($id) {
        global $wpdb;

        $product_category = get_post_meta($id, 'product_type');




        if (empty($product_category) || !is_array($product_category)) return array();

        $product_category = $product_category[0];

        $myd_global_extra = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = 'myd_global_extras' AND meta_value LIKE '%\"{$product_category}\"%'");
        $cat_id = $myd_global_extra[0]->post_id;

        $is_category_published = get_post_status($cat_id) === 'publish';

        if(!$is_category_published) return array();

        // find all postmeta that includes $categorie in meta_value
        $wp_category_extras_query = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = 'myd_global_extras' AND meta_value LIKE '%\"{$product_category}\"%'");

        if(empty($wp_category_extras_query)) return array();

        $category_extras = [];

        foreach ($wp_category_extras_query as $category_extra) {
            $category_extras = array_merge($category_extras, unserialize($category_extra->meta_value));
        }


        foreach ($category_extras as $item) {
            $formated_category_extras[] = array(
                'extra_available' => $item['extra_available'] ?? '',
                'extra_limit' => $item['extra_max_limit'],
                'extra_min_limit' => $item['extra_min_limit'] ?? '',
                'extra_required' => $item['extra_required'],
                'extra_title' => $item['extra_title'],
                'extra_options' => $item['myd_extra_options'],
            );
        }





        // var_dump($formated_category_extras);
        // die();


        return $formated_category_extras;
    }

    /**
     * Formar product extra
     *
     * @param int $id
     * @return void
     * @since 1.6
     */
    public function format_product_extra($id) {
        $extras = $this->get_product_extra($id);
        $category_extras = $this->get_category_extras($id);
        $product = new Myd_product();
        $product_extra = new Myd_product_extra();

        ob_start();
        include DRP_PLUGIN_PATH . '/templates/products/product-extra.php';
        include DRP_PLUGIN_PATH . '/templates/products/global-extras.php';
        return ob_get_clean();
    }

    /**
     * Products by categorie
     *
     * @since 1.9.8
     */
    public function fdm_loop_products($products, $categorie) {
        if (!$products->have_posts()) {
            return null;
        }

        ob_start();
        while ($products->have_posts()) :
            $products->the_post();
            $product_category = get_post_meta(get_the_ID(), 'product_type', true);
            $is_available = get_post_meta(get_the_ID(), 'product_available', true);
            if ($product_category === $categorie && $is_available !== 'hide') {
                /**
                 * Loop products
                 */
                include DRP_PLUGIN_PATH . '/templates/products/loop-products.php';
            }
        endwhile;
        wp_reset_postdata();
        return ob_get_clean();
    }

    /**
     * Query products
     *
     * @since 1.9.8
     * @return array
     */
    public function get_products() {
        $args = [
            'post_type' => 'mydelivery-produtos',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'no_found_rows' => true
        ];

        return new \WP_Query($args);
    }

    /**
     * Get categories
     *
     * @return arrray
     * @since 1.9.8
     */
    public function get_categories() {

        $categories = get_option('fdm-list-menu-categories');

        if (empty($categories)) {
            return NULL;
        }

        $categories = explode(",", $categories);
        $categories = array_map('trim', $categories);
        return $categories;
    }

    /**
     * Loop products
     *
     * @return void
     */
    public function fdm_loop_products_per_categorie($categories = array()) {
        $categories = !empty($categories) ? $categories : $this->get_categories();

        if ($categories === null) {
            return esc_html__('For show correct produts, create categories on plugin settings and add in produtcs.', 'drope-delivery');
        }

        $grid_columns = get_option('myd-products-list-columns');
        $products_object = $this->get_products();
        $products = '';

        foreach ($categories as $categorie) {

            $categorie_tag = str_replace(' ', '-', $categorie);
            $product_by_categorie = $this->fdm_loop_products($products_object, $categorie);

            if ($product_by_categorie !== NULL && !empty($product_by_categorie)) {
                $products .= '<h2 class="myd-product-list__title" id="fdm-' . $categorie_tag . '">' . $categorie . '</h2><div class="myd-product-list myd-' . $categorie_tag . ' ' . $grid_columns . '">' . $product_by_categorie . '</div>';
            }
        }

        return $products;
    }

    /*
	*
	* Get categories options
	*
	*/
    public function fdm_list_categories() {

        $categories = get_option('fdm-list-menu-categories');

        if (!empty($categories)) {

            $categories = get_option('fdm-list-menu-categories');
            $categories = explode(",", $categories);
            $categories = array_map('trim', $categories);

            return $categories;
        }
    }

    /**
     * Creat front end template
     *
     * @since 1.8
     * @access public
     */
    public function fdm_list_products_html($args = array()) {
        /**
         * Delivery time to move to Class
         *
         * TODO: Remove to class/method
         *
         * @return JSON
         */
        $date = current_time('Y-m-d');
        $current_week_day = strtolower(date('l', strtotime($date)));
        $delivery_time = get_option('myd-delivery-time');
        if (isset($delivery_time[$current_week_day])) {

            $current_delivery_time = wp_json_encode($delivery_time[$current_week_day], JSON_FORCE_OBJECT);
        } else {
            $current_delivery_time = 'false';
        }


        /**
         * Delivery mode and options
         *
         * TODO: move to class/method
         *
         * @since 1.9.4
         */
        $shipping_type = get_option('myd-delivery-mode');
        $shipping_options = get_option('myd-delivery-mode-options');
        if (isset($shipping_options[$shipping_type])) {
            $shipping_options = \wp_json_encode($shipping_options[$shipping_type], JSON_FORCE_OBJECT | JSON_UNESCAPED_UNICODE);
            /**
             * Escape special characters to solve bug when use single quote and others.
             */
            if ($shipping_type === 'per-neighborhood') {
                $shipping_options = addslashes($shipping_options);
            }
        } else {
            $shipping_options = 'false';
        }

        ob_start();

        /**
         * Define var store info and init JS order.
         *
         * TODO: Move to class/method use array and convert to Json.
         *
         * @since 1.9.4
         */
        if (Store_Data::$template_dependencies_loaded === false) { ?>
            <script type="text/javascript">
                var mydStoreInfo = {
                    currency: {
                        symbol: '<?php echo Store_Data::get_store_data('currency_simbol'); ?>',
                        decimalSeparator: '<?php echo get_option('fdm-decimal-separator'); ?>',
                        decimalNumbers: '<?php echo intval(get_option('fdm-number-decimal')); ?>'
                    },
                    forceStore: '<?php echo get_option( 'myd-delivery-force-open-close-store' ) ?>',
                    deliveryTime: '<?php echo $current_delivery_time; ?>',
                    deliveryShipping: {
                        method: '<?php echo \esc_attr($shipping_type); ?>',
                        options: '<?php echo $shipping_options; ?>',
                    },
                    minimumPurchase: '<?php echo get_option('myd-option-minimum-price'); ?>',
                    autoRedirect: '<?php echo get_option('myd-option-redirect-whatsapp'); ?>',
                    coupons: '',
                    products: {},
                    messages: {
                        storeClosed: '<?php esc_html_e('The store is closed', 'drope-delivery'); ?>',
                        cartEmpty: '<?php esc_html_e('Cart empty', 'drope-delivery'); ?>',
                        addToCard: '<?php esc_html_e('Added to cart', 'drope-delivery'); ?>',
                        deliveryAreaError: '<?php esc_html_e('Sorry, delivery area is not supported', 'drope-delivery'); ?>',
                        invalidCoupon: '<?php esc_html_e('Invalid coupon', 'drope-delivery'); ?>',
                        removedFromCart: '<?php esc_html_e('Removed from cart', 'drope-delivery'); ?>',
                        extraRequired: '<?php esc_html_e('Select required extra', 'drope-delivery'); ?>',
                        extraMin: '<?php esc_html_e('Select the minimum required for the extra', 'drope-delivery'); ?>',
                        inputRequired: '<?php esc_html_e('Required inputs empty', 'drope-delivery'); ?>',
                        minimumPrice: '<?php esc_html_e('The minimum order is', 'drope-delivery'); ?>',
                        template: false,
                    },
                };

                document.addEventListener("DOMContentLoaded", function() {
                    createOrder(order);
                });
            </script>
<?php
        }

        /**
         * Include templates
         *
         * @since 1.9
         */
        include DRP_PLUGIN_PATH . '/templates/template.php';

        return ob_get_clean();
    }
}

$delivery_page_shortcode = new Fdm_products_show();
$delivery_page_shortcode->register_shortcode();
