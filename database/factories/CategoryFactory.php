<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['仕事', 'プライベート', '学習', '健康']),
            'color' => fake()->randomElement(['#0d6efd', '#198754', '#fd7e14', '#dc3545', '#6f42c1']),
        ];
    }
}
