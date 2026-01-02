<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Site;
use App\Models\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@wpwingman.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Demo Client
        $client = Client::create([
            'name' => 'Demo Client',
            'company' => 'Acme Corporation',
            'email' => 'demo@acme.com',
            'phone' => '+1234567890',
            'address' => '123 Main Street, New York, NY 10001',
            'timezone' => 'America/New_York',
            'is_active' => true,
        ]);

        // Create Client User
        $clientUser = User::create([
            'name' => 'Demo Client User',
            'email' => 'client@wpwingman.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
            'client_id' => $client->id,
            'is_active' => true,
        ]);

        // Create Support User
        $support = User::create([
            'name' => 'Support User',
            'email' => 'support@wpwingman.com',
            'password' => Hash::make('password123'),
            'role' => 'support',
            'is_active' => true,
        ]);

        // Create Subscription
        Subscription::create([
            'client_id' => $client->id,
            'plan' => 'professional',
            'status' => 'active',
            'site_limit' => 10,
            'price' => 49.99,
            'current_period_start' => now(),
            'current_period_end' => now()->addMonth(),
        ]);

        // Create Demo Sites
        Site::create([
            'client_id' => $client->id,
            'name' => 'Main Website',
            'url' => 'https://example.com',
            'wp_version' => '6.4.2',
            'php_version' => '8.3.0',
            'status' => 'online',
            'uptime_percentage' => 99,
            'response_time' => 245,
            'last_checked_at' => now(),
            'api_key' => bin2hex(random_bytes(32)),
            'monitoring_enabled' => true,
            'backup_enabled' => true,
            'notes' => 'Main production website',
        ]);

        Site::create([
            'client_id' => $client->id,
            'name' => 'Blog Site',
            'url' => 'https://blog.example.com',
            'wp_version' => '6.4.2',
            'php_version' => '8.2.15',
            'status' => 'online',
            'uptime_percentage' => 100,
            'response_time' => 189,
            'last_checked_at' => now(),
            'api_key' => bin2hex(random_bytes(32)),
            'monitoring_enabled' => true,
            'backup_enabled' => true,
            'notes' => 'Company blog',
        ]);

        Site::create([
            'client_id' => $client->id,
            'name' => 'E-commerce Store',
            'url' => 'https://shop.example.com',
            'wp_version' => '6.4.2',
            'php_version' => '8.3.0',
            'status' => 'warning',
            'uptime_percentage' => 95,
            'response_time' => 512,
            'last_checked_at' => now(),
            'api_key' => bin2hex(random_bytes(32)),
            'monitoring_enabled' => true,
            'backup_enabled' => true,
            'notes' => 'WooCommerce store - needs optimization',
        ]);

        $this->command->info('Demo data seeded successfully!');
        $this->command->info('Admin: admin@wpwingman.com / password123');
        $this->command->info('Client: client@wpwingman.com / password123');
        $this->command->info('Support: support@wpwingman.com / password123');
    }
}
