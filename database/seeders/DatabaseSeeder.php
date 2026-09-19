<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ポートフォリオを見る人がすぐログインして試せるデモアカウント
        $demoUser = User::factory()->create([
            'name' => 'デモユーザー',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
        ]);

        $categories = collect(['仕事', 'プライベート', '学習', '健康'])
            ->map(fn (string $name) => Category::factory()->create(['name' => $name]));

        Task::factory()
            ->count(20)
            ->for($demoUser)
            ->state(fn () => ['category_id' => $categories->random()->id])
            ->create();
    }
}
