<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Event $event)
    {
        return $event->user_id === $user->id ||
            $event->event_for_user_id === $user->id ||
            $event->invitations()->where('user_id', $user->id)->exists();
    }

    public function update(User $user, Event $event): bool
    {
        return $user->id === $event->user_id && !$event->isExpired();
    }

    public function addRequisitionItem(User $user, Event $event): bool
    {
        return ($user->id === $event->user_id || $user->id === $event->event_for_user_id) && !$event->isExpired();
    }

    public function claimRequisitionItem(User $user, Event $event): bool
    {
        return $event->invitations()->where('user_id', $user->id)->where('status', 'accepted')->exists() && !$event->isExpired();
    }

    public function uploadPhoto(User $user, Event $event)
    {
        if ($event->isExpired()) {
            return false; // Block uploads after event ends
        }
        $invitation = $event->invitations()->where('user_id', $user->id)->first();
        return $event->user_id === $user->id ||
            $event->event_for_user_id === $user->id ||
            ($invitation && $invitation->status === 'accepted');
    }
}
