<?php

/**
 * The admin-specific functionality of the plugin.
 */
class WP_Wingman_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function enqueue_styles() {
        wp_enqueue_style($this->plugin_name, WP_WINGMAN_PLUGIN_URL . 'assets/css/wp-wingman-admin.css', array(), $this->version, 'all');
    }

    public function enqueue_scripts() {
        wp_enqueue_script($this->plugin_name, WP_WINGMAN_PLUGIN_URL . 'assets/js/wp-wingman-admin.js', array('jquery'), $this->version, false);
    }

    public function add_plugin_admin_menu() {
        add_menu_page(
            'WP Wingman',
            'WP Wingman',
            'manage_options',
            'wp-wingman',
            array($this, 'display_plugin_setup_page'),
            'dashicons-superhero',
            100
        );
    }

    public function register_settings() {
        register_setting('wp_wingman_options', 'wp_wingman_api_key');
        register_setting('wp_wingman_options', 'wp_wingman_api_url');
        register_setting('wp_wingman_options', 'wp_wingman_monitoring_enabled');
        register_setting('wp_wingman_options', 'wp_wingman_backup_enabled');
    }

    public function display_plugin_setup_page() {
        include_once WP_WINGMAN_PLUGIN_DIR . 'admin/partials/wp-wingman-admin-display.php';
    }
}
