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
<h2>
<form action="" method="post" name="<?php echo $pluginName ?>-instanceselector">
        Instance Settings: <?php
        echo $options->create_selectfield(
             $options->get_newertagcloud_instances(),
             $instanceToUse,
             $pluginName.'-instance',
             ' id="selected-instance" onChange="submit();" data-cur="'.$instanceToUse.'"'
        ); ?>
</form>
<form action="" method="post" name="<?php echo $pluginName ?>-instance">
  <input type="submit" name="<?php echo $pluginName ?>-deleteinstance" value="Delete This Instance" onClick="return verifyDelete()"/>
</form>
</h2>

<div>
    <form action="" method="post" name="<?php echo $pluginName ?>-instance">
        <ul class="form-table">
                <h3>Widget Options</h3>
                <li>
                    <span class="label">Instance Widget Title:</span>
                    <span class="input"><input type="text" id="<?php echo $pluginName ?>-instance-title" name="<?php echo $pluginName ?>-instance-title" value="<?php echo($instanceOptions['title']); ?>" /></span>
                </li>
                <h3>General Options</h3>
                <li>
                    <span class="label">Tag Cloud Instance Name:</span>
                    <span class="input"><input type="text" id="<?php echo $pluginName ?>-instancename" name="<?php echo $pluginName ?>-instancename" value="<?php echo($instanceName); ?>" size="<?php echo(strlen($instanceName)+5); ?>" /></span>
                </li>
                <li>
                    <span class="label">Max Tag Count:</span>
                    <span class="input"><input type="text" name="<?php echo $pluginName ?>-max_count" value="<?php echo($instanceOptions['max_count']); ?>" size="<?php echo(strlen($instanceOptions['max_count'])+5); ?>" /></span>
                </li>
                <h3>Style and Markup Options</h3>
                <li>
                    <span class="label">Largest Tag Font Size:</span>
                    <span class="input"><input type="text" name="<?php echo $pluginName ?>-big_size" value="<?php echo($instanceOptions['big_size']); ?>" size="<?php echo(strlen($instanceOptions['big_size'])+5); ?>" /></span>
                </li>
                <li>
                    <span class="label">Smallest Tag Font Size:</span>
                    <span class="input"><input type="text" name="<?php echo $pluginName ?>-small_size" value="<?php echo($instanceOptions['small_size']); ?>" size="<?php echo(strlen($instanceOptions['small_size'])+5); ?>" /></span>
                </li>
                <li>
                    <span class="label">Step Size (Font Size difference between tags):</span>
                    <span class="input"><input type="text" name="<?php echo $pluginName ?>-step" value="<?php echo($instanceOptions['step']); ?>" size="<?php echo(strlen($instanceOptions['step'])+5); ?>" /></span>
                </li>
                <li>
                    <span class="label">Font Size Unit (CSS sizes e.g. px, pt, em, etc):</span>
                    <span class="input"><input type="text" name="<?php echo $pluginName ?>-size_unit" value="<?php echo($instanceOptions['size_unit']); ?>" size="<?php echo(strlen($instanceOptions['size_unit'])+5); ?>" /></span>
                </li>
                <li>
                    <span class="label">HTML to Insert Before the Cloud:</span>
                    <span class="input"><input type="text" name="<?php echo $pluginName ?>-html_before" value="<?php echo(htmlentities($instanceOptions['html_before'])); ?>" size="<?php echo(strlen($instanceOptions['html_before'])+5); ?>" /></span>
                </li>
                <li>
                    <span class="label">HTML to Insert After the Cloud:</span>
                    <span class="input"><input type="text" name="<?php echo $pluginName ?>-htmlafter" value="<?php echo(htmlentities($instanceOptions['html_after'])); ?>" size="<?php echo(strlen($instanceOptions['html_after'])+5); ?>" /></span>
                </li>
                <li>
                    <span class="label">Tag Entry Template:</span>
                    <span class="input"><input type="text" id="<?php echo $pluginName ?>-entrylayout" name="<?php echo $pluginName ?>-entrylayout" value="<?php echo(htmlentities($instanceOptions['entry_layout'])); ?>" size="<?php echo(strlen($instanceOptions['entry_layout'])+5); ?>" onkeyup="update_example();" onkeydown="update_example();" /><br/><div id="<?php echo $pluginName ?>-entrylayout-example"></div></span>
                </li>
                <li>
                    <span class="label">Glue Character (the string inserted between tags):</span>
                    <span class="input"><input type="text" id="<?php echo $pluginName ?>-glue" name="<?php echo $pluginName ?>-glue" value="<?php echo(htmlentities($instanceOptions['glue'])); ?>" size="<?php echo(strlen($instanceOptions['glue'])+5); ?>" /><input type="button" value="Use a Space" onClick="glueChar('%SPACE%')"/></span>
                <tr/>
                <h3>Order and Filter Options</h3>
                <li>
                    <span class="label">Cloud Tag Order:</span>
                    <span class="input"><?php echo $options->create_selectfield($options->orderOptions, $instanceOptions['order'], $pluginName.'-order'); ?></span>
                </li>
                <li>
                    <span class="label">Category Filters:<br/>Hint: To disable category filtering, deselect all categories!</span>
                    <span class="input"><?php $options->cat_filter_list($instanceOptions['cat_filter']); ?></span>
                </li>
                <li>
                    <span class="label">Tag Filters:</span>
                    <span class="input"><input type="text" id="<?php echo $pluginName ?>-tag_filter" name="<?php echo $pluginName ?>-tag_filter" value="<?php echo(htmlentities($tagFilter)); ?>" size="<?php echo(strlen($tagFilter)+5); ?>" />* Comma seperated list</span>
                </li>
        </ul>
        <p class="submit">
            <input type="hidden" id="<?php echo $pluginName ?>-instance" name="<?php echo $pluginName ?>-instance" value="<?php echo $instanceToUse; ?>"/>
            <input type="hidden" name="<?php echo $pluginName ?>-originalinstancename" value="<?php echo $instanceName; ?>"/>
            <input type="submit" name="<?php echo $pluginName ?>-saveinstance" value="Save Instance Options"/>
            <input type="submit" name="<?php echo $pluginName ?>-resetinstance" value="Reset ALL Instance Options" onClick="return verifyReset()"/>
        </p>
    </form>
</div>
</section>
<script type="text/javascript">
    function update_example()
    {
        var div = document.getElementById("<?php echo $pluginName ?>-entrylayout-example");
        var template = document.getElementById("<?php echo $pluginName ?>-entrylayout").value;
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
        var instanceName = document.getElementById('<?php echo $pluginName ?>-instancename').value;
        return confirm("Are you sure to reset all saved data for instance '" + instanceName + "'?");
    }
    function verifyDelete()
    {
        var instanceName = document.getElementById('<?php echo $pluginName ?>-instancename').value;
        if (document.getElementById('<?php echo $pluginName ?>-instance').value == 0)
        {
            alert("Instance '" + instanceName + "' is the base instance with ID 0 and can't be deleted!");
            return false;
        }
        return confirm("Are you sure to delete all saved data for instance '" + instanceName + "'?");
    }
    function glueChar(theChar)
    {
        document.getElementById('<?php echo $pluginName ?>-glue').value = theChar;
    }
    update_example();
</script>
