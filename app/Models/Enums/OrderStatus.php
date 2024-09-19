<?php

namespace App\Models\Enums;

enum OrderStatus: string
{
    case OPEN   = 'open';
    case IN_PROCESS = 'in_process';
    case COMPLETED = 'completed';
}
