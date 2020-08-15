<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           BH_AWP_Auto_Generate_WooCommerce_Coupons
 *
 * @wordpress-plugin
 * Plugin Name:       Auto Generate Affiliate WP Users & WooCommerce Coupons
 * Plugin URI:        http://github.com/BrianHenryIE/bh-awp-auto-generate-woocommerce-coupons/
 * Description:       Registers users as affiliates after their link is used for the first time. Creates a matching WooCommerce coupon.
 * Version:           1.0.0
 * Author:            Brian Henry
 * Author URI:        http://example.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-awp-auto-generate-woocommerce-coupons
 * Domain Path:       /languages
 */

namespace BH_AWP_Auto_Generate_WooCommerce_Coupons;

use BH_AWP_Auto_Generate_WooCommerce_Coupons\includes\Activator;
use BH_AWP_Auto_Generate_WooCommerce_Coupons\includes\Deactivator;
use BH_AWP_Auto_Generate_WooCommerce_Coupons\includes\BH_AWP_Auto_Generate_WooCommerce_Coupons;
use BH_AWP_Auto_Generate_WooCommerce_Coupons\WPPB\WPPB_Loader;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BH_AWP_AUTO_GENERATE_WOOCOMMERCE_COUPONS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-activator.php
 */
function activate_bh_awp_auto_generate_woocommerce_coupons() {

	Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-deactivator.php
 */
function deactivate_bh_awp_auto_generate_woocommerce_coupons() {

	Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'BH_AWP_Auto_Generate_WooCommerce_Coupons\activate_bh_awp_auto_generate_woocommerce_coupons' );
register_deactivation_hook( __FILE__, 'BH_AWP_Auto_Generate_WooCommerce_Coupons\deactivate_bh_awp_auto_generate_woocommerce_coupons' );


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_bh_awp_auto_generate_woocommerce_coupons() {

	$loader = new WPPB_Loader();
	$plugin = new BH_AWP_Auto_Generate_WooCommerce_Coupons( $loader );

	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['bh_awp_auto_generate_woocommerce_coupons'] = $bh_awp_auto_generate_woocommerce_coupons = instantiate_bh_awp_auto_generate_woocommerce_coupons();
$bh_awp_auto_generate_woocommerce_coupons->run();
