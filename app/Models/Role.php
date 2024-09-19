<?php

namespace App\Models;

use App\Models\Enums\RoleCode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property RoleCode $code
 * @property string $name
 */
class Role extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'code',
            'name',
        ];

    protected $casts
        = [
            'code' => RoleCode::class,
        ];
}
