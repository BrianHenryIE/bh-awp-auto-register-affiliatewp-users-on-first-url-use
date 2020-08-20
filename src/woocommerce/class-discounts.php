<?php
/**
 * The WooCommerce functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @subpackage BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use/woocommerce
 */

namespace BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\woocommerce;

use BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\Logger;
use BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\Psr\Log\LogLevel;
use BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\WPPB\WPPB_Object;
use WP_User;

/**
 * The WooCommerce related functionality of the plugin.
 *
 * @package    BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 * @subpackage BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use/woocommerce
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class Discounts extends WPPB_Object {

	/**
	 * TODO: Code deduplication.
	 * TODO: ignore anything POST.
	 * TODO: ignore REST?
	 */

	/**
	 * Should really be hooked on an Affiliate WP hook but we're hooking to plugins_loaded after where we hook to
	 * make sure the affiliate exists.
	 *
	 * @see https://www.mootpoint.org/blog/create-woocommerce-coupon-programmatically/
	 *
	 * @hooked wp_loaded
	 */
	public function create_coupon() {

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || isset( $_REQUEST['wc-ajax'] ) ) {
			return;
		}

		// Since this isn't hooked on an AffiliateWP action, we need to check.
		if ( ! function_exists( 'affiliate_wp' ) ) {

			Logger::get_instance()->debug( 'affiliate_wp() not available. Is it installed & active? Did we try call it too soon?' );

			return;

		}

		if ( ! class_exists( \WooCommerce::class ) ) {

			Logger::get_instance()->debug( 'WooCommerce not active.' );
			return;
		}

		if ( ! wc_coupons_enabled() ) {
			// Nothing to do here.
			return;
		}

		// When an Affiliate WP link is followed.
		$referral_var = affiliate_wp()->tracking->get_referral_var();

		// Since the URL is coming from external links, there can't possibly be a nonce.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_REQUEST[ $referral_var ] ) ) {

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			Logger::get_instance()->debug( 'Not an Affiliate WP referral URL: ' . wp_json_encode( $_REQUEST ) );

			return;
		}

		// Sanitize ( $affiliate_ref ).
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$affiliate_ref = filter_var( wp_unslash( $_REQUEST[ $referral_var ] ) );

		$affiliate = affwp_get_affiliate( $affiliate_ref );

		// This could happen if auto-registering the affiliate is not enabled.
		if ( false === $affiliate ) {

			Logger::get_instance()->debug( 'The affiliate_ref does not exists, cannot create a coupon: ' . $affiliate_ref );

			return;
		}

		/**
		 * The WordPress user account for the specified affiliate.
		 *
		 * @var WP_User $wp_user
		 */
		$wp_user = $affiliate->get_user();

		// Get coupons for affiliate. // Is this possible?
		// update_post_meta( $coupon_id, 'affwp_discount_affiliate', $affiliate_id );
		// Not efficiently.

		// Look for a coupon id is same as affiliate id.

		$coupon = wc_get_coupon_id_by_code( $wp_user->user_login );

		if ( is_null( $coupon ) ) {
			return;
		}

		if ( 0 !== $coupon ) {

			Logger::get_instance()->debug( 'Coupon already exists for this affiliate ' . $wp_user->user_login . ' ' . $wp_user->ID );

			return;
		}

		Logger::get_instance()->info( 'Creating coupon for affiliate  ' . $wp_user->user_login . ' ' . $wp_user->ID );

		// TODO: Is it possible to have coupons generated on the fly, i.e. a standard affiliate discount that
		// doesn't need x number of individual coupons created in the database, particularly so they can all be
		// easily adjusted?

		// Create a coupon with the properties you need.
		$data = array(
			'discount_type'  => 'percentage',
			'coupon_amount'  => 15,
			'individual_use' => 'no',
			'free_shipping'  => 'yes',

		);
		// Save the coupon in the database.
		$coupon        = array(
			'post_title'   => $wp_user->user_login,
			'post_content' => '',
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_type'    => 'shop_coupon',
		);
		$new_coupon_id = wp_insert_post( $coupon );
		// Write the $data values into postmeta table.
		foreach ( $data as $key => $value ) {
			update_post_meta( $new_coupon_id, $key, $value );
		}

		update_post_meta( $new_coupon_id, 'affwp_discount_affiliate', $affiliate->affiliate_id );

	}


	/**
	 * If a coupon exists for the affiliate being ref'd, apply that coupon to the cart.
	 *
	 * @hooked wp_loaded
	 * @see https://github.com/woocommerce/woocommerce/commit/fb8f5fc750baa772fa057731479fad74a20d33aa
	 */
	public function apply_coupon() {

		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || isset( $_REQUEST['wc-ajax'] ) ) {
			return;
		}

		// Since this isn't hooked on an AffiliateWP action, we need to check.
		if ( ! function_exists( 'affiliate_wp' ) ) {

			Logger::get_instance()->debug( 'affiliate_wp() not available. Is it installed & active? Did we try call it too soon?' );

			return;
		}

		if ( ! class_exists( \WooCommerce::class ) ) {

			Logger::get_instance()->debug( 'WooCommerce not active.' );
			return;
		}

		if ( ! wc_coupons_enabled() ) {
			// Nothing to do here.
			return;
		}

		// When an Affiliate WP link is followed.
		$referral_var = affiliate_wp()->tracking->get_referral_var();

		// Since the URL is coming from external links, there can't possibly be a nonce.
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_REQUEST[ $referral_var ] ) ) {

			// phpcs:ignore WordPress.Security.NonceVerification.Recommended
			Logger::get_instance()->debug( 'Not an Affiliate WP referral URL: ' . wp_json_encode( $_REQUEST ) );

			return;
		}

		// Sanitize ( $affiliate_ref ).
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		$affiliate_ref = filter_var( wp_unslash( $_REQUEST[ $referral_var ] ) );

		$affiliate = affwp_get_affiliate( $affiliate_ref );

		// This could happen if auto-registering the affiliate is not enabled.
		if ( false === $affiliate ) {

			Logger::get_instance()->debug( 'The affiliate_ref does not exists, cannot create a coupon: ' . $affiliate_ref );

			return;
		}

		/**
		 * The WordPress user account for the specified affiliate.
		 *
		 * @var WP_User $wp_user
		 */
		$wp_user = $affiliate->get_user();

		// Get coupons for affiliate. // Is this possible?
		// update_post_meta( $coupon_id, 'affwp_discount_affiliate', $affiliate_id );
		// Not efficiently.

		// Look for a coupon id is same as affiliate id.

		$coupon = wc_get_coupon_id_by_code( $wp_user->user_login );

		if ( 0 === $coupon ) {
			return;
		}

		if ( WC()->cart->has_discount( $wp_user->user_login ) ) {
			return;
		}

		Logger::get_instance()->info( 'Applying discount for affiliate ' . $wp_user->user_login );

		WC()->cart->add_discount( $wp_user->user_login );

	}

}
