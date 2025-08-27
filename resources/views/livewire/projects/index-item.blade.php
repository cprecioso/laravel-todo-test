@props(['projects'])

<flux:navlist.item icon="check-circle" :href="route('project', ['project' => $project->id])"
    :current="request()->routeIs('project') && request()->route()->parameter('project')->id == ($project->id)"
    wire:navigate :key="$project->id">
    {{ $project->name }}
</flux:navlist.item>
