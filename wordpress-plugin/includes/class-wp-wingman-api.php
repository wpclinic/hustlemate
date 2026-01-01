<?php

/**
 * Handle API communication with WP Wingman platform.
 */
class WP_Wingman_API {

    private $api_url;
    private $api_key;

    public function __construct() {
        $this->api_url = get_option('wp_wingman_api_url', 'https://api.wpwingman.com');
        $this->api_key = get_option('wp_wingman_api_key', '');
    }

    /**
     * Send data to the platform.
     */
    public function send_data($endpoint, $data) {
        if (empty($this->api_key)) {
            return new WP_Error('no_api_key', 'API key not configured');
        }

        $response = wp_remote_post($this->api_url . $endpoint, array(
            'headers' => array(
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->api_key,
                'X-WP-Wingman-Version' => WP_WINGMAN_VERSION,
            ),
            'body' => json_encode($data),
            'timeout' => 30,
        ));

        if (is_wp_error($response)) {
            return $response;
        }

        $body = wp_remote_retrieve_body($response);
        $code = wp_remote_retrieve_response_code($response);

        if ($code >= 200 && $code < 300) {
            return json_decode($body, true);
        }

        return new WP_Error('api_error', 'API request failed', array('status' => $code, 'body' => $body));
    }

    /**
     * Collect site information.
     */
    public function collect_site_info() {
        global $wp_version;

        $theme = wp_get_theme();
        $plugins = get_plugins();
        $active_plugins = get_option('active_plugins', array());

        return array(
            'site_url' => get_site_url(),
            'site_name' => get_bloginfo('name'),
            'wp_version' => $wp_version,
            'php_version' => PHP_VERSION,
            'mysql_version' => $this->get_mysql_version(),
            'theme' => array(
                'name' => $theme->get('Name'),
                'version' => $theme->get('Version'),
            ),
            'plugins' => array_map(function($plugin_file) use ($plugins) {
                $plugin = $plugins[$plugin_file];
                return array(
                    'name' => $plugin['Name'],
                    'version' => $plugin['Version'],
                    'active' => in_array($plugin_file, get_option('active_plugins', array())),
                );
            }, array_keys($plugins)),
            'updates' => array(
                'core' => $this->get_core_updates(),
                'plugins' => $this->get_plugin_updates(),
                'themes' => $this->get_theme_updates(),
            ),
        );
    }

    /**
     * Get MySQL version.
     */
    private function get_mysql_version() {
        global $wpdb;
        return $wpdb->db_version();
    }

    /**
     * Get core updates.
     */
    private function get_core_updates() {
        $updates = get_core_updates();
        if (!empty($updates) && !is_wp_error($updates)) {
            $update = reset($updates);
            if ($update->response === 'upgrade') {
                return array(
                    'current_version' => $GLOBALS['wp_version'],
                    'new_version' => $update->version,
                );
            }
        }
        return null;
    }

    /**
     * Get plugin updates.
     */
    private function get_plugin_updates() {
        $updates = get_plugin_updates();
        $available_updates = array();

        foreach ($updates as $plugin_file => $plugin_data) {
            $available_updates[] = array(
                'name' => $plugin_data->Name,
                'current_version' => $plugin_data->Version,
                'new_version' => $plugin_data->update->new_version,
            );
        }

        return $available_updates;
    }

    /**
     * Get theme updates.
     */
    private function get_theme_updates() {
        $updates = get_theme_updates();
        $available_updates = array();

        foreach ($updates as $theme_key => $theme_data) {
            $available_updates[] = array(
                'name' => $theme_data->get('Name'),
                'current_version' => $theme_data->get('Version'),
                'new_version' => $theme_data->update['new_version'],
            );
        }

        return $available_updates;
    }

    /**
     * Collect performance metrics.
     */
    public function collect_performance_metrics() {
        return array(
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'memory_limit' => ini_get('memory_limit'),
            'load_time' => microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'],
            'disk_space' => array(
                'free' => @disk_free_space(ABSPATH),
                'total' => @disk_total_space(ABSPATH),
            ),
        );
    }
}
