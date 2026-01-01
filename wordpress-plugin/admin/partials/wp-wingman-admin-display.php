<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    
    <div class="wp-wingman-header">
        <p class="description" style="font-size: 16px; color: #20C997;"><strong>Your WordPress Wingman - Always at Your Side</strong></p>
    </div>

    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
        settings_fields('wp_wingman_options');
        do_settings_sections('wp_wingman_options');
        ?>

        <table class="form-table">
            <tr valign="top">
                <th scope="row">API Key</th>
                <td>
                    <input type="text" name="wp_wingman_api_key" value="<?php echo esc_attr(get_option('wp_wingman_api_key')); ?>" class="regular-text" />
                    <p class="description">Enter your WP Wingman API key to connect this site to your dashboard.</p>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">API URL</th>
                <td>
                    <input type="text" name="wp_wingman_api_url" value="<?php echo esc_attr(get_option('wp_wingman_api_url', 'https://api.wpwingman.com')); ?>" class="regular-text" />
                    <p class="description">API endpoint URL (default: https://api.wpwingman.com)</p>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Monitoring</th>
                <td>
                    <label>
                        <input type="checkbox" name="wp_wingman_monitoring_enabled" value="1" <?php checked(get_option('wp_wingman_monitoring_enabled', true), 1); ?> />
                        Enable site monitoring
                    </label>
                    <p class="description">Monitor uptime, performance, and security.</p>
                </td>
            </tr>

            <tr valign="top">
                <th scope="row">Backups</th>
                <td>
                    <label>
                        <input type="checkbox" name="wp_wingman_backup_enabled" value="1" <?php checked(get_option('wp_wingman_backup_enabled', true), 1); ?> />
                        Enable automated backups
                    </label>
                    <p class="description">Automatically backup your site to WP Wingman.</p>
                </td>
            </tr>
        </table>

        <?php submit_button(); ?>
    </form>

    <div class="wp-wingman-info card">
        <h2>Site Information</h2>
        <?php
        $api = new WP_Wingman_API();
        $site_info = $api->collect_site_info();
        ?>
        <table class="widefat">
            <tr>
                <td><strong>WordPress Version:</strong></td>
                <td><?php echo esc_html($site_info['wp_version']); ?></td>
            </tr>
            <tr>
                <td><strong>PHP Version:</strong></td>
                <td><?php echo esc_html($site_info['php_version']); ?></td>
            </tr>
            <tr>
                <td><strong>MySQL Version:</strong></td>
                <td><?php echo esc_html($site_info['mysql_version']); ?></td>
            </tr>
            <tr>
                <td><strong>Active Theme:</strong></td>
                <td><?php echo esc_html($site_info['theme']['name']); ?> (v<?php echo esc_html($site_info['theme']['version']); ?>)</td>
            </tr>
            <tr>
                <td><strong>Active Plugins:</strong></td>
                <td><?php echo count(array_filter($site_info['plugins'], function($p) { return $p['active']; })); ?></td>
            </tr>
        </table>
    </div>
</div>
