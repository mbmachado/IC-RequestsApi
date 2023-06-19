<?php

namespace App\Enums;

enum StepType: string
{
    case Initial = 'INITIAL';
    case Intermediate = 'INTERMEDIATE';
    case Final = 'FINAL';

    public static function getValues(): array
    {
        return array_column(StepType::cases(), 'value');
    }
}
