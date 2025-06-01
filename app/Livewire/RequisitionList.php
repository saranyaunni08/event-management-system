<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\RequisitionItem;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RequisitionList extends Component
{
    public Event $event;
    public $itemName = '';
    public $isPublic;

    public function mount()
    {
        // Initialize the is_public setting based on the first requisition item, or default to true
        $firstItem = $this->event->requisitionItems->first();
        $this->isPublic = $firstItem ? $firstItem->is_public : true;
    }

public function addItem()
{
    $this->validate([
        'itemName' => ['required', 'string', 'max:255'],
    ]);

    if ($this->event->isExpired()) {
        $this->addError('itemName', 'This event has expired. No items can be added.');
        return;
    }

    if (!$this->canAddItems()) {
        $this->addError('itemName', 'You are not authorized to add items to this event.');
        return;
    }

    RequisitionItem::create([
        'event_id' => $this->event->id,
        'item_name' => $this->itemName,
        'is_public' => $this->isPublic,
        'added_by_user_id' => Auth::id(),
    ]);

    $this->itemName = '';
    $this->dispatch('item-added')->to('requisition-list');
}
public function editItem($itemId, $newName)
{
    $item = RequisitionItem::findOrFail($itemId);

    if ($this->event->isExpired()) {
        $this->addError('itemName', 'This event has expired. No items can be edited.');
        return;
    }

    if (!$this->canAddItems()) {
        $this->addError('itemName', 'You are not authorized to edit items for this event.');
        return;
    }

    $item->update(['item_name' => $newName]);
    $this->dispatch('item-updated')->to('requisition-list');
}

    public function togglePublic()
    {
        // Only the creator or "event for" user can toggle visibility
        if (!$this->canAddItems()) {
            $this->addError('isPublic', 'You are not authorized to change the visibility of this list.');
            return;
        }

        // Update all items to have the same is_public value
        $this->event->requisitionItems()->update(['is_public' => $this->isPublic]);
    }

// In RequisitionList.php component

public function claimItem($itemId)
{
    // Validate user can claim
    if (!$this->canClaim || $this->event->isExpired()) {
        return;
    }

    $item = RequisitionItem::find($itemId);
    
    // Validate item exists and isn't already claimed
    if (!$item || $item->claimed_by_user_id) {
        $this->addError('claim', 'This item cannot be claimed.');
        return;
    }

    try {
        $item->update([
            'claimed_by_user_id' => Auth::id(),
            'claimed_at' => now()
        ]);
        
        // Refresh data
        $this->requisitionItems = $this->event->requisitionItems()->with('claimedBy')->get();
    } catch (\Exception $e) {
        $this->addError('claim', 'Failed to claim item: ' . $e->getMessage());
    }
}

public function unclaimItem($itemId)
{
    $item = RequisitionItem::find($itemId);
    
    // Validate user can unclaim (either owner or admin)
    $canUnclaim = $item && 
                 ($item->claimed_by_user_id === Auth::id() || 
                  $this->event->user_id === Auth::id()) &&
                 ($item->is_gift || $item->is_optional);
    
    if (!$canUnclaim || $this->event->isExpired()) {
        $this->addError('unclaim', 'You cannot unclaim this item.');
        return;
    }

    try {
        $item->update([
            'claimed_by_user_id' => null,
            'claimed_at' => null
        ]);
        
        // Refresh data
        $this->requisitionItems = $this->event->requisitionItems()->with('claimedBy')->get();
    } catch (\Exception $e) {
        $this->addError('unclaim', 'Failed to unclaim item: ' . $e->getMessage());
    }
}

    protected function canAddItems(): bool
    {
        $userId = Auth::id();
        // If the event is for the creator, only they can add items
        if ($this->event->user_id === $this->event->event_for_user_id) {
            return $userId === $this->event->user_id;
        }
        // Otherwise, both the creator and the "event for" user can add items
        return $userId === $this->event->user_id || $userId === $this->event->event_for_user_id;
    }

   public function canViewList(): bool
{
    $firstItem = $this->event->requisitionItems->first();
    $isPublic = $firstItem ? $firstItem->is_public : true;

    // If the list is public, anyone can view it
    if ($isPublic) {
        return true;
    }

    // If the list is private, only invited users can view it
    return $this->event->invitations->where('user_id', Auth::id())->isNotEmpty();
}


    public function render()
    {
        return view('livewire.requisition-list');
    }
}