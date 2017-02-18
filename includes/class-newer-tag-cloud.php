<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://github.com/mallardduck
 * @since      1.0.0
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/includes
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
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/includes
 * @author     Dan Pock (Liquid Web) <dpock@liquidweb.com>
 */
class Newer_Tag_Cloud {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Newer_Tag_Cloud_Loader    $loader    Maintains and registers all hooks for the plugin.
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

		$this->plugin_name = 'newer-tag-cloud';
		$this->version = '1.0.0';

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
	 * - Newer_Tag_Cloud_Loader. Orchestrates the hooks of the plugin.
	 * - Newer_Tag_Cloud_i18n. Defines internationalization functionality.
	 * - Newer_Tag_Cloud_Admin. Defines all hooks for the admin area.
	 * - Newer_Tag_Cloud_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-newer-tag-cloud-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-newer-tag-cloud-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-newer-tag-cloud-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-newer-tag-cloud-public.php';

		$this->loader = new Newer_Tag_Cloud_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Newer_Tag_Cloud_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Newer_Tag_Cloud_i18n();

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

		$plugin_admin = new Newer_Tag_Cloud_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_admin_page' ); // Add Admin page

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Newer_Tag_Cloud_Public( $this->get_plugin_name(), $this->get_version() );

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
	 * @return    Newer_Tag_Cloud_Loader    Orchestrates the hooks of the plugin.
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

    function generate_newtagcloud($widget = true, $display = true, $instanceID = 0)
    {
        global $newtagcloud_defaults, $wpdb;

        $globalOptions = get_newtagcloud_options();

        if ($globalOptions['enablecache'] && !empty($globalOptions['cache'][$instanceID])) {
            if ($display) {
                echo $globalOptions['cache'][$instanceID];
            } else {
                return $globalOptions['cache'][$instanceID];
            }
            return;
        }

        $instanceOptions = get_newtagcloud_instanceoptions($instanceID);
        $content = array();
        $size = $instanceOptions['bigsize'];

        if (is_array($instanceOptions['catfilter'])) {
            $sqlCatFilter = "`$wpdb->term_relationships`.`object_id` IN (SELECT `object_id` FROM `$wpdb->term_relationships` LEFT JOIN `$wpdb->term_taxonomy` ON `$wpdb->term_relationships`.`term_taxonomy_id` = `$wpdb->term_taxonomy`.`term_taxonomy_id` WHERE `term_id` IN (" . implode(",", $instanceOptions['catfilter']) . ")) AND";
        } else {
            $sqlCatFilter = "";
        }

        if (is_array($instanceOptions['tagfilter'])) {
            foreach ($instanceOptions['tagfilter'] as $key => $value) {
                $instanceOptions['tagfilter'][$key] = "'" . $wpdb->escape($value) . "'";
            }
            $skipTags = implode(",", $instanceOptions['tagfilter']);
            $sqlTagFilter = "AND LOWER(`$wpdb->terms`.`name`) NOT IN ($skipTags)";
        } else {
            $sqlTagFilter = "";
        }
        $query = "SELECT `$wpdb->terms`.`term_id`, `$wpdb->terms`.`name`, LOWER(`$wpdb->terms`.`name`) AS lowername, `$wpdb->term_taxonomy`.`count` FROM `$wpdb->terms` LEFT JOIN `$wpdb->term_taxonomy` ON `$wpdb->terms`.`term_id` = `$wpdb->term_taxonomy`.`term_id` LEFT JOIN `$wpdb->term_relationships` ON `$wpdb->term_taxonomy`.`term_taxonomy_id` = `$wpdb->term_relationships`.`term_taxonomy_id` LEFT JOIN `$wpdb->posts` ON `$wpdb->term_relationships`.`object_id` = `$wpdb->posts`.`ID` WHERE " . $sqlCatFilter . " `$wpdb->term_taxonomy`.`taxonomy` = 'post_tag' AND `$wpdb->term_taxonomy`.`count` > 0 " . $sqlTagFilter . " GROUP BY `$wpdb->terms`.`name` ORDER BY `$wpdb->term_taxonomy`.`count` DESC LIMIT 0, " . $instanceOptions['maxcount'];
        $terms = $wpdb->get_results($query);

        $prevCount = $terms[0]->count;
        $skipTags = explode(",", $instanceOptions['tagfilter']);
        foreach ($terms as $term) {
            if ($prevCount > intval($term->count) && $size > $instanceOptions['smallsize']) {
                $size = $size - $instanceOptions['step'];
                $prevCount = intval($term->count);
            }
            $content[$term->lowername] = str_replace('%FONTSIZE%', $size, $instanceOptions['entry_layout']);
            $content[$term->lowername] = str_replace('%SIZETYPE%', $instanceOptions['sizetype'], $content[$term->lowername]);
            $content[$term->lowername] = str_replace('%TAGURL%', get_tag_link($term->term_id), $content[$term->lowername]);
            $content[$term->lowername] = str_replace('%TAGNAME%', $term->name, $content[$term->lowername]);
        }
        if ($instanceOptions['order'] == 'name') {
            ksort($content);
        }
        $content = implode($instanceOptions['glue'], $content);

        if ($widget) {
            $result = '<h' . ($globalOptions['headingsize'] + 1) . '>' . $instanceOptions['title'] . '</h' . ($globalOptions['headingsize'] + 1) . '>' . $instanceOptions['html_before'] . $content . $instanceOptions['html_after'];
        } else {
            $result = $instanceOptions['html_before'] . $content . $instanceOptions['html_after'];
        }

        newtagcloud_cache_create($instanceID, $result);

        if ($display) {
            echo $result;
        } else {
            return $result;
        }
    }

}
