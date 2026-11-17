<?php

namespace App\Domains\Booking\Enums;

enum ReviewStatus: string
{
    case PendingModeration = 'pending_moderation';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::PendingModeration => 'Pending Moderation',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }
}
