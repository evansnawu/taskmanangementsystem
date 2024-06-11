<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arrayValues = ['Pending', 'In Progress', 'Completed'];

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'duedate' => fake()->date(),
            'status' => $arrayValues[rand(0, 2)],
            'user_id' => User::factory()->create()->id,
        ];
    }
}
