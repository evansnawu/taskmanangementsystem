<?php

use App\Http\Controllers\TaskController;
use App\Models\Task;
use App\Models\User;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\Collection;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\getJson;
use Yajra\DataTables\Facades\DataTables;

beforeEach(function () {
    $this->user = User::factory()->create();
    // $this->task = Task::factory()->create();
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
