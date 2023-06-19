<?php

namespace App\Enums;

enum RequestTemplateStatus: string
{
    case Active = 'ACTIVE';
    case Inactive = 'INACTIVE';

    public static function getValues(): array
    {
        return array_column(RequestTemplateStatus::cases(), 'value');
    }
}
