<div class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-black">My Events</h2>
                <p class="text-gray-400 mt-1">Manage your events and invitations</p>
            </div>
            <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3 w-full sm:w-auto">
                <button wire:click="toggleInvitations" class="bg-amber-400 hover:bg-amber-500 text-gray-900 font-medium px-4 py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                    </svg>
                    {{ $showInvitationsOnly ? 'Show All' : 'My Invitations' }}
                </button>
                <button wire:click="createEvent" class="bg-blue-500 hover:bg-blue-600 text-white font-medium px-4 py-2 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create Event
                </button>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="mb-8 bg-gray-800 p-4 rounded-xl shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-300 mb-1">Search Events</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="search" wire:model.debounce.500ms="search" class="block w-full pl-10 pr-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-black placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Search events...">
                    </div>
                </div>
                
                <div>
                    <label for="filterType" class="block text-sm font-medium text-gray-300 mb-1">Event Type</label>
                    <select id="filterType" wire:model="filterType" class="block w-full pl-3 pr-10 py-2 bg-gray-700 border border-gray-600 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Types</option>
                        @foreach($eventTypes as $type)
                            <option value="{{ $type }}">{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="filterStatus" class="block text-sm font-medium text-gray-300 mb-1">Event Status</label>
                    <select id="filterStatus" wire:model="filterStatus" class="block w-full pl-3 pr-10 py-2 bg-gray-700 border border-gray-600 rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Events</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="expired">Past Events</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Event List -->
        <div class="space-y-5">
            @forelse($events as $event)
                <div class="bg-gradient-to-r from-gray-800 to-gray-700 p-6 rounded-xl shadow-lg border-l-4 @if($event->isExpired()) border-red-500 @else border-blue-500 @endif hover:shadow-xl transition duration-200 transform hover:-translate-y-1">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <h3 class="text-xl font-bold text-black">{{ $event->title }}</h3>
                                @if($event->isExpired())
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-900 text-red-100">Expired</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-900 text-green-100">Upcoming</span>
                                @endif
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-gray-300">
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-black mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-black">{{ $event->date }} at {{ $event->time }}</span>
                                </div>
                                
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-black mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                    <span class="text-black">{{ $event->event_type }}</span>
                                </div>
                                
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-black mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-black">For: {{ $event->eventForUser->name }}</span>
                                </div>
                                
                                <div class="flex items-start">
                                    <svg class="h-5 w-5 text-black mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
                                    </svg>
                                    <span class="text-black">
                                        @if($event->user_id === Auth::id())
                                            <span class="text-blue-300">Organizer</span>
                                        @elseif($event->event_for_user_id === Auth::id())
                                            <span class="text-purple-300">Main Guest</span>
                                        @else
                                            <span class="text-gray-300">Guest</span>
                                            @if($event->invitations->isNotEmpty())
                                                @php
                                                    $invitation = $event->invitations->firstWhere('user_id', Auth::id());
                                                @endphp
                                                @if($invitation)
                                                    <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($invitation->status === 'accepted') bg-green-200 text-green-800
                                                        @elseif($invitation->status === 'rejected') bg-red-200 text-red-800
                                                        @else bg-yellow-200 text-yellow-800 @endif">
                                                        {{ ucfirst($invitation->status) }}
                                                    </span>
                                                @endif
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row md:flex-col gap-2">
                            @if($event->user_id !== Auth::id() && $event->event_for_user_id !== Auth::id() && $event->invitations->isNotEmpty() && $event->invitations->first()->status === 'pending')
                                <div class="flex space-x-2">
                                    <button wire:click="acceptInvitation({{ $event->id }})" class="flex-1 !bg-green-600 !hover:bg-green-700 !text-white px-3 py-1 rounded-lg text-sm transition duration-150 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Accept
                                    </button>
                                    <button wire:click="rejectInvitation({{ $event->id }})" class="flex-1 !bg-red-600 !hover:bg-red-700 !text-white px-3 py-1 rounded-lg text-sm transition duration-150 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Reject
                                    </button>
                                </div>
                            @endif
                            <a href="{{ route('events.show', $event) }}" class="bg-gray-600 hover:bg-gray-500 text-black px-4 py-2 rounded-lg text-sm transition duration-150 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-300">No events found</h3>
                    <p class="mt-1 text-gray-500">Try adjusting your search or create a new event</p>
                    <button wire:click="createEvent" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Create Your First Event
                    </button>
                </div>
            @endforelse
        </div>
    </div>
</div>
