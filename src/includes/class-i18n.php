<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @subpackage BH_AWP_Auto_Generate_WooCommerce_Coupons/includes
 */

namespace BH_AWP_Auto_Generate_WooCommerce_Coupons\includes;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @subpackage BH_AWP_Auto_Generate_WooCommerce_Coupons/includes
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class I18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'bh-awp-auto-generate-woocommerce-coupons',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
