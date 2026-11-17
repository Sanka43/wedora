<?php

namespace App\Domains\Booking\Models;

use App\Domains\Booking\Enums\QuotationStatus;
use App\Domains\Identity\Models\User;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Marketplace\Models\VendorPackage;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quotation extends Model
{
    use HasFactory, HasUuid, BelongsToWedding;

    protected $attributes = [
        'currency' => 'LKR',
        'status' => 'pending',
    ];

    protected $fillable = [
        'uuid',
        'wedding_id',
        'vendor_id',
        'package_id',
        'requested_by_user_id',
        'event_date',
        'guest_count',
        'venue_location',
        'couple_message',
        'vendor_response_message',
        'valid_until',
        'total_amount',
        'currency',
        'status',
        'responded_at',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'guest_count' => 'integer',
            'valid_until' => 'date',
            'total_amount' => 'decimal:2',
            'status' => QuotationStatus::class,
            'responded_at' => 'datetime',
            'accepted_at' => 'datetime',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(VendorPackage::class, 'package_id');
    }

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by_user_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class)->orderBy('sort_order');
    }

    public function booking(): HasOne
    {
        return $this->hasOne(Booking::class);
    }
}
