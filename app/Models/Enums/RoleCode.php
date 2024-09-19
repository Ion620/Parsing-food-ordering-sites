<?php

namespace App\Models\Enums;

enum RoleCode: string
{
    case Admin = '1';
    case Manager = '2';
    case Customer = '3';
}
