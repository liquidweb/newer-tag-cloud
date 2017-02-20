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
<h2>Newer Tag Cloud by <a href="https://www.liquidweb.com/" target="_blank">Liquid Web</a></h2>
<h1>Global Settings</h1>

<div class="wrap left-admin">
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
            <input type="submit" name="<?php echo $pluginName ?>-saveglobal" value="Save global settings"/>
            <?php
            if ($globalOptions['enable_cache'] === true) :
            ?>
            <input type="submit" name="<?php echo $pluginName ?>-clearcache" value="Clear cache"/>
            <?php endif; ?>
        </p>
    </form>
</div>
<div class="wrap right-admin">
    <h2>About the Plugin</h2>
    <p>
        Newer Tag Cloud, inspired by New Tag Cloud, is a WordPress plugin that generates a tag clouds.<br /><br />
        The original New Tag Cloud plugin has been without updates for 7 years and this has recently caused issues with
        modern WordPress versions. As a result a privately maintained version was created within
        <a href="https://www.liquidweb.com/" target="_blank">Liquid Web</a>.<br /><br />
        As this new plugin may benefit others who were still using the now unmaintained 'New Tag Cloud' it's now been
        released. The plguin is provided as is and there is no support provided or guaranteed.<br />
    <h3>Credits:</h3>
    <ul>
        <li>liquidwebdan - Current Maintainer</li>
        <li>funnydingo - Creator of Inspiring Plugin</li>
    </ul>
</div>
