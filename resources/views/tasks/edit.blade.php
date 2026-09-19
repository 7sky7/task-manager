@extends('layouts.app')

@section('title', 'タスク編集')

@section('content')
<div class="mx-auto" style="max-width: 600px;">
    <h1 class="h3 mb-4">タスクを編集</h1>

    <form action="{{ route('tasks.update', $task) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">タイトル</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">詳細</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">カテゴリ</label>
                <select name="category_id" class="form-select">
                    <option value="">未分類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $task->category_id) === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">優先度</label>
                <select name="priority" class="form-select">
                    @foreach (\App\Models\Task::PRIORITIES as $priority)
                        <option value="{{ $priority }}" @selected(old('priority', $task->priority) === $priority)>
                            {{ ucfirst($priority) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">期限日</label>
            <input type="date" name="due_date" class="form-control"
                   value="{{ old('due_date', $task->due_date?->format('Y-m-d')) }}">
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="is_done" class="form-check-input" id="is_done"
                   value="1" {{ old('is_done', $task->is_done) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_done">完了にする</label>
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-link">戻る</a>
    </form>
</div>
@endsection
