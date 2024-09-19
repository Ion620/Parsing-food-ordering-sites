<?php

namespace App\Models\Enums;

enum GoodsStatus: string
{
    case AVAILABLE   = 'available';
    case UNAVAILABLE = 'unavailable';
}
