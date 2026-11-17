<?php

namespace App\Domains\Planning\Models;

use App\Domains\Planning\Enums\ChecklistWeddingType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChecklistTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'wedding_type',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'wedding_type' => ChecklistWeddingType::class,
            'is_active' => 'boolean',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(ChecklistTemplateItem::class)->orderBy('sort_order');
    }
}
