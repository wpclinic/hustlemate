<?php
/**
 * Plugin Name: WP Wingman Client
 * Plugin URI: https://wpwingman.com
 * Description: WordPress monitoring and management plugin for WP Wingman platform. Collects site data, reports performance metrics, and enables remote management.
 * Version: 1.0.0
 * Author: WP Wingman
 * Author URI: https://wpwingman.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: wp-wingman-client
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.1
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

define('WP_WINGMAN_VERSION', '1.0.0');
define('WP_WINGMAN_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WP_WINGMAN_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * The code that runs during plugin activation.
 */
function activate_wp_wingman() {
    require_once WP_WINGMAN_PLUGIN_DIR . 'includes/class-wp-wingman-activator.php';
    WP_Wingman_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_wp_wingman() {
    require_once WP_WINGMAN_PLUGIN_DIR . 'includes/class-wp-wingman-deactivator.php';
    WP_Wingman_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wp_wingman');
register_deactivation_hook(__FILE__, 'deactivate_wp_wingman');

/**
 * The core plugin class.
 */
require WP_WINGMAN_PLUGIN_DIR . 'includes/class-wp-wingman.php';

/**
 * Begins execution of the plugin.
 */
function run_wp_wingman() {
    $plugin = new WP_Wingman();
    $plugin->run();
}
run_wp_wingman();
