<?php

namespace App\Services;

use App\TaskQuery;

class TaskService
{
    use TaskQuery;
    public function populateDatatable()
    {
        return datatables()::of($this->taskQuery())
            ->addIndexColumn()
            ->make(true);
    }
}
