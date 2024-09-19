<?php

namespace App\Models;

use Doctrine\Common\Annotations\Annotation\Enum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $manager_id
 * @property int $establishment_id
 * @property string $number
 * @property Enum $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable
        = [
            'manager_id',
            'establishment_id',
            'number',
            'status',
        ];

    /**
     * @return HasMany<OrderGood>
     */
    public function goods() : HasMany
    {
        return $this->hasMany(OrderGood::class);
    }

    /**
     * @return float|int
     */
    public function totalPrice() : float|int
    {
        $sum = [];
        foreach ($this->goods as $good) {
            $sum[] = $good->sum();
        }
        return array_sum($sum);
    }
}
