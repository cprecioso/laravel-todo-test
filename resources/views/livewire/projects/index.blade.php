<flux:navlist.group :heading="__('Projects')" class="grid" wire:project-list-update="$refresh">
    @foreach ($projects as $project)
        <flux:navlist.item icon="check-circle" :href="route('project', ['project' => $project->id])"
            :current="request()->routeIs('project') && request()->route()->parameter('project')->id == ($project->id)"
            wire:navigate :key="$project->id">
            {{ $project->name }}
        </flux:navlist.item>
    @endforeach

    <flux:navlist.item icon="plus" wire:confirm.prompt="Project name:" wire:click="" variant="outline"
        href="{{ route('projects.new') }}">
        New project
    </flux:navlist.item>
</flux:navlist.group>
