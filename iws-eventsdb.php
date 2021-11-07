<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp-html.co.uk
 * @since             1.0.0
 * @package           Iws_Eventsdb
 *
 * @wordpress-plugin
 * Plugin Name:       IWS EVENTS-DB
 * Plugin URI:        https://wp-html.co.uk
 * Description:       This plugin uses WP Plugin Boilerplate for and Events List.
 * Version:           1.0.0
 * Author:            Craig West
 * Author URI:        https://wp-html.co.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       iws-eventsdb
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'IWS_EVENTSDB_VERSION', '1.0.0' );

// $CUSTOM
define( 'EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH', plugin_dir_path(__FILE__));
define( 'EVENTSDB_MANAGEMENT_TOOL_PLUGIN_BASEFILE', __FILE__ );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-iws-eventsdb-activator.php
 */
function activate_iws_eventsdb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iws-eventsdb-activator.php';
	Iws_Eventsdb_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-iws-eventsdb-deactivator.php
 */
function deactivate_iws_eventsdb() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-iws-eventsdb-deactivator.php';
	Iws_Eventsdb_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_iws_eventsdb' );
register_deactivation_hook( __FILE__, 'deactivate_iws_eventsdb' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-iws-eventsdb.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_iws_eventsdb() {

	$plugin = new Iws_Eventsdb();
	$plugin->run();

}
run_iws_eventsdb();
