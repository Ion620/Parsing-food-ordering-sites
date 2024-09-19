<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceParser extends Model
{
    use HasFactory;

    protected $table = 'sources_to_parser';

    protected $fillable
        = [
            'source_id',
            'parser_id',
        ];
}
