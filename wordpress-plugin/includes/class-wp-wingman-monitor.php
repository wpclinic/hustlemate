<?php

/**
 * Handle site monitoring and reporting.
 */
class WP_Wingman_Monitor {

    private $api;

    public function __construct() {
        $this->api = new WP_Wingman_API();
    }

    /**
     * Perform hourly check.
     */
    public function perform_hourly_check() {
        if (!get_option('wp_wingman_monitoring_enabled', true)) {
            return;
        }

        $data = array(
            'timestamp' => current_time('mysql'),
            'site_info' => $this->api->collect_site_info(),
            'performance' => $this->api->collect_performance_metrics(),
            'status' => $this->check_site_status(),
        );

        $result = $this->api->send_data('/api/v1/sites/monitor', $data);

        if (is_wp_error($result)) {
            error_log('WP Wingman: Failed to send monitoring data - ' . $result->get_error_message());
        }
    }

    /**
     * Send daily report.
     */
    public function send_daily_report() {
        if (!get_option('wp_wingman_monitoring_enabled', true)) {
            return;
        }

        $data = array(
            'timestamp' => current_time('mysql'),
            'site_info' => $this->api->collect_site_info(),
            'performance' => $this->api->collect_performance_metrics(),
            'security' => $this->check_security(),
            'backups' => $this->get_backup_status(),
        );

        $result = $this->api->send_data('/api/v1/sites/daily-report', $data);

        if (is_wp_error($result)) {
            error_log('WP Wingman: Failed to send daily report - ' . $result->get_error_message());
        }
    }

    /**
     * Check site status.
     */
    private function check_site_status() {
        return array(
            'online' => true,
            'response_time' => $this->measure_response_time(),
            'http_code' => 200,
        );
    }

    /**
     * Measure response time.
     */
    private function measure_response_time() {
        $start = microtime(true);
        $response = wp_remote_get(home_url());
        $end = microtime(true);

        return ($end - $start) * 1000; // Convert to milliseconds
    }

    /**
     * Check security.
     */
    private function check_security() {
        return array(
            'ssl_enabled' => is_ssl(),
            'wp_debug' => defined('WP_DEBUG') && WP_DEBUG,
            'file_editing' => !defined('DISALLOW_FILE_EDIT') || !DISALLOW_FILE_EDIT,
            'auto_updates' => get_option('auto_update_core_major', false),
        );
    }

    /**
     * Get backup status.
     */
    private function get_backup_status() {
        // This would integrate with backup plugins or custom backup solution
        return array(
            'enabled' => get_option('wp_wingman_backup_enabled', true),
            'last_backup' => get_option('wp_wingman_last_backup', null),
        );
    }
}
