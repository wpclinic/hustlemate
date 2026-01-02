<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiteMonitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'status',
        'response_time',
        'http_status_code',
        'uptime_percentage',
        'metrics',
        'error_message',
        'checked_at',
    ];

    protected $casts = [
        'response_time' => 'integer',
        'http_status_code' => 'integer',
        'uptime_percentage' => 'decimal:2',
        'metrics' => 'array',
        'checked_at' => 'datetime',
    ];

    /**
     * Get the site that owns the monitor record.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
