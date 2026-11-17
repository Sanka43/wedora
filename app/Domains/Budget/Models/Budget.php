<?php

namespace App\Domains\Budget\Models;

use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use HasFactory, HasUuid, BelongsToWedding;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'category_name',
        'planned_amount',
        'notes',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'planned_amount' => 'decimal:2',
            'sort_order' => 'integer',
        ];
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
