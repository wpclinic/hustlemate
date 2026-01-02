<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'address',
        'timezone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the users for the client.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the sites for the client.
     */
    public function sites()
    {
        return $this->hasMany(Site::class);
    }

    /**
     * Get the subscriptions for the client.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the active subscription for the client.
     */
    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active');
    }

    /**
     * Get the support tickets for the client.
     */
    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    /**
     * Get the reports for the client.
     */
    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
