<?php

namespace App\enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case SALER = 'saler';
    case CUSTOMER = 'customer';

    static public function getRole(): string
    {
        return match (self::class) {
            self::ADMIN => 'admin',
            self::SALER => 'saler',
            self::CUSTOMER => 'customer',
        };
    }

    static public function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
