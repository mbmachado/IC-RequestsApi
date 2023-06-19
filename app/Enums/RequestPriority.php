<?php

namespace App\Enums;

enum RequestPriority: string
{
    case Low = 'LOW';
    case Normal = 'NORMAL';
    case High = 'HIGH';


    public static function getValues(): array
    {
        return array_column(RequestPriority::cases(), 'value');
    }
}
