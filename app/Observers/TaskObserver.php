<?php

namespace App\Observers;

use App\Models\Task;

class TaskObserver
{

    public function created(Task $task): void
    {
        cache()->forget('tasks_' . $task->user_id);
    }

    public function updated(Task $task): void
    {
        cache()->forget('tasks_' . $task->user_id);
    }

    public function deleted(Task $task): void
    {
        cache()->forget('tasks_' . $task->user_id);
    }


}
