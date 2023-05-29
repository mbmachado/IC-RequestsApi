<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'ADMIN';
    case Requester = 'REQUESTER';

    public static function getValues(): array
    {
        return array_column(Role::cases(), 'value');
    }
}
