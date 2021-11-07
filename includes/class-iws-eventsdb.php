<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp-html.co.uk
 * @since      1.0.0
 *
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/includes
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
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/includes
 * @author     Craig West <craig@wp-html.co.uk>
 */
class Iws_Eventsdb {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Iws_Eventsdb_Loader    $loader    Maintains and registers all hooks for the plugin.
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
		if ( defined( 'IWS_EVENTSDB_VERSION' ) ) {
			$this->version = IWS_EVENTSDB_VERSION; // $CUSTOM - add our custom global constant 
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'iws-eventsdb';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Iws_Eventsdb_Loader. Orchestrates the hooks of the plugin.
	 * - Iws_Eventsdb_i18n. Defines internationalization functionality.
	 * - Iws_Eventsdb_Admin. Defines all hooks for the admin area.
	 * - Iws_Eventsdb_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/** $CUSTOM  */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/helpers.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iws-eventsdb-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-iws-eventsdb-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-iws-eventsdb-admin.php';
				/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-iws-eventsdb-public.php';

		// $CUSTOM
		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-iws-eventsdb-admin-rest.php';
	

		$this->loader = new Iws_Eventsdb_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Iws_Eventsdb_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Iws_Eventsdb_i18n();

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

		$plugin_admin = new Iws_Eventsdb_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	
	
		
		// $CUSTOM
		// this is in class-iws-eventsdb-admin.php creating admin pages
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'event_management_menu' ); 
    
		// Hook for Plugin Action Links
		$this->loader->add_filter(
			'plugin_action_links_' . plugin_basename(EVENTSDB_MANAGEMENT_TOOL_PLUGIN_BASEFILE), 
			$plugin_admin, 
			'add_plugin_action_links');
		
		// Create rest routes for admin/create-event etc
		$plugin_admin_rest = new Iws_Eventsdb_Admin_Rest( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'rest_api_init', $plugin_admin_rest, 'create_rest_routes_get' );
		$this->loader->add_action( 'rest_api_init', $plugin_admin_rest, 'create_rest_routes_post' );
		$this->loader->add_action( 'rest_api_init', $plugin_admin_rest, 'create_rest_routes_edit' );
		$this->loader->add_action( 'rest_api_init', $plugin_admin_rest, 'create_rest_routes_delete' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Iws_Eventsdb_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		//$CUSTOM - filter for page template redirect
		$this->loader->add_filter("page_template", $plugin_public, "our_own_custom_page_template");
		// Hook for Plugin Action Links
		$this->loader->add_filter("admin_init", $plugin_public, "our_own_custom_page_template");

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
	 * @return    Iws_Eventsdb_Loader    Orchestrates the hooks of the plugin.
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
