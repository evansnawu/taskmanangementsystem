<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use App\Enums\StatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{

    public function __construct(public TaskService $taskService)
    {
    }

    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            return datatables()::of($this->taskService->taskQuery())
                ->addIndexColumn()
                ->make(true);;
        }
        return view('tasks.index');
    }

    public function create()
    {
        return view('tasks.create', [
            'task' => new Task(),
            'statuses' => array_column(StatusEnum::cases(), 'value')
        ]);
    }

    public function store(StoreTaskRequest $request)
    {
        try {

            $this->taskService->create($request->validated());

            return redirect('/tasks')->with('status', 'Task Successfully Saved');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return redirect('/tasks')->with(
                'error',
                'An error has occured whilst saving task, please try again'
            );
        }
    }


    public function show(Task $task)
    {
        //
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', [
            'task' => $task,
            'statuses' => array_column(StatusEnum::cases(), 'value')
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        try {

            $this->taskService->update($request->validated(), $task);

            return redirect('/tasks')->with('status', 'Task Successfully Saved');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return redirect('/tasks')->with(
                'error',
                'An error has occured whilst saving task, please try again'
            );
        }
    }


    public function destroy(Task $task)
    {
        //
    }
}
