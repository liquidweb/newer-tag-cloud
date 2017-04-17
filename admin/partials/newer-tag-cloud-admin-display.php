<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://github.com/mallardduck
 * @since      1.0.0
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<section class="wrap">
    <h1>Newer Tag Cloud by <a href="https://www.liquidweb.com/" target="_blank">Liquid Web</a></h1>
<div class="left-admin">
    <h2><?php _e('Global Settings', $this->options->get_plugin_name())?></h2>
    <form action="" method="post" name="<?php echo $pluginName ?>-globalsettings">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Instance for widget</th>
                    <td><?php echo $options->create_selectfield($options->get_newertagcloud_instances(), $globalOptions['widget_instance'], $pluginName.'-widget_instance'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Heading size for widget title</th>
                    <td><?php echo $options->create_selectfield(['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], $globalOptions['heading_size'], $pluginName.'-heading_size'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Default instance for shortcode</th>
                    <td><?php echo $options->create_selectfield($options->get_newertagcloud_instances(), $globalOptions['shortcode_instance'], $pluginName.'-shortcode_instance'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable caching?</th>
                    <td><input type="checkbox" name="<?php echo $pluginName ?>-enable_cache" value="enable_cache" <?php echo (($globalOptions['enable_cache'])?"checked":""); ?>/></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Name of new instance</th>
                    <td>
                        <input type="text" name="<?php echo $pluginName ?>-instancename"/><br />
                        * Enter a name to create a new instance. If empty, no new instance will be created if you click 'Save global settings'
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="<?php echo $pluginName ?>-saveglobal" value="Save Settings"/>
            <?php
            if ($globalOptions['enable_cache'] === true) :
            ?>
            <input type="submit" name="<?php echo $pluginName ?>-clearcache" value="Clear Cloud Cache"/>
            <?php endif; ?>
        </p>
    </form>
</div>
<div class="right-admin">
  <h2>Plugin Information</h2>

    <h3>About the Plugin</h3>
    <p>
      Newer Tag Cloud is a WordPress plugin that generates a tag clouds. This plugin was inspired by the original New Tag Cloud.<br /><br />
      The original New Tag Cloud has been without updates for 7 years and this has recently caused issues with modern WordPress versions. Due to the issues for a short time a privately maintained version was created at <a href="https://www.liquidweb.com/" target="_blank">Liquid Web</a>. Now this version is being released to the public!
    </p>
    <h3>Disclaimer</h3>
<p>
  This plugin is provided “as is.” It is free software licensed under the terms of the <a href="http://www.gnu.org/licenses/gpl.html" title=“GNU General Public License 3.0”>GNU General Public License 3.0 (GPL)</a>. It is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. The plugin creator and/or maintainer(s) are not liable for any damages or losses. Your only recourse is to stop using this plugin.
</p>
    <h3>Credits:</h3>
    <ul>
        <li><a href="https://profiles.wordpress.org/liquidwebdan">liquidwebdan</a> - Current Maintainer</li>
        <li><a href="https://profiles.wordpress.org/funnydingo">funnydingo</a> - Creator of Inspiring Plugin</li>
    </ul>
</div>
</section>
