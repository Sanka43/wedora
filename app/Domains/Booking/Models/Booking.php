<?php

namespace App\Domains\Booking\Models;

use App\Domains\Booking\Enums\BookingStatus;
use App\Domains\Budget\Models\Expense;
use App\Domains\Budget\Models\Payment;
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

class Booking extends Model
{
    use HasFactory, HasUuid, BelongsToWedding;

    protected $attributes = [
        'currency' => 'LKR',
        'status' => 'pending_confirmation',
        'advance_amount' => 0.00,
        'balance_amount' => 0.00,
    ];

    protected $fillable = [
        'uuid',
        'wedding_id',
        'vendor_id',
        'quotation_id',
        'package_id',
        'event_date',
        'total_amount',
        'advance_amount',
        'balance_amount',
        'currency',
        'status',
        'cancellation_reason',
        'cancelled_by_user_id',
        'notes',
        'confirmed_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'total_amount' => 'decimal:2',
            'advance_amount' => 'decimal:2',
            'balance_amount' => 'decimal:2',
            'status' => BookingStatus::class,
            'confirmed_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(VendorPackage::class, 'package_id');
    }

    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by_user_id');
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
