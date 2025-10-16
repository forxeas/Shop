<?php

namespace App\Enums;

enum StatusEnum: string
{
    case RECEIVED = 'received';
    case SEND = 'send';
    case PENDING = 'pending';
    case FAILED = 'failed';

    public static function getStatus(): string
    {
        return match (self::class) {
            self::RECEIVED => 'Received',
            self::SEND => 'Send',
            self::PENDING => 'Pending',
            self::FAILED => 'Failed',
        };
    }

    public static function getValues(): array
    {
        return array_map(static fn($case) => $case->value, self::cases());
    }
}
