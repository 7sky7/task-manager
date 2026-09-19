<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 「誰のタスクか」のチェックはTaskPolicyで行うため、ここは常にtrue
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
            'is_done' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'タイトルを入力してください。',
            'title.max' => 'タイトルは255文字以内で入力してください。',
            'priority.required' => '優先度を選択してください。',
            'priority.in' => '優先度の値が不正です。',
            'due_date.date' => '期限日は正しい日付形式で入力してください。',
            'category_id.exists' => '指定されたカテゴリが存在しません。',
        ];
    }
}
