<?php

namespace App\Enums;

enum StatusEnum: string
{
    case Pending = 'Pending';
    case In_Progress = 'In Progress';
    case Completed = 'Completed';

    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->name] = $case->value;
        }
        return $array;
    }
}
