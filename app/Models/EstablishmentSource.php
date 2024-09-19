<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstablishmentSource extends Model
{
    use HasFactory;

    protected $table = 'establishments_to_sources';

    protected $fillable
        = [
            'establishment_id',
            'source_id',
        ];
}
