<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Tasks') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('All your tasks') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="mb-4">
        <livewire:tasks.new-input />
    </div>

    <ul wire:task-list-update="$refresh">
        @forelse ($tasks as $task)
            <livewire:tasks.item :$task :key="$task->id" />
        @empty
            <li class="text-gray-500">{{ __('No tasks available') }}</li>
        @endforelse
    </ul>
</section>
