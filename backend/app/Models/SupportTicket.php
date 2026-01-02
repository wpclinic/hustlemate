<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'site_id',
        'assigned_to',
        'subject',
        'description',
        'priority',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the client that owns the ticket.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the site associated with the ticket.
     */
    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the user assigned to the ticket.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
