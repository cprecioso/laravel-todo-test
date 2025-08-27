@props(['project'])

<li>
    <div
        class="mb-4 flex items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <a href={{ route('project', ['project' => $project->id]) }}>
            <div class="flex items-center">
                {{ $project->name }}
            </div>
        </a>
        <button class="text-red-500 hover:text-red-700" wire:click="handleDelete">{{ __('Delete') }}</button>
    </div>
</li>
