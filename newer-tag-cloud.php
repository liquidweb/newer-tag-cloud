<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://github.com/mallardduck
 * @since             1.0.0
 * @package           Newer_Tag_Cloud
 *
 * @wordpress-plugin
 * Plugin Name: Newer Tag Cloud by Liquid Web
 * Plugin URI: https://wordpress.org/plugins/newer-tag-cloud/
 * Description: The plugin provides an widget which shows a tag cloud with the tags used by the new WordPress own tagging feature
 * Author: Daniel Pock (Liquid Web)
 * Version: 1.0.0
 * Author URI: https://github.com/liquidweb/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       newer-tag-cloud
 * Domain Path:       /languages/
 */
namespace LiquidWeb_Newer_Tag_Cloud;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

// Include the autoloader so we can dynamically include the rest of the classes.
require_once(trailingslashit(dirname(__FILE__)) . 'includes/autoloader.php');

use LiquidWeb_Newer_Tag_Cloud\Lib\Newer_Tag_Cloud;
use LiquidWeb_Newer_Tag_Cloud\Lib\Newer_Tag_Cloud_Activator;
use LiquidWeb_Newer_Tag_Cloud\Lib\Newer_Tag_Cloud_Deactivator;

/**
 * The code that runs during plugin activation.
 * This action is documented in lib/class-newer-tag-cloud-activator.php
 */
function activate_newer_tag_cloud()
{
    Newer_Tag_Cloud_Activator::activate();
}
register_activation_hook(__FILE__, __NAMESPACE__ . '\\activate_newer_tag_cloud');

/**
 * The code that runs during plugin deactivation.
 * This action is documented in lib/class-newer-tag-cloud-deactivator.php
 */
function deactivate_newer_tag_cloud()
{
    Newer_Tag_Cloud_Deactivator::deactivate();
}

register_deactivation_hook(__FILE__, __NAMESPACE__ . '\\deactivate_newer_tag_cloud');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */

add_action('plugins_loaded', __NAMESPACE__ . '\\run_newer_tag_cloud');/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_newer_tag_cloud()
{

    $plugin = new Newer_Tag_Cloud();
    $plugin->run();

    if (function_exists('add_shortcode')) {
        add_shortcode($plugin->get_plugin_name(), __NAMESPACE__ . '\\newertagcloud_shortcode');
    }
}

// Shortcode function
function newertagcloud_shortcode($atts)
{
    $plugin = (new Newer_Tag_Cloud());
    $globalOptions = $plugin->getOptions()->get_newertagcloud_options();

    extract(shortcode_atts(array('int' => null), $atts));
    if (!is_numeric($int)) {
        $int = $globalOptions['shortcode_instance'];
    }
    return $plugin->getTagCloud(false, $int);
}

// function for themes and other plugins
function newerTagCloud($id = 0): void
{
    $plugin = (new Newer_Tag_Cloud());
    echo $plugin->getTagCloud(false, intval($id));
    return;
}
