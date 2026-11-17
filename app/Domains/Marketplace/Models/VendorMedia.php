<?php

namespace App\Domains\Marketplace\Models;

use App\Domains\Marketplace\Enums\MediaType;
use App\Domains\Platform\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorMedia extends Model
{
    use HasFactory, HasUuid;

    protected $table = 'vendor_media';

    protected $fillable = [
        'uuid',
        'vendor_id',
        'file_path',
        'media_type',
        'caption',
        'is_cover',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'media_type' => MediaType::class,
            'is_cover' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
