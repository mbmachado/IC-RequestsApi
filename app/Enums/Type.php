<?php

namespace App\Enums;

enum Type: string
{
    case Office = 'OFFICE';
    case Committee = 'COMMITTEE';
    case Student = 'STUDENT';

    public static function getValues(): array
    {
        return array_column(Type::cases(), 'value');
    }
}
