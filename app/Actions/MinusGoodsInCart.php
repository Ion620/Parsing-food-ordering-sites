<?php

namespace App\Actions;

use App\Models\Cart;
use App\Models\Enums\CartStatus;

class MinusGoodsInCart
{
    public function __invoke(int $goodId, int $customerId): void
    {
        /** @var Cart $cart */
        $cart = Cart::query()
            ->where('customer_id', '=', $customerId)
            ->where('good_id', '=', $goodId)
            ->where('status', '=', CartStatus::IN_PROCESS->value)
            ->firstOrFail();

        if ($cart->quantity > 1) {
            $cart->decrement('quantity');
        } else {
            $cart->delete();
        }
    }
}
