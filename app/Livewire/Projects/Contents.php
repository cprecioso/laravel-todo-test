<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Collection;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Contents extends Component
{
    public Project $project;

    /** @var Collection<int, Task> */
    #[Locked]
    public Collection $tasks;

    #[On("task-list-update")]
    public function refreshTasks()
    {
        $this->authorize("view", $this->project);

        $this->tasks = $this->project->tasks()->get();
    }

    public function mount()
    {
        $this->refreshTasks();
    }

    public function render()
    {
        return view("livewire.projects.contents");
    }

    public function deleteProject()
    {
        $this->authorize("delete", $this->project);

        $this->project->delete();
        session()->flash("message", "Project deleted successfully!");
        $this->dispatch("project-list-update");
        $this->redirectRoute("dashboard");
    }
}
