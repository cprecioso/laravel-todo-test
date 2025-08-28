@props(['project'])

<div class="space-y-6">
    <flux:heading size="lg">
        @can('manage-sharing', $project)
            Manage sharing for "{{ $project->name }}"
        @else
            View sharing for "{{ $project->name }}"
        @endcan
    </flux:heading>


    <div class="flex items-center space-x-4">
        <flux:avatar src="{{ $owner->avatar_url ?? '' }}" alt="{{ $owner->name }}" />
        <div>
            <div class="font-semibold">
                {{ $owner->name }}
                @if ($owner->id == auth()->id())
                    <span class="text-sm text-gray-500">(You)</span>
                @endif
            </div>
            <div class="text-sm text-gray-500">Owner</div>
        </div>
    </div>

    @if ($guests->isNotEmpty())
        <div>
            <flux:subheading size="md" class="mb-2">Shared with</flux:subheading>
            <table class="min-w-full text-left">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        @can('manage-sharing', $project)
                            <th class="px-4 py-2">Actions</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @foreach ($guests as $guest)
                        <tr>
                            <td class="px-4 py-2 flex items-center space-x-2">
                                <flux:avatar src="{{ $guest->avatar_url ?? '' }}" alt="{{ $guest->name }}" size="xs" />
                                <span>{{ $guest->name }}</span>
                            </td>
                            <td class="px-4 py-2">{{ $guest->email }}</td>
                            @can('manage-sharing', $project)
                                <td class="px-4 py-2">
                                    <flux:button type="button" variant="danger" icon="trash" title="Remove"
                                        wire:click="removeGuest({{ $guest->id }})" />
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-gray-500">No guests have access to this project.</div>
    @endif

    <div class="flex">
        <flux:spacer />

        @can('manage-sharing', $project)
            <flux:modal.trigger name="add-guest-modal" variant="primary">
                <flux:button type="submit">Add guest</flux:button>
            </flux:modal.trigger>

            <flux:modal name="add-guest-modal" class="md:w-100">
                <form wire:submit.prevent="addGuest">
                    <flux:heading size="lg" class="mb-4">Add Guest</flux:heading>
                    <div class="mb-4">
                        <flux:label for="guestEmail" value="Guest Email" />
                        <flux:input id="guestEmail" type="email" class="mt-1 block w-full" wire:model="guestEmail"
                            autocomplete="off" required />

                        @error('guestEmail')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end space-x-2">
                        <flux:button type="button" wire:click="$emit('closeModal', 'add-guest-modal')">
                            Cancel
                        </flux:button>
                        <flux:button type="submit" variant="primary">Add Guest</flux:button>
                    </div>
                </form>
            </flux:modal>
        @endcan
    </div>
</div>
