<?php

namespace App\Domains\Wedding\Enums;

enum WeddingMemberRole: string
{
    case Owner = 'owner';
    case Partner = 'partner';
    case Collaborator = 'collaborator';
    case Planner = 'planner';

    public function label(): string
    {
        return match ($this) {
            self::Owner => 'Workspace Owner',
            self::Partner => 'Partner / Spouse',
            self::Collaborator => 'Collaborator',
            self::Planner => 'Wedding Planner',
        };
    }
}
