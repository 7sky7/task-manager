@extends('layouts.app')

@section('title', $task->title)

@section('content')
<div class="mx-auto" style="max-width: 600px;">
    <h1 class="h3 mb-3">{{ $task->title }}</h1>

    <div class="mb-3 d-flex gap-2">
        @if ($task->is_done)
            <span class="badge bg-success">完了</span>
        @else
            <span class="badge bg-secondary">未完了</span>
        @endif

        <span class="badge {{ $task->priorityBadgeClass() }}">優先度: {{ ucfirst($task->priority) }}</span>

        @if ($task->category)
            <span class="badge" style="background-color: {{ $task->category->color }};">
                {{ $task->category->name }}
            </span>
        @endif

        @if ($task->isOverdue())
            <span class="badge bg-danger">期限切れ</span>
        @endif
    </div>

    <p class="text-body">{{ $task->description ?: '(詳細なし)' }}</p>

    <p class="text-muted">
        期限日: {{ $task->due_date?->format('Y/m/d') ?? '設定なし' }}
    </p>

    <p class="small text-muted">
        作成日: {{ $task->created_at->format('Y/m/d H:i') }} /
        更新日: {{ $task->updated_at->format('Y/m/d H:i') }}
    </p>

    <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-secondary">編集</a>
    <a href="{{ route('tasks.index') }}" class="btn btn-link">一覧へ戻る</a>
</div>
@endsection
