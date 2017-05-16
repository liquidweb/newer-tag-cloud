<?php

/**
 * The file that defines the core plugin's widget class
 *
 * @link       http://github.com/mallardduck
 * @since      1.0.0
 *
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/includes
 */
namespace LiquidWeb_Newer_Tag_Cloud\Lib;

use \WP_Widget;
use \LiquidWeb_Newer_Tag_Cloud\Admin\Newer_Tag_Cloud_Admin as Newer_Tag_Cloud_Admin;
use \LiquidWeb_Newer_Tag_Cloud\Front\Newer_Tag_Cloud_Front as Newer_Tag_Cloud_Front;

/**
 * The core plugins Widget class.
 *
 * @since      1.0.0
 * @package    Newer_Tag_Cloud
 * @subpackage Newer_Tag_Cloud/includes
 * @author     Dan Pock (Liquid Web) <dpock@liquidweb.com>
 */
class Newer_Tag_Cloud_Widget extends WP_Widget
{

    /**
	 * An instance of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $pluginInstance;

    /**
	 * The ID of this plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 * @var 		string 			$plugin_name 		The ID of this plugin.
	 */
	private $plugin_name;

    /**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
        $this->pluginInstance = (new Newer_Tag_Cloud());
        $this->plugin_name = $this->pluginInstance->get_plugin_name();
        $this->name = esc_html__('Newer Tag Cloud', $this->plugin_name);
        $this->options = $this->pluginInstance->getOptions();

		$widget_ops = array(
			'classname' => $this->plugin_name,
            'customize_selective_refresh' => true,
			'description' => 'A customizable cloud of your most used tags.',
		);
		parent::__construct( $this->plugin_name, $this->name, $widget_ops );
	}

	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
        $widgetInstanceId = $instance['widget_instance_id'];
        // Get the cache for the plugins widget(s)
        $cache = wp_cache_get( $this->plugin_name.'-'.$widgetInstanceId, 'widget' );
        // If there's no cache then we'll init an empty array
        if ( ! is_array( $cache ) ) {
			$cache = [];
		}
        // If there isn't a widget_id passed, then get the default
        if ( ! isset ( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->plugin_name.'-'.$widgetInstanceId;
        }
        // If it's cached return the cached instance
        if ( isset ( $cache[ $args['widget_id'] ] ) ) {
            return print $cache[ $args['widget_id'] ];
        }
        extract( $args, EXTR_SKIP );
        $widget_string = $before_widget;
		// outputs the content of the widget
        ob_start();
        $cloud = $this->options->generate_newertagcloud(true, $widgetInstanceId);
        include( plugin_dir_path( __FILE__ ) . '../front/partials/newer-tag-cloud-public-display.php' );
        $widget_string .= ob_get_clean();
        $widget_string .= $after_widget;
        // Cache it, then print it
        $cache[ $args['widget_id'] ] = $widget_string;
        wp_cache_set( $this->plugin_name.'-'.$widgetInstanceId, $cache, 'widget' );
        print $widget_string;
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
        // Get instance and widget options
        $globalOptions = $this->options->get_newertagcloud_options();
        $defaultWidget = $globalOptions['default_widget_instance'];
        $instanceList = $this->options->get_newertagcloud_instances();

        // Set up defaults for new widgets
        $defaults['widget_instance_id'] = $defaultWidget;
        $instance = wp_parse_args( (array) $instance, $defaults );

        // Get instance options
        $instanceOptions = $this->options->get_newertagcloud_instanceoptions($instance['widget_instance_id']);
        $instance = array_merge($instanceOptions, $instance);

        // Start the form - Do Widget Instance ID first since all else is based on this
        $widgetNumber_id = $this->get_field_id('widget_instance_id');
        $widgetNumber_name = $this->get_field_name('widget_instance_id');
        printf(
            '<p><label for="%1$s">%2$s</label>' .
            '<select class="widefat" id="%1$s" name="%3$s">',
            $widgetNumber_id,
            __( 'Widget Instance:' ),
            $widgetNumber_name
        );
        foreach ( $instanceList as $key => $value ) {
            printf(
                '<option value="%s"%s>%s</option>',
                esc_attr( $key ),
                selected( $key, $instance['widget_instance_id'], false ),
                $value
            );
        }
        echo '</select></p>';
        // Then widget title
        $title_id = $this->get_field_id('title');
        $title_name = $this->get_field_name('title');
        $title_value = esc_attr( $instanceOptions['title'] );
        echo '<p><label for="' . $title_id .'">' . __( 'Title:' ) . '</label>
            <input type="text" class="widefat" id="' . $title_id .'" name="' . $title_name .'" value="' . $title_value .'" placeholder="' . esc_attr__( 'Enter widget Title.' ) . '" />
        </p>';
		// outputs the options form on admin
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 */
	public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        if ($new_instance['widget_instance_id'] !== $old_instance['widget_instance_id']) {
            $instance['widget_instance_id'] = sanitize_text_field( $new_instance['widget_instance_id'] );
            $instanceOptions = $this->options->get_newertagcloud_instanceoptions($instance['widget_instance_id']);
            $instance['title'] = $instanceOptions['title'];
            return $instance;
        }
        $instanceOptions = $this->options->get_newertagcloud_instanceoptions($instance['widget_instance_id']);

		$instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instanceOptions['title'] = $instance['title'];
        update_option($this->plugin_name.'_instance' . $instance['widget_instance_id'], $instanceOptions);
		return $instance;
	}
}
