<?php

namespace App\Domains\Identity\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case Couple = 'couple';
    case Vendor = 'vendor';
    case Planner = 'planner';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Couple => 'Couple',
            self::Vendor => 'Vendor',
            self::Planner => 'Wedding Planner',
        };
    }
}
