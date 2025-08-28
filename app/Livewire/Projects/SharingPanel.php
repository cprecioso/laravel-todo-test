<?php

namespace App\Livewire\Projects;

use App\Http\Controllers\ProjectInviteController;
use App\Models\Project;
use App\Models\ProjectInvite;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class SharingPanel extends Component
{
    public Project $project;

    public User $owner;

    #[Locked]
    /** @var Collection<int, User> */
    public Collection $guests;

    #[Locked]
    /** @var Collection<int, ProjectInvite> */
    public Collection $invites;

    public function updateShares()
    {
        $this->authorize('view-sharing', $this->project);

        $this->owner = $this->project->owner;
        $this->guests = $this->project->guests()->get();
        $this->invites = $this->project->invites()->whereFuture('expires_at')->get();
    }

    public function mount()
    {
        $this->updateShares();
    }

    public function render()
    {
        return view('livewire.projects.sharing-panel');
    }

    #[Validate('email:rfc')]
    public string $guestEmail = '';

    public function addGuest()
    {
        $this->authorize('manage-sharing', $this->project);

        $this->validate();

        $guest = User::whereEmail($this->guestEmail)->first();

        if ($guest) {
            $this->project->guests()->attach($guest);
            $this->project->save();

            session()->flash('success', 'Guest added successfully.');
        } else {
            app()->make(ProjectInviteController::class)->sendInviteEmail($this->project, $this->guestEmail);

            session()->flash('success', 'Guest invited successfully.');
        }

        $this->reset('guestEmail');
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

    public function removeInvite(string $invite_id)
    {
        $this->authorize('manage-sharing', $this->project);

        ProjectInvite::findSole($invite_id)->delete();

        $this->updateShares();
    }
}
