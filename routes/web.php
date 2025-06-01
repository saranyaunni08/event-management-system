<?php

use App\Livewire\EventCreate;
use App\Livewire\EventIndex;
use App\Livewire\EventShow;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return redirect()->route('events.index');
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/events', EventIndex::class)->name('events.index');
    Route::get('/events/create', EventCreate::class)->name('events.create');
    Route::get('/events/{event}', EventShow::class)
        ->middleware('ensure.invited')
        ->name('events.show');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

require __DIR__.'/auth.php';