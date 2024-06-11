<?php

use App\Models\User;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});


test('unauthenticated user cannot access task', function () {

    $response = $this->get('/tasks');

    $response->assertStatus(302)
        ->assertRedirect('login');
});

test('login redirects to tasks', function () {
    User::create([
        'name' => 'User',
        'email' => 'user@user.com',
        'password' => bcrypt('password123')
    ]);

    post('/login', [
        'email' => 'user@user.com',
        'password' => 'password123'
    ])
        ->assertStatus(302)
        ->assertRedirect('tasks');
});
