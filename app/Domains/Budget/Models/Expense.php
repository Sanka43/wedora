<?php

namespace App\Domains\Budget\Models;

use App\Domains\Booking\Models\Booking;
use App\Domains\Budget\Enums\PaymentStatus;
use App\Domains\Marketplace\Models\Vendor;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, HasUuid, BelongsToWedding, SoftDeletes;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'budget_id',
        'vendor_id',
        'booking_id',
        'title',
        'amount',
        'expense_date',
        'payment_status',
        'notes',
        'receipt_url',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'expense_date' => 'date',
            'payment_status' => PaymentStatus::class,
        ];
    }

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
