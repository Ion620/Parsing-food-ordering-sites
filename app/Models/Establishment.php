<?php

namespace App\Models;

use App\Models\Enums\EstablishmentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * @property string $name
 * @property string $url
 * @property EstablishmentStatus $status
 * @property Parser|null $parser
 * @property EstablishmentToParser|null $establishmentToParser
 */
class Establishment extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'name',
            'url',
            'opening_time',
            'closing_time',
            'action',
            'payment_methods',
            'popular_dishes',
            'status',
        ];

    protected $casts = [
        'status' => EstablishmentStatus::class,
    ];

    /**
     * @return HasOne<EstablishmentToParser>
     */
    public function establishmentToParser(): HasOne
    {
        return $this->hasOne(EstablishmentToParser::class, 'establishment_id');
    }

    /**
     * @return HasOneThrough<Parser>
     */
    public function parser(): HasOneThrough
    {
        return $this->hasOneThrough(Parser::class, EstablishmentToParser::class);
    }

    /**
     * @return BelongsToMany<Source>
     */
    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(Source::class, 'establishments_to_sources');
    }
}
