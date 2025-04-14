<?php
/**
 * Plugin Name:       WP Contributors
 * Plugin URI:        https://github.com/spiderwares/wp-contributors
 * Description:       A simple and lightweight plugin that enables you to assign multiple contributors to a single post with ease.
 * Version:           1.0.0
 * Author:            spiderwares
 * Author URI:        https://github.com/spiderwares
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-contributors
 * Requires PHP:      8.2
 * Requires at least: 6.0
 * Domain Path:       /languages
 *
 * @package WPContributors
 * @since 1.0.0
 */

// Check ABSPATH Define or exit on direct access.
defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WPCB_FILE' ) ) {
	/**
	 * The full path to this plugin file.
	 */
	define( 'WPCB_FILE', __FILE__ );
}

if ( ! defined( 'WPCB_BASENAME' ) ) {
	/**
	 * The basename of the plugin (folder/file.php).
	 */
	define( 'WPCB_BASENAME', plugin_basename( WPCB_FILE ) );
}

if ( ! defined( 'WPCB_VERSION' ) ) {
	/**
	 * The current version of the plugin.
	 */
	define( 'WPCB_VERSION', '1.0.0' );
}

if ( ! defined( 'WPCB_PATH' ) ) {
	/**
	 * The absolute server path to the plugin directory.
	 */
	define( 'WPCB_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WPCB_URL' ) ) {
	/**
	 * The URL to the plugin directory.
	 */
	define( 'WPCB_URL', plugin_dir_url( __FILE__ ) );
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	/**
	 * Autoload the dependencies.
	 */
	include_once __DIR__ . '/vendor/autoload.php';
} else {
	/**
	 * Do not do anything if composer install
	 * is not run.
	 */
	return;
}

if ( ! function_exists( 'wpcb' ) ) {
	/**
	 * Function to initalize.
	 */
	function wpcb() {
		return \WPContributors\WPCB_Init::get_instance();
	}

	$GLOBALS['wpcb'] = wpcb();
}
