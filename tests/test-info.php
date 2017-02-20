<?php
/**
 * Class SampleTest
 *
 * @package Newer_Tag_Cloud
 */

/**
 * Sample test case.
 */
class InfoTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	function test_plugin_info() {
        $plugin = (new Newer_Tag_Cloud());

		// Replace this with some actual testing code.
        $this->assertEquals('newer-tag-cloud', $plugin->get_plugin_name());
        $this->assertEquals('1.0.0', $plugin->get_version());
	}

}
