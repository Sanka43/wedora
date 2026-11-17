<?php

namespace App\Domains\Booking\Enums;

enum QuotationStatus: string
{
    case Pending = 'pending';
    case Responded = 'responded';
    case Accepted = 'accepted';
    case Rejected = 'rejected';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Vendor Response',
            self::Responded => 'Vendor Responded',
            self::Accepted => 'Accepted by Couple',
            self::Rejected => 'Rejected',
            self::Expired => 'Expired',
        };
    }
}
