<section class="w-full">
    <div class="relative mb-6 w-full flex items-center justify-between">
        <div>
            <flux:heading size="xl" level="1">{{ __('Tasks') }}</flux:heading>
            <flux:subheading size="lg" class="mb-6">{{ __('All your tasks') }}</flux:subheading>
            <flux:separator variant="subtle" />
        </div>

        <flux:button.group>
            @canany(['view-sharing', 'manage-sharing'], $project)
                <flux:modal.trigger name="sharing-panel">
                    <flux:button type="button" variant="primary" icon="users" title="{{ __('Sharing') }}" />
                </flux:modal.trigger>
            @endcanany


            @can('delete', $project)
                <flux:button type="button" wire:click="deleteProject" variant="danger" icon="trash"
                    wire:confirm="{{ __('Are you sure you want to delete this project? This action cannot be undone.') }}"
                    title="{{ __('Delete project') }}" />
            @endcan
        </flux:button.group>
    </div>


    <flux:modal name="sharing-panel" class="md:w-150">
        <livewire:projects.sharing-panel :project="$project" />
    </flux:modal>

    @can('create', [\App\Models\Task::class, $project])
        <div class="mb-4">
            <livewire:tasks.new-input :project="$project" />
        </div>
    @endcan

    <ul wire:task-list-update="$refresh">
        @forelse ($tasks as $task)
            <livewire:tasks.item :$task :key="$task->id" />
        @empty
            <li class="text-gray-500">{{ __('No tasks available') }}</li>
        @endforelse
    </ul>
</section>
