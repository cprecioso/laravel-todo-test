<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class Item extends Component
{
    public Project $project;

    public function render()
    {
        return view("livewire.projects.item");
    }

    public function handleDelete()
    {
        $this->project->delete();
        $this->dispatch('project-list-update');
    }
}
