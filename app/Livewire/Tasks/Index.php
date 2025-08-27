<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{

    public Project $project;
    public $tasks;

    #[On('task-list-update')]
    public function refreshTasks()
    {
        $this->tasks = $this->project->tasks()->get();
    }

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->refreshTasks();
    }

    public function render()
    {
        return view("livewire.tasks.index");
    }
}
