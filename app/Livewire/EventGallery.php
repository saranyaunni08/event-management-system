<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Photo;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventGallery extends Component
{
    use WithFileUploads;

    public $event, $photo;

    protected $rules = [
        'photo' => 'required|image|max:10240', // 10MB max
    ];

    public function mount(Event $event)
    {
        $this->event = $event->load('photos');
        $this->authorize('view', $event);
    }


    public function uploadPhoto()
    {
        $this->authorize('uploadPhoto', $this->event);
        $this->validate();

        $path = $this->photo->store('photos', 'public');

        Photo::create([
            'event_id' => $this->event->id,
            'user_id' => Auth::id(),
            'path' => $path,
        ]);

        $this->photo = null;
        session()->flash('message', 'Photo uploaded!');
    }

    public function deletePhoto($photoId)
    {
        $photo = Photo::findOrFail($photoId);

        $this->authorize('deletePhoto', $photo);

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        session()->flash('message', 'Photo deleted!');
    }

    public function render()
    {
        $photos = $this->event->photos ?? collect(); // Fallback to empty collection if null
        return view('livewire.event-gallery', ['photos' => $photos]);
    }
}
