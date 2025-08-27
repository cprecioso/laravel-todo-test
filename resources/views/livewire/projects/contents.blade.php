<section class="w-full">
    <div class="relative mb-6 w-full flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1">{{ __('Tasks') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('All your tasks') }}</flux:subheading>
            <flux:separator variant="subtle" />
        </div>

        <button type="button" class="ml-4 px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600"
            wire:click="deleteProject"
            wire:confirm="{{ __('Are you sure you want to delete this project? This action cannot be undone.') }}">
            {{ __('Delete project') }}
        </button>
    </div>

    <div class="mb-4">
        <livewire:tasks.new-input :project="$project" />
    </div>

    <ul wire:task-list-update="$refresh">
        @forelse ($tasks as $task)
            <livewire:tasks.item :$task :key="$task->id" />
        @empty
            <li class="text-gray-500">{{ __('No tasks available') }}</li>
        @endforelse
    </ul>
</section>
