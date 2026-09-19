<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // タスクの持ち主(usersテーブルとの多対1)。ユーザー削除時はタスクも削除する
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // カテゴリは任意。カテゴリが削除されたらnullに戻す(タスク自体は残す)
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('priority')->default('medium'); // low / medium / high
            $table->date('due_date')->nullable();
            $table->boolean('is_done')->default(false);
            $table->timestamps();

            // 「自分の未完了タスク一覧」の検索を速くするための複合インデックス
            $table->index(['user_id', 'is_done']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
