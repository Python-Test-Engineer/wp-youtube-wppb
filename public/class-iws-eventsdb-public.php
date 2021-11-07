<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wp-html.co.uk
 * @since      1.0.0
 *
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Iws_Eventsdb
 * @subpackage Iws_Eventsdb/public
 * @author     Craig West <craig@wp-html.co.uk>
 */
class Iws_Eventsdb_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/iws-eventsdb-public.css', array(), $this->version, 'all' );
	

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/iws-eventsdb-public.js', array( 'jquery' ), $this->version, false );
		

		
		// $CUSTOM registering of JS frameworks
	
		$path = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL.'react/build/index.js';
		if ( (is_page('react'))) {
			wp_enqueue_script('react-eventsdb',$path, array('wp-element'), '1.0', true);
		}
		$path_js = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL.'svelte/build/bundle.js';
		$path_css = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_URL.'svelte/build/bundle.css';
	
		if ( (is_page('svelte-app'))) {
			wp_enqueue_script('svelte_js', $path_js, array(), '1.0', true);
			wp_enqueue_style( 'svelte_css',$path_css, array(), $this->version, 'all' );
		}
	}
	
	// $CUSTOM - this is the function used with filter hook in registering public hooks in incluede/class-iws-eventsdb
	public function our_own_custom_page_template($template){

		global $post;

		$page_template = $template;
		if ($post) {
		
			if($post->post_name == "react"){

			$page_template = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH."public/partials/react-tool-layout.php";
				
			return $page_template;
			}

			if($post->post_name == "js-app"){

			$page_template = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH."public/partials/js-tool-layout.php";
				
			return $page_template;
			}
			if($post->post_name == "svelte-app"){

			$page_template = EVENTSDB_MANAGEMENT_TOOL_PLUGIN_PATH."public/partials/svelte-tool-layout.php";
				
			return $page_template;
			}
		}
	return $page_template;
		
	}
}
