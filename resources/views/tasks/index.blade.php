@extends('layouts.app')

@section('title', 'タスク一覧')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">タスク一覧</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">+ 新規作成</a>
</div>

{{-- 検索・絞り込みフォーム --}}
<form method="GET" action="{{ route('tasks.index') }}" class="row g-2 mb-4">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control"
               placeholder="タイトル・詳細で検索">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-select">
            <option value="">すべての状態</option>
            <option value="pending" @selected(request('status') === 'pending')>未完了</option>
            <option value="done" @selected(request('status') === 'done')>完了</option>
        </select>
    </div>
    <div class="col-md-3">
        <select name="category" class="form-select">
            <option value="">すべてのカテゴリ</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected((string) request('category') === (string) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-outline-secondary">絞り込む</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-bordered bg-white align-middle">
        <thead>
            <tr>
                <th>状態</th>
                <th>
                    <a class="text-decoration-none text-dark" href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'title', 'direction' => $sort === 'title' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                        タイトル @if ($sort === 'title') {{ $direction === 'asc' ? '↑' : '↓' }} @endif
                    </a>
                </th>
                <th>カテゴリ</th>
                <th>
                    <a class="text-decoration-none text-dark" href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'priority', 'direction' => $sort === 'priority' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                        優先度 @if ($sort === 'priority') {{ $direction === 'asc' ? '↑' : '↓' }} @endif
                    </a>
                </th>
                <th>
                    <a class="text-decoration-none text-dark" href="{{ route('tasks.index', array_merge(request()->query(), ['sort' => 'due_date', 'direction' => $sort === 'due_date' && $direction === 'asc' ? 'desc' : 'asc'])) }}">
                        期限 @if ($sort === 'due_date') {{ $direction === 'asc' ? '↑' : '↓' }} @endif
                    </a>
                </th>
                <th style="width: 200px;">操作</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr class="{{ $task->isOverdue() ? 'table-danger' : '' }}">
                    <td>
                        @if ($task->is_done)
                            <span class="badge bg-success">完了</span>
                        @else
                            <span class="badge bg-secondary">未完了</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a>
                    </td>
                    <td>
                        @if ($task->category)
                            <span class="badge" style="background-color: {{ $task->category->color }};">
                                {{ $task->category->name }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $task->priorityBadgeClass() }}">{{ ucfirst($task->priority) }}</span>
                    </td>
                    <td>
                        {{ $task->due_date?->format('Y/m/d') ?? '—' }}
                        @if ($task->isOverdue())
                            <span class="badge bg-danger ms-1">期限切れ</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-secondary">編集</a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('本当に削除しますか?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">削除</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">条件に一致するタスクはありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $tasks->links() }}
@endsection
