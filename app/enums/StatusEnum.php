<?php

namespace App\enums;

enum StatusEnum: string
{
    case SEND = 'send';
    case PENDING = 'pending';
    case FAILED = 'failed';

    static public function getStatus(): string
    {
        return match (self::class) {
            self::SEND => 'Send',
            self::PENDING => 'Pending',
            self::FAILED => 'Failed',
        };
    }

    static public function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
