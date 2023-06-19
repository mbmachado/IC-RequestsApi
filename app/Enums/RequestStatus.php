<?php

namespace App\Enums;

enum RequestStatus: string
{
    case Open = 'OPEN';
    case Closed = 'CLOSED';
    case Completed = 'COMPLETED';
    case Blocked = 'BLOCKED';
    case OnHold = 'ON_HOLD';
    case InProgress = 'IN_PROGRESS';

    public static function getValues(): array
    {
        return array_column(RequestStatus::cases(), 'value');
    }
}
