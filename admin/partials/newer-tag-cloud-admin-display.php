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
    <br/>
    <form action="" method="post" name="<?php echo $this->options->pluginName ?>-instanceselector">
        <h2>Settings for instance: <?php echo $this->options->create_selectfield($this->options->get_newertagcloud_instances(), $instanceToUse, $this->options->pluginName.'-instance', ' onChange="submit();"'); ?></h2>
    </form>
    <form action="" method="post" name="<?php echo $this->options->pluginName ?>-instance">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Change instance name?</th>
                    <td><input type="text" id="<?php echo $this->options->pluginName ?>-instancename" name="<?php echo $this->options->pluginName ?>-instancename" value="<?php echo($instanceName); ?>" size="<?php echo(strlen($instanceName)+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">How many tags should be shown at most?</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-max_count" value="<?php echo($instanceOptions['max_count']); ?>" size="<?php echo(strlen($instanceOptions['max_count'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">How big should be the biggest tag?</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-big_size" value="<?php echo($instanceOptions['big_size']); ?>" size="<?php echo(strlen($instanceOptions['big_size'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">How small should be the smallest tag?</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-small_size" value="<?php echo($instanceOptions['small_size']); ?>" size="<?php echo(strlen($instanceOptions['small_size'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Font size difference between to sizes?</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-step" value="<?php echo($instanceOptions['step']); ?>" size="<?php echo(strlen($instanceOptions['step'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Which CSS size type you want use (e.g. px, pt, em, ...)?</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-size_unit" value="<?php echo($instanceOptions['size_unit']); ?>" size="<?php echo(strlen($instanceOptions['size_unit'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Provide HTML code used before entries:</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-html_before" value="<?php echo(htmlentities($instanceOptions['html_before'])); ?>" size="<?php echo(strlen($instanceOptions['html_before'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Provide HTML coded used after entries:</th>
                    <td><input type="text" name="<?php echo $this->options->pluginName ?>-htmlafter" value="<?php echo(htmlentities($instanceOptions['html_after'])); ?>" size="<?php echo(strlen($instanceOptions['html_after'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Entry template</th>
                    <td><input type="text" id="<?php echo $this->options->pluginName ?>-entrylayout" name="<?php echo $this->options->pluginName ?>-entrylayout" value="<?php echo(htmlentities($instanceOptions['entry_layout'])); ?>" size="<?php echo(strlen($instanceOptions['entry_layout'])+5); ?>" onkeyup="update_example();" onkeydown="update_example();" /><br/><div id="<?php echo $this->options->pluginName ?>-entrylayout-example"></div></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Which glue char you want use?</th>
                    <td><input type="text" id="<?php echo $this->options->pluginName ?>-glue" name="<?php echo $this->options->pluginName ?>-glue" value="<?php echo(htmlentities($instanceOptions['glue'])); ?>" size="<?php echo(strlen($instanceOptions['glue'])+5); ?>" /><input type="button" value="I want use a blank" onClick="glueChar('%BLANK%')"/></td>
                <tr/>
                <tr valign="top">
                    <th scope="row">Which order type you want to use to sort the tags?</th>
                    <td><?php echo $this->options->create_selectfield($this->options->orderOptions, $instanceOptions['order'], $this->options->pluginName.'-order'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable category filter?<br/>Hint: To disable category filtering, deselect all categories!</th>
                    <td><?php $this->options->catfilter_list($instanceOptions['catfilter']); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Filter tags?</th>
                    <td><input type="text" id="<?php echo $this->options->pluginName ?>-tagfilter" name="<?php echo $this->options->pluginName ?>-tagfilter" value="<?php echo(htmlentities($tagFilter)); ?>" size="<?php echo(strlen($tagFilter)+5); ?>" />* Comma seperated list</td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="hidden" id="<?php echo $this->options->pluginName ?>-instance" name="<?php echo $this->options->pluginName ?>-instance" value="<?php echo $instanceToUse; ?>"/>
            <input type="hidden" name="<?php echo $this->options->pluginName ?>-originalinstancename" value="<?php echo $instanceName; ?>"/>
            <input type="submit" name="<?php echo $this->options->pluginName ?>-saveinstance" value="Save instance settings"/>
            <input type="submit" name="<?php echo $this->options->pluginName ?>-resetinstance" value="Reset all data for this instance" onClick="return verifyReset()"/>
            <input type="submit" name="<?php echo $this->options->pluginName ?>-deleteinstance" value="Delete this instance" onClick="return verifyDelete()"/>
        </p>
    </form>
</div>
<script type="text/javascript">
    function update_example()
    {
        var div = document.getElementById("<?php echo $this->options->pluginName ?>-entrylayout-example");
        var template = document.getElementById("<?php echo $this->options->pluginName ?>-entrylayout").value;
        template = template.replace(/</g, "&lt;");
        template = template.replace(/>/g, "&gt;");
        template = template.replace(/%FONTSIZE%/g, "10");
        template = template.replace(/%SIZETYPE%/g, "<?php echo $instanceOptions['size_unit']; ?>");
        template = template.replace(/%TAGURL%/g, "<?php echo get_site_url(); ?>/tags/test");
        template = template.replace(/%TAGNAME%/g, "test");
        div.innerHTML = template;
    }
    function verifyReset()
    {
        var instanceName = document.getElementById('<?php echo $this->options->pluginName ?>-instancename').value;
        return confirm("Are you sure to reset all saved data for instance '" + instanceName + "'?");
    }
    function verifyDelete()
    {
        var instanceName = document.getElementById('<?php echo $this->options->pluginName ?>-instancename').value;
        if (document.getElementById('<?php echo $this->options->pluginName ?>-instance').value == 0)
        {
            alert("Instance '" + instanceName + "' is the base instance with ID 0 and can't be deleted!");
            return false;
        }
        return confirm("Are you sure to delete all saved data for instance '" + instanceName + "'?");
    }
    function glueChar(theChar)
    {
        document.getElementById('<?php echo $this->options->pluginName ?>-glue').value = theChar;
    }
    update_example();
</script>
