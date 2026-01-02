<?php

/**
 * Fired during plugin deactivation.
 */
class WP_Wingman_Deactivator {

    /**
     * Deactivate the plugin.
     */
    public static function deactivate() {
        // Clear scheduled cron jobs
        wp_clear_scheduled_hook('wp_wingman_hourly_check');
        wp_clear_scheduled_hook('wp_wingman_daily_report');
        
        flush_rewrite_rules();
    }
}
