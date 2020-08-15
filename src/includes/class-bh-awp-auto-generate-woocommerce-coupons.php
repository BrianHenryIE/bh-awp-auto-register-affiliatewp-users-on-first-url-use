<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * frontend-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @subpackage BH_AWP_Auto_Generate_WooCommerce_Coupons/includes
 */

namespace BH_AWP_Auto_Generate_WooCommerce_Coupons\includes;

use BH_AWP_Auto_Generate_WooCommerce_Coupons\admin\Admin;
use BH_AWP_Auto_Generate_WooCommerce_Coupons\frontend\Frontend;
use BH_AWP_Auto_Generate_WooCommerce_Coupons\woocommerce\Discounts;
use BH_AWP_Auto_Generate_WooCommerce_Coupons\WPPB\WPPB_Loader_Interface;
use BH_AWP_Auto_Generate_WooCommerce_Coupons\WPPB\WPPB_Object;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * frontend-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @subpackage BH_AWP_Auto_Generate_WooCommerce_Coupons/includes
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class BH_AWP_Auto_Generate_WooCommerce_Coupons extends WPPB_Object {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPPB_Loader_Interface    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param WPPB_Loader_Interface $loader The WPPB class which adds the hooks and filters to WordPress.
	 */
	public function __construct( $loader ) {
		if ( defined( 'BH_AWP_AUTO_GENERATE_WOOCOMMERCE_COUPONS_VERSION' ) ) {
			$this->version = BH_AWP_AUTO_GENERATE_WOOCOMMERCE_COUPONS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bh-awp-auto-generate-woocommerce-coupons';

		parent::__construct( $this->plugin_name, $this->version );

		$this->loader = $loader;

		$this->set_locale();
		$this->define_admin_hooks();

		$this->define_frontend_hooks();
		$this->define_woocommerce_hooks();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_frontend_hooks() {

		$plugin_frontend = new Frontend( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'plugins_loaded', $plugin_frontend, 'register_missing_affiliates', 6 );

	}

	protected function define_woocommerce_hooks() {

		$woocommerce_discounts = new Discounts( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'plugins_loaded', $woocommerce_discounts, 'create_coupon', 7 );

		$this->loader->add_action( 'plugins_loaded', $woocommerce_discounts, 'apply_coupon', 8 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPPB_Loader_Interface    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

}
