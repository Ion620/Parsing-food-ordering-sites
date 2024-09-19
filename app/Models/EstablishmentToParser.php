<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array $options
 */
class EstablishmentToParser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable
        = [
            'options',
        ];

    protected $casts
        = [
            'options' => 'array',
        ];

    /**
     * @return  BelongsTo<Establishment, self>
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * @return BelongsTo<Parser, self>
     */
    public function parser(): BelongsTo
    {
        return $this->belongsTo(Parser::class);
    }
}
