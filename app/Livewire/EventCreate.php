<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EventCreate extends Component
{
    public $title, $date, $time, $event_type, $event_for_user_id, $event_guidelines, $invited_users = [];

    protected $rules = [
        'title' => 'required|string|max:255',
        'date' => 'required|date|after:today',
        'time' => 'required',
        'event_type' => 'required|in:Meeting,Celebration,Seminar',
        'event_for_user_id' => 'required|exists:users,id',
        'event_guidelines' => 'nullable|string',
        'invited_users' => 'required|array|min:1', // Updated to require at least one user
        'invited_users.*' => 'exists:users,id',
    ];

    public function createEvent()
    {
        $this->validate();

        $event = Event::create([
            'title' => $this->title,
            'date' => $this->date,
            'time' => $this->time,
            'event_type' => $this->event_type,
            'user_id' => Auth::id(),
            'event_for_user_id' => $this->event_for_user_id,
            'event_guidelines' => $this->event_guidelines,
        ]);

        foreach ($this->invited_users as $userId) {
            $event->invitations()->create(['user_id' => $userId]);
        }

        session()->flash('message', 'Event created successfully!');
        return redirect()->route('events.index');
    }

    public function render()
    {
        return view('livewire.event-create', [
            'users' => User::where('id', '!=', Auth::id())->get(),
        ]);
    }
}