<?php

namespace App\Livewire\Dashboard;

use App\Models\Client;
use App\Models\Site;
use App\Models\SupportTicket;
use App\Models\Backup;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $stats = [
            'total_clients' => Client::count(),
            'total_sites' => Site::count(),
            'online_sites' => Site::where('status', 'online')->count(),
            'open_tickets' => SupportTicket::where('status', 'open')->count(),
            'recent_backups' => Backup::where('status', 'completed')->count(),
        ];

        $recentSites = Site::with('client')->latest()->take(5)->get();
        $recentTickets = SupportTicket::with('client')->latest()->take(5)->get();

        return view('livewire.dashboard.index', [
            'stats' => $stats,
            'recentSites' => $recentSites,
            'recentTickets' => $recentTickets,
        ]);
    }
}
