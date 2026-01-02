<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;
    public $clientIdToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion($clientId)
    {
        $this->confirmingDeletion = true;
        $this->clientIdToDelete = $clientId;
    }

    public function deleteClient()
    {
        $client = Client::findOrFail($this->clientIdToDelete);
        $client->delete();

        $this->confirmingDeletion = false;
        $this->clientIdToDelete = null;

        session()->flash('message', 'Client deleted successfully.');
    }

    public function render()
    {
        $clients = Client::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('company', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.clients.index', [
            'clients' => $clients,
        ]);
    }
}
