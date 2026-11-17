<?php

namespace App\Domains\Planning\Enums;

enum ChecklistWeddingType: string
{
    case Traditional = 'traditional';
    case Western = 'western';
    case Homecoming = 'homecoming';
    case Reception = 'reception';
    case All = 'all';

    public function label(): string
    {
        return match ($this) {
            self::Traditional => 'Traditional (Poruwa)',
            self::Western => 'Western / Church',
            self::Homecoming => 'Homecoming',
            self::Reception => 'Reception',
            self::All => 'All Wedding Types',
        };
    }
}
