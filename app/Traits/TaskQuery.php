<?php

namespace App\Traits;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
trait TaskQuery
{
    public function taskQuery():Builder{

        return Task::with('user');
    }
}
