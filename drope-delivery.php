<?php
/**
 * Plugin Name: BRAGA Delivery
 * Plugin URI: https://bragasistemasdeinformcao.com.br/braga-delivery
 * Description: BRAGA Delivery - Crie um sistema completo para entrega com produtos, pedidos, suporte para envio de pedido no WhatsApp e muito mais.
 * Author: Braga Sistemas de Informação
 * Author URI: https://bragasistemasdeinformcao.com.br
 * Version: 1.2.3.5
 * Requires PHP: 7.0
 * Requires at least: 5.5
 * Text Domain: braga-delivery
 * Domain Path: /languages
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package DRP_Delivery_Pro
 */

if (!defined('ABSPATH')) {
	exit;
}

define('DRP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('DRP_PLUGN_URL', plugin_dir_url(__FILE__));
define('DRP_PLUGIN_MAIN_FILE', __FILE__);
define('DRP_PLUGIN_BASENAME', plugin_basename(__FILE__));
define('DRP_PLUGIN_DIRNAME', plugin_basename(__DIR__));
define('DRP_CURRENT_VERSION', '1.2.3.5');
define('DRP_SUB_VERSION', '1.9.42');
define('DRP_MINIMUM_PHP_VERSION', '7.0');
define('DRP_MINIMUM_WP_VERSION', '5.5');
define('DRP_PLUGIN_NAME', 'DROPE Delivery');
define('DRP_CUSTOM_LOGO', esc_url(wp_get_attachment_url(get_theme_mod('custom_logo'))) ?? '');

ini_set('display_errors', 0);

include_once DRP_PLUGIN_PATH . 'includes/license/class-license.php';

class Admin_Page {
    public $plugin_file = DRP_PLUGIN_MAIN_FILE;
    public $response;
    public $message;
    public $show=false;
    public $slug = 'drope-delivery';
    public $plugin_version = '';
    public $text_domain = '';
    protected $menu_page;
	protected $submenu_pages;
	protected $page_templates;
    function __construct() {
        $this->set_plugin_data();
	    $main_lic_key = base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ==');
	    $lic_key_name = License::get_lic_key_param($main_lic_key);
        $license_key = get_option($lic_key_name, '');
        if(empty($license_key)){
	        $license_key = get_option($main_lic_key, '');
	        if(!empty($license_key)){
	            update_option($lic_key_name, $license_key) || add_option($lic_key_name, $license_key);
            }
        }
        $lice_email = get_option('drope-delivery-license-email', '');
        License::add_on_delete(function(){
           update_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='), '');
        });
        if(License::check_wp_plugin($license_key, $lice_email, $this->message, $this->response, DRP_PLUGIN_MAIN_FILE)){
            add_action('admin_menu', [$this, 'active_admin_menu'],99999);
            add_action('admin_post_drope_delivery_deactivate_license', [ $this, 'action_deactivate_license']);
			
            $this->menu_page = [
				'page_title' => 'DROPE Delivery',
				'menu_title' => 'DROPE Delivery',
				'capability' => 'publish_posts',
				'slug' => 'drope-delivery-dashboard',
				'call_template' => '',
				'icon' => DRP_PLUGN_URL . 'assets/img/fdm-icon.png',
				'position' => 60,
			];
	
			$this->submenu_pages = [
				[
					'parent_slug' => 'drope-delivery-dashboard',
					'page_title' => 'DROPE Delivery Dashboard',
					'menu_title' => esc_html__( 'Dashboard', 'drope-delivery' ),
					'capability' => 'publish_posts',
					'slug' => 'drope-delivery-dashboard',
					'call_template' => [ $this, 'get_template_dashboard' ],
					'position' => 0,
					'condition' => false,
				],
				[
					'parent_slug' => 'drope-delivery-dashboard',
					'page_title' => 'DROPE Delivery Reports',
					'menu_title' => esc_html__( 'Reports', 'drope-delivery' ),
					'capability' => 'publish_posts',
					'slug' => 'drope-delivery-reports',
					'call_template' => [ $this, 'get_template_reports' ],
					'position' => 5,
					'condition' => true,
				],
				[
					'parent_slug' => 'drope-delivery-dashboard',
					'page_title' => 'DROPE Delivery Settings',
					'menu_title' => esc_html__( 'Settings', 'drope-delivery' ),
					'capability' => 'manage_options',
					'slug' => 'drope-delivery-settings',
					'call_template' => [ $this, 'get_template_settings' ],
					'position' => 6,
					'condition' => true,
				],
			];
	
			$this->page_templates = [
				'dashboard' => DRP_PLUGIN_PATH . 'templates/admin/dashboard.php',
				'settings' => DRP_PLUGIN_PATH . 'templates/admin/settings.php',
				'reports' => DRP_PLUGIN_PATH . 'templates/admin/reports.php',
				'customers' => DRP_PLUGIN_PATH . 'templates/admin/customers.php',
				'addons' => DRP_PLUGIN_PATH . 'templates/admin/addons.php',
				'license' => DRP_PLUGIN_PATH . 'templates/admin/license.php',
			];
        }else{
            if(!empty($license_key) && !empty($this->message)) : $this->show=true; endif;
            update_option($license_key, '') || add_option($license_key, '');
            add_action('admin_post_drope_delivery_activate_license', [$this, 'action_activate_license']);
            add_action('admin_menu', [$this, 'inactive_menu']);
        }
    }
    public function set_plugin_data(){
		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( function_exists( 'get_plugin_data' ) ) {
			$data = get_plugin_data( $this->plugin_file );
			if ( isset( $data['Version'] ) ) {
				$this->plugin_version = $data['Version'];
			}
			if ( isset( $data['TextDomain'] ) ) {
				$this->text_domain = $data['TextDomain'];
			}
		}
    }
	private static function &get_server_array() {
		return $_SERVER;
	}
	private static function get_raw_domain(){
		if(function_exists('site_url')){
			return site_url();
		}
		if ( defined('WPINC') && function_exists('get_bloginfo')) {
			return get_bloginfo( 'url' );
		} else {
			$server = self::get_server_array();
			if ( ! empty( $server['HTTP_HOST'] ) && ! empty( $server['SCRIPT_NAME'] ) ) {
				$base_url  = ( ( isset( $server['HTTPS'] ) && $server['HTTPS'] == 'on' ) ? 'https' : 'http' );
				$base_url .= '://' . $server['HTTP_HOST'];
				$base_url .= str_replace( basename( $server['SCRIPT_NAME'] ), '', $server['SCRIPT_NAME'] );
				
				return $base_url;
			}
		}
		return '';
	}
	private static function get_raw_wp(){
		$domain=self::get_raw_domain();
		return preg_replace('(^https?://)', '', $domain );
	}
	public static function get_lic_key_param($key){
		$raw_url=self::get_raw_wp();
		return $key.'_s'.hash('crc32b', $raw_url.'vtpbdapps');
	}

	public function active_admin_menu(){
        add_submenu_page('drope-delivery-dashboard', 'DROPE Delivery Dashboard', esc_html__( 'License', 'drope-delivery' ), 'publish_posts',  base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='), [$this, 'activated'] );
    }
	
	public function inactive_menu() {
        add_menu_page(esc_html__( 'DROPE Delivery - License', 'drope-delivery' ), 'DROPE Delivery', 'publish_posts', base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='),  [$this, 'license_form'], DRP_PLUGN_URL . 'assets/img/fdm-icon.png', 60);
    }
    function action_activate_license(){
        check_admin_referer( 'el-license' );
        $license_key = !empty($_POST['el_license_key']) ? sanitize_text_field(wp_unslash($_POST['el_license_key'])):'';
        $license_email = !empty($_POST['el_license_email']) ? sanitize_email(wp_unslash($_POST['el_license_email'])):'';
        update_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='), $license_key) || add_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='), $license_key);
        update_option('drope-delivery-license-email', $license_email) || add_option('drope-delivery-license-email', $license_email);
        update_option('_site_transient_update_plugins', '');
        wp_safe_redirect(admin_url( 'admin.php?page=drope-delivery-license'));
    }
    function action_deactivate_license() {
        check_admin_referer( 'el-license' );
        $message = '';
	    $main_lic_key = base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ==');
	    $lic_key_name = License::get_lic_key_param($main_lic_key);
        if(License::remove_license_key(__FILE__, $message)){
            update_option($lic_key_name, '') || add_option($lic_key_name, '');
            update_option('_site_transient_update_plugins', '');
        }
        wp_safe_redirect(admin_url( 'admin.php?page=drope-delivery-license'));
    }
    function activated(){ ?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="drope_delivery_deactivate_license"/>
            <div class="drope-delivery-card">
                <h3 class="el-license-title"><?php esc_html_e('DROPE Delivery License Info','drope-delivery');?> </h3>
                <hr>
                <ul class="el-license-info">
                <li>
                    <div>
                        <span class="el-license-info-title"><?php esc_html_e("Status:",'drope-delivery');?></span>
                        <?php if ( $this->response->is_valid ) : ?>
                            <span class="el-license-valid"><?php esc_html_e("Valid",'drope-delivery');?></span>
                        <?php else : ?>
                            <span class="el-license-valid"><?php esc_html_e("Invalid",'drope-delivery');?></span>
                        <?php endif; ?>
                    </div>
                </li>
                <li>
                    <div>
                        <span class="el-license-info-title"><?php esc_html_e("License Type",'drope-delivery');?></span>
                        <?php echo esc_html($this->response->license_title,'drope-delivery'); ?>
                    </div>
                </li>
               <li>
                   <div>
                       <span class="el-license-info-title"><?php esc_html_e("License Expired on",'drope-delivery');?></span>
                       <?php echo esc_html($this->response->expire_date,'drope-delivery');
                       if(!empty($this->response->expire_renew_link)){
                           ?>
                           <a target="_blank" class="el-blue-btn" href="<?php echo esc_url($this->response->expire_renew_link); ?>">Renew</a>
                           <?php
                       }
                       ?>
                   </div>
               </li>
               <li>
                   <div>
                       <span class="el-license-info-title"><?php esc_html_e("Support Expired on",'drope-delivery');?></span>
                       <?php echo esc_html($this->response->support_end,'drope-delivery');
                        if(!empty($this->response->support_renew_link)){ ?>
                            <a target="_blank" class="el-blue-btn" href="<?php echo esc_url($this->response->support_renew_link); ?>">Renew</a>
                        <?php } ?>
                   </div>
               </li>
                <li>
                    <div>
                        <span class="el-license-info-title"><?php esc_html_e("Your License Key",'drope-delivery');?></span>
                        <span class="el-license-key"><?php echo esc_attr( substr($this->response->license_key,0,9)."XXXXXXXX-XXXXXXXX".substr($this->response->license_key,-9) ); ?></span>
                    </div>
                </li>
                </ul>
                <div class="el-license-active-btn">
                    <?php wp_nonce_field( 'el-license' ); ?>
                    <?php submit_button('Desativar'); ?>
                </div>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading"><?php esc_html_e("Activated license",'drope-delivery');?></h4>
                    <p><?php esc_html_e("You are now receiving automatic updates and support.",'drope-delivery');?></p>
                    <p><?php esc_html_e("If you have any problems, please create a",'drope-delivery');?> <a href="https://bragasistemasdeinformcao.com.br/suporte/" target="_blank">ticket</a> <?php esc_html_e("through your user panel on the Braga website.",'drope-delivery');?></p>
                    <hr>
                    <p class="mb-0"><?php esc_html_e("To use this license on another domain, please click the Deactivate button just above.",'drope-delivery');?></p>
                </div>
            </div>
        </form>
    <?php
    }

    function license_form() { ?>
    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="drope_delivery_activate_license"/>
        <div class="drope-delivery-card">
            <h3 class="el-license-title"><?php esc_html_e("Braga Delivery Licensing",'drope-delivery');?></h3><hr>
            <?php
            if (!empty($this->show) && !empty($this->message)){ ?>
                <div class="notice notice-error is-dismissible">
                    <p><?php echo esc_html($this->message,'drope-delivery'); ?></p>
                </div>
            <?php } ?>
            <p><?php esc_html_e("Enter your license key here, to activate the product, and get full feature updates and premium support.",'drope-delivery');?></p>
            <p><?php esc_html_e("If you don't already have a license, click",'drope-delivery');?> <a href="https://bragasistemasdeinformcao.com.br/braga-delivery/" target="_blank"><?php esc_html_e("here",'drope-delivery');?></a> <?php esc_html_e("to get one.",'drope-delivery');?></p>
            <div class="el-license-field">
                <h4><label for="el_license_key"><?php esc_html_e("License code bellow",'drope-delivery');?></label></h4>
                <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
            </div>
            <div class="alert alert-danger" role="alert" style="margin-top:20px;">
                <h4 class="alert-heading"><?php esc_html_e("Problems with your license?",'drope-delivery');?></h4>
                <p><?php esc_html_e("If you have any problems activating your license, please contact our customer service via",'drope-delivery');?> <a href="https://api.whatsapp.com/send?phone=5591993631716&text=Ol%C3%A1,%20estou%20com%20problema%20para%20ativar%20a%20licen%C3%A7a%20do%20plugin%20*Braga%20Delivery*,%20poderia%20me%20ajudar?" target="_blank"><?php esc_html_e("WhatsApp",'drope-delivery');?></a></p>
                <p><?php esc_html_e("Note: in some cases, the license is sent to your email spam box.",'drope-delivery');?></p>
            </div>
            
            <div class="el-license-active-btn">
                <?php wp_nonce_field( 'el-license' ); ?>
                <?php submit_button('Ativar'); ?>
            </div>
        </div>
    </form>
    <?php
    }

    public function add_admin_pages() {
		$this->add_menu_page();
		$this->add_submenu_page();
	}

	public function add_menu_page() {
		add_menu_page(
			$this->menu_page['page_title'],
			$this->menu_page['menu_title'],
			$this->menu_page['capability'],
			$this->menu_page['slug'],
			$this->menu_page['call_template'],
			$this->menu_page['icon'],
			$this->menu_page['position']
		);
	}

	public function add_submenu_page() {
		$submenu_pages = apply_filters( 'mydp_before_regigster_submenu', $this->submenu_pages );
        if ((!empty(get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='))))) {
			foreach ( $submenu_pages as $submenu ) {
				if ( $submenu['condition'] === false || $submenu['condition'] === true ) {
					add_submenu_page(
						$submenu['parent_slug'],
						$submenu['page_title'],
						$submenu['menu_title'],
						$submenu['capability'],
						$submenu['slug'],
						$submenu['call_template'],
						$submenu['position']
					);
				}
			}
        }
	}

	public function get_template_dashboard() {
		include_once $this->page_templates['dashboard'];
	}

	public function get_template_settings() {
		include_once $this->page_templates['settings'];
	}

	public function get_template_reports() {
		include_once $this->page_templates['reports'];
	}

	public function get_template_customers() {
		include_once $this->page_templates['customers'];
	}

}

if (!version_compare(PHP_VERSION, DRP_MINIMUM_PHP_VERSION, '>=')) {

	add_action('admin_notices', 'mydp_admin_notice_php_version_fail');
	return;
}

if (!version_compare(get_bloginfo('version'), DRP_MINIMUM_WP_VERSION, '>=')) {

	add_action('admin_notices', 'mydp_admin_notice_wp_version_fail');
	return;
}

if ((empty(get_option(base64_decode('ZHJvcGUtZGVsaXZlcnktbGljZW5zZQ=='))))) {

	add_action('admin_notices', 'mydp_admin_notice_license_fail');
	
}

include_once DRP_PLUGIN_PATH . 'includes/class-plugin.php';
require_once DRP_PLUGIN_PATH . 'includes/vendor/autoload.php';

MydPro\Includes\Plugin::instance();

function mydp_admin_notice_php_version_fail(){

	$message = sprintf(
		esc_html__('%1$s requires PHP version %2$s or greater.', 'drope-delivery'),
		'<strong>DROPE Delivery</strong>',
		DRP_MINIMUM_PHP_VERSION
	);

	$html_message = sprintf('<div class="notice notice-error"><p>%1$s</p></div>', $message);

	echo wp_kses_post($html_message);
}

function mydp_admin_notice_wp_version_fail(){

	$message = sprintf(
		esc_html__('%1$s requires WordPress version %2$s or greater.', 'drope-delivery'),
		'<strong>DROPE Delivery</strong>',
		DRP_MINIMUM_WP_VERSION
	);

	$html_message = sprintf('<div class="notice notice-error"><p>%1$s</p></div>', $message);

	echo wp_kses_post($html_message);
}

function mydp_admin_notice_license_fail(){

	$message = sprintf(
		esc_html__('%1$s requires license key to work.', 'drope-delivery'),
		'<strong>DROPE Delivery</strong>'
	);

	$html_message = sprintf('<div class="notice notice-error"><p>%1$s</p></div>', $message);

	echo wp_kses_post($html_message);
}