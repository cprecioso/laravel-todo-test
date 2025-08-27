<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Tasks') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('All your tasks') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <ul>
        @forelse ($tasks as $task)
            <li :key="$task->id">
                <livewire:tasks.item :task="$task" />
            </li>
        @empty
            <li class="text-gray-500">{{ __('No tasks available') }}</li>
        @endforelse
    </ul>
</section>
