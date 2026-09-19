<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    /** 優先度として許可する値 */
    public const PRIORITIES = ['low', 'medium', 'high'];

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'priority',
        'due_date',
        'is_done',
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'due_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 未完了かつ期限日を過ぎているか
     */
    public function isOverdue(): bool
    {
        return ! $this->is_done
            && $this->due_date !== null
            && $this->due_date->isPast();
    }

    /**
     * 優先度に応じたBootstrapのバッジクラスを返す(View側のロジックをモデルに寄せる)
     */
    public function priorityBadgeClass(): string
    {
        return match ($this->priority) {
            'high' => 'bg-danger',
            'medium' => 'bg-warning text-dark',
            default => 'bg-secondary',
        };
    }
}
