<?php

namespace App\Enums;

enum UserCourse: string
{
    case ComputerScience = 'COMPUTER_SCIENCE';
    case InformationSystems = 'INFORMATION_SYSTEMS';
    case ComputationDegree = 'COMPUTATION_DEGREE';

    public static function getValues(): array
    {
        return array_column(UserCourse::cases(), 'value');
    }
}
