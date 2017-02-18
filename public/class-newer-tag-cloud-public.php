<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://github.com/mallardduck
 * @since      1.0.0
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/public
 * @author     Dan Pock (Liquid Web) <dpock@liquidweb.com>
 */
class Newer_Tag_Cloud_Public {

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

    function newtagcloud_control()
    {
        global $newtagcloud_defaults;

        $globalOptions = get_newtagcloud_options();
        $instanceOptions = get_newtagcloud_instanceoptions($globalOptions['widgetinstance']);
        if (isset($_POST['newtagcloud-title'])) {
            $instanceOptions['title'] = strip_tags(stripslashes($_POST['newtagcloud-title']));
            update_option('newtagcloud_instance' . $globalOptions['widgetinstance'], $instanceOptions);
        }
        echo '<p style="text-align:right;"><label for="newtagcloud-title">Title: <input style="width: 250px;" id="newtagcloud-title" name="newtagcloud-title" type="text" value="'.$instanceOptions['title'].'" /></label></p>';
    }

    /**
	 * Create the options page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function newtagcloud_init() {
	{
	    if (!function_exists('wp_register_sidebar_widget') || !function_exists('wp_register_widget_control')) {
	        return;
	    }
	    function print_newertagcloud($args)
	    {
	        extract($args);
            $globalOptions = get_newtagcloud_options();
            $cloud = generate_newtagcloud(true, true, $globalOptions['widgetinstance']);
            require __DIR__ . '/partials/newer-tag-cloud-public-display.php';
	    }
	    wp_register_sidebar_widget('new_tag_cloud-lw', 'New Tag Cloud', 'print_newertagcloud');
	    wp_register_widget_control('new_tag_cloud-lw', 'New Tag Cloud', 'newtagcloud_control', 50, 10);
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
		 * defined in Newer_Tag_Cloud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Newer_Tag_Cloud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/newer-tag-cloud-public.css', array(), $this->version, 'all' );

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
		 * defined in Newer_Tag_Cloud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Newer_Tag_Cloud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/newer-tag-cloud-public.js', array( 'jquery' ), $this->version, false );

	}

}
