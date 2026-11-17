<?php

namespace App\Domains\Booking\Actions;

use App\Domains\Booking\Enums\BookingStatus;
use App\Domains\Booking\Enums\QuotationStatus;
use App\Domains\Booking\Models\Booking;
use App\Domains\Booking\Models\Quotation;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class ConvertQuotationToBookingAction
{
    /**
     * Convert an accepted or confirmed quotation into an active booking.
     */
    public function execute(
        Quotation $quotation,
        float $advanceAmount = 0.00,
        ?string $notes = null
    ): Booking {
        if ($quotation->status === QuotationStatus::Rejected || $quotation->status === QuotationStatus::Expired) {
            throw new InvalidArgumentException("Cannot convert a {$quotation->status->value} quotation into a booking.");
        }

        return DB::transaction(function () use ($quotation, $advanceAmount, $notes) {
            $quotation->update([
                'status' => QuotationStatus::Accepted,
                'accepted_at' => now(),
            ]);

            $balanceAmount = max(0.00, (float) $quotation->total_amount - $advanceAmount);

            return Booking::create([
                'wedding_id' => $quotation->wedding_id,
                'vendor_id' => $quotation->vendor_id,
                'quotation_id' => $quotation->id,
                'package_id' => $quotation->package_id,
                'event_date' => $quotation->event_date,
                'total_amount' => $quotation->total_amount,
                'advance_amount' => $advanceAmount,
                'balance_amount' => $balanceAmount,
                'currency' => $quotation->currency ?: 'LKR',
                'status' => BookingStatus::Confirmed,
                'notes' => $notes,
                'confirmed_at' => now(),
            ]);
        });
    }
}
