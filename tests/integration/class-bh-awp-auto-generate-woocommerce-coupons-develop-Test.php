<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_AWP_Auto_Generate_WooCommerce_Coupons;

use BH_AWP_Auto_Generate_WooCommerce_Coupons\includes\BH_AWP_Auto_Generate_WooCommerce_Coupons;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Develop_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'bh_awp_auto_generate_woocommerce_coupons', $GLOBALS );

		$this->assertInstanceOf( BH_AWP_Auto_Generate_WooCommerce_Coupons::class, $GLOBALS['bh_awp_auto_generate_woocommerce_coupons'] );
	}

}
