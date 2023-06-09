<?php
// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://acrosswp.com
 * @since      1.0.0
 *
 * @package    Media_Features_For_BuddyBoss
 * @subpackage Media_Features_For_BuddyBoss/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Media_Features_For_BuddyBoss
 * @subpackage Media_Features_For_BuddyBoss/includes
 * @author     AcrossWP <contact@acrosswp.com>
 */
final class Media_Features_For_BuddyBoss {
	
	/**
	 * The single instance of the class.
	 *
	 * @var Media_Features_For_BuddyBoss
	 * @since 1.0.0
	 */
	protected static $_instance = null;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Media_Features_For_BuddyBoss_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MEDIA_FEATURES_FOR_BUDDYBOSS_VERSION' ) ) {
			$this->version = MEDIA_FEATURES_FOR_BUDDYBOSS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'media-features-for-buddyboss';

		$this->define_constants();

		$this->load_dependencies();

		$this->set_locale();

		$this->load_hooks();

	}

	/**
	 * Main Media_Features_For_BuddyBoss Instance.
	 *
	 * Ensures only one instance of WooCommerce is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @static
	 * @see Media_Features_For_BuddyBoss()
	 * @return Media_Features_For_BuddyBoss - Main instance.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Define WCE Constants
	 */
	private function define_constants() {

		$this->define( 'MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_FILE', MEDIA_FEATURES_FOR_BUDDYBOSS_FILES );
		$this->define( 'MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_BASENAME', plugin_basename( MEDIA_FEATURES_FOR_BUDDYBOSS_FILES ) );
		$this->define( 'MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH', plugin_dir_path( MEDIA_FEATURES_FOR_BUDDYBOSS_FILES ) );
		$this->define( 'MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_URL', plugin_dir_url( MEDIA_FEATURES_FOR_BUDDYBOSS_FILES ) );
		
		if( ! function_exists( 'get_plugin_data' ) ){
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		$plugin_data = get_plugin_data( MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_FILE );
		$version = $plugin_data['Version'];
		$this->define( 'MEDIA_FEATURES_FOR_BUDDYBOSS_VERSION', $version );
	}

	/**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Register all the hook once all the active plugins are loaded
	 *
	 * Uses the plugins_loaded to load all the hooks and filters
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function load_hooks() {

		/**
		 * Check if plugin can be loaded safely or not
		 * 
		 * @since    1.0.0
		 */
		if( apply_filters( 'media-features-for-buddyboss-load', true ) ) {
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Media_Features_For_BuddyBoss_Loader. Orchestrates the hooks of the plugin.
	 * - Media_Features_For_BuddyBoss_i18n. Defines internationalization functionality.
	 * - Media_Features_For_BuddyBoss_Admin. Defines all hooks for the admin area.
	 * - Media_Features_For_BuddyBoss_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for loading the dependency main class
		 * core plugin.
		 */
		require_once MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH . 'includes/dependency/class-dependency.php';

		/**
		 * The class responsible for loading the dependency main class
		 * core plugin.
		 */
		require_once MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH . 'includes/dependency/buddyboss.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH . 'includes/class-media-features-for-buddyboss-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH . 'includes/class-media-features-for-buddyboss-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH . 'admin/class-media-features-for-buddyboss-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once MEDIA_FEATURES_FOR_BUDDYBOSS_PLUGIN_PATH . 'public/class-media-features-for-buddyboss-public.php';

		$this->loader = Media_Features_For_BuddyBoss_Loader::instance();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Media_Features_For_BuddyBoss_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Media_Features_For_BuddyBoss_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		
		$plugin_admin = new Media_Features_For_BuddyBoss_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'bp_setup_integrations', $plugin_admin, 'register_integration' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Media_Features_For_BuddyBoss_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Media_Features_For_BuddyBoss_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
