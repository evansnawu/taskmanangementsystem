<?php

use App\Models\Task;
use App\Models\User;

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
        'status' => 1,
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

    $task = Task::factory()->create();
    actingAs($this->user)->get('tasks/' . $task->id . '/edit')
        ->assertStatus(200)
        ->assertSee('value="' . $task->name . '"', false)
        ->assertSee('value="' . $task->price . '"', false)
        ->assertViewHas('task', $task);
});

test('task update validation error redirects back to form', function () {
    $task = Task::factory()->create();

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


test('task edited successfully', function () {

    $task = Task::factory()->create();

    $task->title = 'changed title';
    $task->status = 1;
    $task->description = 'description changed';
    $task->updated_at = date('Y-m-d H:i:s');
    $task->created_at = date('Y-m-d H:i:s');

    actingAs($this->user)
        ->put('/tasks/' . $task->id, $task->toArray())
        ->assertRedirect('tasks');

    $this->assertDatabaseHas('tasks', $task->toArray());
});
