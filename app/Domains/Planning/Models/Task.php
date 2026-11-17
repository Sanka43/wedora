<?php

namespace App\Domains\Planning\Models;

use App\Domains\Identity\Models\User;
use App\Domains\Planning\Enums\TaskPriority;
use App\Domains\Planning\Enums\TaskStatus;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, HasUuid, BelongsToWedding, SoftDeletes;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'category_id',
        'assigned_to_user_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'sort_order',
        'completed_at',
        'completed_by_user_id',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'priority' => TaskPriority::class,
            'status' => TaskStatus::class,
            'sort_order' => 'integer',
            'completed_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(TaskCategory::class, 'category_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function completedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by_user_id');
    }
}
