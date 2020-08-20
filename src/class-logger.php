<?php
/**
 * Subclass of Klogger for configuring a static instance.
 *
 * @since             1.0.0
 * @package           BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 */

namespace BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use;

use \BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\Katzgrau\KLogger\Logger as Klogger;
use BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use\Psr\Log\LogLevel;

/**
 * Instantiate the logger to output to wp-content/logs/bh-awp-auto-register-affiliatewp-users-on-first-url-use-DATE.log.
 *
 * Class Logger
 *
 * @package BH_AWP_Auto_Register_AffiliateWP_Users_on_First_URL_Use
 */
class Logger extends KLogger {

	/**
	 * Class instance
	 *
	 * @var Logger $instace
	 */
	protected static $instance = null;

	/**
	 * Get class instance.
	 *
	 * @return KLogger
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Create an instance of the logger, setting the log file filename to match the plugin slug.
	 */
	protected function __construct() {

		$log_file_directory = WP_CONTENT_DIR . '/logs';

		$log_level = LogLevel::DEBUG;

		$plugin_slug     = 'bh-awp-auto-register-affiliatewp-users-on-first-url-use';
		$log_file_prefix = "$plugin_slug-";

		$options = array(
			'extension' => 'log',
			'prefix'    => $log_file_prefix,

		);

		parent::__construct( $log_file_directory, $log_level, $options );
	}

}
