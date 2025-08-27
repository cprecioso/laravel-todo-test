<?php

namespace App\Livewire\Tasks;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{

    public $tasks;

    #[On('task-list-update')]
    public function refreshTasks()
    {
        $this->tasks = Auth::user()->tasks()->get();
    }

    public function mount()
    {
        $this->refreshTasks();
    }

    public function render()
    {
        return view("livewire.tasks.index");
    }
}
