@props(['task'])

<li>
    <div
        class="mb-4 flex items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="flex items-center">
            <input type="checkbox" wire:click={{ $task->is_completed ? 'handleUncheck' : 'handleCheck' }}
                class="mr-4 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ $task->is_completed ?
    'checked' : '' }} wire:model="$task->is_completed" @disabled(Auth::user()->cannot('update', $task))>
            <span class="{{ $task->is_completed ? 'line-through text-gray-500' : '' }}">{{ $task->text }}</span>
        </div>


        @can('delete', $task)
            <button class="text-red-500 hover:text-red-700" wire:click="handleDelete">{{ __('Delete') }}</button>
        @endcan
    </div>
</li>
