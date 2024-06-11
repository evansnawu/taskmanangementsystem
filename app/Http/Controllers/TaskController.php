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

    public function store(StoreTaskRequest $request): RedirectResponse
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
        if (request()->user()->cannot('view', $task)) {
            return redirect('/tasks')->with(
                'error',
                'User is not authorized to view this task'
            );
        }

        return view('tasks.show', [
            'task' => $task
        ]);
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', [
            'task' => $task,
            'statuses' => array_column(StatusEnum::cases(), 'value')
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        try {

            if ($request->user()->cannot('update', $task)) {
                return redirect('/tasks')->with(
                    'error',
                    'User is not authorized to update this task'
                );
            }

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


    public function destroy(Task $task): RedirectResponse
    {
        try {

            if (request()->user()->cannot('delete', $task)) {
                return redirect('/tasks')->with(
                    'error',
                    'User is not authorized to delete this task'
                );
            }


            $this->taskService->delete($task);

            return redirect('/tasks')->with('status', 'Task Successfully Deleted');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
            return redirect('/tasks')->with(
                'error',
                'An error has occured whilst saving task, please try again'
            );
        }
    }
}
