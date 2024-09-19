<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Enums\CartStatus;

class PlusGoodsToCart
{
    public function __invoke(int $goodId, int $customerId): void
    {
        /** @var Cart $cart */
        $cart = Cart::query()
            ->firstOrCreate(
                [
                    'customer_id' => $customerId,
                    'good_id'     => $goodId,
                    'status'      => CartStatus::IN_PROCESS->value,
                ],
                [
                    'quantity' => 0,
                ]
            );

        $cart->increment('quantity');
    }
}
