<?php
/**
 * Plugin Name: WP Demo Builder
 * Plugin URI:  http://www.wpdemobuilder.com/
 * Description: Create base site package, push it to WP Demo Builder system and display demo builder panel with ease.
 * Version:     1.3.1
 * Author:      WPDemoBuilder Team <admin@wpdemobuilder.com>
 * Author URI:  http://www.wpdemobuilder.com/
 * License:     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

// Define path to this plugin's main file
define( 'WPDB_PLUGIN', __FILE__ );

// Define text domain
define( 'WPDB_TEXT', 'wp-demo-builder' );


// Load core class file
include_once dirname( WPDB_PLUGIN ) . '/includes/core.php';

// Hook into WordPress
WPDB_Demo_Builder::hook();
