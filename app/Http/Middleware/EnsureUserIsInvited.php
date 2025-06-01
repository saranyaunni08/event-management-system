<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsInvited
{
    public function handle(Request $request, Closure $next): Response
    {
        // Get the event from the route (assumes 'event' is a route parameter)
        $event = $request->route('event');

        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to access this event.');
        }

        // Check if event exists
        if (!$event instanceof Event) {
            return redirect()->route('events.index')->with('error', 'Event not found.');
        }

        $user = Auth::user();

        // Allow access if user is creator, event is for them, or they are invited
        if ($user->id === $event->user_id || $user->id === $event->event_for_user_id || $event->invitations()->where('user_id', $user->id)->exists()) {
            return $next($request);
        }

        // Deny access if none of the conditions are met
        return redirect()->route('events.index')->with('error', 'You are not authorized to access this event.');
    }
}