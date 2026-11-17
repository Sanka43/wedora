<?php

namespace App\Domains\Marketplace\Models;

use App\Domains\Platform\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VendorCategory extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'parent_id',
        'name',
        'slug',
        'description',
        'icon_url',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(VendorCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(VendorCategory::class, 'parent_id');
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class, 'category_id');
    }
}
