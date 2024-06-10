<?php

namespace App\Traits;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;

trait TaskQuery
{
    public function taskQuery()
    {
        return cache()->rememberForever('tasks_' . auth()->id(), function () {
            return Task::with('user')->get();
        });
    }
}
