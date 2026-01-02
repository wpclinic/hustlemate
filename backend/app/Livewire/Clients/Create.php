<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class Create extends Component
{
    public $name = '';
    public $company = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $timezone = 'UTC';
    public $is_active = true;

    protected $rules = [
        'name' => 'required|string|max:255',
        'company' => 'nullable|string|max:255',
        'email' => 'required|email|unique:clients,email',
        'phone' => 'nullable|string|max:255',
        'address' => 'nullable|string',
        'timezone' => 'required|string',
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        Client::create([
            'name' => $this->name,
            'company' => $this->company,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'timezone' => $this->timezone,
            'is_active' => $this->is_active,
        ]);

        session()->flash('message', 'Client created successfully.');

        return redirect()->route('clients.index');
    }

    public function render()
    {
        return view('livewire.clients.create');
    }
}
