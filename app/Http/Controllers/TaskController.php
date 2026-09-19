<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * 一覧表示。検索・絞り込み・並び替え・ページネーションに対応
     */
    public function index(Request $request)
    {
        // 必ずログインユーザー自身のタスクだけを対象にする
        $query = Auth::user()->tasks()->with('category');

        // キーワード検索(タイトル・詳細のあいまい検索)
        if ($request->filled('search')) {
            $keyword = $request->string('search');
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // 状態での絞り込み(完了 / 未完了)
        if ($request->filled('status')) {
            $query->where('is_done', $request->string('status') === 'done');
        }

        // カテゴリでの絞り込み
        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }

        // 並び替え(ホワイトリストで安全なカラムのみ許可)
        $allowedSorts = ['created_at', 'due_date', 'priority', 'title'];
        $sort = in_array($request->get('sort'), $allowedSorts, true)
            ? $request->get('sort')
            : 'created_at';
        $direction = $request->get('direction') === 'asc' ? 'asc' : 'desc';

        $tasks = $query->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString(); // ページネーションのリンクに検索条件を引き継ぐ

        $categories = Category::orderBy('name')->get();

        return view('tasks.index', compact('tasks', 'categories', 'sort', 'direction'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('tasks.create', compact('categories'));
    }

    public function store(StoreTaskRequest $request)
    {
        // 必ずログインユーザーに紐づけて作成する(他人のuser_idを指定させない)
        Auth::user()->tasks()->create($request->validated());

        return redirect()
            ->route('tasks.index')
            ->with('message', 'タスクを作成しました。');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $categories = Category::orderBy('name')->get();

        return view('tasks.edit', compact('task', 'categories'));
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $request->validated();
        // チェックボックスは未チェック時に送信されないため、明示的にboolへ変換
        $data['is_done'] = $request->boolean('is_done');

        $task->update($data);

        return redirect()
            ->route('tasks.index')
            ->with('message', 'タスクを更新しました。');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('message', 'タスクを削除しました。');
    }
}
