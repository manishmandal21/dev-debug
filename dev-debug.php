<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://manishmandal.com
 * @since             1.0.0
 * @package           Dev_Debug
 *
 * @wordpress-plugin
 * Plugin Name:       Dev Debug
 * Plugin URI:        https://medium.com/@manntrix
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Manish Mandal
 * Author URI:        http://manishmandal.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dev-debug
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define constants for plugin
 */

define( 'DEV_DEBUG_VERSION', '1.0.0' );
define( 'DEV_DEBUG_PARENT_DIR', plugin_dir_url( __FILE__ ) );
define( 'DEV_DEBUG_ASSETS_DIR', plugin_dir_url( __FILE__ ) . 'public' );



/** Load Autoload File */
require_once plugin_dir_path( __FILE__ ) . '/lib/vendor/autoload.php';




/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-dev-debug-activator.php
 */

function activate_dev_debug() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dev-debug-activator.php';
	Dev_Debug_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-dev-debug-deactivator.php
 */
function deactivate_dev_debug() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-dev-debug-deactivator.php';
	Dev_Debug_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_dev_debug' );
register_deactivation_hook( __FILE__, 'deactivate_dev_debug' );

/** Include redux framework for custom options */

require_once (dirname(__FILE__) . '/lib/custom/loader.php');

if( !class_exists('ReduxFramework')){
    require_once(dirname(__FILE__) . '/lib/ReduxCore/Framework.php');
}

if( !isset( $dev_debug ) ){
    require_once( dirname( __FILE__) . '/lib/ReduxCore/plugin-config.php');
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-dev-debug.php';
require plugin_dir_path( __FILE__ ) . 'lib/whoop/class-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_dev_debug() {

	$plugin = new Dev_Debug();
	$plugin->run();
	$plugin->dev_debug_custom_functions();
    $whoops = new \Devdebug\whoops\DevDebugWhoops();
    $whoops->run();


}
run_dev_debug();

