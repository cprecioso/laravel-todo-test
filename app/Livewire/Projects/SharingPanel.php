<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Component;

class SharingPanel extends Component
{
    public Project $project;

    public User $owner;
    public Collection $guests;

    public function updateShares()
    {
        $this->owner = $this->project->owner;
        $this->guests = $this->project->guests()->get();
    }

    public function mount()
    {
        $this->updateShares();
    }

    public function render()
    {
        return view('livewire.projects.sharing-panel');
    }

    public string $guestEmail = '';
    public function addGuest()
    {
        $this->authorize('manage-sharing', $this->project);

        $guest = User::whereEmail($this->guestEmail)->first();

        if (!$guest) {
            $this->addError('guestEmail', 'No user found with that email address.');
            return;
        }

        $this->reset('guestEmail');

        $this->project->guests()->attach($guest);
        $this->project->save();

        $this->updateShares();
        Flux::modal('add-guest-modal')->close();

    }

    public function removeGuest(string $guest_id)
    {
        $this->authorize('manage-sharing', $this->project);

        $this->project->guests()->detach($guest_id);
        $this->project->save();

        $this->updateShares();
    }
}
