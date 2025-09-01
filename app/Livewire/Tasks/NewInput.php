<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewInput extends Component
{
    public Project $project;

    #[Validate("required|string|max:255")]
    public string $text = "";

    public function addTask()
    {
        $this->authorize("create", [Task::class, $this->project]);

        $this->validate();

        Task::create([
            "text" => $this->text,
            "user_id" => Auth::id(),
            "project_id" => $this->project->id,
        ]);

        $this->reset("text");
        session()->flash("message", "Task added successfully!");
        $this->dispatch("task-list-update");
    }

    public function render()
    {
        return view("livewire.tasks.new-input");
    }
}
