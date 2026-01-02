<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Update extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_id',
        'type',
        'name',
        'current_version',
        'new_version',
        'status',
        'changelog',
        'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
    ];

    /**
     * Get the site that owns the update.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
