<?php
/**
 * PHPUnit bootstrap file
 *
 * @package LiquidWeb_Newer_Tag_Cloud
 * @subpackage LiquidWeb_Newer_Tag_Cloud\Tests
 */
namespace LiquidWeb_Newer_Tag_Cloud\Tests;

use \PHPUnit\Framework\TestCase as PHPUnit_Framework_TestCase;

function trailingslashit( $string ) {
	return untrailingslashit( $string ) . '/';
}

function untrailingslashit( $string ) {
	return rtrim( $string, '/\\' );
}

// Include the autoloader so we can dynamically include the rest of the classes.
require_once( trailingslashit( dirname( __FILE__ ) ) . '../includes/autoloader.php' );

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/newer-tag-cloud.php';
}
tests_add_filter( 'muplugins_loaded', __NAMESPACE__ . '\\_manually_load_plugin' );
