<?php

namespace App\Domains\Guest\Enums;

enum GuestInvitationStatus: string
{
    case NotSent = 'not_sent';
    case Sent = 'sent';
    case Delivered = 'delivered';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::NotSent => 'Not Sent',
            self::Sent => 'Sent',
            self::Delivered => 'Delivered',
            self::Failed => 'Delivery Failed',
        };
    }
}
