<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'plan',
        'status',
        'site_limit',
        'price',
        'current_period_start',
        'current_period_end',
        'cancelled_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'site_limit' => 'integer',
        'current_period_start' => 'datetime',
        'current_period_end' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the client that owns the subscription.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
