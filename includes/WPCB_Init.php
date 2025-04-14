<?php
/**
 * Plugin manifest class.
 *
 * @package WPContributors
 */

namespace WPContributors;

use WPContributors\Admin\ContributorsMetabox;
use WPContributors\Public\PostContributors;

if ( ! class_exists( 'WPCB_Init' ) ) {

	/**
	 * Main WPCB_Init Class
	 *
	 * @class   WPCB_Init
	 * @version 1.0.0
	 */
	final class WPCB_Init {


		/**
		 * Constructor for the class.
		 */
		public static function get_instance() {
			// Load plugin classes.
			if ( is_admin() ) {
				self::load_admin_instance();
			} else {
				self::load_public_instance();
			}
		}

		/**
		 * Load Admin Instances
		 */
		protected static function load_admin_instance() {
			new ContributorsMetabox();
		}

		/**
		 * Load Public Instances
		 */
		protected static function load_public_instance() {
			new PostContributors();
		}
	}
}
