<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $path
 * @property string $hash
 */
class Images extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'path',
            'hash',
        ];
}
