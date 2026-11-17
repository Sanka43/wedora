<?php

namespace App\Domains\Booking\Models;

use App\Domains\Booking\Enums\ReviewStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory, HasUuid, BelongsToWedding;

    protected $fillable = [
        'uuid',
        'booking_id',
        'wedding_id',
        'vendor_id',
        'user_id',
        'rating',
        'comment',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
            'status' => ReviewStatus::class,
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
