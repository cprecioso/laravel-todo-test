<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    /** @var Collection<int, Project> */
    #[Locked]
    public Collection $ownProjects;

    /** @var Collection<int, Project> */
    #[Locked]
    public Collection $guestProjects;

    #[On("project-list-update")]
    public function refreshProjects()
    {
        $this->ownProjects = Auth::user()->ownProjects()->get();
        $this->guestProjects = Auth::user()->guestProjects()->get();
    }

    public function mount()
    {
        $this->refreshProjects();
    }

    public function render()
    {
        return view("livewire.projects.index");
    }
}
