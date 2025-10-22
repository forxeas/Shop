<?php

namespace App\Enums;

enum PaymentEnum : string
{
    case CASH = 'Cash';
    case CARD = 'Card';
    case SBP = 'SBP';

    public static function  getPayment(PaymentEnum $payment): string
    {
        return match($payment) {
            self::CASH => 'cash',
            self::CARD => 'card',
            self::SBP => 'sbp',
        };
    }

    public static function getValues(): array
    {
        return array_map(static fn($case) => $case->value, self::cases());
    }
}
