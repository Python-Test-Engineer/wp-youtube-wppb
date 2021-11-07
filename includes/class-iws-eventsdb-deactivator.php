<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://wp-html.co.uk
 * @since      1.0.0
 *
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/includes
 * @author     Craig West <craig@wp-html.co.uk>
 */
class Iws_Eventsdb_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		 // delete pages when plugin deactivates
		global $wpdb;

 		$table = 'plugins_posts';
    $wpdb->delete( $table, array( 'post_title' => 'REACT') );
    $wpdb->delete( $table, array( 'post_title' => 'SVELTE') );
    $wpdb->delete( $table, array( 'post_title' => 'JS') );
	
	}
}


