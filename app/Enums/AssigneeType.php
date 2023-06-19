<?php

namespace App\Enums;

enum AssigneeType: string
{
    case Office = 'OFFICE';
    case Committee = 'COMMITTEE';

    public static function getValues(): array
    {
        return array_column(AssigneeType::cases(), 'value');
    }
}
