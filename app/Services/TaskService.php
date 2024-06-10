<?php

namespace App\Services;

use App\Models\Task;
use App\Traits\TaskQuery;

class TaskService
{
    use TaskQuery;

    public function create(array $data): Task
    {
        return  Task::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'duedate' => $data['duedate'],
            'user_id' => $data['user_id'],
        ]);
    }

    public function update(array $data, Task $task): bool
    {
        return  $task->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'status' => $data['status'],
            'duedate' => $data['duedate'],
        ]);
    }
}
