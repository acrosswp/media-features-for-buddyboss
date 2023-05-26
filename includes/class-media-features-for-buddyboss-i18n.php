<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://acrosswp.com
 * @since      1.0.0
 *
 * @package    Media_Features_For_BuddyBoss
 * @subpackage Media_Features_For_BuddyBoss/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Media_Features_For_BuddyBoss
 * @subpackage Media_Features_For_BuddyBoss/includes
 * @author     AcrossWP <contact@acrosswp.com>
 */
class Media_Features_For_BuddyBoss_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'media-features-for-buddyboss',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
