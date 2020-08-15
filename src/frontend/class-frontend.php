<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @subpackage BH_AWP_Auto_Generate_WooCommerce_Coupons/frontend
 */

namespace BH_AWP_Auto_Generate_WooCommerce_Coupons\frontend;

use BH_AWP_Auto_Generate_WooCommerce_Coupons\WPPB\WPPB_Object;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the frontend-facing stylesheet and JavaScript.
 *
 * @package    BH_AWP_Auto_Generate_WooCommerce_Coupons
 * @subpackage BH_AWP_Auto_Generate_WooCommerce_Coupons/frontend
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class Frontend extends WPPB_Object {

	/**
	 * Automatically register the user as an affiliate if not already existing.
	 *
	 * E.g. If a user visits https://example.org/ref/brianhenryie but brianhenryie is a WordPress user but not registered
	 * with AffiliateWP, this method takes care of that.
	 *
	 * http://localhost/bh-awp-auto-generate-woocommerce-coupons/?ref=bob
	 *
	 * 1. Checks the request is an affiliate link.  @see Affiliate_WP_Tracking::get_referral_var()
	 * 2.
	 *
	 * @hooked plugins_loaded
	 *
	 * @see Affiliate_WP::instance() is hooked on plugins_loaded, -1 to instantiate objects, so we presume after that
	 * is good to hook in. Need to hook before referral_var is checked though... when is that?
	 */
	public function register_missing_affiliates() {

		// TODO: ignore anything POST.
		if( is_admin() || wp_doing_ajax() || wp_doing_cron() || isset( $_REQUEST['wc-ajax'] ) ) {
			return;
		}

		// Since this isn't hooked on an AffiliateWP action, we need to check.
		if ( ! function_exists( 'affiliate_wp' ) ) {

			error_log( 'affiliate_wp() not available. Is it installed & active? Did we try call it too soon?' );

			return;
		}

		// When an Affiliate WP link is followed.
		$referral_var = affiliate_wp()->tracking->get_referral_var();

		// Since the URL is coming from external links, there can't possibly be a nonce.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_REQUEST[ $referral_var ] ) ) {

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			error_log( 'Not an Affiliate WP referral URL: ' . wp_json_encode( $_REQUEST ) );

			return;
		}

		// Sanitize ( $affiliate_ref ).
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$affiliate_ref = filter_var( wp_unslash( $_REQUEST[ $referral_var ] ) );

		// If the affiliate ref is an int, then we it's likely to be accurate, we're only going to check usernames.
		if ( is_int( $affiliate_ref ) ) {

			error_log( 'Affiliate ref is an int, we don\'t care: ' . $affiliate_ref );

			return;
		}

		// If this affiliate_ref already works, we've nothing to do.
		if ( false !== affwp_get_affiliate( $affiliate_ref ) ) {

			error_log( 'The affiliate_ref already exists: ' . $affiliate_ref );

			return;
		}

		$user = get_user_by( 'login', $affiliate_ref );

		// If the user does not exist there is nothing we can do.
		if ( false === $user ) {

			error_log( 'Affiliate ref does not match a WordPress user login: ' . $affiliate_ref );

			return;
		}

		$args = array(
			'payment_email' => $user->user_email,
			'user_id'       => $user->ID,
			'user_name'     => $user->user_login,
		);

		error_log( 'Registering affiliate using `affwp_add_affiliate( '. wp_json_encode( $args ) . ' )`' );

		// Disable the email notification to avoid a PHP fatal error.
		// PHP Fatal error:  Uncaught Error: Call to a member function get_page_permastruct() on null in /wp-includes/link-template.php:375
		add_filter( 'affwp_email_notification_enabled', function( $a, $b, $c ) { return false; }, 100, 3 );

		$new_affiliate_id = affwp_add_affiliate( $args );

		if ( false === $new_affiliate_id ) {

			error_log( 'Failed to register affiliate.' );

			return;
		}

		// Success!
		error_log( 'New affiliate registered for user ' . $user->user_login );

	}

}
