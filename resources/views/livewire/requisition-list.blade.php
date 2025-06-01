
<div class="text-gray-900">
    <!-- Event Expiry Notice -->
    @if($event->isExpired())
        <p class="text-gray-500 italic mb-4 p-3 bg-gray-100 rounded-lg">
            This event has expired. The requisition list is read-only.
        </p>
    @endif

    <!-- Permission Check -->
    @if($this->canViewList())
        <!-- Add Item Form -->
        @if($this->canAddItems() && !$event->isExpired())
            <form wire:submit.prevent="addItem" class="mb-6 flex flex-col sm:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-1 text-gray-700">Item Name</label>
                    <input 
                        wire:model="itemName" 
                        type="text" 
                        class="w-full p-2 bg-white border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                        placeholder="Enter item name..."
                    >
                    @error('itemName') 
                        <span class="text-red-400 text-sm">{{ $message }}</span> 
                    @enderror
                </div>
                <button 
                    type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out"
                >
                    Add Item
                </button>
            </form>

            <!-- Public/Private Toggle -->
            <div class="mb-6 flex items-center gap-4">
                <label class="flex items-center">
                    <input 
                        wire:model="isPublic" 
                        wire:change="togglePublic" 
                        type="checkbox" 
                        class="mr-2 bg-white border-gray-300 text-blue-500 focus:ring-blue-500"
                    >
                    <span class="text-gray-700">Public (visible to all users)</span>
                </label>
                @error('isPublic') 
                    <span class="text-red-400 text-sm">{{ $message }}</span> 
                @enderror
            </div>
        @elseif(!$this->canAddItems())
            <p class="text-gray-500 italic mb-4 p-3 bg-gray-100 rounded-lg">
                You are not authorized to add items to this list.
            </p>
        @endif

        <!-- Requisition List Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-md border border-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Item Name</th>
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Claimed By</th>
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Gift</th>
                        <th class="py-3 px-6 text-left font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($event->requisitionItems as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="py-3 px-6 text-gray-900">{{ $item->item_name }}</td>
                            <td class="py-3 px-6 text-gray-900">
                                {{ $item->claimed_by_user_id ? $item->claimedBy->name : 'Not claimed' }}
                            </td>
                            <td class="py-3 px-6 text-gray-900">
                                {{ $item->is_gift ? 'Yes' : 'No' }}
                            </td>
                            <td class="py-3 px-6">
                                @if(!$event->isExpired())
                                    @if($item->claimed_by_user_id)
                                        @if($item->claimed_by_user_id === Auth::id() && $item->is_gift)
                                            <button 
                                                wire:click="unclaimItem({{ $item->id }})" 
                                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-lg transition duration-150"
                                            >
                                                Unclaim
                                            </button>
                                        @endif
                                    @else
                                        @if($event->invitations->where('user_id', Auth::id())->where('status', 'accepted')->count() > 0)
                                            <button 
                                                wire:click="claimItem({{ $item->id }})" 
                                                class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-lg transition duration-150"
                                            >
                                                Claim
                                            </button>
                                        @endif
                                    @endif
                                @else
                                    <span class="text-gray-500 text-sm">No actions available</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-3 px-6 text-center text-gray-500">
                                No items in the requisition list.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Error Messages -->
        @error('claim') 
            <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
        @enderror
        @error('unclaim') 
            <span class="text-red-400 text-sm mt-2 block">{{ $message }}</span> 
        @enderror
    @else
        <p class="text-gray-500 italic p-3 bg-gray-100 rounded-lg">
            You do not have permission to view this requisition list.
        </p>
    @endif
</div>