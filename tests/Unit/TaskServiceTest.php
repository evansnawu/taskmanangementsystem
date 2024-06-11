<?php

use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('task is saved successfully', function () {
    $validatedData  = [
        'title' => 'Title 1',
        'description' => 'description 1',
        'duedate' => '2024-10-10',
        'status' => 1,
        'user_id' => $this->user->id,
    ];

    $task = (new TaskService())->create($validatedData);

    expect($task)
        ->title
        ->not->toBeNull()
        ->toBeString()
        ->toEqual($task->title)
        ->description
        ->not->toBeNull()
        ->toBeString();
});

test('task is updated successfully', function () {

    $task = Task::factory()->create([
        'user_id' => $this->user->id
    ]);
    $ogtask = $task;
    $task->title = 'changed title';
    $task->status = 1;
    $task->description = 'description changed';

    (new TaskService())->update($task->toArray(), $ogtask);

    expect($ogtask)
        ->title
        ->not->toBeNull()
        ->toBeString()
        ->toEqual($task->title)
        ->description
        ->not->toBeNull()
        ->toBeString();
});

test('task delete successful', function () {
    $task = Task::factory([
        'user_id' => $this->user->id
    ])->create();

    (new TaskService())->delete($task);

    expect(Task::count())->toEqual(0);
});
