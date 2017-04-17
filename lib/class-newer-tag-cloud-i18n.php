<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://github.com/mallardduck
 * @since      1.0.0
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/includes
 */
namespace LiquidWeb_Newer_Tag_Cloud\Lib;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/includes
 * @author     Dan Pock (Liquid Web) <dpock@liquidweb.com>
 */
class Newer_Tag_Cloud_i18n
{

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      object    $options       The options class for the plugin.
     */
    public function __construct($options)
    {
        $this->options = $options;
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain()
    {

        load_plugin_textdomain(
            $this->options->get_plugin_name(),
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}
