<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wp-html.co.uk
 * @since      1.0.0
 *
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/includes
 * @author     Craig West <craig@wp-html.co.uk>
 */
class Iws_Eventsdb_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 * 
	 */
	public static function activate() {

		// $CUSTOM - empty initially
	 
		self::create_table();
		global $wpdb;
		
		// create page on plugin activation
		// wp_posts
		$get_data =$wpdb->get_row(
			$wpdb->prepare(
				"SELECT post_name from ".$wpdb->prefix."posts WHERE post_name = %s", 'react'
			)
		);
		// var_dump($get_data);
		// die;

		if(!empty($get_data)){
			// already we have data with this post name
		}else{
			// create page
			$post_arr_data = array(
				"post_title" => "REACT",
				"post_name" => "react",
				"post_status" => "publish",
				"post_author" => 1,
				"post_content" => "Simple page content of Event Tool",
				"post_type" => "page"
			);

			wp_insert_post($post_arr_data);
		}
	// create page on plugin activation
	// 	wp_posts
		$get_data2 =$wpdb->get_row(
			$wpdb->prepare(
				"SELECT * from ".$wpdb->prefix."posts WHERE post_name = %s", 'js_app'
			)
		);

		if(!empty($get_data2)){
			// already we have data with this post name
		}else{
			// create page
			$post_arr_data2 = array(
				"post_title" => "JS",
				"post_name" => "js-app",
				"post_status" => "publish",
				"post_author" => 1,
				"post_content" => "Simple page content of JS",
				"post_type" => "page"
			);

			wp_insert_post($post_arr_data2);
		}
	if(!empty($get_data3)){
				// already we have data with this post name
			}else{
				// create page
				$post_arr_data3 = array(
					"post_title" => "SVELTE",
					"post_name" => "svelte-app",
					"post_status" => "publish",
					"post_author" => 1,
					"post_content" => "Simple page content of SVELTE",
					"post_type" => "page"
				);

				wp_insert_post($post_arr_data3);
		}

	}

	public static function create_table(){
		
		global $wpdb;
    	$charset = $wpdb->get_charset_collate();
      $tablename =  "01_iws_tbl_events";
	
 		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		 
        dbDelta("CREATE TABLE IF NOT EXISTS $tablename (
                `event_id` BIGINT NOT NULL AUTO_INCREMENT , 
                `event_name` VARCHAR(200) NOT NULL , 
                `event_start_date` DATETIME NOT NULL , 
                `event_end_date` DATETIME NOT NULL,
								`event_image` varchar(1000)  DEFAULT NULL,
						  	`is_active` tinyint(4) NOT NULL DEFAULT 1,

                PRIMARY KEY (`event_id`)
            ) $charset;");
		$rnd = rand(200,300);
		$event_name = "ACT-TEST-${rnd}";
	

		$event_image = site_url().'/wp-content/uploads/download-1.png';
		// var_export(	$event_image, false);
		// die();

		 $query = "INSERT INTO `01_iws_tbl_events` (`event_id`, `event_name`, `event_start_date`, `event_end_date`,`event_image`) VALUES (NULL, '".$event_name."', '2021-12-09 08:35:16.000000', '2021-12-22 09:35:16.000000', '{$event_image}')";
  
       
        $wpdb->query($query);

	}



}
