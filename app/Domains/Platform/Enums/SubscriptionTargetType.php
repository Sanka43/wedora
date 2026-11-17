<?php

namespace App\Domains\Platform\Enums;

enum SubscriptionTargetType: string
{
    case Vendor = 'vendor';
    case Planner = 'planner';

    public function label(): string
    {
        return match ($this) {
            self::Vendor => 'Vendor',
            self::Planner => 'Wedding Planner',
        };
    }
}
