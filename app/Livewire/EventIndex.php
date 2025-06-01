<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EventIndex extends Component
{
    public $search = '';
    public $filterType = '';
    public $filterStatus = '';
    public $showInvitationsOnly = false;

    public $eventTypes = ['Meeting', 'Celebration', 'Seminar'];

    public function toggleInvitations()
    {
        $this->showInvitationsOnly = !$this->showInvitationsOnly;
    }

    public function createEvent()
    {
        return redirect()->route('events.create');
    }

    public function acceptInvitation($eventId)
    {
        $event = Event::findOrFail($eventId);
        $invitation = $event->invitations()->where('user_id', Auth::id())->first();
        if ($invitation && $invitation->status === 'pending') {
            $invitation->update(['status' => 'accepted']);
            session()->flash('message', 'Invitation accepted!');
        }
    }

    public function rejectInvitation($eventId)
    {
        $event = Event::findOrFail($eventId);
        $invitation = $event->invitations()->where('user_id', Auth::id())->first();
        if ($invitation && $invitation->status === 'pending') {
            $invitation->update(['status' => 'rejected']);
            session()->flash('message', 'Invitation rejected!');
        }
    }

    public function render()
    {
        $query = Event::query()
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                      ->orWhere('event_for_user_id', Auth::id())
                      ->orWhereHas('invitations', function ($q) {
                          $q->where('user_id', Auth::id());
                      });
            })
            ->with(['creator', 'eventForUser', 'invitations' => function ($q) {
                $q->where('user_id', Auth::id());
            }]);

        if ($this->showInvitationsOnly) {
            $query->whereHas('invitations', function ($q) {
                $q->where('user_id', Auth::id());
            })->where('user_id', '!=', Auth::id())
              ->where('event_for_user_id', '!=', Auth::id());
        }

        if ($this->search) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        if ($this->filterType) {
            $query->where('event_type', $this->filterType);
        }

        if ($this->filterStatus === 'upcoming') {
            $query->where('date', '>=', now()->toDateString());
        } elseif ($this->filterStatus === 'expired') {
            $query->where('date', '<', now()->toDateString());
        }

        $events = $query->latest()->get();

        return view('livewire.event-index', [
            'events' => $events,
            'eventTypes' => $this->eventTypes,
        ]);
    }
}