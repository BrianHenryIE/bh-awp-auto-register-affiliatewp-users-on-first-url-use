<?php
/**
 * Tests for the root plugin file.
 *
 * @package BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use;

use BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\includes\BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use;

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

		require_once $plugin_root_dir . '/bh-awp-auto-register-affiliatewp-users-on-first-url-use.php';

		$this->assertArrayHasKey( 'bh_awp_auto_register_affiliatewp_users_on_first_url_use', $GLOBALS );

		$this->assertInstanceOf( BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use::class, $GLOBALS['bh_awp_auto_register_affiliatewp_users_on_first_url_use'] );

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

		require_once $plugin_root_dir . '/bh-awp-auto-register-affiliatewp-users-on-first-url-use.php';

		$printed_output = ob_get_contents();

		ob_end_clean();

		$this->assertEmpty( $printed_output );

	}

}
