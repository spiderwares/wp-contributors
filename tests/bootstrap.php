<?php

// Load PHPUnit Polyfills (required for WP tests).
if ( file_exists( dirname( __DIR__ ) . '/vendor/autoload.php' ) ) {
    require dirname( __DIR__ ) . '/vendor/autoload.php';
}

// Then load WordPress testing framework
$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
    $_tests_dir = sys_get_temp_dir() . '/wordpress-tests-lib';
}

if ( ! file_exists( $_tests_dir . '/includes/functions.php' ) ) {
    echo "Could not find {$_tests_dir}/includes/functions.php\n";
    exit( 1 );
}

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
    require dirname( dirname( __FILE__ ) ) . '/wp-contributors.php';  // Adjust if plugin file name is different
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';
