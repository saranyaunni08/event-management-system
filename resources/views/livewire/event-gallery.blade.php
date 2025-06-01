<div>
    <h3 class="text-xl font-bold mb-4">Event Gallery</h3>
    @if (session('message'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif
    @can('uploadPhoto', $event)
        <form wire:submit="uploadPhoto" class="space-y-4 mb-4">
            <div>
                <label class="block text-sm font-medium">Upload Photo</label>
                <input wire:model="photo" type="file" class="w-full p-2 border rounded">
                @error('photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Upload</button>
        </form>
    @endcan
    <div class="grid grid-cols-3 gap-4">
        @if($photos && $photos->count())
            @foreach($photos as $photo)
                <div class="bg-white p-2 rounded shadow">
                    <img src="{{ Storage::url($photo->path) }}" alt="Event Photo" class="w-full h-32 object-cover">
                    <p>Uploaded by: {{ $photo->user->name }}</p>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No photos uploaded yet.</p>
        @endif
    </div>
</div>