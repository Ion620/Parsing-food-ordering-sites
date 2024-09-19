<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $customer_id
 * @property int $good_id
 * @property float $price
 * @property int $quantity
 * @property string $quantity_type
 * @property int $final_quantity
 * @property float $total_price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class OrderGood extends Model
{
    use HasFactory;

    protected $fillable
        = [
            'customer_id',
            'good_id',
            'order_id',
            'price',
            'quantity',
            'quantity_type',
            'final_quantity',
            'total_price',
        ];

    /**
     * @return float|int
     */
    public function sum(): float|int
    {
        return $this->price * $this->quantity;
    }
}
