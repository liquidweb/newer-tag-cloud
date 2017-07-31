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
namespace LiquidWeb_Newer_Tag_Cloud\Admin;

use \LiquidWeb_Newer_Tag_Cloud\Front\Newer_Tag_Cloud_Front as Newer_Tag_Cloud_Front;

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
class Newer_Tag_Cloud_Admin
{

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
     * @var      array    $options
     */
    private $options;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     * @param      string    $options       The options class for the plugin.
     */
    public function __construct($plugin_name, $version, $options)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->options = $options;
        $this->options = $options;
    }

    /**
     * Register the options page for the admin area.
     *
     * @since    1.0.0
     */
    public function register_admin_pages()
    {
        add_menu_page('Newer Tag Cloud', 'Newer Tag Cloud', 'manage_options', $this->plugin_name, [$this, 'options_page']);
        add_submenu_page($this->plugin_name, 'Newer Tag Cloud Instances', 'Instance Options', 'manage_options', $this->plugin_name."/instances", [$this, 'instance_options_page']);
    }

    /**
     * Create the options page for the admin area.
     *
     * @since    1.0.0
     */
    public function options_page()
    {
        $options = $this->options;
        $pluginName = $this->plugin_name;

        // Check if user is Admin
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', $this->options->get_plugin_name()));
        }

        if (isset($_POST[$pluginName.'-saveglobal'])) {
            $this->update_newertagcloud_options();
        }

        if (isset($_POST[$pluginName.'-clearcache'])) {
            $this->newertagcloud_cache_clear();
            echo '<div id="message" class="updated fade"><p><strong>' . __('Cache cleared.', $this->options->get_plugin_name()) . '</strong></p></div>';
        }

        $globalOptions = $options->get_newertagcloud_options();

        require __DIR__ . '/partials/newer-tag-cloud-admin-display.php';
    }

    /**
     * Create the options page for the admin area.
     *
     * @since    1.0.0
     */
    public function instance_options_page()
    {
        // Init basic variables used in partial
        $options = $this->options;
        $pluginName = $this->plugin_name;
        // Check if user is Admin
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.', $this->options->get_plugin_name()));
        }

        $orderOptions = $options->orderOptions;

        if (isset($_POST[$pluginName.'-instance'])) {
            $instanceToUse = intval($_POST[$pluginName.'-instance']);
        } else {
            $instanceToUse = 0;
        }

        if (isset($_POST[$pluginName.'-saveinstance'])) {
            $this->update_newertagcloud_instanceoptions(intval($_POST[$pluginName.'-instance']));
        }

        if (isset($_POST[$pluginName.'-resetinstance'])) {
            delete_option($pluginName.'_instance' . intval($_POST[$pluginName.'-instance']));
            echo '<div id="message" class="updated fade"><p><strong>';
            _e('Instance Options Reset.', $this->options->get_plugin_name());
            echo '</strong></p></div>';
        }

        if (isset($_POST[$pluginName.'-deleteinstance'])) {
            $this->delete_newertagcloud_instance(intval($_POST[$pluginName.'-instance']));
            $instanceToUse = 0;
        }

        $globalOptions = $options->get_newertagcloud_options();
        $instanceOptions = $options->get_newertagcloud_instanceoptions($instanceToUse);

        $instanceOptions['glue'] = str_replace(" ", "%SPACE%", $instanceOptions['glue']);
        $instanceName = unserialize($globalOptions['instances']);
        $instanceName = $instanceName[$instanceToUse];
        if (is_array($instanceOptions['tag_filter'])) {
            $tagFilter = implode(",", $instanceOptions['tag_filter']);
        } else {
            $tagFilter = "";
        }

        require __DIR__ . '/partials/newer-tag-cloud-instances-display.php';
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/newer-tag-cloud-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/newer-tag-cloud-admin.js', array( 'jquery' ), $this->version, false);
    }

    public function newertagcloud_cache_clear()
    {
        $options = $this->options->get_newertagcloud_options();
        unset($options['cache']);
        update_option($this->plugin_name, $options);
    }

    public function update_newertagcloud_options()
    {
        $options = $this->options->get_newertagcloud_options();
        $options['default_widget_instance'] = intval($_POST[$this->plugin_name.'-widget_instance']);
        $options['heading_size'] = intval($_POST[$this->plugin_name.'-heading_size']);
        $options['shortcode_instance'] = intval($_POST[$this->plugin_name.'-shortcode_instance']);
        $options['enable_cache'] = (isset($_POST[$this->plugin_name.'-enable_cache'])) ? true : false;
        if ($options['enable_cache'] === false) {
            unset($options['cache']);
        }

        if (strlen($_POST[$this->plugin_name.'-instancename']) > 0) {
            $instances = unserialize($options['instances']);
            $instances[] = strip_tags(stripslashes($_POST[$this->plugin_name.'-instancename']));
            $options['instances'] = serialize($instances);
        }

        update_option($this->plugin_name, $options);
        echo '<div id="message" class="updated fade"><p><strong>';
        _e('Options saved.', $this->options->get_plugin_name());
        echo '</strong></p></div>';
    }

    public function update_newertagcloud_instanceoptions($instanceID)
    {

        $options = $this->options->get_newertagcloud_instanceoptions($instanceID);

        $options['title'] = sanitize_text_field($_POST[$this->plugin_name.'-instance-title']);
        $options['max_count'] = intval($_POST[$this->plugin_name.'-max_count']);
        $options['big_size'] = floatval($_POST[$this->plugin_name.'-big_size']);
        $options['small_size'] = floatval($_POST[$this->plugin_name.'-small_size']);
        $options['step'] = floatval($_POST[$this->plugin_name.'-step']);
        $options['size_unit'] = sanitize_text_field($_POST[$this->plugin_name.'-size_unit']);
        $options['html_before'] = stripslashes($_POST[$this->plugin_name.'-html_before']);
        $options['html_after'] = stripslashes($_POST[$this->plugin_name.'-htmlafter']);
        $options['entry_layout'] = stripslashes($_POST[$this->plugin_name.'-entrylayout']);
        $options['glue'] = stripslashes(str_replace("%SPACE%", " ", $_POST[$this->plugin_name.'-glue']));
        $options['order'] = stripslashes(str_replace("%SPACE%", " ", $_POST[$this->plugin_name.'-order']));

        if (empty($_POST[$this->plugin_name.'-tag_filter'])) {
            unset($options['tag_filter']);
            $options['tag_filter'] = '';
        } else {
            $options['tag_filter'] = explode(",", strtolower((stripslashes($_POST[$this->plugin_name.'-tag_filter']))));
        }

        unset($options['cat_filter']);
        if (is_array($_POST[$this->plugin_name.'-cat_filter'])) {
            foreach ($_POST[$this->plugin_name.'-cat_filter'] as $id => $value) {
                $options['cat_filter'][] = $id;
            }
        } else {
            $options['cat_filter'] = [];
        }

        update_option($this->plugin_name.'_instance' . $instanceID, $options);

        $options = $this->options->get_newertagcloud_options();
        if ($_POST[$this->plugin_name.'-instancename'] != $_POST[$this->plugin_name.'-originalinstancename']) {
            $instances = unserialize($options['instances']);
            $instances[$instanceID] = strip_tags(stripslashes($_POST[$this->plugin_name.'-instancename']));
            $options['instances'] = serialize($instances);
        }
        unset($options['cache'][$instanceID]);
        update_option($this->plugin_name, $options);
        echo '<div id="message" class="updated fade"><p><strong>';
        _e('Options saved.', $this->options->get_plugin_name());
        echo '</strong></p></div>';
    }

    function delete_newertagcloud_instance($instanceID)
    {
        if ($instanceID == 0) {
            echo '<div id="message" class="updated fade"><p><strong>';
            _e("Instance 0 can't be deleted!", $this->options->get_plugin_name());
            echo '</strong></p></div>';
            return;
        }
        delete_option($this->plugin_name.'_instance' . $instanceID);
        $options = $this->options->get_newertagcloud_options();
        $instances = unserialize($options['instances']);
        unset($instances[$instanceID]);
        $options['instances'] = serialize($instances);
        update_option($this->plugin_name, $options);
        echo '<div id="message" class="updated fade"><p><strong>';
        _e('Instance deleted.', $this->options->get_plugin_name());
        echo '</strong></p></div>';
    }

    public function newertagcloud_widget_init()
    {
        if (!function_exists('register_widget')) {
            return;
        }

        register_widget( 'LiquidWeb_Newer_Tag_Cloud\Lib\Newer_Tag_Cloud_Widget' );
    }
}
