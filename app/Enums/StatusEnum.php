<?php

namespace App\Enums;

enum StatusEnum:string
{
    case Pending = 'Pending';
    case In_Progress = 'In Progress';
    case Completed = 'Completed';
}
