<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://github.com/mallardduck
 * @since      1.0.0
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/admin
 * @author     Dan Pock (Liquid Web) <dpock@liquidweb.com>
 */
class Newer_Tag_Cloud_Admin {

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
	 * Register the options page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function register_admin_page() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/newer-tag-cloud-admin.css', array(), $this->version, 'all' );
        add_options_page('Newer Tag Cloud Options', 'Newer Tag Cloud', 8, 'newer-tag-cloud.php', 'options_page');
	}

    /**
	 * Create the options page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function options_page() {
        // Check if user is Admin
        if ( !current_user_can( 'manage_options' ) )  {
    		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    	}

        global $newtagcloud_orderoptions;

        if (isset($_POST['newtagcloud-instance'])) {
            $instanceToUse = intval($_POST['newtagcloud-instance']);
        } else {
            $instanceToUse = 0;
        }

        if (isset($_POST['newtagcloud-saveglobal'])) {
            update_newtagcloud_options();
        }

        if (isset($_POST['newtagcloud-clearcache'])) {
            newtagcloud_cache_clear();
            echo '<div id="message" class="updated fade"><p><strong>Cache cleared</strong></p></div>';
        }

        if (isset($_POST['newtagcloud-saveinstance'])) {
            update_newtagcloud_instanceoptions(intval($_POST['newtagcloud-instance']));
        }

        if (isset($_POST['newtagcloud-resetinstance'])) {
            delete_option('newtagcloud_instance' . intval($_POST['newtagcloud-instance']));
            echo '<div id="message" class="updated fade"><p><strong>';
            _e('Instance reseted.');
            echo '</strong></p></div>';
        }

        if (isset($_POST['newtagcloud-deleteinstance'])) {
            delete_newtagcloud_instance(intval($_POST['newtagcloud-instance']));
            $instanceToUse = 0;
        }

        $globalOptions = get_newtagcloud_options();
        $instanceOptions = get_newtagcloud_instanceoptions($instanceToUse);
        $instanceOptions['glue'] = str_replace(" ", "%BLANK%", $instanceOptions['glue']);
        $instanceName = unserialize($globalOptions['instances']);
        $instanceName = $instanceName[$instanceToUse];
        if (is_array($instanceOptions['tagfilter'])) {
            $tagFilter = implode(",", $instanceOptions['tagfilter']);
        } else {
            $tagFilter = "";
        }

        require __DIR__ . '/partials/newer-tag-cloud-admin-display.php';
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
		 * defined in Newer_Tag_Cloud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Newer_Tag_Cloud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/newer-tag-cloud-admin.css', array(), $this->version, 'all' );

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
		 * defined in Newer_Tag_Cloud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Newer_Tag_Cloud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/newer-tag-cloud-admin.js', array( 'jquery' ), $this->version, false );

	}

}
