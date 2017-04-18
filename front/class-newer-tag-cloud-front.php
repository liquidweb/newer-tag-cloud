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
namespace LiquidWeb_Newer_Tag_Cloud\Front;

use LiquidWeb_Newer_Tag_Cloud\Admin\Newer_Tag_Cloud_Admin as Newer_Tag_Cloud_Admin;

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
class Newer_Tag_Cloud_Front
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
    public function __construct($plugin_name, $version, $options)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->options = $options;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/newer-tag-cloud-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
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

        //wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/newer-tag-cloud-public.js', array( 'jquery' ), $this->version, false);
    }

    public function print_newertagcloud($args)
    {
        extract($args);
        $globalOptions = $this->options->get_newertagcloud_options();
        $cloud = $this->options->generate_newertagcloud(false, $globalOptions['widget_instance']);

        require __DIR__ . '/partials/newer-tag-cloud-public-display.php';
    }

    public function print_newertagcloud_widget($args)
    {
        extract($args);
        $globalOptions = $this->options->get_newertagcloud_options();
        $cloud = $this->options->generate_newertagcloud(true, $globalOptions['widget_instance']);

        require __DIR__ . '/partials/newer-tag-cloud-public-display.php';
    }
}
