<?php

namespace App\Domains\Guest\Enums;

enum RsvpStatus: string
{
    case Pending = 'pending';
    case Attending = 'attending';
    case Declined = 'declined';
    case Tentative = 'tentative';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Response',
            self::Attending => 'Attending',
            self::Declined => 'Declined',
            self::Tentative => 'Tentative / Maybe',
        };
    }
}
