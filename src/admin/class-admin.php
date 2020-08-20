<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @subpackage BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use/admin
 */

namespace BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\admin;

use BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\WPPB\WPPB_Object;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @subpackage BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use/admin
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class Admin extends WPPB_Object {

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/bh-awp-auto-register-affiliatewp-users-on-first-url-use-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/bh-awp-auto-register-affiliatewp-users-on-first-url-use-admin.js', array( 'jquery' ), $this->version, false );

	}

}
