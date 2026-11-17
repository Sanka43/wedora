<?php

namespace App\Domains\Wedding\Enums;

enum WeddingStatus: string
{
    case Planning = 'planning';
    case Completed = 'completed';
    case Archived = 'archived';

    public function label(): string
    {
        return match ($this) {
            self::Planning => 'Planning',
            self::Completed => 'Completed',
            self::Archived => 'Archived',
        };
    }
}
