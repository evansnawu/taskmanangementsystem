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
    Task::factory()->create();
});

test('returns view for non ajax request', function () {

    actingAs($this->user)
        ->get('/tasks')
        ->assertStatus(200);
});

it('returns JSON response for AJAX request', function () {

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


