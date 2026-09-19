<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'title' => 'テストタスク',
            'description' => '説明文',
            'priority' => 'high',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'title' => 'テストタスク',
            'user_id' => $user->id,
        ]);
    }

    public function test_task_requires_title(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/tasks', [
            'priority' => 'medium',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function test_user_can_only_see_own_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        Task::factory()->for($userA)->create(['title' => 'Aさんのタスク']);
        Task::factory()->for($userB)->create(['title' => 'Bさんのタスク']);

        $response = $this->actingAs($userA)->get('/tasks');

        $response->assertSee('Aさんのタスク');
        $response->assertDontSee('Bさんのタスク');
    }

    public function test_user_cannot_update_others_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task = Task::factory()->for($owner)->create();

        $response = $this->actingAs($other)->put("/tasks/{$task->id}", [
            'title' => '書き換え',
            'priority' => 'low',
        ]);

        $response->assertForbidden();
    }

    public function test_user_cannot_delete_others_task(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $task = Task::factory()->for($owner)->create();

        $response = $this->actingAs($other)->delete("/tasks/{$task->id}");

        $response->assertForbidden();
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function test_user_can_update_own_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create(['is_done' => false]);

        $response = $this->actingAs($user)->put("/tasks/{$task->id}", [
            'title' => '更新後のタイトル',
            'priority' => 'high',
            'is_done' => '1',
        ]);

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => '更新後のタイトル',
            'is_done' => true,
        ]);
    }

    public function test_user_can_delete_own_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $response = $this->actingAs($user)->delete("/tasks/{$task->id}");

        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
