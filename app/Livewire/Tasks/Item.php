<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class Item extends Component
{
    public Task $task;

    public function render()
    {
        return view("livewire.tasks.item");
    }

    public function handleCheck()
    {
        $this->authorize("update", $this->task);

        $this->task->is_completed = true;
        $this->task->save();
    }

    public function handleUncheck()
    {
        $this->authorize("update", $this->task);

        $this->task->is_completed = false;
        $this->task->save();
    }

    public function handleDelete()
    {
        $this->authorize("delete", $this->task);

        $this->task->delete();
        $this->dispatch("task-list-update");
    }
}
