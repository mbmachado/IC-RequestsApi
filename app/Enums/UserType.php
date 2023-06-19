<?php

namespace App\Enums;

enum UserType: string
{
    case Office = 'OFFICE';
    case Committee = 'COMMITTEE';
    case Student = 'STUDENT';

    public static function getValues(): array
    {
        return array_column(UserType::cases(), 'value');
    }
}
