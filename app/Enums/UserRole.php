<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'ADMIN';
    case Requester = 'REQUESTER';

    public static function getValues(): array
    {
        return array_column(UserRole::cases(), 'value');
    }
}
