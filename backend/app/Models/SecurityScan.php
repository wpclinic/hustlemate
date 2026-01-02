<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SecurityScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'status',
        'threats_found',
        'scan_results',
        'recommendations',
        'scanned_at',
    ];

    protected $casts = [
        'threats_found' => 'integer',
        'scan_results' => 'array',
        'scanned_at' => 'datetime',
    ];

    /**
     * Get the site that owns the security scan.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
