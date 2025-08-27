<?php

namespace App\Livewire\Projects;

use Livewire\Component;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class NewInput extends Component
{
    public string $name = '';

    public function addProject()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        Project::create([
            'name' => $this->name,
            'owner_id' => Auth::id(),
        ]);

        $this->reset('name');
        session()->flash('message', 'Project added successfully!');
        $this->dispatch('project-list-update');
    }

    public function render()
    {
        return view('livewire.projects.new-input');
    }
}
