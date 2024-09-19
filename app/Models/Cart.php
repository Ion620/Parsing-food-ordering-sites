<?php

namespace App\Models;

use App\Models\Enums\CartStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $customer_id
 * @property int $establishment_id
 * @property int $good_id
 * @property int $quantity
 * @property CartStatus $status
 */
class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cart';

    protected $fillable = [
        'customer_id',
        'establishment_id',
        'good_id',
        'quantity',
        'status',
    ];

    protected $casts = [
        'status' => CartStatus::class,
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Establishment, self>
     */
    public function establishment(): BelongsTo
    {
        return $this->belongsTo(Establishment::class);
    }

    /**
     * @return BelongsTo<Goods, self>
     */
    public function good(): BelongsTo
    {
        return $this->belongsTo(Goods::class);
    }

    /**
     * @return float|int
     */
    public function price(): float|int
    {
        return (int)$this->good->price * $this->quantity;
    }
}
