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
class Iws_Eventsdb_Admin {

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iws_Eventsdb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iws_Eventsdb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
	
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iws-eventsdb-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Iws_Eventsdb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Iws_Eventsdb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iws-eventsdb-admin.js', array(), $this->version, false ); 
		// can avoid jQuery - in this example we use JS - normally array('jQuery') would be used but in this plugin it is set to null
		
		// $CUSTOM
		// Register and enqueue scripts in admin/js - these can be helper functions that can then be called elsewhere, for example in partials/create-event.php we can refactor validate JS into other JS files
		wp_register_script( 'forms', plugin_dir_url( __FILE__ ) . 'js/iws-eventsdb-forms.js');
		wp_enqueue_script( 'forms', plugin_dir_url( __FILE__ ) . 'js/iws-eventsdb-forms.js', array( ), $this->version, true );

	}
	
	public function handle_ajax_requests_admin(){

	}

	// $CUSTOM
	
	// the main hook called in class-iws-eventdb.admin.php
	// it uses many functions listed below in event_managememt_menu
 
	public function event_management_menu(){

		add_menu_page("EventsDB", "EventsDB", "manage_options", "event-management-tool", array($this, "event_management_plugin"), "dashicons-admin-site-alt3", 4);

    // create plugin submenus
		add_submenu_page("event-management-tool","Dashboard", "Dashboard", "manage_options", "event-management-tool", array($this, "event_management_plugin"));


		add_submenu_page("event-management-tool","Create Event", "Create Event", "manage_options", "event-management-create-event", array($this, "event_management_create_event"));

		add_submenu_page("event-management-tool","List Events", "List Events", "manage_options", "event-management-list-event", array($this, "event_management_list_event"));

		add_submenu_page("event-management-tool","Options", "Options", "manage_options", "event-management-options", array($this, "event_management_options"));

	

		// add sub-menu page but don't list - set parent to null
		add_submenu_page(null,"Edit Event", "Edit Event", "manage_options", "event-management-edit-event", array($this, "event_management_edit_event"));
		add_submenu_page(null,"Delete Event", "Delete Event", "manage_options", "event-management-delete-event", array($this, "event_management_delete_event"));
	

	
		// wp_localize_script needs to be linked to an enqueued js file
		wp_register_script( 'wp-rest', plugin_dir_url( __FILE__ ) . 'js/iws-eventsdb-admin.js');
		wp_enqueue_script( 'wp-rest', plugin_dir_url( __FILE__ ) . 'js/iws-eventsdb-admin.js');


		wp_localize_script( 'wp-rest', 'siteObj',
				array( 
						'siteUrl'    => site_url(),  
						'adminUrl'   => admin_url().'admin.php?'
				)
		);

	}

	// Add links to plugin in Plugin dashboard
	public function add_plugin_action_links($links){
		 $mylinks = array(
      '<a href="' . admin_url( 'options-general.php?page=event-management-options' ) . '">Settings</a>',
			'<a href="' . admin_url( 'admin.php?page=event-management-tool' ) . '">Details</a>',

   );
 
   return  array_merge( $links, $mylinks );

	}
	// Now that hook has been fired, we can create the sub pages.

	// Settings page



	public function event_management_options(){
			echo "<h1>OPTIONS</h1>";
			
	}
	// Dashboard sub-menu page

 public function event_management_plugin(){
		// this function creates the Dashboard sub menu page called in add_submenu_page
		// these are custom functions declared later in file
		$this->event_management_dashboard();
		$this->sample_wpdb();
		// $this->sample_prepare_wpdb();
		
	}

	public function event_management_dashboard(){

		echo "<h1>Welcome to Plugin Dashboard</h1>";
		// fn in helpers-admin.php
		echo helpersAdmin();	
		$admin_url = admin_url();
		echo $admin_url.'<br>';
		$settings_page = $admin_url.'admin.php?page=event-management-options';
		echo "<h1>Setting page: <a href=$settings_page>here...</a></h1>";
	

	}	

	// List Events sub-page
	public function event_management_list_event(){ 
		$admin_url = admin_url();

		if (isset($_GET['page']) == 'event-management-list-event') {
 				 echo "<h1>event-management-list-event</h1>";
		}
		
		?>
		<div class="wrap">
			<h1>List Events</h1>
		
			<table class="wp-lit-table widefat striped table-events" id="table_events"> 
				<thead>
					<tr>
						<th class="manage-column">ID</th>
						<th class="manage-column">Event Name</th>
						<th class="manage-column">Event Start</th>
						<th class="manage-column">Event End</th>
						<th class="manage-column">Edit</th>
						<th class="manage-column">Delete</th>
					</tr>	
				</thead>
				<tbody></tbody>
				<?php 
					global $wpdb;
					$table ='01_iws_tbl_events';
					$events =  $wpdb->get_results("SELECT * FROM $table WHERE is_active = 1 ORDER BY event_id DESC", ARRAY_A);
					// echo '<pre>';
					// var_dump($events);
					// echo '</pre>';
					foreach($events as $event) { ?>

					<tr>
						<td><?php echo $event['event_id'] ?></td>
						<td><?php echo $event['event_name'] ?></td>
						<td><?php echo $event['event_start_date'] ?></td>
						<td><?php echo $event['event_end_date'] ?></td>
						<td ><a href="<?php echo $admin_url ?>admin.php?page=event-management-edit-event&id=<?php echo $event['event_id'] ;?>" class="update-event" data-id="<?php echo $event['event_id'] ;?>" data-action="edit">Edit - <?php echo $event['event_id'] ?></a></td>
						<td ><a href="<?php echo $admin_url ?>admin.php?page=event-management-delete-event&id=<?php echo $event['event_id'] ;?>" class="delete-event" data-id="<?php echo $event['event_id'] ;?>" data-action="edit">Delete - <?php echo $event['event_id'] ?></a></td>
					</tr>

					<?php
					}

				?>
			</table>	
		
		</div>
   
	<?php
	}
	// Edit Events sub-page
	public function event_management_edit_event(){ 
			ob_start(); // started buffer

		include_once(EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH."admin/partials/tmpl-edit-event.php"); // included template file

		$template = ob_get_contents(); // reading content
	
		ob_end_clean(); // closing and cleaning buffer

		echo $template;
	
	}
		// Edit Events sub-page
	public function event_management_delete_event(){ 
			ob_start(); // started buffer

		include_once(EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH."admin/partials/tmpl-delete-event.php"); // included template file

		$template = ob_get_contents(); // reading content
	
		ob_end_clean(); // closing and cleaning buffer

		echo $template;
	
	}
	// Create Event sub-page
	public function event_management_create_event(){

		ob_start(); // started buffer

		include_once(EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH."admin/partials/tmpl-create-event.php"); // included template file

		$template = ob_get_contents(); // reading content

		//DEBUG - can be put in tmpl file too
		$template .=  '<div id="plugin-info"><br>EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH: '.EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH;
		$template .=  '<br>EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL: '.EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL;
		$current_url = home_url($_SERVER['REQUEST_URI']);
		$template .=  '<br>'.$current_url;
		$variable = $_GET['page'];
		$template .=  '<br>slug: '.$variable.'</div>';

		ob_end_clean(); // closing and cleaning buffer

		echo $template;
	}

	// functions used in Dashboard page...
	public function sample_wpdb(){

		global $wpdb;

		$prefix = $wpdb->prefix;

		$user_email = $wpdb->get_var("SELECT user_email from {$prefix}users WHERE ID = 1");

		echo "<h2>User Email: ".$user_email."</h2>";

		$user_data = $wpdb->get_row(
			"SELECT * FROM {$prefix}users WHERE ID = 1", ARRAY_A
		);

		echo "<pre>";
		print_r($user_data);
		echo "</pre>";

		$user_data = $wpdb->get_row(
			"SELECT * FROM {$prefix}users WHERE ID = 1", ARRAY_A
		);

		echo "<pre>";
		print_r($user_data);
		echo "</pre>";

		$post_title = $wpdb->get_col(
			"SELECT post_title FROM {$prefix}posts WHERE post_status='publish';"
		);

		echo "<pre>";
		print_r($post_title);
		echo "</pre>";
		
		echo "----------------------";

		$all_posts = $wpdb->get_results(
			"SELECT  ID, post_author, post_title FROM {$prefix}posts WHERE  post_status ='publish'", ARRAY_A
		);

		echo "<pre>";
		print_r($all_posts);
		echo "</pre>";
	}

	public function sample_prepare_wpdb(){
		$sql_query = "INSERT INTO `01_iws_tbl_events` (`event_id`, `event_name`, `event_start_date`, `event_end_date`, `event_image`) VALUES (NULL, %s, %s, %s, %s)";

		global $wpdb;

		$rnd = rand(1,100);
		$table_name = '01_iws_tbl_events';
		$event_name = "PREPARED EVENT {$rnd} ADMIN PAGE";
		$event_start_date = '2023-01-09 08:35:16';
		$event_end_date = '2023-12-22 09:35:16';
		$event_image_url = site_url().'/wp-content/uploads/default-1.png';
		$wpdb->query( 
			$wpdb->prepare( 
							$sql_query, 
							$event_name, 	
							$event_start_date, 
							$event_end_date,
							$event_image_url
						) 
			);
		
	}

		/**
		 * To add Plugin Menu and Settings page
		 */
		public function plugin_menu_settings_using_helper() {

		require_once IWS_EVENTSDB_BASE_DIR . 'vendor/boo-settings-helper/class-boo-settings-helper.php';

		$iws_eventsdb_settings = array(
		'tabs'     => true,
		'prefix'   => 'iws_',
		'menu'     =>
			array(
				'page_title' => __( 'IWS EVENTSDB Settings', 'iws-eventsdb' ),
				'menu_title' => __( 'EVENTSDB OPTIONS', 'iws-eventsdb' ),
				'slug'       => 'event-management-options',
				'capability' => 'manage_options',
			
				'icon'       => 'dashicons-admin-site-alt',
				'position'   => 90,
				'parent'     => 'options-general.php',
				// 'parent'     => 'admin.php?page=event-management-tool',
				'submenu'    => true,
			),

		'sections' =>
			array(
				array(
					'id'    => 'general_section',
					'title' => __( 'General Settings', 'iws-eventsdb' ),
					'desc'  => __( 'These are general settings for Plugin Name', 'iws-eventsdb' ),
				),
				array(
					'id'    => 'advance_section',
					'title' => __( 'Advanced Settings', 'iws-eventsdb' ),
					'desc'  => __( 'These are advance settings for Plugin Name', 'iws-eventsdb' )
				)
			),
		'fields'   => array(
			'general_section' => array(
				array(
					'id'    => 'iws_text_field_id',
					'label' => __( 'Text Field', 'iws-eventsdb' ),
				),
				array(
					'id'    => 'color_field_id',
					'label' => __( 'Color Field', 'iws-eventsdb' ),
					'type'  => 'color',
				),
				array(
					'id'      => 'radio_field_id',
					'label'   => __( 'Radio Button', 'iws-eventsdb' ),
					'desc'    => __( 'A radio button', 'iws-eventsdb' ),
					'type'    => 'radio',
					'options' => array(
						'radio_1' => 'Radio 1',
						'radio_2' => 'Radio 2',
						'radio_3' => 'Radio 3'
					),
					'default' => 'radio_2',
				),
				array(
					'id'      => 'select_field_id',
					'label'   => __( 'A Dropdown Select', 'plugin-name' ),
					'desc'    => __( 'Dropdown description', 'plugin-name' ),
					'type'    => 'select',
					'default' => 'option_2',
					'options' => array(
						'option_1' => 'Option 1',
						'option_2' => 'Option 2',
						'option_3' => 'Option 3'
					),
				),
			),
			'advance_section' => array(
				array(
					'id'                => 'adv_text_field_id',
					'label'             => __( 'Another Text', 'plugin-name' ),
					'desc'              => __( 'with sanitize callback "sanitize_title"', 'plugin-name' ),
					'placeholder'       => __( 'Text Input placeholder', 'plugin-name' ),
					'type'              => 'text',
					'default'           => '',
					'sanitize_callback' => 'sanitize_title'
				)
			)
		),
		'links'    => array(
			'plugin_basename' => plugin_basename( __FILE__ ),
			'action_links'    => true,
		),
	);

			new Boo_Settings_Helper( $iws_eventsdb_settings );

		}

}