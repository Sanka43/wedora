<?php

namespace App\Domains\Platform\Enums;

enum SubscriptionStatus: string
{
    case Trial = 'trial';
    case Active = 'active';
    case PastDue = 'past_due';
    case Cancelled = 'cancelled';
    case Expired = 'expired';

    public function label(): string
    {
        return match ($this) {
            self::Trial => 'Trial Period',
            self::Active => 'Active Subscription',
            self::PastDue => 'Past Due',
            self::Cancelled => 'Cancelled',
            self::Expired => 'Expired',
        };
    }
}
