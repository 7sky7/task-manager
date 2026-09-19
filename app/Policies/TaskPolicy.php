<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    /**
     * 自分のタスクだけ閲覧できる
     */
    public function view(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * 自分のタスクだけ編集できる
     */
    public function update(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }

    /**
     * 自分のタスクだけ削除できる
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->user_id;
    }
}
