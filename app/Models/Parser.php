<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property Collection<Establishment> $establishments
 * @property array $options
 * @property string $class
 */
class Parser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable
        = [
            'class',
            'options',
        ];

    protected $casts
        = [
            'options' => 'array',
        ];

    /**
     * @return HasManyThrough<Establishment>
     */
    public function establishments(): HasManyThrough
    {
        return $this->hasManyThrough(Establishment::class, EstablishmentToParser::class);
    }


    /**
     * @return HasOneThrough<Source>
     */
    public function sources(): HasOneThrough
    {
        return $this->hasOneThrough(Source::class, SourceParser::class);
    }
}
