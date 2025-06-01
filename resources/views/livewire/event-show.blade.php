<div class="bg-gray-100 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header with back button -->
        <div class="flex items-center mb-6">
            <a href="{{ route('events.index') }}" class="mr-4 text-blue-600 hover:text-blue-800 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">{{ $event->title }}</h1>
        </div>

        <!-- Success message -->
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-4 mb-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('message') }}
                </div>
            </div>
        @endif

        <!-- Event Details Card -->
        <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200 mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Event Details</h2>
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->date }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Time</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->time }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Event Type</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->event_type }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Organized By</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ \App\Models\User::find($event->event_for_user_id)->name ?? 'Unknown' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Guidelines</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $event->event_guidelines }}</dd>
                </div>
            </dl>

            @auth
                @php
                    $userInvitation = $event->invitations->where('user_id', Auth::id())->first();
                @endphp

                @if($userInvitation)
                    <div class="mt-6 pt-6 border-t border-gray-200 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        @if($userInvitation->status === 'pending')
                            <button wire:click="acceptInvitation" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg transition-all duration-200 flex items-center justify-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Accept Invitation
                            </button>
                            <button wire:click="rejectInvitation" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-6 rounded-lg transition-all duration-200 flex items-center justify-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Decline
                            </button>
                        @elseif($userInvitation->status === 'accepted')
                            <span class="text-green-600 font-medium py-2 px-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                You've accepted this invitation
                            </span>
                        @else
                            <span class="text-red-600 font-medium py-2 px-4 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                You've declined this invitation
                            </span>
                        @endif
                    </div>
                @endif
            @endauth
        </div>

        <!-- Invitations Section -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Guest List
            </h2>

            @if($event->invitations->count() > 0)
                <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($event->invitations as $invitation)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-600">{{ strtoupper(substr($invitation->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $invitation->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $invitation->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($invitation->status === 'accepted') bg-green-100 text-green-800
                                            @elseif($invitation->status === 'rejected') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($invitation->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-white p-6 rounded-lg border border-gray-200 text-center">
                    <p class="text-gray-500">No guests have been invited yet.</p>
                </div>
            @endif
        </div>

        <!-- Requisition List -->
        <div class="mb-8">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Requirements
            </h2>
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <livewire:requisition-list :event="$event" />
            </div>
        </div>

        <!-- Event Gallery -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Event Gallery
            </h2>
            <div class="bg-white p-6 rounded-lg shadow-md border border-gray-200">
                <livewire:event-gallery :event="$event" />
            </div>
        </div>
    </div>
</div>
