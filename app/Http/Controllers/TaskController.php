<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Enums\StatusEnum;
use App\Traits\TaskQuery;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class TaskController extends Controller
{

    public function __construct(public TaskService $taskService)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            return datatables()::of($this->taskService->taskQuery())
                ->addIndexColumn()
                ->make(true);;
        }
        return view('tasks.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $task = new Task();
        $statuses = StatusEnum::cases();

        return view('tasks.create', ['task' => $task, 'statuses' => $statuses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        try {

            $this->taskService->create($request->validated());

            return redirect('/tasks')->with('status', 'Task Successfully Saved');

        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return redirect('/tasks')->with('error', 'An error has occured whilst saving task, please try again');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
