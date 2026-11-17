<?php

namespace App\Domains\Budget\Models;

use App\Domains\Booking\Models\Booking;
use App\Domains\Budget\Enums\PaymentMethod;
use App\Domains\Identity\Models\User;
use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory, HasUuid, BelongsToWedding;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'expense_id',
        'booking_id',
        'recorded_by_user_id',
        'amount',
        'payment_method',
        'payment_date',
        'reference_number',
        'receipt_url',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_method' => PaymentMethod::class,
            'payment_date' => 'date',
        ];
    }

    public function expense(): BelongsTo
    {
        return $this->belongsTo(Expense::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by_user_id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
