<form wire:submit.prevent="addProject" class="flex items-center space-x-2">
    <input type="text" wire:model="name" placeholder="New project" class="p-2 text-base border rounded-lg flex-1" />
    <button type="submit" class="p-2 text-base bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        New
    </button>
</form>
