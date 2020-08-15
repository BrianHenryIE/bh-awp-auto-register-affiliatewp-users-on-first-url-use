<?php
/**
 * Tests for the root plugin file.
 *
 * @package BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_AWP_Auto_Generate_WooCommerce_Coupons;

use BH_AWP_Auto_Generate_WooCommerce_Coupons\includes\BH_AWP_Auto_Generate_WooCommerce_Coupons;

/**
 * Class Plugin_WP_Mock_Test
 */
class Plugin_WP_Mock_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}

	/**
	 * Verifies the plugin initialization.
	 */
	public function test_plugin_include() {

		$plugin_root_dir = dirname( __DIR__, 2 ) . '/src';

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		require_once $plugin_root_dir . '/bh-awp-auto-generate-woocommerce-coupons.php';

		$this->assertArrayHasKey( 'bh_awp_auto_generate_woocommerce_coupons', $GLOBALS );

		$this->assertInstanceOf( BH_AWP_Auto_Generate_WooCommerce_Coupons::class, $GLOBALS['bh_awp_auto_generate_woocommerce_coupons'] );

	}


	/**
	 * Verifies the plugin does not output anything to screen.
	 */
	public function test_plugin_include_no_output() {

		$plugin_root_dir = dirname( __DIR__, 2 ) . '/src';

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		ob_start();

		require_once $plugin_root_dir . '/bh-awp-auto-generate-woocommerce-coupons.php';

		$printed_output = ob_get_contents();

		ob_end_clean();

		$this->assertEmpty( $printed_output );

	}

}
