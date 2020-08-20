<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use;

use BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\includes\BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class Plugin_Develop_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'bh_awp_auto_register_affiliatewp_users_on_first_url_use', $GLOBALS );

		$this->assertInstanceOf( BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use::class, $GLOBALS['bh_awp_auto_register_affiliatewp_users_on_first_url_use'] );
	}

}
