<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case SALER = 'saler';
    case CUSTOMER = 'customer';

    public static function getRole(RoleEnum $role): string
    {
        return match ($role) {
            self::ADMIN => 'admin',
            self::SALER => 'saler',
            self::CUSTOMER => 'customer',
        };
    }

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
