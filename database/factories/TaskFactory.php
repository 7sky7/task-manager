<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => null,
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'due_date' => fake()->optional()->dateTimeBetween('-5 days', '+30 days'),
            'is_done' => fake()->boolean(30),
        ];
    }
}
