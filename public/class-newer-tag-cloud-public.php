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
	 * The options of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $options    The current options for this plugin.
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $options ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->options = $options;

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

    public function newtagcloud_shortcode($atts)
    {
        $globalOptions = $this->options->get_newertagcloud_options();

        extract(shortcode_atts(array('int' => null), $atts));
        if (!is_numeric($int)) {
            $int = $globalOptions['shortcode_instance'];
        }
        return $this->options->generate_newertagcloud(false, $int);
    }

    public function generate_newertagcloud($widget = true, $instanceID = 0)
    {
        global $wpdb;

        $globalOptions = $this->options->get_newertagcloud_options();

        if ($globalOptions['enablecache'] && !empty($globalOptions['cache'][$instanceID])) {
            return $globalOptions['cache'][$instanceID];
        }

        $instanceOptions = $this->options->get_newertagcloud_instanceoptions($instanceID);
        $content = [];
        $size = $instanceOptions['big_size'];

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

        $query = "SELECT `$wpdb->terms`.`term_id`, `$wpdb->terms`.`name`, LOWER(`$wpdb->terms`.`name`) AS lowername, `$wpdb->term_taxonomy`.`count` FROM `$wpdb->terms` LEFT JOIN `$wpdb->term_taxonomy` ON `$wpdb->terms`.`term_id` = `$wpdb->term_taxonomy`.`term_id` LEFT JOIN `$wpdb->term_relationships` ON `$wpdb->term_taxonomy`.`term_taxonomy_id` = `$wpdb->term_relationships`.`term_taxonomy_id` LEFT JOIN `$wpdb->posts` ON `$wpdb->term_relationships`.`object_id` = `$wpdb->posts`.`ID` WHERE " . $sqlCatFilter . " `$wpdb->term_taxonomy`.`taxonomy` = 'post_tag' AND `$wpdb->term_taxonomy`.`count` > 0 " . $sqlTagFilter . " GROUP BY `$wpdb->terms`.`name` ORDER BY `$wpdb->term_taxonomy`.`count` DESC LIMIT 0, " . $instanceOptions['max_count'];
        $terms = $wpdb->get_results($query);

        //var_dump($terms);die;

        $prevCount = $terms[0]->count;
        $skipTags = explode(",", $instanceOptions['tagfilter']);
        foreach ($terms as $term) {
            if ($prevCount > intval($term->count) && $size > $instanceOptions['small_size']) {
                $size = $size - $instanceOptions['step'];
                $prevCount = intval($term->count);
            }
            $content[$term->lowername] = str_replace('%FONTSIZE%', $size, $instanceOptions['entry_layout']);
            $content[$term->lowername] = str_replace('%SIZETYPE%', $instanceOptions['size_unit'], $content[$term->lowername]);
            $content[$term->lowername] = str_replace('%TAGURL%', get_tag_link($term->term_id), $content[$term->lowername]);
            $content[$term->lowername] = str_replace('%TAGNAME%', $term->name, $content[$term->lowername]);
        }
        if ($instanceOptions['order'] == 'name') {
            ksort($content);
        }
        $content = implode($instanceOptions['glue'], $content);

        if ($widget) {
            $result = '<h' . ($globalOptions['heading_size'] + 1) . '>' . $instanceOptions['title'] . '</h' . ($globalOptions['heading_size'] + 1) . '>' . $instanceOptions['html_before'] . $content . $instanceOptions['html_after'];
        } else {
            $result = $instanceOptions['html_before'] . $content . $instanceOptions['html_after'];
        }

        $this->options->newertagcloud_cache_create($instanceID, $result);

        return $result;
    }

    public function newertagcloud_control()
    {
        $globalOptions = $this->options->get_newertagcloud_options();
        $instanceOptions = $this->options->get_newertagcloud_instanceoptions($globalOptions['widget_instance']);
        if (isset($_POST[$this->plugin_name.'-title'])) {
            $instanceOptions['title'] = strip_tags(stripslashes($_POST[$this->plugin_name.'-title']));
            update_option($this->plugin_name.'_instance' . $globalOptions['widget_instance'], $instanceOptions);
        }
        echo '<p style="text-align:right;"><label for="'.$this->plugin_name.'-title">Title: <input style="width: 250px;" id="'.$this->plugin_name.'-title" name="'.$this->plugin_name.'-title" type="text" value="'.$instanceOptions['title'].'" /></label></p>';
    }

    public function print_newertagcloud($args)
    {
        extract($args);
        $globalOptions = $this->options->get_newertagcloud_options();
        $cloud = $this->generate_newertagcloud(true, $globalOptions['widget_instance']);;

        require __DIR__ . '/partials/newer-tag-cloud-public-display.php';
    }

    public function newertagcloud_init()
    {
        if (!function_exists('wp_register_sidebar_widget') || !function_exists('wp_register_widget_control')) {
            return;
        }

        wp_register_sidebar_widget('new_tag_cloud-lw', 'Newer Tag Cloud', [$this, 'print_newertagcloud']);
        wp_register_widget_control('new_tag_cloud-lw', 'Newer Tag Cloud', [$this, 'newertagcloud_control'], 50, 10);
    }

}
