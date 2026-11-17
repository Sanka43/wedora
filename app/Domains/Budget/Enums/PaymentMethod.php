<?php

namespace App\Domains\Budget\Enums;

enum PaymentMethod: string
{
    case Cash = 'cash';
    case BankTransfer = 'bank_transfer';
    case CreditCard = 'credit_card';
    case OnlineSlip = 'online_slip';
    case Cheque = 'cheque';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Cash => 'Cash',
            self::BankTransfer => 'Bank Transfer',
            self::CreditCard => 'Credit / Debit Card',
            self::OnlineSlip => 'Online Slip / Receipt Upload',
            self::Cheque => 'Cheque',
            self::Other => 'Other',
        };
    }
}
