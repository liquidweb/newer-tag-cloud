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
class Newer_Tag_Cloud_Init {

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

    public $defaultOptions;

    public $instanceDefaults;

    public $orderOptions;

    /**
    * Define the core functionality of the plugin.
    *
    * Set the plugin name and the plugin version that can be used throughout the plugin.
    * Load the dependencies, define the locale, and set the hooks for the admin area and
    * the public-facing side of the site.
    *
    * @since    1.0.0
    */
    public function __construct(string $name, string $version) {
        $this->plugin_name = $name;
        $this->version = $version;
        $this->defaultOptions = $this->get_default_options();
        $this->instanceDefaults = $this->get_instance_defaults();
        $this->orderOptions = $this->get_order_options();
    }

    /**
  	 * The name of the plugin used to uniquely identify it within the context of
  	 * WordPress and to define internationalization functionality.
  	 *
  	 * @since     1.0.0
  	 * @return    string    The name of the plugin.
  	 */
  	public function get_plugin_name() {
  		return $this->plugin_name;
  	}

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
      return $this->version;
    }

    private function get_default_options()
    {
        return [
            'db_layout'          => '0.5',
            'widget_instance'    => 0,
            'heading_size'       => 1,
            'shortcode_instance' => 0,
            'instances'         => serialize([0 => 'Default']),
            'enable_cache'       => false
        ];
    }

    private function get_instance_defaults()
    {
        return [
            'title'             => 'Newer Tag Cloud',
            'max_count'          => 10,
            'big_size'           => 24,
            'small_size'         => 10,
            'step'              => 2,
            'size_unit'          => 'px',
            'html_before'       => '<ul id="'.$this->plugin_name.'">',
            'html_after'        => '</ul>',
            'entry_layout'      => '<li><a style="font-size:%FONTSIZE%%SIZETYPE%" href="%TAGURL%" target="_self">%TAGNAME%</a></li>',
            'glue'              => ' ',
            'cat_filter'        => false,
            'tag_filter'        => false,
            'order'             => 'name'
        ];
    }

    private function get_order_options()
    {
        return [
            'name' => 'By name',
            'count' => 'By count'
        ];
    }

    public function get_newertagcloud_options()
    {
        $defaultOptions = $this->defaultOptions;
        $options = get_option($this->plugin_name);
        if ($options !== false && is_array($options) === true) {
            // Compare options found to defaults
            $options['db_layout'] = ($options['db_layout'] === null) ? $defaultOptions['db_layout'] : $options['db_layout'];
            $options['widget_instance'] = ($options['widget_instance'] === null) ? $defaultOptions['widget_instance'] : $options['widget_instance'];
            $options['heading_size'] = ($options['heading_size'] === null) ? $defaultOptions['heading_size'] : $options['heading_size'];
            $options['shortcode_instance'] = ($options['shortcode_instance'] === null) ? $defaultOptions['shortcode_instance'] : $options['shortcode_instance'];
            $options['instances'] = ($options['instances'] === null) ? $defaultOptions['instances'] : $options['instances'];
            $options['enable_cache'] = ($options['enable_cache'] === null) ? $defaultOptions['enable_cache'] : $options['enable_cache'];
            // return options
            return $options;
        }
        return $defaultOptions;
    }

    public function get_newertagcloud_instanceoptions($instanceID = 0)
    {
        $instanceDefaults = $this->instanceDefaults;
        $options = get_option($this->plugin_name.'_instance' . $instanceID);
        if ($options !== false && is_array($options) === true) {
            $options['title'] = ($options['title'] === null) ? $instanceDefaults['title'] : $options['title'];
            $options['max_count'] = ($options['max_count'] === null) ? $instanceDefaults['max_count'] : $options['max_count'];
            $options['big_size'] = ($options['big_size'] === null) ? $instanceDefaults['big_size'] : $options['big_size'];
            $options['small_size'] = ($options['small_size'] === null) ? $instanceDefaults['small_size'] : $options['small_size'];
            $options['step'] = ($options['step'] === null) ? $instanceDefaults['step'] : $options['step'];
            $options['size_unit'] = ($options['size_unit'] === null) ? $instanceDefaults['size_unit'] : $options['size_unit'];
            $options['html_before'] = ($options['html_before'] === null) ? $instanceDefaults['html_before'] : $options['html_before'];
            $options['html_after'] = ($options['html_after'] === null) ? $instanceDefaults['html_after'] : $options['html_after'];
            $options['entry_layout'] = ($options['entry_layout'] === null) ? $instanceDefaults['entry_layout'] : $options['entry_layout'];
            $options['glue'] = ($options['glue'] === null) ? $instanceDefaults['glue'] : $options['glue'];
            $options['cat_filter'] = ($options['cat_filter'] === null) ? $instanceDefaults['cat_filter'] : $options['cat_filter'];
            $options['tag_filter'] = ($options['tag_filter'] === null) ? $instanceDefaults['tag_filter'] : $options['tag_filter'];
            $options['order'] = ($options['order'] === null) ? $instanceDefaults['order'] : $options['order'];
            return $options;
        }
        return $instanceDefaults;
    }

    public function create_selectfield($options, $preselect, $name, $extra = "")
    {
        $html = '<select name="' . $name . '"' . $extra . '>';
        foreach ($options as $key => $value) {
            if ($preselect == $key) {
                $html .= '<option value="' . $key . '" selected="selected">'. $value . '</option>';
            } else {
                $html .= '<option value="' . $key . '">'. $value . '</option>';
            }
        }
        $html .= '</select>';
        return $html;
    }

    public function get_newertagcloud_instances()
    {
        $options = $this->get_newertagcloud_options();
        $instances = unserialize($options['instances']);
        foreach ($instances as $id => $name) {
            $instances[$id] = $name . ' (ID: ' . $id . ')';
        }
        return $instances;
    }

    public function cat_filter_list($catfilter)
    {
        global $wpdb;

        $query = "SELECT `$wpdb->terms`.`term_id`, `$wpdb->terms`.`name` FROM `$wpdb->terms` LEFT JOIN `$wpdb->term_taxonomy` ON `$wpdb->terms`.`term_id` = `$wpdb->term_taxonomy`.`term_id` WHERE `$wpdb->term_taxonomy`.`taxonomy` = 'category' ORDER BY `$wpdb->terms`.`name`";
        $terms = $wpdb->get_results($query);
        foreach ($terms as $term) {
            if (is_array($catfilter)) {
                if (in_array($term->term_id, $catfilter)) {
                    echo '<input type="checkbox" name="'.$this->plugin_name.'-cat_filter[' . $term->term_id . ']" value="dofilter" checked="checked" /> ' . $term->name . '<br/>';
                } else {
                    echo '<input type="checkbox" name="'.$this->plugin_name.'-cat_filter[' . $term->term_id . ']" value="dofilter" /> ' . $term->name . '<br/>';
                }
            } else {
                echo '<input type="checkbox" name="'.$this->plugin_name.'-cat_filter[' . $term->term_id . ']" value="dofilter" /> ' . $term->name . '<br/>';
            }
        }
    }

    public function generate_newertagcloud($widget = true, $instanceID = 0)
    {
        global $wpdb;

        $globalOptions = $this->get_newertagcloud_options();

        if ($globalOptions['enable_cache'] && !empty($globalOptions['cache'][$instanceID])) {
            return $globalOptions['cache'][$instanceID];
        }

        $instanceOptions = $this->get_newertagcloud_instanceoptions($instanceID);
        $content = [];
        $size = $instanceOptions['big_size'];

        if (is_array($instanceOptions['cat_filter'])) {
            $sqlCatFilter = "`$wpdb->term_relationships`.`object_id` IN (SELECT `object_id` FROM `$wpdb->term_relationships` LEFT JOIN `$wpdb->term_taxonomy` ON `$wpdb->term_relationships`.`term_taxonomy_id` = `$wpdb->term_taxonomy`.`term_taxonomy_id` WHERE `term_id` IN (" . implode(",", $instanceOptions['cat_filter']) . ")) AND";
        } else {
            $sqlCatFilter = "";
        }

        if (is_array($instanceOptions['tag_filter'])) {
            foreach ($instanceOptions['tag_filter'] as $key => $value) {
                $instanceOptions['tag_filter'][$key] = "'" . $wpdb->escape($value) . "'";
            }
            $skipTags = implode(",", $instanceOptions['tag_filter']);
            $sqlTagFilter = "AND LOWER(`$wpdb->terms`.`name`) NOT IN ($skipTags)";
        } else {
            $sqlTagFilter = "";
        }
        $query = "SELECT `$wpdb->terms`.`term_id`, `$wpdb->terms`.`name`, LOWER(`$wpdb->terms`.`name`) AS lowername, `$wpdb->term_taxonomy`.`count` FROM `$wpdb->terms` LEFT JOIN `$wpdb->term_taxonomy` ON `$wpdb->terms`.`term_id` = `$wpdb->term_taxonomy`.`term_id` LEFT JOIN `$wpdb->term_relationships` ON `$wpdb->term_taxonomy`.`term_taxonomy_id` = `$wpdb->term_relationships`.`term_taxonomy_id` LEFT JOIN `$wpdb->posts` ON `$wpdb->term_relationships`.`object_id` = `$wpdb->posts`.`ID` WHERE " . $sqlCatFilter . " `$wpdb->term_taxonomy`.`taxonomy` = 'post_tag' AND `$wpdb->term_taxonomy`.`count` > 0 " . $sqlTagFilter . " GROUP BY `$wpdb->terms`.`name` ORDER BY `$wpdb->term_taxonomy`.`count` DESC LIMIT 0, " . $instanceOptions['max_count'];
        $terms = $wpdb->get_results($query);

        $prevCount = $terms[0]->count;
        $skipTags = explode(",", $instanceOptions['tag_filter']);
        foreach ($terms as $term) {
            if ($prevCount > intval($term->count) && $size > $instanceOptions['small_size']) {
                $size = $size - $instanceOptions['step'];
                $prevCount = intval($term->count);
            }
            $content[$term->lowername] = str_replace('%FONTSIZE%', $size, $instanceOptions['entry_layout']);
            $content[$term->lowername] = str_replace('%SIZETYPE%', $instanceOptions['size_unit'], $content[$term->lowername]);
            $content[$term->lowername] = str_replace('%TAGURL%', get_tag_link($term->term_id), $content[$term->lowername]);
            $content[$term->lowername] = str_replace('%TAGNAME%', $term->name, $content[$term->lowername]);
        }
        if ($instanceOptions['order'] == 'name') {
            ksort($content);
        }
        $content = implode($instanceOptions['glue'], $content);

        if ($widget) {
            $result = '<h' . ($globalOptions['heading_size'] + 1) . '>' . $instanceOptions['title'] . '</h' . ($globalOptions['heading_size'] + 1) . '>' . $instanceOptions['html_before'] . $content . $instanceOptions['html_after'];
        } else {
            $result = $instanceOptions['html_before'] . $content . $instanceOptions['html_after'];
        }

        if ($globalOptions['enable_cache']) {
          $this->newertagcloud_cache_create($instanceID, $result);
        }

        return $result;
    }

    public function newertagcloud_cache_create($instanceID, $data)
    {
        $options = $this->get_newertagcloud_options();
        $options['cache'][$instanceID] = $data;
        update_option($this->plugin_name, $options);
    }

    public function newertagcloud_cache_clear()
    {
        $options = $this->get_newertagcloud_options();
        unset($options['cache']);
        update_option($this->plugin_name, $options);
    }

}
