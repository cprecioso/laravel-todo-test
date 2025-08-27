<section class="w-full">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Projects') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('All your projects') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <div class="mb-4">
        <livewire:projects.new-input />
    </div>

    <ul wire:project-list-update="$refresh">
        @forelse ($projects as $project)
            <livewire:projects.item :$project :key="$project->id" />
        @empty
            <li class="text-gray-500">{{ __('No projects available') }}</li>
        @endforelse
    </ul>
</section>
