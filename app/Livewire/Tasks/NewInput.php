<?php

namespace App\Livewire\Tasks;

use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class NewInput extends Component
{
    public string $text = '';

    public function addTask()
    {
        $this->validate([
            'text' => 'required|string|max:255',
        ]);

        Task::create([
            'text' => $this->text,
            'user_id' => Auth::id(),
        ]);

        $this->reset('text');
        session()->flash('message', 'Task added successfully!');
        $this->dispatch('task-list-update');
    }

    public function render()
    {
        return view('livewire.tasks.new-input');
    }
}
