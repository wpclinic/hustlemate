<?php

/**
 * Fired during plugin activation.
 */
class WP_Wingman_Activator {

    /**
     * Activate the plugin.
     */
    public static function activate() {
        // Create options
        add_option('wp_wingman_api_key', '');
        add_option('wp_wingman_api_url', 'https://api.wpwingman.com');
        add_option('wp_wingman_monitoring_enabled', true);
        add_option('wp_wingman_backup_enabled', true);
        
        // Schedule cron jobs
        if (!wp_next_scheduled('wp_wingman_hourly_check')) {
            wp_schedule_event(time(), 'hourly', 'wp_wingman_hourly_check');
        }
        
        if (!wp_next_scheduled('wp_wingman_daily_report')) {
            wp_schedule_event(time(), 'daily', 'wp_wingman_daily_report');
        }
        
        flush_rewrite_rules();
    }
}
