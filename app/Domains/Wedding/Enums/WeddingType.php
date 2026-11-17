<?php

namespace App\Domains\Wedding\Enums;

enum WeddingType: string
{
    case Traditional = 'traditional';
    case Western = 'western';
    case Homecoming = 'homecoming';
    case Reception = 'reception';
    case Hindu = 'hindu';
    case Muslim = 'muslim';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Traditional => 'Traditional (Poruwa)',
            self::Western => 'Western / Church',
            self::Homecoming => 'Homecoming Ceremony',
            self::Reception => 'Wedding Reception',
            self::Hindu => 'Hindu Wedding',
            self::Muslim => 'Muslim Wedding',
            self::Other => 'Other / Custom',
        };
    }
}
