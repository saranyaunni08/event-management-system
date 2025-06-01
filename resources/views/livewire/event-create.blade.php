<div>
    <h2 class="text-2xl font-bold mb-4">Create scarsEvent</h2>
    @if (session('message'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif
    <form wire:submit="createEvent" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Title</label>
            <input wire:model="title" type="text" class="w-full p-2 border rounded">
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Date</label>
            <input wire:model="date" type="date" class="w-full p-2 border rounded">
            @error('date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Time</label>
            <input wire:model="time" type="time" class="w-full p-2 border rounded">
            @error('time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Event Type</label>
            <select wire:model="event_type" class="w-full p-2 border rounded">
                <option value="">Select Type</option>
                <option value="Meeting">Meeting</option>
                <option value="Celebration">Celebration</option>
                <option value="Seminar">Seminar</option>
            </select>
            @error('event_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Event For</label>
            <select wire:model="event_for_user_id" class="w-full p-2 border rounded">
                <option value="">Select User</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('event_for_user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Guidelines</label>
            <textarea wire:model="event_guidelines" class="w-full p-2 border rounded"></textarea>
            @error('event_guidelines') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Invite Users</label>
            <div class="space-y-2 max-h-40 overflow-y-auto border rounded p-2">
                @foreach($users as $user)
                    <div class="flex items-center">
                        <input wire:model="invited_users" type="checkbox" value="{{ $user->id }}" class="mr-2">
                        <label>{{ $user->name }}</label>
                    </div>
                @endforeach
            </div>
            @error('invited_users') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create Event</button>
    </form>
</div>