<?php

namespace App\Livewire\Sites;

use App\Models\Site;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDeletion = false;
    public $siteIdToDelete = null;

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDeletion($siteId)
    {
        $this->confirmingDeletion = true;
        $this->siteIdToDelete = $siteId;
    }

    public function deleteSite()
    {
        $site = Site::findOrFail($this->siteIdToDelete);
        $site->delete();

        $this->confirmingDeletion = false;
        $this->siteIdToDelete = null;

        session()->flash('message', 'Site deleted successfully.');
    }

    public function render()
    {
        $sites = Site::with('client')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('url', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.sites.index', [
            'sites' => $sites,
        ]);
    }
}
