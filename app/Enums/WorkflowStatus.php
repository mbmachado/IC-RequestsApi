<?php

namespace App\Enums;

enum WorkflowStatus: string
{
    case Active = 'ACTIVE';
    case Inactive = 'INACTIVE';

    public static function getValues(): array
    {
        return array_column(WorkflowStatus::cases(), 'value');
    }
}
