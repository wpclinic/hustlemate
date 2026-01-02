<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Clients\Index as ClientsIndex;
use App\Livewire\Clients\Create as ClientsCreate;
use App\Livewire\Clients\Edit as ClientsEdit;
use App\Livewire\Sites\Index as SitesIndex;
use App\Livewire\Sites\Create as SitesCreate;
use App\Livewire\Sites\Edit as SitesEdit;
use App\Livewire\Subscriptions\Index as SubscriptionsIndex;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
    
    // Clients routes
    Route::get('/clients', ClientsIndex::class)->name('clients.index');
    Route::get('/clients/create', ClientsCreate::class)->name('clients.create');
    Route::get('/clients/{id}/edit', ClientsEdit::class)->name('clients.edit');
    
    // Sites routes
    Route::get('/sites', SitesIndex::class)->name('sites.index');
    Route::get('/sites/create', SitesCreate::class)->name('sites.create');
    Route::get('/sites/{id}/edit', SitesEdit::class)->name('sites.edit');
    
    // Subscriptions routes
    Route::get('/subscriptions', SubscriptionsIndex::class)->name('subscriptions.index');
});
