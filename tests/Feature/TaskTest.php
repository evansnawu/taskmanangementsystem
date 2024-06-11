<?php

use App\Enums\StatusEnum;
use App\Events\TaskCompleted;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Event;

use function Pest\Laravel\actingAs;
use Yajra\DataTables\Facades\DataTables;

beforeEach(function () {
    $this->user = User::factory()->create();
});

test('returns view for non ajax request', function () {
    actingAs($this->user)
        ->get('/tasks')
        ->assertStatus(200);
});

test('returns JSON response for AJAX request', function () {

    $tasks = Task::factory(10)->create();

    $tasks = Task::with('user')->get();
    $expected = DataTables::of($tasks)
        ->addIndexColumn()
        ->make(true)
        ->getContent();

    actingAs($this->user)
        ->getJson('/tasks', ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
        ->assertStatus(200)
        ->assertJson(json_decode($expected, true));
});

test('can show create page', function () {
    $response = $this->actingAs($this->user)->get('/tasks/create');

    $response->assertStatus(200);
});

test('create task successfully', function () {

    $task = [
        'title' => 'Title 1',
        'description' => 'description 1',
        'duedate' => '2024-10-10',
        'status' => StatusEnum::In_Progress->value,
        'user_id' => $this->user->id,
    ];

    actingAs($this->user)
        ->post('/tasks', $task)
        ->assertStatus(302)
        ->assertRedirect('tasks');

    $this->assertDatabaseHas('tasks', $task);

    $lastTask = Task::latest()->first();
    expect($task['title'])->toBe($lastTask->title)
        ->and($task['description'])->toBe($lastTask->description);
});

test('task create validation error redirects form with errors', function () {

    $response = actingAs($this->user)->post(
        '/tasks',
        [
            'title' => '',
            'duedate' => ''
        ]
    );

    $response->assertStatus(302)
        ->assertInvalid(['title', 'duedate']);
});


test('task edit contains correct values', function () {

    $task = Task::factory()->create([
        'user_id' => $this->user->id
    ]);
    actingAs($this->user)->get('tasks/' . $task->id . '/edit')
        ->assertStatus(200)
        ->assertSee($task->title, false)
        ->assertSee($task->description, false)
        ->assertViewHas('task', $task);
});

test('task update validation error redirects back to form', function () {
    $task = Task::factory()->create([
        'user_id' => $this->user->id
    ]);

    actingAs($this->user)->put('tasks/' . $task->id, [
        'title' => '',
        'duedate' => '',
        'description' => '',
        'status' => '',
        'user_id' => '',
    ])
        ->assertStatus(302)
        ->assertInvalid(['title', 'duedate'])
        ->assertSessionHasErrors(['title', 'duedate']);
});


test('task delete successful', function () {
    $task = Task::factory([
        'user_id' => $this->user->id
    ])->create();

    actingAs($this->user)
        ->delete('tasks/' . $task->id)
        ->assertStatus(302)
        ->assertRedirect('tasks');

    $this->assertDatabaseMissing('tasks', $task->toArray());
    $this->assertDatabaseCount('tasks', 0);

    $this->assertModelMissing($task);
    $this->assertDatabaseEmpty('tasks');
});

test('task edited successfully', function () {

    $task = Task::factory()->create([
        'user_id' => $this->user->id
    ]);

    $task->title = "changed title";
    $task->status = StatusEnum::Completed->value;
    $task->description = 'description changed';
    $task->duedate = '2026-01-30';

     actingAs($this->user)
        ->put(url('tasks' , $task->id), $task->toArray())
        ->assertStatus(302);

    $this->assertDatabaseHas('tasks', $task->toArray());
});


test('task show contains correct values', function () {

    $task = Task::factory()->create([
        'user_id' => $this->user->id
    ]);
    actingAs($this->user)->get('tasks/' . $task->id)
        ->assertStatus(200)
        ->assertSee($task->title, false)
        ->assertSee($task->duedate, false)
        ->assertViewHas('task', $task);
});

test('task completion fires events', function () {

    Event::fake();

    $task = Task::factory()->create([
        'user_id' => $this->user->id,
        'status' => StatusEnum::Pending->value,
    ]);

    $task->title = "changed title";
    $task->status = StatusEnum::Completed->value;
    $task->description = 'description changed';
    $task->duedate = '2026-01-30';

     actingAs($this->user)
        ->put(url('tasks' , $task->id), $task->toArray())
        ->assertStatus(302);

    Event::assertDispatched(TaskCompleted::class);
});
