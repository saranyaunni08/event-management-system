<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Invitation;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EventShow extends Component
{
    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
        $this->authorize('view', $event);
    }

    public function acceptInvitation()
    {
        $invitation = $this->event->invitations()->where('user_id', Auth::id())->first();
        if ($invitation && $invitation->status === 'pending') {
            $invitation->update(['status' => 'accepted']);
            session()->flash('message', 'Invitation accepted!');
        }
    }

    public function rejectInvitation()
    {
        $invitation = $this->event->invitations()->where('user_id', Auth::id())->first();
        if ($invitation && $invitation->status === 'pending') {
            $invitation->update(['status' => 'rejected']);
            session()->flash('message', 'Invitation rejected!');
        }
    }

    public function render()
    {
        return view('livewire.event-show');
    }
}
