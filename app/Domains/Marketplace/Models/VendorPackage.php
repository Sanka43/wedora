<?php

namespace App\Domains\Marketplace\Models;

use App\Domains\Platform\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorPackage extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'uuid',
        'vendor_id',
        'name',
        'description',
        'price',
        'currency',
        'duration_hours',
        'features',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'duration_hours' => 'decimal:1',
            'features' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
