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
 * @package    BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @subpackage BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use/includes
 */

namespace BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\includes;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @subpackage BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use/includes
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
			'bh-awp-auto-register-affiliatewp-users-on-first-url-use',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
