<?php

namespace App\Enums;

enum CommentSource: string
{
    case User = 'USER';
    case System = 'SYSTEM';

    public static function getValues(): array
    {
        return array_column(CommentSource::cases(), 'value');
    }
}
