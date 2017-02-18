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
    <form action="" method="post" name="newtagcloud-globalsettings">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Instance for widget</th>
                    <td><?php echo create_selectfield(get_newtagcloud_instances(), $globalOptions['widgetinstance'], 'newtagcloud-widgetinstance'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Heading size for widget title</th>
                    <td><?php echo create_selectfield(array('h1', 'h2', 'h3', 'h4', 'h5', 'h6'), $globalOptions['headingsize'], 'newtagcloud-headingsize'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Do you want to enable filtering of <em>&lt;!--new-tag-cloud--&gt;</em>?</th>
                    <td><input type="checkbox" name="newtagcloud-enablefilter" value="enablefilter" <?php echo (($globalOptions['enablefilter'])?"checked":""); ?>/>* This is the old way, you better should use shortcode ([newtagcloud], [newtagcloud int=&lt;ID&gt;) instead becaus it's faster!</td>
                </tr>
                <tr valign="top">
                    <th scope="row">Default instance for filter</th>
                    <td><?php echo create_selectfield(get_newtagcloud_instances(), $globalOptions['filterinstance'], 'newtagcloud-filterinstance'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Default instance for shortcode</th>
                    <td><?php echo create_selectfield(get_newtagcloud_instances(), $globalOptions['shortcodeinstance'], 'newtagcloud-shortcodeinstance'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable caching?</th>
                    <td><input type="checkbox" name="newtagcloud-enablecache" value="enablecache" <?php echo (($globalOptions['enablecache'])?"checked":""); ?>/></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Name of new instance</th>
                    <td><input type="text" name="newtagcloud-instancename"/>* Enter a name to create a new instance. If empty, no new instance will be created if you click 'Save global settings'</td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="submit" name="newtagcloud-saveglobal" value="Save global settings"/>
            <input type="submit" name="newtagcloud-clearcache" value="Clear cache"/>
        </p>
    </form>
    <br/>
    <form action="" method="post" name="newtagcloud-instanceselector">
        <h2>Settings for instance: <?php echo create_selectfield(get_newtagcloud_instances(), $instanceToUse, 'newtagcloud-instance', ' onChange="submit();"'); ?></h2>
    </form>
    <form action="" method="post" name="newtagcloud-instance">
        <table class="form-table">
            <tbody>
                <tr valign="top">
                    <th scope="row">Change instance name?</th>
                    <td><input type="text" id="newtagcloud-instancename" name="newtagcloud-instancename" value="<?php echo($instanceName); ?>" size="<?php echo(strlen($instanceName)+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">How many tags should be shown at most?</th>
                    <td><input type="text" name="newtagcloud-maxcount" value="<?php echo($instanceOptions['maxcount']); ?>" size="<?php echo(strlen($instanceOptions['maxcount'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">How big should be the biggest tag?</th>
                    <td><input type="text" name="newtagcloud-bigsize" value="<?php echo($instanceOptions['bigsize']); ?>" size="<?php echo(strlen($instanceOptions['bigsize'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">How small should be the smallest tag?</th>
                    <td><input type="text" name="newtagcloud-smallsize" value="<?php echo($instanceOptions['smallsize']); ?>" size="<?php echo(strlen($instanceOptions['smallsize'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Font size difference between to sizes?</th>
                    <td><input type="text" name="newtagcloud-step" value="<?php echo($instanceOptions['step']); ?>" size="<?php echo(strlen($instanceOptions['step'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Wich CSS size type you want use (e.g. px, pt, em, ...)?</th>
                    <td><input type="text" name="newtagcloud-sizetype" value="<?php echo($instanceOptions['sizetype']); ?>" size="<?php echo(strlen($instanceOptions['sizetype'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Provide HTML code used before entries:</th>
                    <td><input type="text" name="newtagcloud-htmlbefore" value="<?php echo(htmlentities($instanceOptions['html_before'])); ?>" size="<?php echo(strlen($instanceOptions['html_before'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Provide HTML coded used after entries:</th>
                    <td><input type="text" name="newtagcloud-htmlafter" value="<?php echo(htmlentities($instanceOptions['html_after'])); ?>" size="<?php echo(strlen($instanceOptions['html_after'])+5); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Entry template</th>
                    <td><input type="text" id="newtagcloud-entrylayout" name="newtagcloud-entrylayout" value="<?php echo(htmlentities($instanceOptions['entry_layout'])); ?>" size="<?php echo(strlen($instanceOptions['entry_layout'])+5); ?>" onkeyup="update_example();" onkeydown="update_example();" /><br/><div id="newtagcloud-entrylayout-example"></div></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Wich glue char you want use?</th>
                    <td><input type="text" id="newtagcloud-glue" name="newtagcloud-glue" value="<?php echo(htmlentities($instanceOptions['glue'])); ?>" size="<?php echo(strlen($instanceOptions['glue'])+5); ?>" /><input type="button" value="I want use a blank" onClick="glueChar('%BLANK%')"/></td>
                <tr/>
                <tr valign="top">
                    <th scope="row">Wich order type you want to use to sort the tags?</th>
                    <td><?php echo create_selectfield($newtagcloud_orderoptions, $instanceOptions['order'], 'newtagcloud-order'); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Enable category filter?<br/>Hint: To disable category filtering, deselect all categories!</th>
                    <td><?php catfilter_list($instanceOptions['catfilter']); ?></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Filter tags?</th>
                    <td><input type="text" id="newtagcloud-tagfilter" name="newtagcloud-tagfilter" value="<?php echo(htmlentities($tagFilter)); ?>" size="<?php echo(strlen($tagFilter)+5); ?>" />* Comma seperated list</td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="hidden" id="newtagcloud-instance" name="newtagcloud-instance" value="<?php echo $instanceToUse; ?>"/>
            <input type="hidden" name="newtagcloud-originalinstancename" value="<?php echo $instanceName; ?>"/>
            <input type="submit" name="newtagcloud-saveinstance" value="Save instance settings"/>
            <input type="submit" name="newtagcloud-resetinstance" value="Reset all data for this instance" onClick="return verifyReset()"/>
            <input type="submit" name="newtagcloud-deleteinstance" value="Delete this instance" onClick="return verifyDelete()"/>
        </p>
    </form>
</div>
<script type="text/javascript">
    function update_example()
    {
        var div = document.getElementById("newtagcloud-entrylayout-example");
        var template = document.getElementById("newtagcloud-entrylayout").value;
        template = template.replace(/</g, "&lt;");
        template = template.replace(/>/g, "&gt;");
        template = template.replace(/%FONTSIZE%/g, "10");
        template = template.replace(/%SIZETYPE%/g, "px");
        template = template.replace(/%TAGURL%/g, "http://www.yourblog.com/tags/test");
        template = template.replace(/%TAGNAME%/g, "test");
        div.innerHTML = template;
    }
    function verifyReset()
    {
        var instanceName = document.getElementById('newtagcloud-instancename').value;
        return confirm("Are you sure to reset all saved data for instance '" + instanceName + "'?");
    }
    function verifyDelete()
    {
        var instanceName = document.getElementById('newtagcloud-instancename').value;
        if (document.getElementById('newtagcloud-instance').value == 0)
        {
            alert("Instance '" + instanceName + "' is the base instance with ID 0 and can't be deleted!");
            return false;
        }
        return confirm("Are you sure to delete all saved data for instance '" + instanceName + "'?");
    }
    function glueChar(theChar)
    {
        document.getElementById('newtagcloud-glue').value = theChar;
    }
    update_example();
</script>
