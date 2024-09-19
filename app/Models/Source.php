<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $url
 * @property Parser $parsers
 */
class Source extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable
        = [
            'name',
            'url',
            'date',
        ];

    /**
     * @return BelongsToMany<Establishment>
     */
    public function establishments(): BelongsToMany
    {
        return $this->belongsToMany(Establishment::class, 'establishments_to_sources');
    }

    /**
     * @return HasOneThrough<Parser>
     */
    public function parsers(): HasOneThrough
    {
        return $this->hasOneThrough(Parser::class, SourceParser::class, 'source_id', 'id', 'id', 'parser_id');
    }
}
