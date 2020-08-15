<?php
/**
 * Tests for I18n. Tests load_plugin_textdomain.
 *
 * @package BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_AWP_Auto_Generate_WooCommerce_Coupons\includes;

/**
 * Class I18n_Test
 *
 * @see I18n
 */
class I18n_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Checks if the filter run by WordPress in the load_plugin_textdomain() function is called.
	 *
	 * @see load_plugin_textdomain()
	 */
	public function test_load_plugin_textdomain_function() {

		$called        = false;
		$actual_domain = null;

		$filter = function( $locale, $domain ) use ( &$called, &$actual_domain ) {

			$called        = true;
			$actual_domain = $domain;

			return $locale;
		};

		add_filter( 'plugin_locale', $filter, 10, 2 );

		/**
		 * Get the main plugin class.
		 *
		 * @var BH_AWP_Auto_Generate_WooCommerce_Coupons $bh_awp_auto_generate_woocommerce_coupons
		 */
		$bh_awp_auto_generate_woocommerce_coupons = $GLOBALS['bh_awp_auto_generate_woocommerce_coupons'];
		$i18n         = $bh_awp_auto_generate_woocommerce_coupons->i18n;

		$i18n->load_plugin_textdomain();

		$this->assertTrue( $called, 'plugin_locale filter not called within load_plugin_textdomain() suggesting it has not been set by the plugin.' );
		$this->assertEquals( 'bh-awp-auto-generate-woocommerce-coupons', $actual_domain );

	}
}
