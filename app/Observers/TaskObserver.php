<?php

namespace App\Observers;

use App\Enums\StatusEnum;
use App\Events\TaskCompleted;
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

        if ($task->isDirty('status') && $task->status==StatusEnum::Completed->value){
            event(new TaskCompleted($task));
        }
    }

    public function deleted(Task $task): void
    {
        cache()->forget('tasks_' . $task->user_id);
    }


}
