@props(['project'])

<form wire:submit.prevent="addTask" class="flex items-center space-x-2">
    <input type="text" wire:model="text" placeholder="Enter your task..."
        class="p-2 text-base border rounded-lg flex-1" />
    <button type="submit" class="p-2 text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        <flux:icon name="plus" />
    </button>
</form>
