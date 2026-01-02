<?php

/**
 * The core plugin class.
 */
class WP_Wingman {

    protected $loader;
    protected $plugin_name;
    protected $version;

    public function __construct() {
        $this->version = WP_WINGMAN_VERSION;
        $this->plugin_name = 'wp-wingman-client';

        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    private function load_dependencies() {
        require_once WP_WINGMAN_PLUGIN_DIR . 'includes/class-wp-wingman-loader.php';
        require_once WP_WINGMAN_PLUGIN_DIR . 'includes/class-wp-wingman-api.php';
        require_once WP_WINGMAN_PLUGIN_DIR . 'includes/class-wp-wingman-monitor.php';
        require_once WP_WINGMAN_PLUGIN_DIR . 'admin/class-wp-wingman-admin.php';

        $this->loader = new WP_Wingman_Loader();
    }

    private function define_admin_hooks() {
        $plugin_admin = new WP_Wingman_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'add_plugin_admin_menu');
        $this->loader->add_action('admin_init', $plugin_admin, 'register_settings');
    }

    private function define_public_hooks() {
        // Monitoring hooks
        $monitor = new WP_Wingman_Monitor();
        $this->loader->add_action('wp_wingman_hourly_check', $monitor, 'perform_hourly_check');
        $this->loader->add_action('wp_wingman_daily_report', $monitor, 'send_daily_report');
    }

    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_version() {
        return $this->version;
    }

    public function get_loader() {
        return $this->loader;
    }
}
