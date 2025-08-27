<?php

namespace App\Livewire\Projects;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{

    public $projects;

    #[On('project-list-update')]
    public function refreshProjects()
    {
        $this->projects = Auth::user()->projects()->get();
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
