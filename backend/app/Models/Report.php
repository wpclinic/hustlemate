<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'site_id',
        'type',
        'title',
        'data',
        'status',
        'file_path',
        'generated_at',
    ];

    protected $casts = [
        'data' => 'array',
        'generated_at' => 'datetime',
    ];

    /**
     * Get the client that owns the report.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the site associated with the report.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
