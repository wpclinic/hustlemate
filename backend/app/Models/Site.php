<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'url',
        'wp_version',
        'php_version',
        'status',
        'uptime_percentage',
        'response_time',
        'last_checked_at',
        'api_key',
        'monitoring_enabled',
        'backup_enabled',
        'notes',
    ];

    protected $casts = [
        'uptime_percentage' => 'decimal:2',
        'response_time' => 'integer',
        'last_checked_at' => 'datetime',
        'monitoring_enabled' => 'boolean',
        'backup_enabled' => 'boolean',
    ];

    /**
     * Get the client that owns the site.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the backups for the site.
     */
    public function backups()
    {
        return $this->hasMany(Backup::class);
    }

    /**
     * Get the security scans for the site.
     */
    public function securityScans()
    {
        return $this->hasMany(SecurityScan::class);
    }

    /**
     * Get the updates for the site.
     */
    public function updates()
    {
        return $this->hasMany(Update::class);
    }

    /**
     * Get the monitors for the site.
     */
    public function monitors()
    {
        return $this->hasMany(SiteMonitor::class);
    }

    /**
     * Get the support tickets for the site.
     */
    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }
}
