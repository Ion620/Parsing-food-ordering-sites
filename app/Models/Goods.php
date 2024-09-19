<?php

namespace App\Models;

use App\Models\Enums\GoodsStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $description
 * @property string $price
 * @property GoodsStatus $status
 * @property string $category
 * @property string $image
 * @property array $data
 * @property int $party_id
 * @property Establishment $party
 * @property Cart $cart
 */
class Goods extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'name',
            'description',
            'price',
            'status',
            'category',
            'image',
            'data',
            'party_id',
        ];

    protected $casts = [
        'status' => GoodsStatus::class,
        'data'   => 'array',
    ];

    /**
     * @return BelongsTo<Cart, self>
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'id', 'good_id');
    }

    /**
     * @return BelongsTo<Establishment, self>
     */
    public function party(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }
}
