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

<div class="wrap">
    <h2>Global Settings</h2>
    <form action="" method="post" name="<?php echo $this->options->pluginName ?>-globalsettings">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Instance for widget</th>
                    <td><?php echo $this->options->create_selectfield($this->options->get_newertagcloud_instances(), $globalOptions['widget_instance'], $this->options->pluginName.'-widget_instance'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Heading size for widget title</th>
                    <td><?php echo $this->options->create_selectfield(['h1', 'h2', 'h3', 'h4', 'h5', 'h6'], $globalOptions['heading_size'], $this->options->pluginName.'-heading_size'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Default instance for shortcode</th>
                    <td><?php echo $this->options->create_selectfield($this->options->get_newertagcloud_instances(), $globalOptions['shortcode_instance'], $this->options->pluginName.'-shortcode_instance'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable caching?</th>
                    <td><input type="checkbox" name="<?php echo $this->options->pluginName ?>-enable_cache" value="enable_cache" <?php echo (($globalOptions['enable_cache'])?"checked":""); ?>/></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Name of new instance</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-instancename"/>* Enter a name to create a new instance. If empty, no new instance will be created if you click 'Save global settings'</td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="<?php echo $this->options->pluginName ?>-saveglobal" value="Save global settings"/>
            <?php
            if ($globalOptions['enable_cache'] === true) :
            ?>
            <input type="submit" name="<?php echo $this->options->pluginName ?>-clearcache" value="Clear cache"/>
            <?php endif; ?>
        </p>
    </form>
</div>
