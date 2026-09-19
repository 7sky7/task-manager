@extends('layouts.app')

@section('title', 'タスク作成')

@section('content')
<div class="mx-auto" style="max-width: 600px;">
    <h1 class="h3 mb-4">タスクを新規作成</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">タイトル</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">詳細</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">カテゴリ</label>
                <select name="category_id" class="form-select">
                    <option value="">未分類</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">優先度</label>
                <select name="priority" class="form-select">
                    @foreach (\App\Models\Task::PRIORITIES as $priority)
                        <option value="{{ $priority }}" @selected(old('priority', 'medium') === $priority)>
                            {{ ucfirst($priority) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">期限日</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}">
        </div>

        <button type="submit" class="btn btn-primary">保存</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-link">戻る</a>
    </form>
</div>
@endsection
