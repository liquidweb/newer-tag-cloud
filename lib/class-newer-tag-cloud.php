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
namespace LiquidWeb_Newer_Tag_Cloud\Lib;

use \LiquidWeb_Newer_Tag_Cloud\Admin\Newer_Tag_Cloud_Admin as Newer_Tag_Cloud_Admin;
use \LiquidWeb_Newer_Tag_Cloud\Front\Newer_Tag_Cloud_Front as Newer_Tag_Cloud_Front;

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
class Newer_Tag_Cloud
{

        /**
         * The loader that's responsible for options and basic logic
         *
         * @since    1.0.0
         * @access   protected
         * @var      Newer_Tag_Cloud_Init    $options    Maintains and registers all hooks for the plugin.
         */
    protected $options;

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
    public function __construct()
    {
        $this->plugin_name = 'newer-tag-cloud';
        $this->version = '1.1.1';

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
    private function load_dependencies()
    {
        $this->loader = new Newer_Tag_Cloud_Loader();
        $this->options = new Newer_Tag_Cloud_Init($this->plugin_name, $this->version);
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
    private function set_locale()
    {

        $plugin_i18n = new Newer_Tag_Cloud_i18n($this->options);

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

        /**
         * Register all of the hooks related to the admin area functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
    private function define_admin_hooks()
    {

        $plugin_admin = new Newer_Tag_Cloud_Admin($this->plugin_name, $this->version, $this->options);

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'register_admin_pages'); // Add Admin page
        $this->loader->add_action('save_post', $plugin_admin, 'newertagcloud_cache_clear'); // Add Admin page
        $this->loader->add_action('widgets_init', $plugin_admin, 'newertagcloud_widget_init');
    }

        /**
         * Register all of the hooks related to the public-facing functionality
         * of the plugin.
         *
         * @since    1.0.0
         * @access   private
         */
    private function define_public_hooks()
    {

        $plugin_public = new Newer_Tag_Cloud_Front($this->plugin_name, $this->version, $this->options);

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
    }

        /**
         * Run the loader to execute all of the hooks with WordPress.
         *
         * @since    1.0.0
         */
    public function run()
    {
        $this->loader->run();
    }


    public function getOptions()
    {
        return $this->options;
    }

    public function getTagCloud($widget = true, $instanceID = 0)
    {
        return $this->options->generate_newertagcloud($widget, $instanceID);
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Newer_Tag_Cloud_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
