<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wp-html.co.uk
 * @since      1.0.0
 *
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/admin
 * @author     Craig West <craig@wp-html.co.uk>
 */
class Iws_Eventsdb_Admin_Rest {

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

	public function create_rest_routes_get() {
		// WP REST API ENDPOINT ROUTE CREATION
     
		register_rest_route( 'iws-eventsdb/v1', 'get-events',
			array(
        'methods'  => WP_REST_Server::READABLE, // For GET
        // 'methods'  => WP_REST_Server::CREATABLE, // could just use 'POST'
        'callback' => 'get_events',
		
			));
      function get_events(WP_REST_Request $request) { // works without WP_REST_Request
				// REQUEST FILTER OPTIONAL - JUST ADDED TO SHOW WHAT CAN BE DONE
				// WE MIGHT HAVE ONE ENDPOINT THAT HANDLES GET, POST, DELETE ETC.
		
						return array(
								"status"         => "SUCCESS", 
								"data"           => "data results from endpoint",
								"method"         => "POST", 
								"message"        => "ENDPOINT: iws-eventsdb-get-events", 
								"sentParams"     => "PARAMS"
								);
				}
  }

	public function create_rest_routes_post() {
		// WP REST API ENDPOINT ROUTE CREATION
     
		register_rest_route( 'iws-eventsdb/v1', 'add-event',
			array(
			//'methods'  => WP_REST_Server::READABLE, // For GET
			'methods'  => WP_REST_Server::CREATABLE, // could just use 'POST'
			'callback' => 'add_event',
			'args'     => array (
						'eventName'  => array( 
								'type'             => 'string',
						// REQUIRED AND VALIDATE_CALLBACK OPTIONAL
								'required'         => true,
								'validate_callback' => function($param){
										if (strlen($param) > 3) {
												return true;
										} else {
												return false;
										}
								}
						),
							'imageUrl'  => array( 
								'type'             => 'string',
						// REQUIRED AND VALIDATE_CALLBACK OPTIONAL
								// 'required'         => true,
								// 'validate_callback' => function($param){
								// 		if (strlen($param) > 3) {
								// 				return true;
								// 		} else {
								// 				return false;
								// 		}
								// }
							),
						'eventStartDate'  => array(
								'type'     => 'string',
						// REQUIRED AND VALIDAE_CALLBACK OPTIONAL
								'required' => true,
								'validate_callback' => function($param){
										if (strlen($param) > 3 ) {
												return true;
										} else {
												return false;
										}
								}
						),
						'eventEndDate'    => array(
								'type' => 'string',
								// REQUIRED AND VALIDAE_CALLBACK OPTIONAL
								'required' => true,
								'validate_callback' => function($param){
										if (strlen($param) > 3 ) {
												return true;
										} else {
												return false;
										}
								}
							),
							// this is the nonce from X-WP-NONCE function
							'_wpnonce'    => array(
									'type' => 'string',
									'required' => true,
									'validate_callback' => function($param){
											if ($param > -1) {
													return true;
											} else {
													return false;
											}
									}
							)
				),
							
			));

     // CALLBACK FUNTION
		function add_event(WP_REST_Request $request) { // works without WP_REST_Request
      // REQUEST FILTER OPTIONAL - JUST ADDED TO SHOW WHAT CAN BE DONE
      // WE MIGHT HAVE ONE ENDPOINT THAT HANDLES GET, POST, DELETE ETC.
      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == "POST") { 
          $parameters = array(
						
              "eventName"      => $request->get_param("eventName"),
              "eventStartDate" => $request->get_param("eventStartDate"),
              "eventEndDate"   => $request->get_param("eventEndDate"),
              "imageUrl"       => $request->get_param("imageUrl"),
							"_wpnonce"       => $request->get_param("_wpnonce"),
              );  
          // Do standard validations
          $event_name = sanitize_text_field($request->get_param("eventName"));
          $event_start_date = sanitize_text_field($request->get_param("eventStartDate"));
          $event_end_date = sanitize_text_field($request->get_param("eventEndDate"));
					 $event_image_url = sanitize_text_field($request->get_param("imageUrl"));
					$nonce =  sanitize_text_field($request->get_param("_wpnonce"));
					// $nonce = 'afdfdsafafa'; - test wrong nonce
			

					// 'NoncePageTest' was name or key we gave the nonce on the form page
					$check = wp_verify_nonce( $nonce, 'wp_rest' );
					$check = 2;
					switch ( $check ) {
							case 0:
									$message = 'Nonce FAILS. ';
										break;
							case 1:
									$message = 'VALID - Nonce is less than 12 hours old. ';
									break;
							case 2:
									$message = 'VALID - Nonce is between 12 and 24 hours old. ';
									break;
							default:
									$message = 'Nonce is invalid. ';
					}

					if ($check == 1 || $check ==2)  {
					
						$sql_query = "INSERT INTO `01_iws_tbl_events` (`event_id`, `event_name`, `event_start_date`, `event_end_date`, `event_image`) VALUES (NULL, %s, %s, %s, %s)";

						global $wpdb;
						$table_name = '01_iws_tbl_events';
		
						$wpdb->query( $wpdb->prepare( $sql_query, $event_name, $event_start_date, $event_end_date, $event_image_url) );
						
						$last_id = $wpdb->insert_id;
					
						return array(
								"status"         => "SUCCESS - New event {$last_id} added.", 
								"data"           => "data results from endpoint",
								"method"         => "POST", 
								"message"        => "ENDPOINT: iws-eventsdb-add-event", 
								"sentParams"     => $parameters
								);

					} else {
								return array( 
										"status"         => "FAILURE<br>", 
										"message"        => $message."<br>"     
								);
					}
					
      }
		}
	}



	public function create_rest_routes_edit() {
		// WP REST API ENDPOINT ROUTE CREATION
     
		register_rest_route( 'iws-eventsdb/v1', 'edit-event',
			array(
			//'methods'  => WP_REST_Server::READABLE, // For GET
			'methods'  => WP_REST_Server::CREATABLE, // could just use 'POST'
			'callback' => 'edit_event',
			'args'     => array (
						'eventId'  => array( 
								'type'             => 'string',
								
						),
						'eventName'  => array( 
								'type'             => 'string',
						// REQUIRED AND VALIDATE_CALLBACK OPTIONAL
								'required'         => true,
								'validate_callback' => function($param){
										if (strlen($param) > 0) {
												return true;
										} else {
												return false;
										}
								}
						),
							'imageUrl'  => array( 
								'type'             => 'string',
						// REQUIRED AND VALIDATE_CALLBACK OPTIONAL
								// 'required'         => true,
								// 'validate_callback' => function($param){
								// 		if (strlen($param) > 3) {
								// 				return true;
								// 		} else {
								// 				return false;
								// 		}
								// }
							),
						'eventStartDate'  => array(
								'type'     => 'string',
						// REQUIRED AND VALIDAE_CALLBACK OPTIONAL
								'required' => true,
								'validate_callback' => function($param){
										if (strlen($param) > 3 ) {
												return true;
										} else {
												return false;
										}
								}
						),
						'eventEndDate'    => array(
								'type' => 'string',
								// REQUIRED AND VALIDAE_CALLBACK OPTIONAL
								'required' => true,
								'validate_callback' => function($param){
										if (strlen($param) > 3 ) {
												return true;
										} else {
												return false;
										}
								}
							),
							// this is the nonce from X-WP-NONCE function
							'_wpnonce'    => array(
									'type' => 'string',
									'required' => true,
									'validate_callback' => function($param){
											if ($param > -1) {
													return true;
											} else {
													return false;
											}
									}
							)
				),
							
			));

     // CALLBACK FUNTION
		 
		function edit_event(WP_REST_Request $request) { // works without WP_REST_Request
      // REQUEST FILTER OPTIONAL - JUST ADDED TO SHOW WHAT CAN BE DONE
      // WE MIGHT HAVE ONE ENDPOINT THAT HANDLES GET, POST, DELETE ETC.
      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == "POST") { 
          $parameters = array(
							"eventId"        => $request->get_param("eventId"),
              "eventName"      => $request->get_param("eventName"),
              "eventStartDate" => $request->get_param("eventStartDate"),
              "eventEndDate"   => $request->get_param("eventEndDate"),
              "imageUrl"       => $request->get_param("imageUrl"),
							"_wpnonce"       => $request->get_param("_wpnonce"),
              );  
          // Do standard validations
          $event_id = absint($request->get_param("eventId"));
          $event_name = sanitize_text_field($request->get_param("eventName"));
          $event_start_date = sanitize_text_field($request->get_param("eventStartDate"));
          $event_end_date = sanitize_text_field($request->get_param("eventEndDate"));
					$event_image_url = sanitize_text_field($request->get_param("imageUrl"));
					$nonce =  sanitize_text_field($request->get_param("_wpnonce"));
					// $nonce = 'afdfdsafafa'; - test wrong nonce
			

					// 'NoncePageTest' was name or key we gave the nonce on the form page
					$check = wp_verify_nonce( $nonce, 'wp_rest' );

					// $check = 2;
					switch ( $check ) {
							case 0:
									$message = 'Nonce FAILS. ';
										break;
							case 1:
									$message = 'VALID - Nonce is less than 12 hours old. ';
									break;
							case 2:
									$message = 'VALID - Nonce is between 12 and 24 hours old. ';
									break;
							default:
									$message = 'Nonce is invalid. ';
					}

					if ($check == 1 || $check ==2)  {
					
					

						global $wpdb;
						$table_name = '01_iws_tbl_events';

						
						$wpdb->query($wpdb->prepare(
							"UPDATE 01_iws_tbl_events SET event_name = %s, event_start_date = %s, event_end_date = %s, event_image = %s WHERE event_id = %d", $event_name, $event_start_date, $event_end_date, $event_image_url, $event_id
						));
						
					
						$wpdb->query($wpdb->prepare(
							"UPDATE 01_iws_tbl_events SET event_name = %s, event_start_date = %s, event_end_date = %s, event_image = %s WHERE event_id = %d", $event_name, $event_start_date, $event_end_date, $event_image_url, $event_id
						));
					
					
						return array(
								"status"         => "SUCCESS - EVENT {$event_id} UPDATED", 
								"data"           => "data results from endpoint",
								"method"         => "POST", 
								"message"        => "ENDPOINT: iws-eventsdb-edit-event", 
								"sentParams"     => $parameters
								);

					} else {
								return array( 
										"status"         => "FAILURE<br>", 
										"message"        => $message."<br>"     
								);
					}
					
      }
		}
	}


	public function create_rest_routes_delete() {
		// WP REST API ENDPOINT ROUTE CREATION
     
		register_rest_route( 'iws-eventsdb/v1', 'delete-event',
			array(
			//'methods'  => WP_REST_Server::READABLE, // For GET
			'methods'  => WP_REST_Server::CREATABLE, // could just use 'POST'
			'callback' => 'delete_event',
			'args'     => array (
											'eventId'  => array( 
													'type'             => 'string',
													
											),
					
											// this is the nonce from X-WP-NONCE function
											'_wpnonce'    => array(
													'type' => 'string',
													'required' => true,
													'validate_callback' => function($param){
															if ($param > -1) {
																	return true;
															} else {
																	return false;
															}
													}
							)
				),
							
			));

     // CALLBACK FUNTION
		 
		function delete_event(WP_REST_Request $request) { // works without WP_REST_Request
      // REQUEST FILTER OPTIONAL - JUST ADDED TO SHOW WHAT CAN BE DONE
      // WE MIGHT HAVE ONE ENDPOINT THAT HANDLES GET, POST, DELETE ETC.
      $request_type = $_SERVER['REQUEST_METHOD'];
      if ($request_type == "POST") { 
          $parameters = array(
							"eventId"        => $request->get_param("eventId"),
							"_wpnonce"       => $request->get_param("_wpnonce"),
              );  
          // Do standard validations
          $event_id = absint($request->get_param("eventId"));
					$nonce =  sanitize_text_field($request->get_param("_wpnonce"));
					// $nonce = 'afdfdsafafa'; - test wrong nonce
					// 'NoncePageTest' was name or key we gave the nonce on the form page
					$check = wp_verify_nonce( $nonce, 'wp_rest' );

					$check = 2;
					switch ( $check ) {
							case 0:
									$message = 'Nonce FAILS. ';
										break;
							case 1:
									$message = 'VALID - Nonce is less than 12 hours old. ';
									break;
							case 2:
									$message = 'VALID - Nonce is between 12 and 24 hours old. ';
									break;
							default:
									$message = 'Nonce is invalid. ';
					}

					if ($check == 1 || $check ==2)  {
					
						global $wpdb;
						$table_name = '01_iws_tbl_events';
					
						$wpdb->query($wpdb->prepare(
							"UPDATE 01_iws_tbl_events SET is_active = 0 WHERE event_id = %d", $event_id
						));
					
					
						return array(
								"status"         => "SUCCESS - EVENT {$event_id} has is_active set to false<br>", 
								"data"           => "data results from endpoint",
								"method"         => "POST", 
								"message"        => "ENDPOINT: iws-eventsdb-delete-event", 
								"sentParams"     => $parameters
								);

					} else {
								return array( 
										"status"         => "FAILURE<br>", 
										"message"        => $message."<br>"     
								);
					}
					
      }
		}
	}
}
