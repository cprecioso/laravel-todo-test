<div>
    <flux:navlist.group :heading="__('My projects')" class="grid" wire:project-list-update="$refresh">
        @foreach ($ownProjects as $project)
            <livewire:projects.index-item :project="$project" :key="$project->id" />
        @endforeach
    </flux:navlist.group>

    <flux:navlist.group :heading="__('Shared with me')" class="grid" wire:project-list-update="$refresh">
        @foreach ($guestProjects as $project)
            <livewire:projects.index-item :project="$project" :key="$project->id" />
        @endforeach
    </flux:navlist.group>

    <flux:navlist.item icon="plus" variant="outline" :href="route('projects.new')"
        :current="request()->routeIs('projects.new')">
        New project
    </flux:navlist.item>
</div>
