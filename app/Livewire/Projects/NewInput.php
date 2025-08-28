<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewInput extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    public function addProject()
    {
        $this->authorize('create', Project::class);

        $this->validate();

        $newProject = Project::create([
            'name' => $this->name,
            'owner_id' => Auth::id(),
        ]);

        $this->reset('name');
        session()->flash('message', 'Project added successfully!');
        $this->dispatch('project-list-update');

        $this->redirectRoute('project', ['project' => $newProject->id]);
    }

    public function render()
    {
        return view('livewire.projects.new-input');
    }
}
