<?php

namespace App\Domains\Communication\Enums;

enum ConversationType: string
{
    case CoupleVendor = 'couple_vendor';
    case CoupleSupport = 'couple_support';
    case VendorSupport = 'vendor_support';

    public function label(): string
    {
        return match ($this) {
            self::CoupleVendor => 'Couple & Vendor',
            self::CoupleSupport => 'Couple Support Ticket',
            self::VendorSupport => 'Vendor Support Ticket',
        };
    }
}
