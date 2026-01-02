<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Backup extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'name',
        'type',
        'status',
        'file_path',
        'file_size',
        'error_message',
        'completed_at',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the site that owns the backup.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
