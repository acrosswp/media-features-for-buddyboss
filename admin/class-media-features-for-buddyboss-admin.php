<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://acrosswp.com
 * @since      1.0.0
 *
 * @package    Media_Features_For_BuddyBoss
 * @subpackage Media_Features_For_BuddyBoss/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Media_Features_For_BuddyBoss
 * @subpackage Media_Features_For_BuddyBoss/admin
 * @author     AcrossWP <contact@acrosswp.com>
 */
class Media_Features_For_BuddyBoss_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Add class
	 */
	public function register_integration() {
		require_once MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH . 'admin/integration/buddyboss-integration.php';
		buddypress()->integrations['addon'] = new Media_Features_For_BuddyBoss_BuddyBoss_Integration( $this->plugin_name );
	}

}
