<?php

namespace App\Models\Enums;

enum CartStatus : string
{
    case IN_PROCESS = 'in_process';
    case COMPLETED = 'completed';
}
