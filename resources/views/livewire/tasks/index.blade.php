<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Tasks') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('All your tasks') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <ul>
        @forelse ($tasks as $task)
            <li
                class="mb-4 flex items-center justify-between rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center">
                    <input type="checkbox" class="mr-4 h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ $task->is_completed ? 'checked' : '' }}>
                    <span class="{{ $task->is_completed ? 'line-through text-gray-500' : '' }}">{{ $task->text }}</span>
                </div>
                <button class="text-red-500 hover:text-red-700">{{ __('Delete') }}</button>
            </li>
        @empty
            <li class="text-gray-500">{{ __('No tasks available') }}</li>
        @endforelse
    </ul>
</section>
