<?php

namespace App\Domains\Planning\Models;

use App\Domains\Planning\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChecklistTemplateItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_template_id',
        'category_name',
        'title',
        'description',
        'suggested_due_offset_days',
        'priority',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'suggested_due_offset_days' => 'integer',
            'priority' => TaskPriority::class,
            'sort_order' => 'integer',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(ChecklistTemplate::class, 'checklist_template_id');
    }
}
